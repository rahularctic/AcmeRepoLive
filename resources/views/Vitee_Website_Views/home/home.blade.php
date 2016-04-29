@extends('Vitee_Website_Views.index')


@section('assets')

    {{--<link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/custom.css')}}" type="text/css" />--}}
    <link rel="stylesheet" href="{{asset('fonts/MyFontsWebfontsKit.css')}}" type="text/css" />

@endsection

@section('slider')
    <section id="slider" class="force-full-screen full-screen dark error404-wrap">

        <div class="force-full-screen full-screen dark section nopadding nomargin noborder ohidden">


            <div class="container vertical-middle center clearfix">

                <div class="error404" style=" font-family: Ample-Medium;">Vitee</div>

                <div class="heading-block nobottomborder">
                    <h4>Find Your Next Favorite Event</h4>
                    <span></span>
                </div>

            </div>
            <div class="video-wrap">
                <video poster="Vitee_Website_Assets/images/videos/explore-poster.jpg" preload="auto" loop autoplay muted>
                    <source src='Vitee_Website_Assets/images/videos/vitee.mp4' type='video/mp4' />
                </video>

            </div>

        </div>

    </section>
@endsection


@section('content')


    <div class="content-wrap">

        <div class="container clear-bottommargin clearfix">

            <div class="row clearfix">

                <div class="heading-block center">
                    <h2>Latest Created Events</h2>
                    <span>Stay in Touch with the Latest Events Happening in BAHRAIN</span>
                </div>


                <div class="clear"></div>

                <div class="clear"></div>



                @foreach($latest_events as $event)

                    <div class="ipost col-sm-6 bottommargin clearfix">
                        <div class="row" >
                            <div class="col-md-6">
                                <div class="entry-image nobottommargin latest-image">
                                    <a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}"><img src="{{asset('/img/event/'.$event->EVENTID.'/header/'.$event->EVENTIMAGE)}}"   alt="{{$event->EVENTNAME}}"></a>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 20px;">
                                <span class="before-heading">{{$event->EVENTTYPENAME}}</span>
                                <div class="entry-title">
                                    <h3><a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}">{{$event->EVENTNAME}}</a></h3>
                                </div>
                                <ul class="entry-meta clearfix">
                                    <li><i class="icon-calendar3"></i>{{$event->EVENTSTART}}</li>
                                    @if($event->EVENTPAID == 1)
                                        <li><span class="label label-primary">Paid</span></li>
                                    @else
                                        <li><span class="label label-success">Free</span></li>
                                    @endif
                                    <li><i class="icon-map-marker2"></i> {{$event->EVENTLOCATION}}</li>
                                </ul>
                                <div class="entry-content">
                                    <a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}" class="more-link">More Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>

        </div>





        <div class="common-height clearfix">

            <div id="popular-dest-map" class="col-md-8 col-padding gmap hidden-xs" style="padding:0">

                <div id="map_wrapper">
                    <div id="map_canvas" class="mapping"></div>
                </div>

            </div>

            <div class="col-md-4 col-padding" style="background-color: #F9F9F9;">
                <div class="max-height clearfix">
                    <div class="heading-block nobottommargin">
                        <h4>Popular Events</h4>
                    </div>

                    @foreach($popular_events as $event)
                        <div class="spost col-md-12 col-sm-6 noborder noleftpadding clearfix">
                            <div class="entry-image">
                                <a href="event/{{$event['EVENTID']}}"><img src="{{asset('/img/event/'.$event['EVENTID'].'/thumbnails/'.$event['EVENTIMAGE'])}}" alt={{$event['EVENTNAME']}}></a>
                            </div>
                            <div class="entry-c">
                                <div class="entry-title">
                                    <h4><a href="{{URL('/event/'.$event['EVENTID'].'/'.$event['EVENTNAME'])}}}}">{{$event['EVENTNAME']}}</a></h4>
                                </div>
                                <ul class="entry-meta">

                                    <li>
                                        @for ($i = 0; $i < $event['0']; $i++)
                                            <i class="icon-star3" style="color: #f47932; "></i>
                                        @endfor
                                    </li>

                                    @if($event['EVENTPAID'] == 1)
                                        <li><span class="label label-primary">Paid</span></li>
                                    @else
                                        <li><span class="label label-success">Free</span></li>

                                    @endif

                                </ul>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>




        </div>


        <div class="container clearfix">

            <div class="heading-block center nobottomborder">
                <span class="before-heading color">What are you in the Mood for.?</span>
                <h2>Find Your Favorites Events</h2>
            </div>

        </div>

        <div id="portfolio" class="portfolio-nomargin portfolio-full portfolio-overlay-open clearfix">

            <article class="portfolio-item pf-media pf-icons">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/6')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/food.jpg')}}" alt="Dining">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>Dining</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-illustrations">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/2')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/exhibition.jpg')}}" alt="Exhibitions">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>Exhibitions</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-graphics pf-uielements">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/1')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/art.jpg')}}" alt="Art">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>Art</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-icons pf-illustrations">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/5')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/nightlife.jpg')}}" alt="Nightlife">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>Nightlife</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-uielements pf-media">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/7')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/sports.jpg')}}" alt="Sport">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>Sport</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-graphics pf-illustrations">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/3')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/music.jpg')}}" alt="Music">
                        <div class="portfolio-overlay" data-lightbox="gallery">
                            <div class="portfolio-desc">
                                <h3>Music</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-uielements pf-icons">
                <div class="portfolio-image">
                    <a href="{{URL('/events/c/4')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/social.jpg')}}" alt="Social">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>Social</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

            <article class="portfolio-item pf-graphics">
                <div class="portfolio-image">
                    <a href="{{URL('/events/all')}}">
                        <img src="{{asset('/Vitee_Website_Assets/images/home/categories/all.jpg')}}" alt="All Events">
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>All Events</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </article>

        </div>

        <script type="text/javascript">

            jQuery(window).load(function(){

                var $container = $('#portfolio');

                $container.isotope();

                $(window).resize(function() {
                    $container.isotope('layout');
                });

            });

        </script>
        <a href="{{URL('/events/all')}}" class="button button-full button-dark center bottommargin-lg">
            <div class="container clearfix">
                Can't find your Favorite Event? <strong>Browse All Events</strong> <i class="icon-caret-right" style="top:4px;"></i>
            </div>
        </a>

        <div class="container clearfix">
            <div class="clear"></div>
            <div class="heading-block center">
                <h3>Available on all Major Platforms.</h3>
                <span>We have made our App available on all Major Platforms</span>
            </div>

            <p class="divcenter center" style="max-width: 800px;">Android, iOS and even a website version, we want everyone in on the action. Vitee is easily accessible to anyone, anywhere and costs absolutely nothing!</p>

            <div class="col_full center topmargin nobottommargin">

                <a href="https://itunes.apple.com/us/app/vitee/id1034390761?mt=8" class="social-icon si-appstore si-large si-rounded si-colored inline-block" title="iOS App Store">
                    <i class="icon-appstore"></i>
                    <i class="icon-appstore"></i>
                </a>

                <a href="https://play.google.com/store/apps/details?id=com.vt&hl=en" class="social-icon si-android si-large si-rounded si-colored inline-block" title="Android Store">
                    <i class="icon-android"></i>
                    <i class="icon-android"></i>
                </a>



            </div>

            <div class="clear"></div>

            <div class="divider divider-short divider-vshort divider-line divider-center">&nbsp;</div>

            <div class="heading-block center">
                <h3> <span style=" font-family: Ample-Medium;">Vitee</span> " Something for everyone " </h3>
            </div>

            <div id="widget-subscribe-form2-result" data-notify-type="success" data-notify-msg=""></div>



        </div>


    </div>



@endsection

@section('assets-footer')

    <script>

        jQuery(function($) {
            // Asynchronously Load the map API
            var script = document.createElement('script');
            script.async=true;
            script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
            document.body.appendChild(script);
        });

        function initialize() {
            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                mapTypeId: 'roadmap',
                scrollwheel: false,
                disableDefaultUI: true,
                zoomControl:true


            };

            // Display a map on the page
            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            map.setTilt(45);

            // Markers (Pins on the map)

            var markers = [];

            // Info Window Content
            var infoWindowContent = [];


            @foreach($all_events as $event)

            //push content to the marker

            markers.push(['{{$event->EVENTLOCATION}}', {{$event->EVENTLATITUDE}},{{$event->EVENTLONGITUDE}}]);


            //push content to the infowindow

            var htmContent =  ['<div id="iw-container">' +
            '<div class="iw-title"> <a href="{{URL('event/'.$event->EVENTID.'/'.str_replace(' ', '-', $event->EVENTNAME))}}">{{$event->EVENTNAME}} </a></div>' +
            '<div class="iw-content">' +
            '<div class="iw-img"> <a href="{{URL('event/'.$event->EVENTID.'/'.str_replace(' ', '-', $event->EVENTNAME))}}">  <img  src=" {{asset("img/event/$event->EVENTID/header/$event->EVENTIMAGE")}} " > </a> </div>'+
            '<div class="iw-subTitle">  <ul>  <a href="{{URL('event/'.$event->EVENTID)}}"> ' +
            ' <li><i class="icon-calendar3">  </i> {{$event->STARTDATE}}  <span style="float:right;"> <i class="icon-clock"> </i> {{$event->STARTTIME}} </span></li>'+
            '<li><i class="icon-map-marker2"></i>  {{$event->EVENTLOCATION}} </li>' +
            ' </a> </ul></div>' +
            '</div>' +
            '</div>'];

            infoWindowContent.push(htmContent);

            @endforeach

               // Display multiple markers on a map
            var infoWindow = new google.maps.InfoWindow(), marker, i;

            // Loop through our array of markers & place each one on the map
            for( i = 0; i < markers.length; i++ ) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0]
                });

                // Allow each marker to have an info window
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);

                    }
                })(marker, i));

                google.maps.event.addListener(map, "click", function(event) {
                    infoWindow.close();
                });


                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }


            // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom(12);
                google.maps.event.removeListener(boundsListener);
            });







            // *
            // START INFOWINDOW CUSTOMIZE.
            // The google.maps.event.addListener() event expects
            // the creation of the infowindow HTML structure 'domready'
            // and before the opening of the infowindow, defined styles are applied.
            // *
            google.maps.event.addListener(infoWindow, 'domready', function() {

                // Reference to the DIV that wraps the bottom of infowindow
                var iwOuter = $('.gm-style-iw');

                /* Since this div is in a position prior to .gm-div style-iw.
                 * We use jQuery and create a iwBackground variable,
                 * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
                 */
                var iwBackground = iwOuter.prev();

                // Removes background shadow DIV
                iwBackground.children(':nth-child(2)').css({'display' : 'none'});

                // Removes white background DIV
                iwBackground.children(':nth-child(4)').css({'display' : 'none'});

                // Moves the infowindow 115px to the right.
                iwOuter.parent().parent().css({left: '115px'});

                // Moves the shadow of the arrow 76px to the left margin.
                iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

                // Moves the arrow 76px to the left margin.
                iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

                // Changes the desired tail shadow color.
                iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

                // Reference to the div that groups the close button elements.
                var iwCloseBtn = iwOuter.next();

                // Apply the desired effect to the close button
                iwCloseBtn.css({opacity: '1', right: '38px', top: '3px',  'border-radius': '13px'});

                // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
                if($('.iw-content').height() < 140){
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
                iwCloseBtn.mouseout(function(){
                    $(this).css({opacity: '1'});
                });
            });

        }



    </script>




@endsection
