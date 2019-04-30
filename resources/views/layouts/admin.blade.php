<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Sumit Rai">
    <title>@yield('title')</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css?ver=12345') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('assets/vendor/font-awesome/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Nunito);
        body{
            font-family:Nunito,sans-serif;
        }
        div#DataTables_Table_0_filter {
            float: right;
        }

        .onoffswitch {
            position: relative; width: 93px;
            -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
        }
        .onoffswitch-checkbox {
            display: none;
        }
        .onoffswitch-label {
            display: block; overflow: hidden; cursor: pointer;
            border: 2px solid #999999; border-radius: 18px;
        }
        .onoffswitch-inner {
            display: block; width: 200%; margin-left: -100%;
            transition: margin 0.3s ease-in 0s;
        }
        .onoffswitch-inner:before, .onoffswitch-inner:after {
            display: block; float: left; width: 50%; height: 24px; padding: 0; line-height: 24px;
            font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
            box-sizing: border-box;
        }
        .onoffswitch-inner:before {
            content: "Active";
            padding-left: 10px;
            background-color: #3F8A05; color: #FFFFFF;
        }
        .onoffswitch-inner:after {
            content: "Inactive";
            padding-right: 10px;
            background-color: #E0E0E0; color: #5C5C5C;
            text-align: right;
        }
        .onoffswitch-switch {
            display: block; width: 14px; margin: 5px;
            background: #FFFFFF;
            position: absolute; top: 0; bottom: 0;
            right: 65px;
            border: 2px solid #999999; border-radius: 18px;
            transition: all 0.3s ease-in 0s;
        }
        .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
            margin-left: 0;
        }
        .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
            right: 0px;
        }
    </style>
      @yield('style')
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                @php $companyName = 'Snapper'; @endphp
                @if(!empty(Auth::user()->company_id))
                    @if(Auth::user()->level==5)
                        @php $companyName = 'Snapper'; @endphp
                    @elseif(Auth::user()->level==4)
                      @php $companyName = Auth::user()->companyname->company_name; @endphp
                    @elseif(Auth::user()->level==3)
                      @php $companyName = Auth::user()->companyname->company_name; @endphp
                    @endif
                @endif
                <a class="navbar-brand" href="{{ route(Auth::user()->levelname->slug.".home") }}">{{ @$companyName }}</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw">&nbsp;</i> {{ Auth::user()->name }} &nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
            @if(Auth()->user()->level==3)
              @include('user.layouts.navigation')
            @elseif(Auth()->user()->level==4)
              @include('admin.layouts.navigation')
            @elseif(Auth()->user()->level==5)
              @include('superadmin.layouts.navigation')
            @endif
        </nav>

        <div id="page-wrapper">
            @yield('content')
        </div>
    </div>
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
