<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AirportController extends Controller
{
    /**
     * Datatables source
     */
    public function getAirports(Request $request)
    {
        $query = Airport::with('country')->select('airports.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('logo', function ($row) {
                return $row->logo
                    ? '<img src="' . asset('storage/' . $row->logo) . '" width="50" height="50" class="rounded border">'
                    : '<span class="text-muted fst-italic">No Logo</span>';
            })
            ->addColumn('country', fn($row) => $row->country->country_name ?? '-')
            ->addColumn('actions', function ($row) {
                $edit = route('airport.edit', $row->id);
                $delete = route('airport.destroy', $row->id);
                $modalId = 'deleteAirportModal' . $row->id;

                return '
                    <div class="dropdown">
                        <button class="btn bg-primary-subtle text-primary dropdown-toggle" data-bs-toggle="dropdown">Action</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . $edit . '"><i class="ti ti-edit"></i> Edit</a></li>
                            <li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i class="ti ti-trash"></i> Delete</button></li>
                        </ul>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure want to delete <strong>' . e($row->name) . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    
                                    <form action="' . $delete . '" method="POST" class="d-inline">'
                    . csrf_field() . method_field('DELETE') . '
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
                if ($request->name) $query->where('name', 'like', "%{$request->name}%");
                if ($request->code) $query->where('code', 'like', "%{$request->code}%");
                if ($request->country) {
                    $query->whereHas(
                        'country',
                        fn($q) =>
                        $q->where('country_name', 'like', "%{$request->country}%")
                    );
                }
            })
            ->rawColumns(['logo', 'actions'])
            ->make(true);
    }

    /**
     * Index page
     */
    public function index()
    {
        return view('admin.airport.index', [
            'title' => 'Airport Management',
        ]);
    }

    /**
     * Create form
     */
    public function create()
    {
        $countries = Country::orderBy('country_name')->get();

        return view('admin.airport.create', [
            'title' => 'Add Airport / Seaport',
            'countries' => $countries,
        ]);
    }

    /**
     * Store new airport
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airports,code',
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = strtolower($validated['code']) . '.' . $file->getClientOriginalExtension();
            $validated['logo'] = $file->storeAs('airport_logos', $filename, 'public');
        }

        Airport::create($validated);

        return redirect()->route('airport.index')->with('success', 'Airport added successfully!');
    }

    /**
     * Edit form
     */
    public function edit($id)
    {
        $airport = Airport::findOrFail($id);
        $countries = Country::orderBy('country_name')->get();

        return view('admin.airport.edit', [
            'title' => 'Edit Airport / Seaport',
            'airport' => $airport,
            'countries' => $countries,
        ]);
    }

    /**
     * Update airport
     */
    public function update(Request $request, $id)
    {
        $airport = Airport::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airports,code,' . $id,
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($airport->logo && Storage::disk('public')->exists($airport->logo)) {
                Storage::disk('public')->delete($airport->logo);
            }
            $file = $request->file('logo');
            $filename = strtolower($validated['code']) . '.' . $file->getClientOriginalExtension();
            $validated['logo'] = $file->storeAs('airport_logos', $filename, 'public');
        }

        $airport->update($validated);

        return redirect()->route('airport.index')->with('success', 'Airport updated successfully!');
    }

    /**
     * Delete airport
     */
    public function destroy($id)
    {
        $airport = Airport::findOrFail($id);

        if ($airport->logo && Storage::disk('public')->exists($airport->logo)) {
            Storage::disk('public')->delete($airport->logo);
        }

        $airport->delete();

        return redirect()->route('airport.index')->with('success', 'Airport deleted successfully!');
    }
}
