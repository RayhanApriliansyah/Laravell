@extends('layout/app')

@section('content')
<!-- Breadcrumb -->
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-4">
        <div class="row align-items-center">

            <div class="col-md-8 col-sm-7">
                <h4 class="fw-semibold mb-1">{{ $title }}</h4>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-4 col-sm-5 text-end">
                <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}"
                    alt="breadcrumb"
                    class="img-fluid"
                    style="max-height:90px; object-fit:contain;">
            </div>

        </div>
    </div>
</div>

<!-- Form Create Shipper -->
<div class="card shadow-sm border-0">
    <div class="card-body px-4 py-4">

        <form action="{{ route('shipper.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-lg-6">

                    {{-- Shipper Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Shipper Name</label>
                        <input type="text" name="name" class="form-control shadow-sm"
                            placeholder="Enter shipper name" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control shadow-sm"
                            placeholder="Enter email" required>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control shadow-sm"
                            placeholder="Enter phone number" required>
                    </div>

                </div>

                <div class="col-lg-6">

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control shadow-sm" rows="4"
                            placeholder="Enter address" required></textarea>
                    </div>

                    {{-- Logo --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Shipper Logo (optional)</label>
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
                <a href="{{ route('shipper.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>

</div>
</div>
@endsection


@push('scripts')
<script>
    // Preview image sebelum submit
    function previewImage(event) {
        const preview = document.getElementById('logoPreview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = 'block';
    }
</script>
@endpush