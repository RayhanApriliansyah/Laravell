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
                                    <a class="text-muted" href="{{ route('airport.index') }}">Airports</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Airport</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('airport.update', $airport->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Airport Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $airport->name) }}" required>
                    </div>

                    {{-- Code --}}
                    <div class="mb-3">
                        <label class="form-label">Airport Code</label>
                        <input type="text" name="code" class="form-control"
                            value="{{ old('code', $airport->code) }}" required>
                    </div>


                    {{-- Country --}}
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select name="country_id" class="form-select" required>
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ old('country_id', $airport->country_id) == $country->id ? 'selected' : '' }}>
                                {{ $country->country_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Logo --}}
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control mb-2" accept="image/*">
                        @if($airport->logo)
                        <div>
                            <img src="{{ asset('storage/' . $airport->logo) }}"
                                alt="Logo" width="100" class="rounded border">
                        </div>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('airport.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection