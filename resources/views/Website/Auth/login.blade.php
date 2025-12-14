@extends('Website.Layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/Website/css/login.css') }}" />
@endpush

@section('title', 'Login')

@section('content')
    <section class="main_bg py-5">
        <div class="container">
            <p class="text-center main_text fw-bold py-4">Welcome Back!</p>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <form action="{{ tenant_route('login') }}" method="POST" class="login-form">
                        @csrf
                        <div class="d-flex flex-column gap-2">
                            <label for="identifier">Email/Phone</label>
                            <div class="input_container">
                                <input type="text" name="identifier" required />
                            </div>
                            @error('identifier')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="d-flex flex-column gap-2 my-3">
                            <label for="password">Password</label>
                            <div class="d-flex align-items-center input_container">
                                <input type="password" name="password" id="password" required />
                                <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                            </div>
                            @error('password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        {{-- <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <label for="rememberMe">Remember me</label>
                                <input type="checkbox" name="rememberme" id="rememberMe" />
                            </div>
                            <a href="{{route('showEnterEmail')}}" class="main_text">Forget password?</a>
                        </div>
                        @error('rememberme')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror --}}
                        <div>
                            <button type="submit" class="main_btn w-100 mt-3">
                                Log in
                            </button>
                        </div>
                    </form>
                    <p class="mt-4 text-center">
                        Don’t have an account?
                        <a href="{{ tenant_route('website.showRegister') }}" class="main_text">Signup</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const isPassword = passwordField.type === 'password';

                passwordField.type = isPassword ? 'text' : 'password';

                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        });
    </script>
@endpush
