<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConsigneeController extends Controller
{
    /**
     * Datatables source
     */
    public function getConsignees(Request $request)
    {
        $query = Consignee::select('*');

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('actions', function ($row) {
                $edit = route('consignee.edit', $row->id);
                $delete = route('consignee.delete', $row->id);
                $modalId = 'deleteModal' . $row->id;

                return '
                    <div class="dropdown">
                        <button class="btn bg-primary-subtle text-primary dropdown-toggle" data-bs-toggle="dropdown">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . $edit . '">
                                <i class="ti ti-edit"></i> Edit
                            </a></li>
                            <li>
                                <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                    data-bs-target="#' . $modalId . '">
                                    <i class="ti ti-trash"></i> Delete
                                </button>
                            </li>
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
                if ($request->name)
                    $query->where('name', 'like', "%{$request->name}%");

                if ($request->npwp)
                    $query->where('npwp', 'like', "%{$request->npwp}%");

                if ($request->address)
                    $query->where('address', 'like', "%{$request->address}%");
            })

            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Index page
     */
    public function index()
    {
        return view('consignee.index', [
            'title' => 'Consignee Management'
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('consignee.create', [
            'title' => 'Add Consignee',
        ]);
    }

    /**
     * Store new consignee
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'npwp'    => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        Consignee::create($validated);

        return redirect()->route('consignee.index')
            ->with('success', 'Consignee added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $consignee = Consignee::findOrFail($id);

        return  
            view('consignee.edit', [
                'title'     => 'Edit Consignee',
                'consignee' => $consignee,
            ]);
    }

    /**
     * Update consignee
     */
    public function update(Request $request, $id)
    {
        $consignee = Consignee::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'npwp'    => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $consignee->update($validated);

        return redirect()->route('consignee.index')
            ->with('success', 'Consignee updated successfully!');
    }

    /**
     * Delete consignee
     */
    public function destroy($id)
    {
        $consignee = Consignee::findOrFail($id);
        $consignee->delete();

        return redirect()->route('consignee.index')
            ->with('success', 'Consignee deleted successfully!');
    }
}
