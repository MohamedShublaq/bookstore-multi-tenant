@extends('Dashboard.Layouts.app')

@section('title', 'Edit Book')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/selects/selectize.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/Dashboard/vendors/css/forms/selects/selectize.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/plugins/forms/selectize/selectize.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/toggle/switchery.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
@endpush

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Edit book</h3>
                </div>
                <div class="content-body w-100">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form action="{{ route('library.books.update', $book->id) }}" method="POST"
                                        class="form" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ old('name', $book->name) }}"
                                                            class="form-control" name="name" required>
                                                        @error('name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Total Stock <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ old('total_stock', $book->total_stock) }}"
                                                            class="form-control" name="total_stock" required>
                                                        @error('total_stock')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Publish year <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            value="{{ old('publish_year', $book->publish_year) }}"
                                                            class="form-control" name="publish_year" required>
                                                        @error('publish_year')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Price <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ old('price', $book->price) }}"
                                                            class="form-control" name="price" required>
                                                        @error('price')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="rate">Rate <span class="text-muted">(out of 5)</span> <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ old('rate', $book->rate) }}"
                                                            class="form-control" name="rate" required>
                                                        @error('rate')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Pages <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ old('pages', $book->pages) }}"
                                                            class="form-control" name="pages" required>
                                                        @error('pages')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="description" rows="10">{{ old('description', $book->description) }}</textarea>
                                                        @error('description')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Image</label>
                                                        <input type="file" class="form-control dropify" name="image">
                                                        @error('image')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Category <span class="text-danger">*</span></label>
                                                        <select class="selectize-select" name="category_id" required>
                                                            <option selected disabled value="">Choose category
                                                            </option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Language <span class="text-danger">*</span></label>
                                                        <select class="selectize-select" name="language_id" required>
                                                            <option selected disabled value="">Choose language
                                                            </option>
                                                            @foreach ($languages as $language)
                                                                <option value="{{ $language->id }}"
                                                                    {{ $book->language_id == $language->id ? 'selected' : '' }}>
                                                                    {{ $language->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Author <span class="text-danger">*</span></label>
                                                        <select class="selectize-select" name="author_id" required>
                                                            <option selected disabled value="">Choose author</option>
                                                            @foreach ($authors as $author)
                                                                <option value="{{ $author->id }}"
                                                                    {{ $book->author_id == $author->id ? 'selected' : '' }}>
                                                                    {{ $author->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Publisher <span class="text-danger">*</span></label>
                                                        <select class="selectize-select" name="publisher_id" required>
                                                            <option selected disabled value="">Choose publisher
                                                            </option>
                                                            @foreach ($publishers as $publisher)
                                                                <option value="{{ $publisher->id }}"
                                                                    {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>
                                                                    {{ $publisher->name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> Save
                                            </button>
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
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/select/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/js/scripts/forms/select/form-selectize.js') }}" type="text/javascript">
    </script>
    {{-- <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/bootstrap-switch.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard//js/scripts/forms/switch.js') }}" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drop the image here',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
