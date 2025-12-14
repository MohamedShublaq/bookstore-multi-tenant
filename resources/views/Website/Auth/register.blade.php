@extends('Website.Layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/Website/css/register.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .input_container {
            overflow: visible !important;
        }
    </style>
@endpush

@section('title', 'Register')

@section('content')
    <section class="main_bg py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    @if ($errors->has('register'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('register') }}</strong>
                        </div>
                    @endif
                    <form action="{{ tenant_route('website.register') }}" method="POST" class="login-form">
                        @csrf
                        <div class="d-flex gap-2 user-name">
                            <div class="d-flex flex-column gap-2">
                                <label>First Name</label>
                                <div class="input_container">
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" required />
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <label>Last Name</label>
                                <div class="input_container">
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" required />
                                </div>
                            </div>
                        </div>
                        @error('first_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        @error('last_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        <div class="d-flex flex-column gap-2 my-3">
                            <label for="email">Email</label>
                            <div class="input_container">
                                <input type="email" name="email" value="{{ old('email') }}" required />
                            </div>
                        </div>
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        <div class="d-flex flex-column gap-2 my-3">
                            <label for="phone">Phone</label>
                            <div class="input_container">
                                <input id="phone" type="tel" required />
                            </div>
                        </div>
                        <input type="hidden" name="full_phone" id="full_phone">
                        @error('full_phone')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        <div class="d-flex flex-column gap-2 my-3">
                            <label for="password">Password</label>
                            <div class="d-flex align-items-center input_container">
                                <input type="password" name="password" id="password" required />
                                <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                            </div>
                        </div>
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        <div class="d-flex flex-column gap-2 my-3">
                            <label for="password_confirmation">Confirm password</label>
                            <div class="d-flex align-items-center input_container">
                                <input type="password" name="password_confirmation" id="password_confirmation" required />
                                <i class="fa-regular fa-eye-slash" id="togglePasswordConfirmation"></i>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        <div>
                            <button type="submit" class="main_btn w-100 mt-3">
                                Sign Up
                            </button>
                        </div>
                    </form>
                    <p class="mt-4 text-center">
                        Already have an account?
                        <a href="{{ tenant_route('showLogin') }}" class="main_text">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function setupToggle(toggleId, fieldId) {
                const toggleIcon = document.getElementById(toggleId);
                const field = document.getElementById(fieldId);

                toggleIcon.addEventListener('click', function() {
                    const isPassword = field.type === 'password';
                    field.type = isPassword ? 'text' : 'password';

                    this.classList.toggle('fa-eye-slash');
                    this.classList.toggle('fa-eye');
                });
            }

            setupToggle('togglePassword', 'password');
            setupToggle('togglePasswordConfirmation', 'password_confirmation');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        const input = document.querySelector("#phone");

        const iti = window.intlTelInput(input, {
            preferredCountries: ["eg", "sa", "ae", "jo"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        input.addEventListener("blur", function() {
            document.querySelector("#full_phone").value = iti.getNumber();
        });
    </script>
@endpush
