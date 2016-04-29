@extends('Vitee_Website_Views.master')


@section('assets')


    <!-- External CSS
  ============================================= -->

    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/calendar/calendar.css')}}" type="text/css" />
    <link rel="stylesheet" href="http://weloveiconfonts.com/api/?family=fontawesome">

    <!-- External JavaScripts
  ============================================= -->




@endsection

@section('title')

    <title>Events Calendar </title>

@endsection

@section('page-title')

    <div class="container clearfix">
        <h1>Events Calendar </h1>
        <span> Events List </span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Events Calendar </li>
        </ol>
    </div>

@endsection



@section('content')

    <div class="content-wrap">

        <div class="container">

            <div class="row">
                <div class="col-md-6" >
                    <div class="calendar hidden-print">
                        <header>
                            <h2 class="month"></h2>
                            <a class="btn-prev fontawesome-angle-left" href="#"></a>
                            <a class="btn-next fontawesome-angle-right" href="#"></a>
                        </header>
                        <table>
                            <thead class="event-days">
                            <tr></tr>
                            </thead>
                            <tbody class="event-calendar">
                            <tr class="1"></tr>
                            <tr class="2"></tr>
                            <tr class="3"></tr>
                            <tr class="4"></tr>
                            <tr class="5"></tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="col-md-6">

                    <div class="list">

                        @foreach( $allEvents as $event)

                        <div  class="day-event" date-day=" " date-month=" " date-year=" "  data-number="1">
                            <a href="{{URL('/event/'.$event->EVENTID.'/'. str_replace(' ', '-', $event->EVENTNAME) )}}">
                                <div class="notice notice-event">
                                    <div class="event-img">
                                        <img src="{{asset('/img/event/'.$event->EVENTID.'/thumbnails/'.$event->EVENTIMAGE)}}" />
                                    </div>

                                    <div class="event-info">
                                        <h2 class="event-title">{{$event->EVENTNAME}}</h2>
                                        <p class="event-date"> <i class="fa fa-clock-o"></i>  {{$event->STARTDATE}} </p>
                                        <p class="event-location" > <i class="fa fa-map-marker"></i> {{$event->EVENTLOCATION}}  </p>
                                        <p class="event-promoter"> By : <strong> {{$event->EVENTLOCATION}} </strong>  </p>
                                    </div>

                                </div>
                            </a>

                        </div>

                        @endforeach


                    </div>


                </div>
            </div>
        </div>



    </div>

 @endsection

@section('assets-footer')




    <script type="text/javascript">

        $(document).ready(function (){


            $('.day-event').each(function( index ) {

               var d = new Date($(this).find('.event-date').text());

                $(this).attr('date-day', d.getDate());
                $(this).attr('date-month', d.getMonth()+1);
                $(this).attr('date-year', d.getFullYear());

            });


        });

    </script>

    <script type="text/javascript" src="{{asset('Vitee_Website_Assets/js/calendar/simplecalendar.js')}}"></script>

@endsection