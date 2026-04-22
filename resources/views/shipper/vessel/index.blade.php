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
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}"
                            alt="breadcrumb"
                            class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="card">
            <div class="card-body">

                <a href="{{ route('vessel.create') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus fs-4"></i>&nbsp; Add Vessel
                </a>

                <div class="table-responsive">
                    <table id="vesselTable" class="table table-striped table-bordered text-nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Logo</th>
                                <th class="text-center">Vessel Name</th>
                                <th class="text-center">IMO</th>
                                <th class="text-center">Country</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <!-- search per column -->
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>

                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search"
                                            data-name="name" placeholder="Search Vessel">
                                    </div>
                                </th>

                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search"
                                            data-name="imo" placeholder="Search IMO">
                                    </div>
                                </th>

                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search"
                                            data-name="country" placeholder="Search Country">
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
    let table = $('#vesselTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("vessel.data") }}',
            data: function(d) {
                $('.column-search').each(function() {
                    d[$(this).data('name')] = $(this).val();
                });
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'text-center'
            },
            {
                data: 'logo',
                name: 'logo',
                className: 'text-center'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'imo',
                name: 'imo',
                className: 'text-center'
            },
            {
                data: 'country',
                name: 'country.name',
                className: 'text-center'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
        ],
        order: [
            [2, 'asc']
        ],
        pageLength: 10,
        responsive: true,
        autoWidth: false,
    });

    // Debounce search
    $('.column-search').on('input', function() {
        clearTimeout($.data(this, 'timer'));
        $(this).data('timer', setTimeout(() => table.ajax.reload(null, false), 300));
    });
</script>

<style>
    table.dataTable tbody td,
    table.dataTable thead th {
        text-align: center;
        vertical-align: middle;
    }

    div.dataTables_wrapper {
        overflow-x: auto;
        overflow-y: visible;
        padding-bottom: 1rem;
    }

    table.dataTable {
        margin-bottom: 0 !important;
        width: 100% !important;
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