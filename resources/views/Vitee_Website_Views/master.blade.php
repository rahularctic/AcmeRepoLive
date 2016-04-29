<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
    ============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/magnific-popup.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/responsive.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/plugins.js')}}"></script>


    <!-- Additional Assets
============================================= -->

    @yield('assets')




    <!-- Document Title
    ============================================= -->
@yield('title')

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Header
    ============================================= -->
    <header id="header" class="full-header">

        <div id="header-wrap">

            <div class="container clearfix">

                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                <!-- Logo
                ============================================= -->
                <div id="logo">
                    <a href="{{URL('/')}}" class="standard-logo" data-dark-logo="{{asset('Vitee_Website_Assets/')}}"><img src="{{asset('Vitee_Website_Assets/images/logo.png')}}" alt="Vitee Logo"></a>
                    <a href="{{URL('/')}}" class="retina-logo" data-dark-logo="{{asset('Vitee_Website_Assets/images/logo-dark@2x.png')}}"><img src="{{asset('Vitee_Website_Assets/images/logo@2x.png')}}" alt="Vitee Logo"></a>
                </div><!-- #logo end -->

                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu">


                   {{-- @yield('nav-bar')--}}

                    <ul>
                        <li><a href="{{URL('/')}}"><div> <i class="icon-home2"></i>Home</div></a>

                        </li>

                        <li class="current">
                            <a href="#"><div><i class="icon-calendar3"></i>Events </div></a>
                            <ul>

                                <li><a href="{{URL('/events/all')}}"><div> <i class="icon-line-align-justify"></i> All &nbsp; Events</div></a> </li>

                                <li><a href="{{URL('/events/calendar')}}"><div><i class="icon-calendar"></i> Event &nbsp; Calendar </div></a> </li>

                                <li><a href="#"><div>  <i class="icon-line2-arrow-right"></i>  Event &nbsp; Category</div></a>
                                    <ul>
                                        <li><a href="{{URL('/events/c/6')}}"><div>Food</div></a></li>
                                        <li><a href="{{URL('/events/c/7')}}"><div>Sport</div></a></li>
                                        <li><a href="{{URL('/events/c/3')}}"><div>Music</div></a></li>
                                        <li><a href="{{URL('/events/c/2')}}"><div> Exihibtion</div></a></li>
                                        <li><a href="{{URL('/events/c/1')}}"><div> Art </div></a></li>
                                        <li><a href="{{URL('/events/c/4')}}"><div> Social </div></a></li>
                                        <li><a href="{{URL('/events/c/5')}}"><div> Night Life </div></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{URL('/about')}}"><div> <i class="icon-info"></i>About</div></a></li>                       
                        <li class="blog"><a href="#"><div> <i class="icon-pencil2"></i> Blog</div></a></li>
                        {{--<li  class="contact"><a href="{{URL('/contact')}}"><div> <i class="icon-line2-envelope-letter"></i>  Contact us</div></a></li>--}}
                        <li class="faq"><a href="{{URL('/faq')}}"><div>Faq</div></a></li>
                        <li class="profile">
                            <a href="#"><div><i class="icon-user"></i>Profile </div></a>
                            <ul>
                            @if((Session::get('userId') == NULL ))
                            <li><a href="{{URL('/user/login')}}"><div> <i class="fa-sign-in"></i>&nbsp; Login</div></a> </li>

                            <li><a href="{{URL('/user/register')}}"><div><i class="fa-user-plus"></i>&nbsp; Register </div></a> </li>


                            @else
                            <li><a href="{{URL('/userProfile/'.Session::get('userId'))}}"><div><i class="fa-user-plus"></i>&nbsp;Edit Profile</div></a> </li>
                                    <li> <a href="{{URL('/myTickets')}}"><div><i class="fa-sign-out"></i>&nbsp; My Tickets </div></a></li>
                            <li> <a href="{{URL('/user/logout')}}"><div><i class="fa-sign-out"></i>&nbsp; Logout </div></a></li>
                            @endif
                            </ul>
                        </li>

                    </ul>

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->

    <!-- Page Title
    ============================================= -->
    <section id="page-title">

@yield('page-title')

    </section><!-- #page-title end -->

    <!-- Content
    ============================================= -->
    <section id="content">

      @yield('content')

    </section><!-- #content end -->

    <!-- Footer
    ============================================= -->
    <footer id="footer" class="dark" style="background-color: #222;">

        <div class="container">

            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap clearfix">

                <div class="col_one_third">

                    <div class="widget clear-bottommargin-sm clearfix">

                        <div class="row">

                            <div class="col-md-12 bottommargin-sm">
                                <div class="footer-big-contacts">
                                    <span>Call Us:</span>
                                    (973) 36651772
                                </div>
                            </div>

                            <div class="col-md-12 bottommargin-sm">
                                <div class="footer-big-contacts">
                                    <span>Send an Enquiry:</span>
                                    contact@vitee.net
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="widget subscribe-widget clearfix">

                    </div>

                </div>

                <div class="col_one_third">

                    <div class="widget clearfix" style="margin-bottom: -20px;">

                        <div class="row">

                            <div class="col-md-6 bottommargin-sm">
                                <div class="counter counter-small"><span data-from="0" data-to="600" data-refresh-interval="10" data-speed="30000" data-comma="true">500</span></div>
                                <h5 class="nobottommargin">Total Downloads</h5>
                            </div>

                            <div class="col-md-6 bottommargin-sm">
                                <div class="counter counter-small"><span data-from="0" data-to="100" data-refresh-interval="10" data-speed="20000" data-comma="true">100</span></div>
                                <h5 class="nobottommargin">Event Promoter</h5>
                            </div>

                        </div>



                    </div>

                </div>

                <div class="col_one_third col_last">

                    <div class="row">

                        <div class="col-md-6 clearfix bottommargin-sm">
                            <a href="https://www.facebook.com/vitee.net/" class="social-icon si-dark si-colored si-facebook nobottommargin" style="margin-right: 10px;">
                                <i class="icon-facebook"></i>
                                <i class="icon-facebook"></i>
                            </a>
                            <a href="https://www.facebook.com/vitee.net/"><small style="display: block; margin-top: 3px;"><strong>Like us</strong><br>on Facebook</small></a>
                        </div>
                        <div class="col-md-6 clearfix">
                            <a href="#" class="social-icon si-dark si-colored si-instagram nobottommargin" style="margin-right: 10px;">
                                <i class="icon-instagram"></i>
                                <i class="icon-instagram"></i>
                            </a>
                            <a href="https://instagram.com/vitee.me/"><small style="display: block; margin-top: 3px;"><strong> Follow us </strong><br>on Instagram</small></a>
                        </div>

                    </div>



                </div>

            </div><!-- .footer-widgets-wrap end -->

        </div>

        <!-- Copyrights
        ============================================= -->
        <div id="copyrights">

            <div class="container clearfix">

                <div class="col_half">
                    Copyrights &copy; 2015 All Rights Reserved by Vitee <br>
                    <div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
                </div>

                <div class="col_half col_last tright">
                    <div class="fright clearfix">
                        <a href="https://www.facebook.com/vitee.net/" class="social-icon si-small si-borderless si-facebook">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>

                        <a href="https://instagram.com/vitee.me/" class="social-icon si-small si-borderless si-instagram">
                            <i class="icon-instagram"></i>
                            <i class="icon-instagram"></i>
                        </a>

                        <a href="mailto:contact@vitee.net" class="social-icon si-small si-borderless si-email3">
                            <i class="icon-email3"></i>
                            <i class="icon-email3"></i>
                        </a>

                        <a href="https://play.google.com/store/apps/details?id=com.vt&hl=en" class="social-icon si-small si-borderless si-android">
                            <i class="icon-android"></i>
                            <i class="icon-android"></i>
                        </a>

                        <a href="https://itunes.apple.com/us/app/vitee/id1034390761?mt=8" class="social-icon si-small si-borderless si-icon-appstore">
                            <i class="icon-appstore"></i>
                            <i class="icon-appstore"></i>
                        </a>


                    </div>

                    <div class="clear"></div>

                    <i class="icon-envelope2"></i> contact@vitee.net <span class="middot">&middot;</span> <i class="icon-phone-sign"></i> 973 36651772 <span class="middot">&middot;</span>
                </div>

            </div>

        </div><!-- #copyrights end -->

    </footer><!-- #footer end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/functions.js')}}"></script>

@yield('script')<script type="text/javascript" src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
@yield('assets-footer')

</body>
</html>