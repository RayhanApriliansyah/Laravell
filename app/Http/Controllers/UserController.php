<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ✅ Menampilkan daftar user (halaman utama user management)
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('occupation', 'like', '%' . $request->search . '%');
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.users.index', [
            'title' => 'User Management',
            'menuAdminUser' => 'active',
            'users' => $users,
            'search' => $request->search ?? '',
        ]);
    }

    /**
     * ✅ AJAX Search (untuk real-time search)
     */
    public function getData(Request $request)
    {
        $query = User::query();

        if ($request->name) $query->where('name', 'like', "%{$request->name}%");
        if ($request->email) $query->where('email', 'like', "%{$request->email}%");
        if ($request->role) $query->where('role', 'like', "%{$request->role}%");
        if ($request->status) $query->where('status', 'like', "%{$request->status}%");
        if ($request->created_at) $query->whereDate('created_at', $request->created_at);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                $gender = strtolower($row->gender ?? '');
                $selectedImage = $gender === 'female' ? 'user-2.jpg' : 'user-1.jpg';
                $profileImage = $row->profile_image ?? $selectedImage;

                return '
                <div class="d-flex align-items-center gap-6">
                    <img src="' . asset('assets/images/profile/' . $profileImage) . '" class="rounded-circle" width="50" />
                    <div class="ms-3">
                        <h6 class="mb-0">' . e($row->name) . '</h6>
                        <small class="text-muted">' . e($row->occupation ?? '-') . '</small>
                    </div>
                </div>';
            })
            ->addColumn('created_at', function ($row) {
                return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i');
            })

            ->addColumn('role', function ($row) {
                if ($row->role === 'admin') {
                    return '<span class="mb-2 badge rounded-pill bg-secondary-subtle text-secondary">Admin</span>';
                } else {
                    return '<span class="mb-2 badge rounded-pill bg-primary-subtle text-primary">User</span>';
                }
            })
            ->addColumn('status', function ($row) {
                $badge = $row->status == 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
                return $badge;
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="dropdown">
                    <button class="btn bg-primary-subtle text-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . route('userEdit', $row->id) . '">Edit</a></li>
                        <li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row->id . '">Delete</button></li>
                    </ul>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="deleteModal' . $row->id . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $row->id . '" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel' . $row->id . '">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>' . e($row->name) . '</strong>?
                            </div>
                            <div class="modal-footer">
                                
                                <form action="' . route('userDestroy', $row->id) . '" method="POST" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
            })
            ->rawColumns(['user', 'role', 'status', 'actions', 'created_at'])
            ->make(true);
    }
    public function create()
    {
        $data = [
            'title' => 'Add Users',
            'menuAdminUser' => 'active',
        ];

        return view('admin.users.create', $data);
    }
    public function store(Request $request)
    {
        $request->merge(['gender' => strtolower($request->gender)]);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8',
            'occupation' => 'nullable|string|max:255',
            'role'       => 'required|string',
            'status'     => 'required|string',
            'gender'     => 'required|string|in:male,female',
        ]);

        // Pilih gambar default sesuai gender
        $maleImages = ['user-1.jpg'];
        $femaleImages = ['user-2.jpg'];

        $selectedImage = $request->gender === 'female'
            ? $femaleImages[array_rand($femaleImages)]
            : $maleImages[array_rand($maleImages)];

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'occupation'    => $request->occupation,
            'role'          => $request->role,
            'status'        => $request->status,
            'gender'        => $request->gender,
            'profile_image' => $selectedImage,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * ✅ Form edit user
     */
    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'menuAdminUser' => 'active',
            'user' => User::findOrFail($id),
        ];
        return view('admin.users.edit', $data);
    }

    /**
     * ✅ Update user
     */
    public function update(Request $request, $id)
    {
        $request->merge(['gender' => strtolower($request->gender)]);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'password'   => 'nullable|min:8',
            'occupation' => 'nullable|string|max:255',
            'role'       => 'required|string',
            'status'     => 'required|string',
            'gender'     => 'required|in:male,female',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'gender.required' => 'Gender wajib dipilih.',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->occupation = $request->occupation;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->gender = $request->gender;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    /**
     * ✅ Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
