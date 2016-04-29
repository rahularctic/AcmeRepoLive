@extends('Vitee_Website_Views.master')


@section('assets')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />

@endsection

@section('title')

    <title> Vitee - My Tickets </title>

@endsection

@section('page-title')


    <div class="container clearfix">
        <h1> My Tickets </h1>
        <span> </span>
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/events/all">All Events</a></li>

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
        <?php
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
        ?>

        <div class="container clearfix">


		@if(count($ticketsToday) > 0)
            <div id="portfolio" class="clearfix">
                <div class="col-sm-6">
                    <div class="panel  col-sm-offset-2">
                        <div class="panel-body">
                       @foreach($ticketsToday as $Event)

                                <div class="panel  panel-success" style="border: none;">
                                    <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title" >
                                            <button class='btn btn-warning'>Today</button>
                                        </h3>
                                    </div>
                                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{$Event->EVENTIMAGE}}" alt="no image"/>
                            </div>
                            <div class="col-sm-6">

                                    <div class="row"><h5><b>{{$Event->EVENTNAME}}</b></h5></div>
                                    <div class="row"><h5><b>{{$Event->EVENTLOCATION}}</b></h5></div>
                                    <div class="row"><h5><b>{{$Event->EVENTSTART}}</b></h5></div>

                            </div>
                        </div>
                        <div class="row">
                            <br/>

                            <div class="panel panel-default">
                                <div class="panel-heading" style="height: 30px;">
                                    <h3 class="panel-title" >

                                            <div class="col-sm-4"><b>Ticket Type</b></div>
                                            <div class="col-sm-6"><b>Ticket Number</b></div>
                                            <div class="col-sm-2"></div>

                                    </h3>
                                </div>
                                <div class="panel-body">
                                    @foreach($ticketTypeToday as $TicketInfo)
                                    <div class="col-sm-12" >
                                        <div class="col-sm-4">{{$TicketInfo->TICKETTYPENAME}}</div>
                                        <div class="col-sm-4">{{$TicketInfo->TICKETID}}</div>
                                        <div class="col-sm-4"><a href="{{URL::to('downloadInvoicePDF/1')}}" target="_blank" >Download pdf</a></div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>

                            <br/>
                            <br/>
                            <br/>
                            <br/>
                        </div>
                                    </div>
                                </div>
                        @endforeach

                        </div>
                    </div>
            </div>
        </div>
		@endif

		@if(count($ticketsTomorrow) > 0)
            <div id="portfolio" class="clearfix">
                <div class="col-sm-6">
                    <div class="panel  col-sm-offset-2">
                        <div class="panel-body">
                            @foreach($ticketsTomorrow as $Event)

                                <div class="panel  panel-success" style="border: none;">
                                    <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title" >
                                            <button class='btn btn-warning'>Tommorrow</button>
                                        </h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <img src="{{$Event->EVENTIMAGE}}" alt="no image"/>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="row"><h5><b>{{$Event->EVENTNAME}}</b></h5></div>
                                                <div class="row"><h5><b>{{$Event->EVENTLOCATION}}</b></h5></div>
                                                <div class="row"><h5><b>{{$Event->EVENTSTART}}</b></h5></div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <br/>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="height: 30px;">
                                                    <h3 class="panel-title" >

                                                        <div class="col-sm-4"><b>Ticket Type</b></div>
                                                        <div class="col-sm-6"><b>Ticket Number</b></div>
                                                        <div class="col-sm-2"></div>

                                                    </h3>
                                                </div>
                                                <div class="panel-body">
                                                    @foreach($ticketTypeTomorrow as $TicketInfo)
                                                        <div class="col-sm-12" >
                                                            <div class="col-sm-4">{{$TicketInfo->TICKETTYPENAME}}</div>
                                                            <div class="col-sm-4">{{$TicketInfo->TICKETID}}</div>
                                                            <div class="col-sm-4"><a href="{{URL::to('downloadInvoicePDF/1')}}" target="_blank" >Download pdf</a></div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>

                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
			@endif

			@if(count($ticketsAfterTomorrow) > 0)
            <div id="portfolio" class="clearfix">
                <div class="col-sm-6">
                    <div class="panel  col-sm-offset-2">
                        <div class="panel-body">

                            @foreach($ticketsAfterTomorrow as $Event)

                                <div class="panel  panel-success" style="border: none;">
                                    <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title" >
                                            <button class='btn btn-warning'>{{ Carbon\Carbon::parse($Event->EVENTSTART)->format('F j, Y, g:i a')  }}</button>
                                        </h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <img src="{{$Event->EVENTIMAGE}}" alt="no image"/>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="row"><h5><b>{{$Event->EVENTNAME}}</b></h5></div>
                                                <div class="row"><h5><b>{{$Event->EVENTLOCATION}}</b></h5></div>
                                                <div class="row"><h5><b>{{$Event->EVENTSTART}}</b></h5></div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <br/>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="height: 30px;">
                                                    <h3 class="panel-title" >

                                                        <div class="col-sm-4"><b>Ticket Type</b></div>
                                                        <div class="col-sm-6"><b>Ticket Number</b></div>
                                                        <div class="col-sm-2"></div>

                                                    </h3>
                                                </div>
                                                <div class="panel-body">
                                                    @foreach($ticketTypeAfterTomorrow[$count3] as $TicketInfo)
                                                        <div class="col-sm-12" >
                                                            <div class="col-sm-4">{{$TicketInfo->TICKETTYPENAME}}</div>
                                                            <div class="col-sm-4">{{$TicketInfo->TICKETID}}</div>
                                                            <div class="col-sm-4"><a href="{{URL::to('downloadInvoicePDF/1')}}" target="_blank" >Download pdf</a></div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>

                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                                <?php $count3++; ?>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
			@endif
			
			<?php if($count1 == 0 && $count2 == 0 && $count3 == 0) { ?>
			<div id="portfolio" class="clearfix">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">                                
							<div class="panel-heading" style="height: 50px;">
								<h1 class="panel-title" ><b>No Bookings Yet.</b></h1>
								<br/>
								<h2 class="panel-title" ><b>Cick here to  <a href="events/all" >BOOK NOW</a></b></h2>
							</div>	
								
						</div>		
					</div>	
				</div>	
			</div>	
			<?php } ?>


    </div>
    </div>

@endsection


