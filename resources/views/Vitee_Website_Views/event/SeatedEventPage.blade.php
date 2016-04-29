@extends('Vitee_Website_Views.master')


@section('title')

    <title> {{$event[0]->EVENTNAME}} </title>

@endsection


@section('page-title')

    <div class="container clearfix">
        <h1>{{$event[0]->EVENTNAME}} </h1>
        <span> Event Page</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Event</li>
        </ol>
    </div>

@endsection


@section('nav-bar')



    <ul>
        <li><a href="{{URL('/')}}"><div>Home</div></a>

        </li>
        <li class="current"><a href="#"><div>Events</div></a>

            <ul>
                <li><a href="#"><div>Popular Events</div></a></li>
                <li><a href="#"><div>Latest Events</div></a></li>
                <li><a href="#"><div>Featured Events</div></a></li>
            </ul>

        </li>
        <li class="mega-menu"><a href="{{URL('/about')}}"><div>About</div></a></li>
        <li class="mega-menu"><a href="{{URL('/blog')}}"><div>Blog</div></a></li>
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

            <div class="single-event">

                <div class="col_three_fourth">
                    <div class="entry-image nobottommargin">
                        <a href="#"><img src="{{asset('/img/event/'.$event[0]->EVENTID.'/1.jpeg')}}" alt="Event Single"></a>
                        <div class="entry-overlay">
                            <span class="hidden-xs">Starts in: </span><div id="event-countdown" class="countdown"></div>
                        </div>
                        <script>
                            jQuery(document).ready( function($){

                                var eventStartDate = new Date();
                                eventStartDate = new Date("{{$event[0]->STARTDATE}} {{$event[0]->STARTTIME}}");
                                $('#event-countdown').countdown({until: eventStartDate});
                            });
                        </script>
                    </div>
                </div>
.               <div class="col_one_fourth col_last">
                    <div class="panel panel-default events-meta">
                        <div class="panel-heading">
                            <h3 class="panel-title">Event Info:</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="iconlist nobottommargin">
                                <li><i class="icon-calendar3"></i> {{$event[0]->STARTDATE}}</li>
                                <li><i class="icon-time"></i> {{$event[0]->STARTTIME}} - {{$event[0]->ENDTIME}}</li>
                                <li><i class="icon-map-marker2"></i> {{$event[0]->EVENTLOCATION}}</li>
                                <li><i class="icon-dollar"></i>
                                    <strong>
                                        @if($event[0]->EVENTPAID == 1)
                                            <span class="label label-primary">Paid</span>
                                        @else
                                            <span class="label label-success">Free</span>

                                        @endif

                                    </strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if($event[0]->EVENTPAID == 1)

                        <a href="{{URl('event/'.$event[0]->EVENTID.'/tickets')}}" class="btn btn-success btn-block btn-lg">Buy Tickets</a>

                    @endif



                </div>

                <div class="clear"></div>

                <div class="col_three_fourth">

                    <h3>Details</h3>

                    <p>{{$event[0]->EVENTDESCRIPTION}}</p>


                    @if($event[0]->EVENTPAID == 1)
                    <h4>Tickets Info</h4>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>    <i class="icon-ticket"></i> Ticket Type</th>
                                <th>    <i class="icon-dollar">Ticket Price</th>
                                <th>    <i class="icon-time"></i> Ticket Start Sales - End Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td> <strong>  {{$ticket->TICKETTYPENAME}}  </strong> </td>
                                    <td> <span class="label label-success"> {{$ticket->TICKETPRICE}} BHD</span>  </td>
                                    <td> <span class="label label-primary">{{$ticket->TICKETSTARTSALES}}</span> - <span class="label label-danger">{{$ticket->TICKETENDSALES}}</span></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    @endif



                </div>

                <div class="col_one_fourth col_last">

                    <h4>Location</h4>

                    <section id="event-location" class="gmap" style="height: 300px;"></section>

                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                    <script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/jquery.gmap.js')}}"></script>

                    <script type="text/javascript">

                        jQuery('#event-location').gMap({

                            latitude: {{$event[0]->EVENTLATITUDE}},
                            longitude: {{$event[0]->EVENTLONGITUDE}},
                            maptype: 'ROADMAP',
                            zoom: 15,
                            markers: [
                                {
                                    latitude: {{$event[0]->EVENTLATITUDE}},
                                    longitude: {{$event[0]->EVENTLONGITUDE}},
                                }
                            ],
                            icon: {
                                image: "http://www.google.com/mapfiles/marker.png",
                                shadow: "http://www.google.com/mapfiles/shadow50.png",
                                iconsize: [20, 34],
                                shadowsize: [37, 34],
                                iconanchor: [9, 34],
                                shadowanchor: [19, 34]
                            },
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

                </div>

                <div class="clear"></div>

                <div class="col_two_fifth nobottommargin">

                    <h4>Gallery</h4>

                    <!-- Events Single Gallery Thumbs
                    ============================================= -->
                    <div class="masonry-thumbs col-4" data-lightbox="gallery">
                        @foreach($images as $image)

                        <a href="{{asset('img/event/'.$event[0]->EVENTID.'/'.$image['basename'])}}" data-lightbox="gallery-item"><img class="image_fade" src="{{asset('img/event/'.$event[0]->EVENTID.'/'.$image['basename'])}}" alt="Gallery Thumb 1"></a>
                        @endforeach

                    </div><!-- Event Single Gallery Thumbs End -->

                </div>

                <div class="col_three_fifth nobottommargin col_last">

                    <h4>Tickets Info</h4>



                </div>

            </div>

        </div>

    </div>

@endsection