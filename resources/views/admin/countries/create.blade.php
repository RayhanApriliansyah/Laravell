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

                <form action="{{ route('countries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Country Name</label>
                        <input type="text" name="country_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country Code</label>
                        <input type="text" name="country_code" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency Name</label>
                        <input type="text" name="currency_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency Code</label>
                        <input type="text" name="currency_code" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Flag Image</label>
                        <input type="file" name="flag" id="flag" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-3">
                            <img id="flagPreview" src="#" alt="Preview" style="display:none; width:80px; height:80px; border-radius:8px; border:1px solid #ccc;">
                        </div>
                    </div>

                    <div class="mt-4 text-left">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('airport.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('flagPreview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = 'block';
        }
    </script>
    @endsection