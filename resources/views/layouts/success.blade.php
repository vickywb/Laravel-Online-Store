<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>{{ isset($headerTitle) ? $headerTitle : '' }}</title>

    {{-- Style --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/plugin.css') }}" rel="stylesheet" type="text/css" />
    @include('includes.style')

</head>

<body>
    {{-- Navbar --}}
    @include('includes.navbar')

    {{-- Page Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('includes.footer')

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')
</body>

</html>