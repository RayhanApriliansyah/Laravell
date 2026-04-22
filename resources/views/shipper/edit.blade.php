@extends('layout/app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">{{ $title }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3 text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="breadcrumb"
                            class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('shipper.update', $shipper->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Shipper Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $shipper->name) }}" required>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $shipper->address) }}</textarea>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $shipper->phone) }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $shipper->email) }}">
                    </div>

                    {{-- Contact Person --}}
                    <div class="mb-3">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact" class="form-control"
                            value="{{ old('contact', $shipper->contact) }}">
                    </div>

                    {{-- Buttons --}}
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('shipper.index') }}" class="btn btn-secondary">Cancel</a>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection