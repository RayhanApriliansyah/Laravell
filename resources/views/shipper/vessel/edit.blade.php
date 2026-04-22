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
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted" href="{{ route('vessel.index') }}">Vessel</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Vessel</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('vessel.update', $vessel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Vessel Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $vessel->name) }}" required>
                    </div>

                    {{-- IMO --}}
                    <div class="mb-3">
                        <label class="form-label">IMO Number</label>
                        <input type="text" name="imo" class="form-control"
                            value="{{ old('imo', $vessel->imo) }}" required>
                    </div>

                    {{-- Country --}}
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select class="form-select country-select" name="country_id">
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ old('country_id', $vessel->country_id) == $country->id ? 'selected' : '' }}>
                                {{ $country->country_name }} ({{ $country->country_code }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Logo --}}
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control mb-2">

                        @if($vessel->logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $vessel->logo) }}"
                                alt="Logo"
                                width="120"
                                class="rounded border">
                        </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('vessel.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection