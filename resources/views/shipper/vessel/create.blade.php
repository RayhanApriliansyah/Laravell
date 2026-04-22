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

        <!-- Form Create Vessel -->
        <div class="card shadow-sm border-0">
            <div class="card-body px-4 py-4">

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('vessel.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Vessel Name</label>
                                <input type="text" name="name" class="form-control shadow-sm"
                                    placeholder="Enter vessel name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">IMO Number</label>
                                <input type="text" name="imo" class="form-control shadow-sm"
                                    placeholder="Enter IMO number" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Country</label>
                                <select class="form-select country-select" name="country_id">
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" data-flag="{{ $country->flag }}">
                                        {{ $country->country_name }} ({{ $country->country_code }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control shadow-sm"
                                    accept="image/*" onchange="previewImage(event)">
                                <div class="mt-3 text-center">
                                    <img id="logoPreview" src="#" alt="Preview"
                                        style="display:none; width:100px; height:100px; border-radius:12px; border:1px solid #ccc; object-fit:cover;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('vessel.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection


@push('scripts')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    /* === Samakan tampilan Select2 dengan form-select Bootstrap === */
    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #ced4da !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        background-color: #fff !important;
        display: flex !important;
        align-items: center !important;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    /* Hover efek seperti form-control */
    .select2-container--default .select2-selection--single:hover {
        border-color: #0d6efd !important;
        box-shadow: 0 0 4px rgba(13, 110, 253, 0.2) !important;
    }

    /* Placeholder dan teks sejajar */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6c757d !important;
        line-height: normal !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 2px !important;
        padding-right: 32px !important;
    }

    /* Panah dropdown sejajar kanan */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute !important;
        top: 50% !important;
        right: 10px !important;
        transform: translateY(-50%) !important;
        width: 20px !important;
        height: 20px !important;
    }

    /* Dropdown result styling */
    .select2-dropdown {
        border-radius: 8px !important;
        border: 1px solid #ced4da !important;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05) !important;
    }

    .select2-results__option {
        padding: 8px 10px !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    .select2-results__option img {
        width: 22px;
        height: 15px;
        border-radius: 2px;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    /* Saat terpilih */
    .select2-container--default .select2-selection--single .select2-selection__rendered img {
        width: 20px;
        height: 14px;
        border-radius: 2px;
        margin-right: 6px;
    }

    /* Highlight saat hover di dropdown */
    .select2-results__option--highlighted {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
</style>

<script>
    // Preview logo sebelum submit
    function previewImage(event) {
        const preview = document.getElementById('logoPreview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = 'block';
    }

    // Template country dengan flag
    $('.country-select').select2({
        templateResult: function(state) {
            return state.text;
        },
        templateSelection: function(state) {
            return state.text;
        }
    });

    $(document).ready(function() {
        $('.select2-country').select2({
            width: '100%',
            templateResult: formatCountry,
            templateSelection: formatCountry,
            placeholder: '-- Search or select a country --',
            allowClear: true,
        });
    });
</script>
@endpush