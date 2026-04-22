<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class VesselController extends Controller
{
    /**
     * Datatables source
     */
    public function getVessels(Request $request)
    {
        $query = Vessel::with('country')->select('vessels.*');

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('logo', function ($row) {
                return $row->logo
                    ? '<img src="' . asset('storage/' . $row->logo) . '" width="50" height="50" class="rounded-circle border">'
                    : '<span class="text-muted">No Logo</span>';
            })

            ->addColumn('country', fn($row) => $row->country->country_name ?? '-')

            ->addColumn('actions', function ($row) {
                $edit = route('vessel.edit', $row->id);
                $delete = route('vessel.destroy', $row->id);
                $modalId = 'deleteModal' . $row->id;

                return '
                    <div class="dropdown">
                        <button class="btn bg-primary-subtle text-primary dropdown-toggle" data-bs-toggle="dropdown">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . $edit . '">
                                <i class="ti ti-edit"></i> Edit</a></li>
                            <li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">
                                <i class="ti ti-trash"></i> Delete
                            </button></li>
                        </ul>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Delete</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure want to delete <strong>' . $row->name . '</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="' . $delete . '" method="POST" class="d-inline">
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
                if ($request->name) {
                    $query->where('name', 'like', "%{$request->name}%");
                }
                if ($request->imo) {
                    $query->where('imo', 'like', "%{$request->imo}%");
                }
                if ($request->country) {
                    $query->whereHas('country', function ($q) use ($request) {
                        $q->where('country_name', 'like', "%{$request->country}%");
                    });
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
        return view('vessel.index', [
            'title' => 'Vessel Management',
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $countries = Country::orderBy('country_name')->get();

        return view('vessel.create', [
            'title' => 'Add Vessel',
            'countries' => $countries,
        ]);
    }

    /**
     * Store new vessel
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'imo'         => 'required|string|max:50|unique:vessels,imo',
            'country_id'  => 'required|exists:countries,id',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = strtolower($validated['imo']) . '.' . $file->getClientOriginalExtension();
            $validated['logo'] = $file->storeAs('vessel', $filename, 'public');
        }

        Vessel::create($validated);

        return redirect()->route('vessel.index')->with('success', 'Vessel added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $vessel = Vessel::findOrFail($id);
        $countries = Country::orderBy('country_name')->get();

        return view('vessel.edit', [
            'title' => 'Edit Vessel',
            'vessel' => $vessel,
            'countries' => $countries,
        ]);
    }

    /**
     * Update vessel
     */
    public function update(Request $request, $id)
    {
        $vessel = Vessel::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'imo'         => 'required|string|max:50|unique:vessels,imo,' . $id,
            'country_id'  => 'required|exists:countries,id',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        // Replace logo
        if ($request->hasFile('logo')) {
            if ($vessel->logo && Storage::disk('public')->exists($vessel->logo)) {
                Storage::disk('public')->delete($vessel->logo);
            }

            $file = $request->file('logo');
            $filename = strtolower($validated['imo']) . '.' . $file->getClientOriginalExtension();
            $validated['logo'] = $file->storeAs('vessel', $filename, 'public');
        }

        $vessel->update($validated);

        return redirect()->route('vessel.index')->with('success', 'Vessel updated successfully!');
    }

    /**
     * Delete vessel
     */
    public function destroy($id)
    {
        $vessel = Vessel::findOrFail($id);

        if ($vessel->logo && Storage::disk('public')->exists($vessel->logo)) {
            Storage::disk('public')->delete($vessel->logo);
        }

        $vessel->delete();

        return redirect()->route('vessel.index')->with('success', 'Vessel deleted successfully!');
    }
}
