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
                            <img src="{{asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('userStore') }}" method="POST" class="card p-4 shadow-sm">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('name') is-invalid @enderror">First Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
                        @error('name')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('email') is-invalid @enderror">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
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
                        <input type="text" name="occupation" class="form-control" placeholder="Contoh: Assistant Manager">
                        @error('occupation')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('role') is-invalid @enderror">Role</label>
                        <select name="role" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="user" selected>User</option>
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
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                        <small class="text-danger mt-2 text-sm">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputfirstname4" class="form-label @error('status') is-invalid @enderror">Gender</label>
                        <select name="gender" class="form-select" class="form-control">
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                    </div>

                    <div class="mt-4 text-left">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('airport.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection