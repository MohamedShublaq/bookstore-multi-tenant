@extends('Dashboard.Layouts.app')

@section('title', 'Flash Sales')

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
                        @php
                            $title = match (true) {
                                request()->filled('status') && request('status') == App\Enums\DiscountStatus::Active->value    => 'Active Flash Sales',
                                request()->filled('status') && request('status') == App\Enums\DiscountStatus::Inactive->value  => 'Inactive Flash Sales',
                                request()->filled('status') && request('status') == App\Enums\DiscountStatus::Scheduled->value => 'Scheduled Flash Sales',
                                request()->filled('status') && request('status') == App\Enums\DiscountStatus::Expired->value   => 'Expired Flash Sales',
                                default => 'All Flash Sales',
                            };
                        @endphp

                        {{ $title }}
                    </h3>
                </div>
                <div class="content-body w-100">
                    <section id="configuration">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    @if (!request()->filled('status'))
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <a href="{{ route('library.flash-sales.create') }}" class="btn btn-info">
                                                <i class="la la-plus"></i> Create Flash Sale
                                            </a>
                                        </div>
                                    @endif
                                    <div class="card-content collapse show">
                                        <div class="card-body card-dashboard">
                                            <table id="flash-sales-table"
                                                class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Discount</th>
                                                        <th>Start At</th>
                                                        <th>End At</th>
                                                        <th>Status</th>
                                                        <th>Applies to All Books?</th>
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
            $('#flash-sales-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('library.flash-sales.data') }}',
                    data: function(d) {
                        d.status = '{{ request('status') }}';
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: true
                    },
                    {
                        data: 'discount_value',
                        name: 'discount_value',
                        orderable: true
                    },
                    {
                        data: 'start_at_format',
                        name: 'start_at_format',
                        orderable: true
                    },
                    {
                        data: 'end_at_format',
                        name: 'end_at_format',
                        orderable: true
                    },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'applies_to_all_books',
                        name: 'applies_to_all_books',
                        orderable: false,
                        searchable: false
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
