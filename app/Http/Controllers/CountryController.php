<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{

    /**
     * AJAX: Get Data for DataTables
     */

    public function getCountries(Request $request)
    {
        $query = Country::select([
            'id',
            'country_name',
            'country_code',
            'currency_name',
            'currency_code',
            'currency_symbol',
            'flag'
        ]);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('flag', function ($row) {
                return $row->flag
                    ? '<img src="' . asset('storage/' . $row->flag) . '" width="50" height="50" class="rounded-circle border">'
                    : '<span class="text-muted">No Image</span>';
            })
            ->addColumn('actions', function ($row) {
                $editUrl = route('countries.edit', $row->id);
                $deleteModalId = 'deleteModal' . $row->id;

                return '
                    <div class="dropdown">
                        <button class="btn bg-primary-subtle text-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="' . $editUrl . '">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                            </li>
                            <li>
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#' . $deleteModalId . '">
                                    <i class="ti ti-trash"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="' . $deleteModalId . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $row->id . '" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header text-white">
                                    <h5 class="modal-title">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>' . e($row->country_name) . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    
                                    <form action="' . route('countries.destroy', $row->id) . '" method="POST" class="d-inline">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            })
            ->filter(function ($query) use ($request) {
                if ($request->country_name) {
                    $query->where('country_name', 'like', "%{$request->country_name}%");
                }
                if ($request->country_code) {
                    $query->where('country_code', 'like', "%{$request->country_code}%");
                }
                if ($request->currency_name) {
                    $query->where('currency_name', 'like', "%{$request->currency_name}%");
                }
                if ($request->currency_code) {
                    $query->where('currency_code', 'like', "%{$request->currency_code}%");
                }
                if ($request->currency_symbol) {
                    $query->where('currency_symbol', 'like', "%{$request->currency_symbol}%");
                }
            })
            ->rawColumns(['flag', 'actions'])
            ->make(true);
    }


    /**
     * Display Country List Page
     */
    public function index()
    {
        return view('admin.countries.index', [
            'title' => 'Country List',
        ]);
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        return view('admin.countries.create', [
            'title' => 'Add Country',
        ]);
    }

    /**
     * Store New Country
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_name' => 'required|string|max:255',
            'country_code' => 'required|string|max:10',
            'currency_name' => 'required|string|max:255',
            'currency_code' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'flag' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('flag')) {
            $file = $request->file('flag');
            $filename = strtolower($request->country_code) . '.' . $file->getClientOriginalExtension();
            $validated['flag'] = $file->storeAs('flags', $filename, 'public');
        }

        Country::create($validated);

        return redirect()->route('countries.index')->with('success', 'Country added successfully!');
    }

    /**
     * Show Edit Form
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);

        return view('admin.countries.edit', [
            'title' => 'Edit Country',
            'country' => $country,
        ]);
    }

    /**
     * Update Country
     */
    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'country_name' => 'required|string|max:255',
            'country_code' => 'required|string|max:10',
            'currency_name' => 'required|string|max:255',
            'currency_code' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'flag' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('flag')) {
            // Hapus flag lama
            if ($country->flag && Storage::disk('public')->exists($country->flag)) {
                Storage::disk('public')->delete($country->flag);
            }

            $file = $request->file('flag');
            $filename = strtolower($request->country_code) . '.' . $file->getClientOriginalExtension();
            $validated['flag'] = $file->storeAs('flags', $filename, 'public');
        }

        $country->update($validated);

        return redirect()->route('countries.index')->with('success', 'Country updated successfully!');
    }

    /**
     * Delete Country
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);

        if ($country->flag && Storage::disk('public')->exists($country->flag)) {
            Storage::disk('public')->delete($country->flag);
        }

        $country->delete();

        return redirect()->route('countries.index')->with('success', 'Country deleted successfully!');
    }

    /**
     * Optional: Search (for Select2)
     */
    public function search(Request $request)
    {
        $term = $request->input('term', '');

        $countries = Country::where('country_name', 'LIKE', "%{$term}%")
            ->orderBy('country_name')
            ->limit(20)
            ->get(['id', 'country_name as text']);

        return response()->json(['results' => $countries]);
    }
}
