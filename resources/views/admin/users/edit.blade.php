@extends('layout/app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8"> {{$title}} </h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">{{$title}}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('userUpdate', $user->id) }}" method="POST" class="card p-4 shadow-sm">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('name') is-invalid @enderror">First Name</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}">
                        @error('name')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('email') is-invalid @enderror">Email</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email}}">
                        @error('email')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('password') is-invalid @enderror">Password </label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        @error('password')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('occupation') is-invalid @enderror">Occupation</label>
                        <input type="text" name="occupation" class="form-control" value="{{$user->occupation}}">
                        @error('occupation')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('role') is-invalid @enderror">Role</label>
                        <select name="role" class="form-select">
                            <option disabled>--Select Role--</option>
                            <option value="admin" {{$user->role == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="user" {{$user->role == 'user' ? 'selected' : ''}}>User</option>
                        </select>
                        @error('role')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('status') is-invalid @enderror">Status</label>
                        <select name="status" class="form-select" class="mb-3">
                            <option disabled>--Select Status--</option>
                            <option value="active" {{$user->status == 'active' ? 'selected' : ''}}>Active</option>
                            <option value="inactive" {{$user->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                        </select>
                        @error('status')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label @error('gender') is-invalid @enderror">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-primary">Submit</button>
                            <a href="{{route('users.index')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection