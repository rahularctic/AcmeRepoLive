<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title> Vitee | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


    <!-- jQuery 2.1.3 -->
    <script src="{{asset('plugins/jQuery/jQuery-2.1.3.min.js')}}"></script>

    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 3.3.2 -->
    <link href="{{asset('/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{asset('/dist/css/skins/skin-blue.min.css')}}" rel="stylesheet" type="text/css" />
<style>

    .btncreate {
        background: #1b9ef5;
        background-image: -webkit-linear-gradient(top, #1b9ef5, #bbdaed);
        background-image: -moz-linear-gradient(top, #1b9ef5, #bbdaed);
        background-image: -ms-linear-gradient(top, #1b9ef5, #bbdaed);
        background-image: -o-linear-gradient(top, #1b9ef5, #bbdaed);
        background-image: linear-gradient(to bottom, #1b9ef5, #bbdaed);
        -webkit-border-radius: 30;
        -moz-border-radius: 30;
        border-radius: 30px;
        font-family: Georgia;
        color: #fcfdff;
        font-size: 16px;
        padding: 10px 20px 10px 20px;
        text-decoration: none;
    }

    .btncreate:hover {
        background: #3cb0fd;
        background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
        background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
        text-decoration: none;
    }

</style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <script>

        function createEvent() {

            window.location.assign("http://google.com");
        }

    </script>


    <script>

     /*   var date = new Date()

             $("#createddate").value = moment($("#createddate").val()).format('D MMM YYYY');*/



    </script>

    <![endif]-->

    @yield('assets')


</head>

<body  class="skin-blue fixed"  >


<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header" >

        <!-- Logo -->
        <a href="/dashboard/home" class="logo"><b>Vitee</b> Dashboard </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
           <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
<!--                     <li >

                        <a class="btn-default" href="/event/create" >  <span style="color : #3C8DBC" > CREATE EVENT </span> </a>
                            {{--<button onclick="createEvent();"  style="margin-top: 2px; "> </button>--}}
                    </li> -->

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('/img/user/'.Auth::user()->USERID.'/'.Auth::user()->USERIMAGE)}}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"> {{strtoupper(Auth::user()->USERNAME) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('/img/user/'.Auth::user()->USERID.'/'.Auth::user()->USERIMAGE)}}" class="img-circle" alt="User Image" />
                                <p>
                                    Welcome, {{strtoupper(Auth::user()->USERNAME) }}
                                    <small id="createddate">{{strtoupper(Auth::user()->created_at) }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-6 text-center">
                                    <a href="/dashboard/events">My Events</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="/dashboard/settings">Settings</a>
                                </div>


                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
<!--                                 <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div> -->
                                <div class="pull-right">
                                    <a href="{{url('/auth/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    @yield('side')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
<!--         <section class="content-header">
            <h1>
                Page Header
                <small>Optional description</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section> -->

        <!-- Main content -->
        <section class="content">

            @yield('content')

            <!-- Your Page Content Here -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">Vitee</a>.</strong> All rights reserved.
    </footer>

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->


<!-- Bootstrap 3.3.2 JS -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/app.min.js')}}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
<!-- SlimScroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>



@yield('asset-footer')
</body>


<script>
    $( document ).ready(function() {

        var newdate= ($("#createddate").html()).substr(0, 10);
        newdate = moment(newdate).format('D MMM YYYY');

        $("#createddate").html('Member Since '+newdate);
    });
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63696030-1', 'auto');
  ga('send', 'pageview');

</script>

@yield('footer')
</html>