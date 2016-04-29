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


@section('content')

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-event">

                <div class="col_three_fourth">
                    <div class="entry-image nobottommargin">
                        <a href="#"><img src="{{asset('/img/event/'.$event[0]->EVENTID.'/'.$event[0]->EVENTIMAGE)}}" alt="Event Single"></a>
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
                <div class="col_one_fourth col_last" >
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



                             <a href="#buynow" class="btn btn-success btn-block btn-lg" id="buyTicket1" >Buy Tickets</a>




                    @endif



                </div>

                <div class="clear"></div>

                <div class="col_three_fourth">

                    <h3>Details</h3>

                    <pre style="border: none;  background-color: inherit;">
                      <p>  {{$event[0]->EVENTDESCRIPTION}} </p>
                    </pre>


                    @if($event[0]->EVENTPAID == 1)
                    <h4>Tickets Info</h4>
                    <form  id="buyTicketForm" action="{{URL::to('buyTicket')}}" method="post">
                        <input type="hidden" name="USERID" value="">
                        <input type="hidden" name="EVENTID" value="{{ $event[0]->EVENTID  }}"  >

                    <div class="table-responsive">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>    <i class="icon-ticket"></i> &nbsp; Ticket Type</th>
                                <th>    <i class="icon-dollar"></i> &nbsp;Ticket Price</th>
                                <th>    <i class="icon-time"></i> &nbsp; Ticket Start Sales - End Sales</th>
                                <th>    <i class="icon-time"></i> &nbsp; Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td> <strong>  {{$ticket->TICKETTYPENAME}}
                                        <input type="hidden" name="TICKETTYPEID[]" value="{{ $ticket->TICKETTYPEID  }}"  >
                                        </strong>
                                    </td>
                                    <td> <span class="label label-success"> {{$ticket->TICKETPRICE}} BHD</span>
                                        <input type="hidden" name="TICKETPRICE[]" id="Price{{ $ticket->TICKETTYPEID }}" value="{{ $ticket->TICKETPRICE  }}">
                                    </td>
                                    <td> <span class="label label-primary">{{$ticket->TICKETSTARTSALES}}</span> - <span class="label label-danger">{{$ticket->TICKETENDSALES}}</span>
                                    </td>

                                    <td>
                                        {{--<input type="number" name="quantity[]" id="{{$ticket->TICKETTYPEID}}" min="0" max="10" value="0" class="spinner" style="text-align: center; padding: 6px; width: 100%;">--}}
                                        <select class="ticketQuantity" name="quantity[]" id="{{$ticket->TICKETTYPEID}}" >
                                            <option value="0">Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>

                                        <input type="hidden" name="finalPrice[]" id="finalPrice{{ $ticket->TICKETTYPEID }}" value="0">
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                    </form>
                    @endif

                    <section id="buynow">
                        <div class="col_full text-right">
                            <span id="grandTotalLabel" style="color: #008000"><b>TOTAL = </b></span><span id="grandTotalValue" style="color: #008000"></span>
                            {{--&nbsp;&nbsp;<a href = "tickets/purchase"><b>Buy Now</b></a>--}}
                            &nbsp;&nbsp;<a  href = "#" id = "buyTicket"><b>Buy Now</b></a>
                        </div>
                    </section>




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
                            zoom: 12,
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

{{--                    <h4>Tickets Info</h4>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>    <i class="icon-ticket"></i> Ticket Type</th>
                                <th>   <i class="icon-dollar">Ticket Price</th>
                                <th>   <i class="icon-time"></i> Ticket Start Sales - End Sales</th>
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
                    </div>--}}

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/bootstrap-number-input.js')}}"></script>
    <script>
        $(document).ready(function($) {
            
            var quantity = 0;


         

            $('#buyTicket').on('click', function (e) {
                e.preventDefault();
                $('#buyTicketForm').submit();
            })

            $('#grandTotalValue').html("<b>0 BHD</b>");

            $('.ticketQuantity').change(function (event) {

                var Gtotal = 0;
                quantity = $(this).val();

                var current_id = $(this).attr('id');
                var currentPrice = 0;

                currentPrice = $("#Price"+current_id).val();
                currentPrice*=quantity;

                $("#finalPrice"+current_id).val(currentPrice);

                //alert($("#finalPrice").length);

//                for (var i = 0; i < (); i++) {
//                    alert(myStringArray[i]);
//                    //Do something
//                }

                $('input[name^=finalPrice]').each(function(){
                    var Pricetype = parseInt($(this).val());
                    Gtotal = Gtotal + Pricetype;
                })


                $('#grandTotalValue').html("<b>"+Gtotal+" BHD</b>");
            })

//            $('.spinner').bootstrapNumber({
//                upClass: 'success',
//                downClass: 'danger'
//            });



        })
    </script>
@endsection