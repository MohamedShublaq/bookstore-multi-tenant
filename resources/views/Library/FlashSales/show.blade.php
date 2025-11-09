@extends('Dashboard.Layouts.app')

@section('title', 'Flash Sale Details')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/Dashboard/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/toggle/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/plugins/forms/switch.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/core/colors/palette-switch.css') }}">
    <style>
        .info-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 17px;
            color: #222;
        }

        .info-box {
            padding: 18px;
            border-radius: 10px;
            background: #fafafa;
            border: 1px solid #e3e3e3;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Flash Sale Details</h3>
                </div>
            </div>

            <div class="content-body">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">

                                <div class="info-box">
                                    <div class="section-title">General Information</div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Discount Type</div>
                                            <div class="info-value">
                                                {{ $flashSale->discount_type->name }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Discount Value</div>
                                            <div class="info-value">
                                                @if ($flashSale->discount_type === \App\Enums\DiscountType::Percentage)
                                                    {{ $flashSale->discount_value }} %
                                                @else
                                                    {{ $flashSale->discount_value }} {{ app('library')->currency ?? 'USD' }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Status</div>
                                            <div class="info-value">
                                                {!! $flashSale->showStatus() !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="info-box">
                                    <div class="section-title">Duration</div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Start At</div>
                                            <div class="info-value">
                                                {{ $flashSale->start_at_format }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">End At</div>
                                            <div class="info-value">
                                                {{ $flashSale->end_at_format }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="section-title">Flash Sale Scope</div>

                                    <div class="info-label mb-2">Applies to all books?</div>
                                    <div class="info-value mb-3">
                                        {{ $flashSale->applies_to_all_books ? 'Yes' : 'No' }}
                                    </div>

                                    @unless ($flashSale->applies_to_all_books)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-label">Categories</div>
                                                <select disabled name="categories[]" class="select2-tags form-control" multiple>
                                                    @foreach ($flashSale->categories as $category)
                                                        <option selected>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-label">Books</div>
                                                <select disabled name="books[]" class="select2-tags form-control" multiple>
                                                    @foreach ($flashSale->books as $book)
                                                        <option selected>{{ $book->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endunless
                                </div>

                                <div class="info-box">
                                    <div class="section-title">Created At</div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-value">
                                                {{ $flashSale->created_at }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('library.flash-sales.edit', $flashSale->id) }}" class="btn btn-primary mt-1">
                                    Edit Flash Sale
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/select/select2.full.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/js/scripts/forms/select/form-select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/bootstrap-switch.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/js/scripts/forms/switch.js') }}" type="text/javascript"></script>
@endpush
