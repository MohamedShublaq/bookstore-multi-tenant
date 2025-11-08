@extends('Dashboard.Layouts.app')

@section('title', 'Edit Coupon')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/Dashboard/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/toggle/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/plugins/forms/switch.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/core/colors/palette-switch.css') }}">
@endpush

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Edit coupon</h3>
                </div>
                <div class="content-body w-100">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form action="{{ route('library.coupons.update', $coupon->id) }}" method="POST"
                                        class="form">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Code <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" value="{{ old('code', $coupon->code) }}"
                                                                class="form-control" name="code" id="code" required>
                                                            <button type="button" id="generate_code"
                                                                class="btn btn-outline-primary">Generate</button>
                                                        </div>
                                                        @error('code')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Discount Type <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="discount_type" id="discount_type"
                                                            required>
                                                            <option
                                                                {{ $coupon->discount_type === \App\Enums\DiscountType::Fixed ? 'selected' : ' ' }}
                                                                value="{{ \App\Enums\DiscountType::Fixed->value }}">
                                                                Fixed amount</option>
                                                            <option
                                                                {{ $coupon->discount_type === \App\Enums\DiscountType::Percentage ? 'selected' : ' ' }}
                                                                value="{{ \App\Enums\DiscountType::Percentage->value }}">
                                                                Percentage</option>
                                                        </select>
                                                        @error('discount_type')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Discount Value
                                                            <span id="discount_unit" class="text-muted"></span>
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input id="discount_value" name="discount_value" type="text"
                                                            class="form-control" required
                                                            value="{{ old('discount_value', $coupon->discount_value) }}" />
                                                        @error('discount_value')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Start Date</label>
                                                    <input type="date"
                                                        value="{{ old('start_date', $coupon->start_date) }}"
                                                        class="form-control" name="start_date" data-toggle="tooltip"
                                                        data-trigger="hover" data-placement="top">
                                                    @error('start_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>End Date</label>
                                                    <input type="date" value="{{ old('end_date', $coupon->end_date) }}"
                                                        class="form-control" name="end_date" data-toggle="tooltip"
                                                        data-trigger="hover" data-placement="top">
                                                    @error('end_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-center">
                                                <div class="form-group text-center">
                                                    <label class="d-block mb-2" for="switcherySize">Make the coupon for
                                                        all
                                                        books?</label>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="hidden" name="applies_to_all_books" value="0">
                                                        <input name="applies_to_all_books" type="checkbox"
                                                            id="applies_to_all_books" class="switchery" data-size="md"
                                                            value="1"
                                                            {{ old('applies_to_all_books', $coupon->applies_to_all_books) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="categories_books">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Categories</label>
                                                        @php
                                                            $selectedCategories = old(
                                                                'categories',
                                                                $coupon->categories()->pluck('category_id')->toArray(),
                                                            );
                                                        @endphp

                                                        <select name="categories[]" class="select2-tags form-control"
                                                            multiple>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('categories')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Books</label>
                                                        @php
                                                            $selectedBooks = old(
                                                                'books',
                                                                $coupon->books()->pluck('book_id')->toArray(),
                                                            );
                                                        @endphp
                                                        <select name="books[]" class="select2-tags form-control"
                                                            multiple="" id="select2-tags">
                                                            @foreach ($books as $book)
                                                                <option value="{{ $book->id }}"
                                                                    {{ in_array($book->id, $selectedBooks) ? 'selected' : '' }}>
                                                                    {{ $book->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('books')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Usage Limit</label>
                                                        <input type="text"
                                                            value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                                            class="form-control" name="usage_limit">
                                                        @error('usage_limit')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Per User Limit</label>
                                                        <input type="text"
                                                            value="{{ old('per_user_limit', $coupon->per_user_limit) }}"
                                                            class="form-control" name="per_user_limit">
                                                        @error('per_user_limit')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
        document.getElementById('generate_code').addEventListener('click', function() {
            fetch('{{ route('library.coupons.generateCode') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('code').value = data.code;
                })
                .catch(error => {
                    console.error('Error generating code:', error);
                    alert('Error generating code, please try again.');
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            const $checkbox = $('#applies_to_all_books');
            const $categoriesBooks = $('#categories_books');

            toggleCategoriesBooks($checkbox.is(':checked'));

            $checkbox.on('change', function() {
                toggleCategoriesBooks($(this).is(':checked'));
            });

            function toggleCategoriesBooks(isChecked) {
                if (isChecked) {
                    $categoriesBooks.slideUp(300);
                } else {
                    $categoriesBooks.slideDown(300);
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const PERCENT = @json(\App\Enums\DiscountType::Percentage->value);
            const FIXED = @json(\App\Enums\DiscountType::Fixed->value);
            const CURRENCY = @json(app()->has('library') ? app('library')->currency : 'USD');

            const discountTypeSelect = document.getElementById('discount_type');
            const discountUnit = document.getElementById('discount_unit');

            function updateDiscountUnit() {
                const selectedValue = discountTypeSelect.value;

                if (selectedValue == PERCENT) {
                    discountUnit.textContent = '(%)';
                } else if (selectedValue == FIXED) {
                    discountUnit.textContent = `(${CURRENCY})`;
                } else {
                    discountUnit.textContent = '';
                }
            }
            updateDiscountUnit();
            discountTypeSelect.addEventListener('change', updateDiscountUnit);
        });
    </script>
@endpush
