<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title> @yield('title')</title>
   <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css?ver=12345') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('app/css/app.css') }}" rel="stylesheet">
</head>

<body>
   @yield('content')
   <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/raphael/raphael.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/vendor/morrisjs/morris.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/data/morris-data.js') }}"></script> -->
    <script src="{{ asset('assets/dist/js/sb-admin-2.js') }}"></script>
   @yield('scripts')
</body>
</html>