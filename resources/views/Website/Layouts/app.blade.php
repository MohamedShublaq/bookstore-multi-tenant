<!DOCTYPE html>
<html lang="en">

@include('Website.Layouts.head')

<body>
    @include('Website.Layouts.header')

    @yield('content')

    @include('Website.Layouts.footer')

    @include('Website.Layouts.scripts')
</body>

</html>
