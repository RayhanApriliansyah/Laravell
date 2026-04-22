<?php

namespace App\Http\Controllers;

use App\Models\Shipper;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShipperController extends Controller
{
    public function index()
    {
        return view('shipper.index', [
            'title' => 'Shipper List'
        ]);
    }

    public function data(Request $request)
    {
        $query = Shipper::query();

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->address) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }
        if ($request->phone) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->contact) {
            $query->where('contact', 'like', '%' . $request->contact . '%');
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {

                return '
            <div class="dropdown">
                <button class="btn bg-primary-subtle text-primary dropdown-toggle" data-bs-toggle="dropdown">Action</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="' . route('shipper.edit', $row->id) . '"><i class="ti ti-edit"></i> Edit</a></li>
                    <li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row->id . '"><i class="ti ti-trash"></i> Delete</button></li>
                </ul>
            </div>

            <div class="modal fade" id="deleteModal' . $row->id . '" tabindex="-1" aria-hidden="true">
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
                            <form action="' . route('shipper.delete', $row->id) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('shipper.create', [
            'title' => 'Add Shipper'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required',
            'email'   => 'required|email',
            'contact' => 'required',
        ]);

        Shipper::create($request->all());

        return redirect()->route('shipper.index')->with('success', 'Shipper added successfully!');
    }

    public function edit($id)
    {
        $shipper = Shipper::findOrFail($id);

        return view('shipper.edit', [
            'title'   => 'Edit Shipper',
            'shipper' => $shipper
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required',
            'email'   => 'required|email',
            'contact' => 'required',
        ]);

        Shipper::findOrFail($id)->update($request->all());

        return redirect()->route('shipper.index')->with('success', 'Shipper updated successfully!');
    }

    public function destroy($id)
    {
        Shipper::findOrFail($id)->delete();

        return redirect()->route('shipper.index')->with('success', 'Shipper deleted successfully!');
    }
}
