<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Book Store - Login</title>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/vendors/css/forms/icheck/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/app.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/Dashboard/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Dashboard/css/pages/login-register.css') }}">
</head>

<body class="vertical-layout vertical-menu 1-column  bg-cyan bg-lighten-2 menu-expanded blank-page blank-page"
    data-open="click" data-menu="vertical-menu" data-col="1-column">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1">
                                            <img src="{{ asset('assets/Dashboard/images/logo/logo-dark.png') }}"
                                                alt="branding logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <form action="{{ route('auth.login') }}" method="POST"
                                            class="form-horizontal" action="index.html">
                                            @csrf
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    id="email">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group mb-1">
                                                <label for="user-password">Password</label>
                                                <input type="password" name="password" class="form-control"
                                                    id="user-password">
                                            </fieldset>
                                            @if (session('error'))
                                                <div class="alert alert-danger mt-2">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                            <button type="submit" class="btn btn-outline-info btn-block"><i
                                                    class="ft-unlock"></i> Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/Dashboard/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/js/core/app-menu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/js/core/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/Dashboard/js/scripts/forms/form-login-register.js') }}" type="text/javascript"></script>
</body>

</html>
