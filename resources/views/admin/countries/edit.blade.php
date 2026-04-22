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
        <div class="card">
            <div class="card-body">


                <form action="{{ route('countries.update', $country->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Country Name</label>
                        <input type="text" name="country_name" id="country_name" class="form-control" value="{{ $country->country_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country Code</label>
                        <input type="text" name="country_code" class="form-control" value="{{ $country->country_code }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency Name</label>
                        <input type="text" name="currency_name" class="form-control" value="{{ $country->currency_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency Code</label>
                        <input type="text" name="currency_code" class="form-control" value="{{ $country->currency_code }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control" value="{{ $country->currency_symbol }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Flag Image</label>
                        <input type="file" name="flag" id="flag" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-3">
                            @if ($country->flag)
                            <img id="flagPreview" src="{{ asset('storage/' . $country->flag) }}" width="80" height="80" class="rounded border">
                            @else
                            <img id="flagPreview" src="#" style="display:none; width:80px; height:80px; border-radius:8px; border:1px solid #ccc;">
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('flagPreview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endpush
@endsection