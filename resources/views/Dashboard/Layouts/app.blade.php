<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

@include('Dashboard.Layouts.head')

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">

    @include('Dashboard.Layouts.navbar')

    @include('Dashboard.Layouts.sidebar')

    @yield('content')

    @include('Dashboard.Layouts.footer')

    @include('Dashboard.Layouts.scripts')
</body>
</html>
