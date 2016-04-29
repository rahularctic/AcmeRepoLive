<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- For Login -->
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('/js/modernizr-2.6.2.min.js') }}"></script>

    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">


    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/vitee.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>


    <title>@yield('title')</title>

</head>

<body>

<div id="top-container" class="container-fluid">


    <div id="top-bar">

        <div class="container">
            <div class="row">
                <div class="col-md-8"><img id="viteeLogo" src="{{asset('image/ic_title-web.PNG')}}" style="width: auto; height: 29px;"></div>
                <div class="col-md-4"><img src="{{asset('image/020.JPG')}}" style="width: 25px; height: 25px;" class="img-circle"></div>
            </div>

            <nav id="menu-nav">
                <div class="row">
                    <div class="col-md-8">
                        <a href="{{ url('/home') }}" alt="">Home</a>
                        <a href="Insights.html" alt="">Insights</a>
                        <a href="{{action('EventsController@index')}}" alt="">Events</a>
                        <a href="Marketing.html" alt="">Marketing</a>
                    </div>

                    <div class="col-md-4">
                        <a class="settings" href="settings.html" alt="">Welcome {{Auth::user()->USERNAME }}</a>

                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>

                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>


<div role="tabpanel"  class="container">
    <div class="row">

        <div class="col-md-3">

        </div>

        <div role="tabpanel" id="content-main" class="col-md-9">
            @yield('content')
        </div>

    </div>
</div>





</body>


</html>
