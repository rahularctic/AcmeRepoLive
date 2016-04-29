 @extends('welcome.master')

<!doctype html>
<html lang="en" class="no-js">
<head>
    <!-- CSS STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/stylelanding.css') }}">
    <meta name="theme-color" content="#f47933">
    <!-- JS SHEETS -->

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="{{ asset('/image/landingimage/ic_launcher.png') }}" />
    <title>Vitee / The easiest way to discover events</title>
    <meta name="description" content="Vitee is an application to discover events easily">
    <meta name="keywords" content="event, mobile, application">
    <meta name="language" content="English">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

@section('content')

    <body>


    <!--<header class="main-header">
        <nav class="navbar navbar-static-top" STYLE="background-color: #ffffff">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="/welcome" class="navbar-brand" ><b STYLE="text-decoration-color: #0000ff">Vitee</b> -  DASHBOARD</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling
                <div class="collapse navbar-collapse" id="navbar-collapse">


                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/login">Log in</a></li>
                        <li><a href="/register">Sign up </a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">HELP <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">About us</a></li>
                                <li><a href="#">How it Works</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Help Center</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
    </header>  -->


    <div class="main" id="particles-js" style="height:600px !important";>
        <div class="container pad_top">
            <img id="activity" src="{{ asset('/image/landingimage/activity.png') }}">
            <div class="boxlanding">
                <h1 style="color:white">Discover events. <br>The best way.</h1>
                <p style="color:white">Coming Soon to  Android, iOS and the Web</p>
                </br>
                <input class="gglelink" type="image" src="{{ asset('/image/landingimage/google.png') }}" name="image" width="60" height="60">

            </div>
        </div>
    </div>

   <!--  Discover
    <div class="main">
        <div class="container pad_top">
            <img id="discover" src="{{ asset('/image/landingimage/discover.png') }}">
            <div class="boxlanding">
                <h1>Discovering just got easier.</h1>
                <p>Planning a weekend out with friends? Just discover all types of events for your liking.
                    Sports? Night Life? Chill by the beach for a scenario sunset? We've got you covered.</p>
            </div>
        </div>
    </div>

    <!-- Geoevent
    <div class="main">
        <div class="container pad_top">
            <img id="geoevent_pic" src="{{ asset('/image/landingimage/GeoEvent.png') }}">
            <div class="boxlanding relative float_right">
                <h1>No more surprises.</h1>
                <p>New in town or simply just want to find out what’s happening in your area? We do that. With GeoEvent you’re just a tap away from finding the next event.</p>
            </div>
        </div>
    </div>-->

    <!-- Ticket
    <div class="main">
        <div class="container pad_top">
            <img id="ticket" src="{{ asset('/image/landingimage/ticket.png') }}">
            <div id="center_div">
                <h1>Whenever, wherever.</h1>
                <p>If you're anything like us, we hate traffic and ques. Which is why we have made it so simple to purchase tickets at Vitee. How simple? Tap "buy" and you're done.</p>
                <p>Oh, and did we mention you can send tickets to your friends and family?</p>
            </div>
        </div>
    </div>
-->



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="http://vincentgarreau.com/particles.js/particles.js"></script>
        <script>
            particlesJS('particles-js', {
                particles: {
                    color: '#fff',
                    shape: 'circle',
                    opacity: 1,
                    size: 3.5,
                    size_random: true,
                    nb: 150,
                    line_linked: {
                        enable_auto: true,
                        distance: 250,
                        color: '#fff',
                        opacity: 0.5,
                        width: 2,
                        condensed_mode: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 600
                        }
                    },
                    anim: {
                        enable: true,
                        speed: 2.5
                    }
                },
                interactivity: {
                    enable: true,
                    mouse: {
                        distance: 250
                    },
                    detect_on: 'canvas',
                    mode: 'grab',
                    line_linked: {
                        opacity: 0.5
                    },
                    events: {
                        onclick: {
                            push_particles: {
                                enable: true,
                                nb: 4
                            }
                        }
                    }
                },
                retina_detect: true
            });
        </script>

        <script>
            //This code is a bit rudimentary.
            //This is more of a proof of concept than code for production.
            //The only thing it needs to do, however, is to check if the field has any value. The rest is done with CSS

            $(document).ready(function(){
                function updateText(event){
                    var input=$(this);
                    setTimeout(function(){
                        var val=input.val();
                        if(val!="")
                            input.parent().addClass("floating-placeholder-float");
                        else
                            input.parent().removeClass("floating-placeholder-float");
                    },1)
                }
                $(".floating-placeholder input").keydown(updateText);
                $(".floating-placeholder input").change(updateText);
            });
        </script>

  <!--  <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
        <!-- Overlay -->
        <!--  <div class="overlay"></div>-->

         <!-- Indicators -->
     <!--  <ol class="carousel-indicators">
            <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#bs-carousel" data-slide-to="1"></li>
            <li data-target="#bs-carousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
      <!--  <div class="carousel-inner">
            <div class="item slides active">
                <div class="slide-1"></div>
                <div class="hero">
                    <hgroup>
                        <h1>Vitee</h1>
                        <h3> It is a place where you can discover events happening near you</h3>
                    </hgroup>
                    <button class="btn btn-hero btn-lg" role="button">See all features</button>
                </div>
            </div>
            <div class="item slides">
                <div class="slide-2"></div>
                <div class="hero">
                    <hgroup>
                        <h1> Our Goal </h1>
                        <h3>to make you the centre of events</h3>
                    </hgroup>
                    <button class="btn btn-hero btn-lg" role="button">See all features</button>
                </div>
            </div>
            <div class="item slides">
                <div class="slide-3"></div>
                <div class="hero">
                    <hgroup>
                        <h1>Always be the first to know</h1>
                        <!-- <h3>Get start your next awesome project</h3> -->
               <!--     </hgroup>
                    <button class="btn btn-hero btn-lg" role="button">See all features</button>
                </div>
            </div>
        </div>
    </div>-->



    <footer class="main-footer">
        <div class="container-fluid">
            <div class="pull-right hidden-xs">
                <b>Vitee </b> 1.0
            </div>
            <strong>Copyright &copy; 2014-2015 Vitee Team </strong>
        </div>

 @endsection

