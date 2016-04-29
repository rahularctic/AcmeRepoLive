<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vitee | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{asset('/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{{asset('/dist/css/skins/_all-skins.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('/css/welcome.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="skin-blue layout-top-nav">


    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="/welcome" class="navbar-brand"><b>Vitee</b> -  DASHBOARD</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">


                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/auth/login">Log in</a></li>
                        <li><a href="/auth/register">Sign up </a></li>
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
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>

    @yield('content')




<!-- jQuery 2.1.3 -->
<script src="{{asset('/plugins/jQuery/jQuery-2.1.3.min.js')}}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{asset('/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="{{asset('/plugins/slimScroll/jquery.slimScroll.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src='{{asset('/plugins/fastclick/fastclick.min.js')}}'></script>
<!-- AdminLTE App -->
<script src="{{asset('/dist/js/app.min.js')}}" type="text/javascript"></script>

</body>
</html>
