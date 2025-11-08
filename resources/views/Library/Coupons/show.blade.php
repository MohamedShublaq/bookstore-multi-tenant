@extends('Dashboard.Layouts.app')

@section('title', 'Coupon Details')

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
                    <h3 class="content-header-title">Coupon Details</h3>
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
                                            <div class="info-label">Code</div>
                                            <div class="info-value">{{ $coupon->code }}</div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Status</div>
                                            <div class="info-value">
                                                {!! $coupon->showStatus() !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Discount Type</div>
                                            <div class="info-value">
                                                {{ $coupon->discount_type->name }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Discount Value</div>
                                            <div class="info-value">
                                                @if ($coupon->discount_type === \App\Enums\DiscountType::Percentage)
                                                    {{ $coupon->discount_value }} %
                                                @else
                                                    {{ $coupon->discount_value }} {{ app('library')->currency ?? 'USD' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="info-box">
                                    <div class="section-title">Duration</div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Start Date</div>
                                            <div class="info-value">
                                                {{ $coupon->start_date ? $coupon->start_date : '—' }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">End Date</div>
                                            <div class="info-value">
                                                {{ $coupon->end_date ? $coupon->end_date : '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="section-title">Coupon Scope</div>

                                    <div class="info-label mb-2">Applies to all books?</div>
                                    <div class="info-value mb-3">
                                        {{ $coupon->applies_to_all_books ? 'Yes' : 'No' }}
                                    </div>

                                    @unless ($coupon->applies_to_all_books)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-label">Categories</div>
                                                <select disabled name="categories[]" class="select2-tags form-control" multiple>
                                                    @foreach ($coupon->categories as $category)
                                                        <option selected>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-label">Books</div>
                                                <select disabled name="books[]" class="select2-tags form-control" multiple>
                                                    @foreach ($coupon->books as $book)
                                                        <option selected>{{ $book->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endunless
                                </div>

                                <div class="info-box">
                                    <div class="section-title">Restrictions</div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Usage Limit</div>
                                            <div class="info-value">
                                                {{ $coupon->usage_limit ?? 'Unlimited' }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="info-label">Per User Limit</div>
                                            <div class="info-value">
                                                {{ $coupon->per_user_limit ?? 'Unlimited' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="section-title">Created At</div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="info-value">
                                                {{ $coupon->created_at }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('library.coupons.edit', $coupon->id) }}" class="btn btn-primary mt-1">
                                    Edit Coupon
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
    <script>
        function toggleList(id, btn) {
            const list = document.getElementById(id);

            if (list.style.maxHeight === 'none') {
                list.style.maxHeight = '70px';
                btn.textContent = 'Show more';
            } else {
                list.style.maxHeight = 'none';
                btn.textContent = 'Show less';
            }
        }
    </script>
@endpush
