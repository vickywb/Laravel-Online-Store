<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>{{ isset($headerTitle) ? $headerTitle . '-' : '' }}Home Store Online</title>

  {{-- Style --}}
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
  @include('includes.script')
  @yield('javascript')

</body>

</html>