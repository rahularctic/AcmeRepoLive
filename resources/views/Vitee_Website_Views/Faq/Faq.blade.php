@extends('Vitee_Website_Views.master')


@section('title')

    <title>Vitee Faq</title>

@endsection


@section('page-title')

    <div class="container clearfix">
        <h1> Faq </h1>
        <span> Help</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Faq</li>
        </ol>
    </div>

@endsection


@section('nav-bar')



    <ul>
        <li><a href="{{URL('/')}}"><div>Home</div></a>

        </li>
        <li><a href="#"><div>Events</div></a>

            <ul>
                <li><a href="#"><div>Popular Events</div></a></li>
                <li><a href="#"><div>Latest Events</div></a></li>
                <li><a href="#"><div>Featured Events</div></a></li>
            </ul>

        </li>
        <li class="mega-menu"><a href="{{URL('/about')}}"><div>About</div></a></li>
        <li class="mega-menu"><a href="#"><div>Blog</div></a></li>
        <li class="mega-menu"><a href="{{URL('/contact')}}"><div>Contact us</div></a>

        </li>

    </ul>


    <!-- Top Search
    ============================================= -->
    <div id="top-search">
        <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
        <form action="search.html" method="get">
            <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
        </form>
    </div><!-- #top-search end -->


@endsection



@section('content')


    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin clearfix">

                <ul id="portfolio-filter" class="clearfix">

                    <li class="activeFilter"><a href="#" data-filter="all">All</a></li>
                    <li class=""><a href="#" data-filter=".faq-general">General</a></li>
                    <li class=""><a href="#" data-filter=".faq-android"> <span class="icon-android"> </span> Android</a></li>
                    <li class=""><a href="#" data-filter=".faq-ios"> <span class="icon-appstore"> </span> iOS</a></li>
                    <li><a href="#" data-filter=".faq-dashboard">Dashboard</a></li>
                    <li><a href="#" data-filter=".faq-website">Website</a></li>


                </ul>

                <div class="clear"></div>

                <div id="faqs" class="faqs">

                    <!-- GENERAL FAQ -->

                    <div style="" class="toggle faq faq-general">
                        <div class="togglet"><i class="toggle-closed icon-question-sign"></i><i class="toggle-open icon-question-sign"></i>How do I sign up to Vitee?</div>
                        <div style="" class="togglec"> You can sign up either by using your email, Facebook or Google+. We recommend to sign up using your Facebook account as we can provide you a better experience of using Vitee.</div>
                    </div>

                    <!-- ANDROID FAQ -->

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>
                            How do I re-position the map so that it locates me?
                        </div>
                        <div style="" class="togglec">
                            Simply click on the current location button on the right side of the screen. This will automatically relocate you on the map to your current location.
                        </div>
                    </div>

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i> How do I increase the radius?</div>
                        <div style="" class="togglec">
                            On the explore page, you will see a settings icon on the top right side of the screen. Click on the icon, you can now adjust radius.
                        </div>
                    </div>

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>
                            How do I use explore?
                        </div>
                        <div style="" class="togglec">
                            To use explore, your GPS must be enabled.  It then shows you events happening around you according to your chosen radius.
                        </div>
                    </div>

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>

                            How do I search for events and users?

                        </div>
                        <div style="" class="togglec">
                            To search, go to “Discover” from the navigation drawer. Tap on the magnifying glass on the top right and type your query. A list will show up for you to choose from.
                        </div>
                    </div>

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>
                            I see nothing in my subscriptions, How do I populate the subscriptions feed?
                        </div>
                        <div style="" class="togglec">
                           <p> In order to populate your subscription feed with great events, you must follow event promoters and both can be achieved by either searching for events or users or discover them. </p>
                           <p>  To search, go to “Discover” from the navigation drawer. Tap on the magnifying glass on the top right and type your query. A list will show up for you to choose from. </p>
                        </div>
                    </div>

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>
                            Which Android devices are supported?
                        </div>
                        <div style="" class="togglec">
                            We support all Android phones provided they meet the following requirements:

                            Your Android phone is running Android OS 4.0 or later.
                            Your Android phone is able to receive emails during the verification process.

                            You will also need an adequate data plan in order to receive messages when outside the range of a Wi-Fi network.

                            We do not support tablets at this time.
                        </div>
                    </div>


                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>
                            How do I create an event?
                        </div>
                        <div style="" class="togglec">
                            Unfortunately, the app does not have the ability to create events. We will be including this feature in the near future.
                        </div>
                    </div>

                    <div style="" class="toggle faq faq-android">
                        <div class="togglet"><i class="toggle-closed icon-comments-alt"></i><i class="toggle-open icon-comments-alt"></i>
                            How do I renew a forgotten password?
                        </div>
                        <div style="" class="togglec">
                            When you launch Vitee, tap on “Forgot Password”. Enter the email that is associated to your account and tap on the tick icon on the top right. We will send you a link to the email that you have provided us (Make sure to check your spam folder if you do not see anything in 5 minutes!). Tap on that link and you will now be able to renew your password.
                        </div>
                    </div>


                    <!-- IOS FAQ -->



                    <div style="" class="toggle faq faq-ios">
                        <div class="togglet"><i class="toggle-closed icon-lock3"></i><i class="toggle-open icon-lock3"></i>How Lorem ipsum dolor sit amet?</div>
                        <div style="" class="togglec">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis? Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
                    </div>



                    <!-- DASHBOARD FAQ -->


                    <div style="" class="toggle faq faq-authors faq-legal faq-dashboard">
                        <div class="togglet"><i class="toggle-closed icon-download-alt"></i><i class="toggle-open icon-download-alt"></i>Can I offer my items for free on a promotional basis?</div>
                        <div style="" class="togglec">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, dolorum, vero ipsum molestiae minima odio quo voluptate illum excepturi quam cum voluptates doloribus quae nisi tempore necessitatibus dolores ducimus enim libero eaque explicabo suscipit animi at quaerat aliquid ex expedita perspiciatis? Saepe, aperiam, nam unde quas beatae vero vitae nulla.</div>
                    </div>



                </div>

                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        var $faqItems = $('#faqs .faq');
                        if( window.location.hash != '' ) {
                            var getFaqFilterHash = window.location.hash;
                            var hashFaqFilter = getFaqFilterHash.split('#');
                            if( $faqItems.hasClass( hashFaqFilter[1] ) ) {
                                $('#portfolio-filter li').removeClass('activeFilter');
                                $( '[data-filter=".'+ hashFaqFilter[1] +'"]' ).parent('li').addClass('activeFilter');
                                var hashFaqSelector = '.' + hashFaqFilter[1];
                                $faqItems.css('display', 'none');
                                if( hashFaqSelector != 'all' ) {
                                    $( hashFaqSelector ).fadeIn(500);
                                } else {
                                    $faqItems.fadeIn(500);
                                }
                            }
                        }

                        $('#portfolio-filter a').click(function(){
                            $('#portfolio-filter li').removeClass('activeFilter');
                            $(this).parent('li').addClass('activeFilter');
                            var faqSelector = $(this).attr('data-filter');
                            $faqItems.css('display', 'none');
                            if( faqSelector != 'all' ) {
                                $( faqSelector ).fadeIn(500);
                            } else {
                                $faqItems.fadeIn(500);
                            }
                            return false;
                        });
                    });
                </script>

            </div><!-- .postcontent end -->



            <!-- Side Bar
          ============================================= -->

            <div class="sidebar nobottommargin col_last clearfix">
                <div class="sidebar-widgets-wrap">



                    <div class="widget clearfix">

                        <h4>Connect with Us</h4>
                        <a data-original-title="Facebook" href="https://www.facebook.com/vitee.net/" class="social-icon si-colored si-small si-facebook" data-toggle="tooltip" data-placement="top" title="">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>


                        <a data-original-title="Email" href="mailto:contact@vitee.net" class="social-icon si-colored si-small si-email3" data-toggle="tooltip" data-placement="top" title="">
                            <i class="icon-email3"></i>
                            <i class="icon-email3"></i>
                        </a>



                        <a data-original-title="Instagram" href="https://instagram.com/vitee.me/" class="social-icon si-colored si-small si-instagram" data-toggle="tooltip" data-placement="top" title="">
                            <i class="icon-instagram"></i>
                            <i class="icon-instagram"></i>
                        </a>


                    </div>


                </div>
            </div>

            <!-- .sidebar end -->



        </div>

    </div>



@endsection

@section('assets-footer')


    <script>

        $(document).ready(function(){

            if (!$('#primary-menu').hasClass("current")) {
                $("li.current").removeClass("current");
                $('#primary-menu').find('li.faq').addClass("current");
            }
        });

    </script>

@endsection