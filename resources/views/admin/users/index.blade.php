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
                                    <a class="text-muted text-decoration-none" href="#">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3 text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="breadcrumb-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <a href="{{ route('userCreate') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus fs-4"></i>&nbsp; Add User
                </a>

                <div class="table-responsive">
                    <table id="usersTable" class="table table-striped table-bordered text-nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">User</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Create Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="name" placeholder="Search User">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="email" placeholder="Search Email">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="role" placeholder="Search Role">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="created_at" placeholder="Search Date">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative">
                                        <span class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></span>
                                        <input type="text" class="form-control ps-5 column-search" data-name="status" placeholder="Search Status">
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
<!-- DataTables dependencies -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

<script>
    $(document).ready(function() {
        let table = $('#usersTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{ route("users.data") }}',
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
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'user',
                    name: 'user',
                    className: 'text-center'
                },
                {
                    data: 'email',
                    name: 'email',
                    className: 'text-center'
                },
                {
                    data: 'role',
                    name: 'role',
                    className: 'text-center'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
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
                [1, 'asc']
            ],
            pageLength: 10,
            responsive: true,
            autoWidth: false,
            processing: false
        });

        // realtime search kolom dengan debounce 300ms
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