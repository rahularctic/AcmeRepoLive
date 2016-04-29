@extends('Vitee_Website_Views.master')


@section('assets')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />

@endsection

@section('title')

    <title> Vitee - All Events </title>

@endsection

@section('page-title')


    <div class="container clearfix">
        <h1> All Event </h1>
        <span> Events List</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">All Events</li>
            <li class="mega-menu"><a href="{{URL('/userProfile/'.Session::get('userId'))}}"><div>edit user</div></a>

            </li>
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
        <li class="mega-menu"><a href="#"><div>Blog</div></a></li>
        <li class="mega-menu"><a href="{{URL('/contact')}}"><div>Contact us</div></a>


    </ul>





@endsection

@section('content')

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Portfolio Filter
            ============================================= -->
            <ul id="portfolio-filter" class="clearfix">

                <li class="activeFilter"><a href="#" data-filter="*">Show All Events</a></li>
                <li><a href="#" data-filter=".1">Art & Theatere</a></li>
                <li><a href="#" data-filter=".2">Exhibitions</a></li>
                <li><a href="#" data-filter=".3">Music & Entertainment</a></li>
                <li><a href="#" data-filter=".4">Networking & Social</a></li>
                <li><a href="#" data-filter=".5">Nightlife</a></li>
                <li><a href="#" data-filter=".6">Food & Dining</a></li>

            </ul><!-- #portfolio-filter end -->

            <div id="portfolio-shuffle">
                <i class="icon-calendar"></i>
            </div>

            <div class="clear"></div>

            <!-- Portfolio Items
            ============================================= -->
            <div id="portfolio" class="clearfix">

                @foreach($userEvents as $userEvent)

                    <article  class="portfolio-item {{$userEvent->EVENTTYPEID}}" class="{{$userEvent->EVENTTYPEID}}" class="item-filter">
                        <span class="number" style="visibility: hidden;"> {{$userEvent->StartTimeStamp}} </span>
                        <div class="portfolio-image">

                            <a href="portfolio-single.html">
                                <img src="{{asset('/img/event/'.$userEvent->EVENTID.'/'.$userEvent->EVENTIMAGE)}}" alt="{{$userEvent->EVENTNAME}}">
                            </a>
                            <div class="portfolio-overlay">
                                <a href="{{URL('/event/'.$userEvent->EVENTID.'/'. str_replace(' ', '-', $userEvent->EVENTNAME) )}}" class="center-icon"><i class="icon-line-ellipsis"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <span> <span class="date"> {{$userEvent->STARTDATE}} </span>

                                @if($userEvent->EVENTPAID == 1)

                                    <span class="label label-primary" style="float: right; color:white;">Paid</span>

                                @else

                                    <span class="label label-success" style="float: right; color:white;">Free</span>

                                @endif


                            </span>
                            <h3><a href="{{URL('/event/'.$userEvent->EVENTID.'/'. str_replace(' ', '-', $userEvent->EVENTNAME) )}}">{{$userEvent->EVENTNAME}}</a></h3>
                            <span> <small><i class="icon-map-marker2"></i> {{$userEvent->EVENTLOCATION}} <a href="#">Icons</a></small></span>
                        </div>
                    </article>

                @endforeach



            </div><!-- #portfolio end -->


            <!-- Pagination
============================================= -->

            <ul class="pager nomargin" id="pagination">
                {{--{!! $allEvents->render() !!}--}}
            </ul><!-- .pager end -->


            <!-- Portfolio Script
            ============================================= -->
            <script type="text/javascript">

                jQuery(window).load(function(){

                    var order = "DESC";

                    var $container = $('#portfolio').isotope({
                        transitionDuration: '0.65s',
                        getSortData: {
                            name: '.name',
                            number : '.number',
                            date : function (itemElem) {
                                // console.log(itemElem);
                                //console.log($( itemElem ).find('.date').text());
                                var dateRaw = $( itemElem ).find('.date').text();
                                var dateValue = Date.parse($( itemElem ).find('.date').text());
                                console.log(dateRaw+' '+dateValue);
                                return $( itemElem ).find('.date').text();
                            }
                        }
                    });

                    var pagination = $('#pagination');




                    $('#portfolio-filter a').click(function(){
                        $('#portfolio-filter li').removeClass('activeFilter');
                        $(this).parent('li').addClass('activeFilter');
                        var selector = $(this).attr('data-filter');
                        $container.isotope({ filter: selector });

                        if(selector == '*'){

                            pagination.show();

                        }else{
                            pagination.hide();
                        }

                        return false;
                    });



                    $('#portfolio-shuffle').click(function(){


                        if(order == "DESC"){

                            $container.isotope({ sortBy: 'number', sortAscending: false});
                            order = "ASCE";
                            console.log('DESC clicked');
                            console.log('order  now : '+order);

                        }else if (order == "ASCE"){
                            $container.isotope({ sortBy: 'number',sortAscending: true});
                            order = "DESC";

                            console.log('ASCE clicked');
                            console.log('order  now : '+order);
                        }


                    });

                    $(window).resize(function() {
                        $container.isotope('layout');
                    });

                });

            </script><!-- Portfolio Script End -->

        </div>

    </div>

@endsection


