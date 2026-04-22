@extends('layout/app')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">

        <!-- Breadcrumb -->
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
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('consignee.index') }}">Consignee</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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

        <!-- Form Edit -->
        <div class="card">
            <div class="card-body">

                <form action="{{ route('consignee.update', $consignee->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Consignee Name</label>
                        <input type="text" name="name" value="{{ $consignee->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NPWP</label>
                        <input type="text" name="npwp" value="{{ $consignee->npwp }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ $consignee->address }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('consignee.index') }}" class="btn btn-secondary">Back</a>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection