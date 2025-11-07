@extends('Dashboard.Layouts.app')

@section('title', 'Books')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/datatables.css') }}">
@endpush

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">
                        Books
                    </h3>
                </div>
                <div class="content-body w-100">
                    <section id="configuration">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <a href="{{ route('library.books.create') }}" class="btn btn-info">
                                            <i class="la la-plus"></i> Create Book
                                        </a>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            <table id="books-table"
                                                class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Total Stock</th>
                                                        <th>Quantity</th>
                                                        <th>Publish Year</th>
                                                        <th>Price</th>
                                                        <th>Availability</th>
                                                        <th>Category</th>
                                                        <th>Author</th>
                                                        <th>Created at</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('library.books.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: true
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true
                    },
                    {
                        data: 'total_stock',
                        name: 'total_stock',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'publish_year',
                        name: 'publish_year',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: true
                    },
                    {
                        data: 'is_available',
                        name: 'is_available',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                        orderable: true
                    },
                    {
                        data: 'author_name',
                        name: 'author_name',
                        orderable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endpush
