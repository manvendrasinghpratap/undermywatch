<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
        <title>@if(isset($pageTitle)){{ $pageTitle }}  @else Home @endif</title>
        @include('common.css')
        @yield('style')
        <script>
        var siteurl = '<?= env('APP_URL'); ?>';
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    </head>
    <body>
      <div class="wrapper flex-center position-ref full-height">
        @if(Auth()->user()->level==config('app.superadminlevel'))
          @include('common.navigation')
        @elseif(Auth()->user()->level==config('app.adminlevel'))
          @include('common.adminnavigation')
        @elseif(Auth()->user()->level==config('app.userlevel'))
          @include('common.usernavigation')
        @endif
          @yield('content')
          @include('common.footer')
          @include('common.modal')
          @yield('scripts')
   </body>
</html>
