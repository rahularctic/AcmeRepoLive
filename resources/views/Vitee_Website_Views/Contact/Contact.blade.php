@extends('Vitee_Website_Views.master')


@section('title')

    <title>Vitee Contact Us </title>

@endsection




@section('page-title')

    <div class="container clearfix">
        <h1>Contact </h1>
        <span> Contact Vitee</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Contact</li>
        </ol>
    </div>

@endsection






@section('content')
    <div class="content-wrap">

        <div class="container clearfix">



            <!-- Google Map
            ============================================= -->
            <div class="col_full">

                <section id="google-map" class="gmap" style="height: 410px;"></section>

                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                <script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/gmap/jquery.gmap.js')}}"></script>

                <script type="text/javascript">

                    jQuery('#google-map').gMap({

                        address: 'Batelco Bldg, Manama Center, Manama, Capital Governorate 304',
                        maptype: 'ROADMAP',
                        zoom: 14,
                        markers: [
                            {
                                address: "Batelco Bldg, Manama Center, Manama, Capital Governorate 304",
                                html: '<div style="width: 300px;"><h4 style="margin-bottom: 8px;"> Hi, we\'re <span>Vitee</span></h4><p class="nobottommargin"> Best App to Find Events in Bahrain</div>',
                                icon: {
                                    iconsize: [32, 39],
                                    iconanchor: [32,39]
                                }
                            }
                        ],
                        doubleclickzoom: false,
                        controls: {
                            panControl: true,
                            zoomControl: true,
                            mapTypeControl: true,
                            scaleControl: false,
                            streetViewControl: false,
                            overviewMapControl: false
                        }

                    });

                </script>

            </div><!-- Google Map End -->

            <div class="clear"></div>

            <!-- Contact Info
            ============================================= -->
            <div class="row clear-bottommargin">

                <div class="col-md-3 col-sm-6 bottommargin clearfix">
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-map-marker2"></i></a>
                        </div>
                        <h3>Our Office<span class="subtitle"> Vitee W.L.L
2nd Floor
Batelco Building
Bab Al Bahrain
Manama
Kingdom of Bahrain </span></h3>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 bottommargin clearfix">
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a href="tel:+973 36651772"><i class="icon-phone3"></i></a>
                        </div>
                        <h3>Speak to Us<span class="subtitle">+973 36651772</span></h3>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 bottommargin clearfix">
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a href="mailto:contact@vitee.net"><i class="icon-email3"></i></a>
                        </div>
                        <h3>Send us an email<span class="subtitle">contact@vitee.net</span></h3>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 bottommargin clearfix">
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a href="https://fb.me/vitee.net"><i class="icon-facebook"></i></a>
                        </div>
                        <h3>Follow us On Facebook<span class="subtitle">https://fb.me/vitee.net</span></h3>
                    </div>
                </div>



            </div><!-- Contact Info End -->

        </div>

    </div>

@endsection


@section('assets-footer')


    <script>

        $(document).ready(function(){

            if (!$('#primary-menu').hasClass("current")) {
                $("li.current").removeClass("current");
                $('#primary-menu').find('li.contact').addClass("current");
            }
        });

    </script>

@endsection