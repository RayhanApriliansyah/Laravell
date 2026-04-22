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
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3 text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="breadcrumb" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="card">
            <div class="card-body">
                <a href="{{ route('airport.create') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus fs-4"></i>&nbsp; Add Airport
                </a>

                <div class="table-responsive">
                    <table id="airportTable" class="table table-striped table-bordered text-nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Flag</th>
                                <th class="text-center">Airport Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Country</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <!-- Search per kolom -->
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="name" placeholder="Search Name">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="code" placeholder="Search Code">
                                    </div>
                                </th>

                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="country" placeholder="Search Country">
                                    </div>
                                </th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- Responsive -->
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        let table = $('#airportTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("airport.data") }}',
                data: function(d) {
                    $('.column-search').each(function() {
                        d[$(this).data('name')] = $(this).val();
                    });
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'logo',
                    name: 'logo',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'country',
                    name: 'country'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [
                [2, 'asc']
            ],
            pageLength: 10,
            responsive: true,
            autoWidth: false,
        });

        // Realtime search per kolom (debounce 300ms)
        $('.column-search').on('input', function() {
            clearTimeout($.data(this, 'timer'));
            $(this).data('timer', setTimeout(() => table.ajax.reload(null, false), 300));
        });
    });
</script>

<style>
    div.dataTables_wrapper {
        overflow-x: auto;
        overflow-y: visible;
        padding-bottom: 1rem;
    }

    table.dataTable tbody td,
    table.dataTable thead th {
        text-align: center;
        vertical-align: middle;
    }

    .dataTables_paginate {
        margin-top: 1rem;
    }

    .dataTables_length,
    .dataTables_filter {
        margin-bottom: 0.5rem;
    }
</style>
@endpush