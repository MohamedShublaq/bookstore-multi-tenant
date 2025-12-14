@extends('Dashboard.Layouts.app')

@section('title', 'Settings')

@push('style')
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
                    <h3 class="content-header-title">Settings</h3>
                </div>
                <div class="content-body w-100">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form action="{{ route('library.settings.toggleWebsiteStatus') }}" method="POST"
                                        class="form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="d-block mb-2" for="is_published">
                                                            Enable or disable your library’s public website
                                                        </label>
                                                        <div class="d-flex justify-content-start">
                                                            <input type="hidden" name="is_published" value="0">
                                                            <input name="is_published" type="checkbox" id="is_published"
                                                                class="switchery" data-size="md" value="1"
                                                                {{ old('is_published', $library->is_published) ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Inactive message</label>
                                                        <input id="inactive_message" name="inactive_message" type="text"
                                                            class="form-control"
                                                            value="{{ old('inactive_message', $library->inactive_message) }}" />
                                                        @error('inactive_message')
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
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/bootstrap-switch.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/js/scripts/forms/switch.js') }}" type="text/javascript"></script>
@endpush
