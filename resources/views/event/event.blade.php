@extends('app')


@section('assets')




    <meta name="csrf-token" content="{{csrf_token()}}" />

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ asset('plugins/morris/morris.js') }}"></script>
    
	<script src="{{asset('js/raphael/raphael-min.js')}}"></script>

    <script>
        $(document).ready(function () {

            var Snewdate = ($("#startDate").html());
            Snewdate = moment($("#startDate").html()).format('Do MMM YYYY , h:mm a');

            var Enewdate = ($("#endDate").html());
            Enewdate = moment($("#endDate").html()).format('Do MMM YYYY  , h:mm a');

            $("#startDate").html(Snewdate);
            $("#endDate").html(Enewdate);


        });
    </script>
    



@endsection



@section('side')

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">


          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li>
              <a href="/dashboard/home">
                <i class="fa fa-home"></i> <span>Home</span>
               <!--  <small class="label pull-right bg-yellow">12</small> -->
              </a>
            </li>

            <li><a href="/dashboard/event/create"><i class="fa fa-edit"></i> Create New Event</a></li>

            <li class="treeview active">
              <a href="#">
                <i class="fa fa-calendar"></i> <span>Manage Events</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/dashboard/event/create"><i class="fa fa-edit"></i> Create New Event</a></li>
                <li class="active"><a href="/dashboard/events"><i class="fa fa-calendar"></i> Show My Events</a></li>
              </ul>
            </li>


            <li>
              <a href="/dashboard/settings">
                <i class="fa fa-cogs"></i> <span>Settings</span>
               <!--  <small class="label pull-right bg-red">3</small> -->
              </a>
            </li>

            
            <li class="header">General</li>
            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> Sign out</a></li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

@endsection

@section('content')

    <!-- Alert Flash Message Event Created   -->
    @if (Session::has('create_event'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{ Session::get('create_event') }}</p>
        </div>
        @endif
                <!-- end alert -->

        <!-- Alert Flash Message Event Created   -->
        @if (Session::has('update_event'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ Session::get('update_event') }}</p>
            </div>
            @endif
                    <!-- end alert -->

            <section class="content-header">

                <ol class="breadcrumb">
                    <li><a href="{{url('/dashboard/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active"> Event Page</li>
                </ol>
            </section>

            <!-- Modal for deleting Event -->

            <div id="modal-from-dom" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                        </div>

                        <div class="modal-body">
                            <p>You are about to delete one track, this procedure is irreversible.</p>

                            <p>Do you want to proceed?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="" class="btn btn-danger btn-ok danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="page-header">
                    <h1> &nbsp; {{$event->EVENTNAME}}
                        <small> </small>
                    </h1>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-8">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-map-marker"></i>

                            <h1 class="box-title">{{$event->EVENTLOCATION}}</h1>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <dl>
                                <dt><i class="fa fa-clock-o"></i> <strong>Start : </strong> <span
                                            id="startDate">{{$event->EVENTSTART}}</span> 
                                </dt>
                                <dd><br></dd>
                                <dt><i class="fa fa-clock-o"></i> <strong>End : </strong> <span
                                            id="endDate">{{$event->EVENTEND}}</span> </dt>
                                <dd><br></dd>
                                <dt>Event Description</dt>
                                <dd>
                                    @if($event->EVENTDESCRIPTION == '') < No Description Available>
                                    @else {{$event->EVENTDESCRIPTION}}
                                    @endif
                                </dd>

                            </dl>

                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="row">

                        <div class="col-xs-6 col-sm-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Attendees</span>
                                    <span class="info-box-number">{{count($attendees)}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <div class="col-xs-6 col-sm-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="ion ion-earth"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"></span>
                            <span class="info-box-number">@if($event->EVENTPRIVACY == 0) Public
                                @else Private
                                @endif</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-xs-6 col-sm-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                                <div class="info-box-content">
                                    @if($event->EVENTPAID == 0)

                                        <span class="info-box-text">No Tickets Sold</span>
                                        <span class="info-box-number">Free Event</span>

                                    @else
                                        <span class="info-box-text">Tickets Sold</span>
                                        <span class="info-box-number">{{$totalTicketsSold[0]->TOTALTICKETSSOLD}} / {{$totalTicketsSold[0]->TICKETTOTAL}} </span>

                                    @endif


                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                    </div>

                </div>

                <div class="col-xs-6 col-md-4">

                    <table class="table table-bordered text-center">
                        <tbody>

                        <tr>
                            <td><a href="{{url('/dashboard/event/update/'.$event->EVENTID) }}">
                                    <button class="btn btn-block btn-success"><i class="fa fa-pencil-square-o"></i>Edit
                                    </button>
                                </a></td>
                            <td><a href="#" class="confirm-delete" data-id="{{$event->EVENTID}}">
                                    <button class="btn btn-block btn-danger" data-toggle="modal"><i
                                                class="fa fa-trash"></i> Delete
                                    </button>
                                </a></td>

                        </tr>


                        </tbody>
                    </table>

                    <img src="{{asset('/img/event/'.$event->EVENTID.'/'.$event->EVENTIMAGE)}}" alt="No Image"
                         data-src="holder.js/100%x180" style="height: 250px; width: auto; display: block;  margin:auto;"/></div>

            </div>



            <div class="row">

                <div class="col-xs-6 col-sm-4">
                    <!-- ATTENDEES LIST -->
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Attendees List</h3>

                            <div class="box-tools pull-right">
                                <span class="label label-danger">{{count($attendees)}} Attendees</span>
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <ul class="users-list clearfix">

                                @if(count($attendees) == 0)
                                    <h1> &nbsp; <i class="fa fa-frown-o fa-2x"></i>
                                        <small> You have No Attendees</small>
                                    </h1>
                                @else

                                    @for ($i = 0; $i < 5; $i++)
                                        @if(!empty($attendees[$i]))

                                            <li>
                                                <img src="/img/user/{{$attendees[$i]->USERID}}"
                                                     alt="User Image">
                                                <a class="users-list-name" href="#">{{$attendees[$i]->USERNAME}}</a>
                                                <span class="users-list-date">Today</span>
                                            </li>
                                        @else
                                        @endif
                                    @endfor
                                @endif

                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <a href="#" class="uppercase" data-toggle="modal" data-target="#myModal">View All
                                Attendees</a>
                        </div>
                        <!-- /.box-footer -->
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Attendees List</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="box-body no-padding">
                                            <ul class="users-list clearfix">

                                                @foreach($attendees as $attendee)

                                                    <li>
                                                        <img src="/img/user/{{$attendee->USERID}}"
                                                             alt="User Image">
                                                        <a class="users-list-name" href="#">{{$attendee->USERNAME}}</a>
                                                        <span class="users-list-date">Today</span>
                                                    </li>


                                                @endforeach


                                            </ul>
                                            <!-- /.users-list -->
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!--
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.box -->
                </div>
                <!-- /.col -->

                <div class="col-xs-6 col-sm-4">


                    <!-- Ticket LIST -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tickets List</h3>

                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                @if($event->EVENTPAID == 0)
                                    <div class="callout callout-info">
                                        <h4>It's Free Event</h4>

                                        <p> No Ticket</p>
                                    </div>
                                @else
                                    @foreach($tickets as $ticket)
                                        <li class="item">
                                            <div class="product-img">
                                                <!-- <img src="http://placehold.it/50x50/d2d6de/ffffff" alt="Product Image"> -->
                                                <i class="fa fa-ticket fa-2x"></i>
                                            </div>
                                            <div class="product-info">
                                                {{--<a href="javascript::;">--}}

                                                   class="product-title">{{$ticket->TICKETTYPENAME}}<span
                                                            class="label label-success pull-right">BHD {{$ticket->TICKETPRICE}}</span></a>
                        <span class="product-description">
                         {{$ticket->TICKETTYPEDESCRIPTION}}
                        </span>
                                            </div>
                                        </li><!-- /.item -->
                                    @endforeach

                                @endif
                            </ul>
                        </div>
                        <!-- /.box-body -->

                        {{--                <div class="box-footer text-center">
                                            <a href="javascript::;" class="uppercase">View All Products</a>
                                        </div><!-- /.box-footer -->
                                        --}}
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col -->

                <div class="clearfix visible-xs-block"></div>

                <div class="col-xs-6 col-sm-4">

                    @if(count($images) > 1)

                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Carousel</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">

                                    @foreach($images as $image)

                                        <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>

                                    @endforeach
                                </ol>
                                <div class="carousel-inner">

                                    @foreach($images as $image)

                                        @if($image['basename'] == $event->EVENTIMAGE )


                                        <div class="item active">
                                         @else
                                         <div class="item">
                                        @endif

                                        <img  style=" width:auto; height: 225px; max-height: 225px; margin:auto;" src="{{asset('/img/event/'.$event->EVENTID.'/thumbnails/'.$image['basename'])}}" alt="First slide">
                                        <div class="carousel-caption">
                                            {{$event->EVENTNAME}}
                                        </div>
                                    </div>


                                @endforeach

                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    @endif

                </div>



            </div>
                </div>

             <div class="row">
                    <div class="col-md-6">

                        <!-- DONUT CHART Gender -->
                        <div class="box box-danger">
                            <div class="box-header">
                                <h3 class="box-title">Gender Chart</h3>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="gender-chart"
                                     style="height: 250px; position: relative;"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                    <div class="col-md-6">

                        <!-- DONUT CHART Age Group-->
                        <div class="box box-danger">
                            <div class="box-header">
                                <h3 class="box-title">Age Group Chart</h3>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="agegroup-chart"
                                     style="height: 250px; position: relative;"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                </div>
            @if($event->EVENTPAID == 0)
            
            

            @else

               
                <h4>
                    {!! Form::label('ticketType', 'Ticket Type')!!}


                    {!! Form::select('ticketType', array_merge(['' => 'Please Select'], $values[0] ))!!}
                </h4>
                <div class="box box-info">

                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div>

                    <div class="box-body chart-responsive">
                        <div class="chart" id="chart">
                       


                            @if ($values[2]== null)

                                <div class="alert alert-info alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    <h4><i class="icon fa fa-info"></i> Please Select Ticket Type to Display the
                                        Tickets Sold Graph </h4>

                                </div>


                            @else




                            @endif


                            @endif


                        </div>
                         <h2 id="chartTypeSales"></h2>

                        <div style="text-align: center;">
                            <i id="refresh" class="fa fa-refresh fa-spin fa-5x" align="center"></i>
                        </div>

                    </div>
                    <!-- /.box-body -->

                </div>

</div>

@endsection

@section('footer')



    <script>
        $('#modal-from-dom').on('show.bs.modal', function () {

            var id = $(this).data('id'),
                    removeBtn = $(this).find('.danger');
            removeBtn.attr('href', removeBtn.attr('href').replace(/\d*/, '/dashboard/event/delete/' + id));
        });

        $('.confirm-delete').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#modal-from-dom').data('id', id).modal('show');
        });
    </script>

    <script>
        //DONUT CHART for Gender
        var donutGender = new Morris.Donut({
            element: 'gender-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: [
                {label: "Females", value: {{$values[6][0]->GENDERCOUNT}}},
                {label: "Males", value:{{$values[5][0]->GENDERCOUNT}}}
            ],
            hideHover: 'auto'
        });


        //DONUT CHART for age group
        var donutAgeGroup = new Morris.Donut({
            element: 'agegroup-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a", "#B33CB9", "#B9B33C", "#3CB9B3", "#CEEDEB"],
            data: [
                {label: "Under 17", value: {{$values[7][0]->under17}}},
                {label: "18 - 24", value:{{$values[7][0]->and1824}}},
                {label: "25 - 34", value:{{$values[7][0]->and2534}}},
                {label: "35 - 44", value:{{$values[7][0]->and3544}}},
                {label: "45 - 54", value:{{$values[7][0]->and4554}}},
                {label: "55 - 64", value:{{$values[7][0]->and5564}}},
                {label: "Over 65", value:{{$values[7][0]->over65}}}
            ],
            hideHover: 'auto'
        });


    </script>



    <!-- page script -->
    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
        });
    </script>

    <script>

        $("#refresh").hide();

        $("#ticketType").change(function () {


            $('#chart').html('');
            $('#chartTypeSales').html('');

            var token = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                url: '/dashboard/event/{{$event->EVENTID}}',
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $("#refresh").show();
                },
                data: {"tickettype": ($("#ticketType").find(':selected').text())},


                success: function (response) {

                    if (response['val'][0] == undefined) {

                        $("#chart").append('<div class="alert alert-info alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' +
                        ' <h4><i class="icon fa fa-info"></i> No Graph Available </h4> </div>');


                    } else {
                    	
                    	
									
                        $('#chartTypeSales').html(response['totalTypeSales'][0]['TICKETTYPENAME'] + " Tickets Sold:  " + response['totalTypeSales'][0]['TOTALTICKETTYPESALES'] + " / " + response['totalTypeSales'][0]['TICKETTYPETOTAL']);
			
			

                        //DRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWWWWWWWWWWw 
                        var lengthtab = (response['val'].length);
                        for (var i = 0; i < lengthtab; i++) {


                        }
                        


                        var origData = {

                            daterange: [response['val'][0]['TICKETSTARTSALES'], response['val'][0]['TICKETENDSALES']],

                        };


                        function formatData() {


                            dataTemp = {
                                date: [],

                            };
                            dataOut = [];


                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();

                            if (dd < 10) {
                                dd = '0' + dd
                            }

                            if (mm < 10) {
                                mm = '0' + mm
                            }

                            today = yyyy + '-' + mm + '-' + dd;

                            if (today >= response['val'][0]['TICKETSTARTSALES'] && today <= response['val'][0]['TICKETENDSALES']) {

                                origData.daterange[1] = today;

                            }

		          moment(origData.daterange[0], "YYYY-MM-DD");
                          

                            var range = moment().range(moment(origData.daterange[0], "YYYY-MM-DD"), moment(origData.daterange[1], "YYYY-MM-DD"));

                            range.by(moment().range(moment(origData.daterange[0], "YYYY-MM-DD"), moment(origData.daterange[0], "YYYY-MM-DD").add("days", 1)), function (m) {
                                dataTemp.date.push(m.format("YYYY-MM-DD"));
                            });

                            num = dataTemp.date.length;


                            for (var i = 0; i < num; i++) {

                                var hasValueForDate = false;

                                var lengthtab = (response['val'].length);

                                for (var j = 0; j < lengthtab; j++) {

                                    if (response['val'][j]['TOP'] == dataTemp.date[i]) {
                                        dataOut.push({
                                            x: response['val'][j]['TICKETCOUNT'],
                                            y: response['val'][j]['TOP']
                                        });
                                        hasValueForDate = true;

                                    }

                                }


                                if (!hasValueForDate) {
                                    dataOut.push({
                                        x: 0,
                                        y: dataTemp.date[i]
                                    });
                                }
                            }

                            return dataOut;

                        }

                        morrisData = formatData();


                        Morris.Line({
                            element: "chart",
                            data: morrisData,
                            xkey: 'y',
                            ykeys: ['x'],
                            xLabelFormat: function (x) {
                                return moment(x).format("MMM D YY");
                            },
                            dateFormat: function (x) {
                                return moment(x).format("dddd, MMMM Do YYYY");
                            },
                            labels: [response['totalTypeSales'][0]['TICKETTYPENAME'] + " Tickets Sold"],
                            lineColors: ["#e74c3c"],
                            gridTextSize: 11,
                            hideHover: true,
                            hoverCallback: function (index, options, content) {
                                var row = options.data[index];
                                return '<div class="hover-title">' + options.dateFormat(row.y) + '</div><b style="color: ' + options.lineColors[0] + '">' + row.x.toLocaleString() + " </b><span>" + options.labels[0] + "</span>";

                            }
                        });

			
                    }

                },
                //END OF SUCCESS
                complete: function () {
                    $("#refresh").hide();
                }
            });
        });

    </script>
    
     
   <script src="{{asset('/js/moment/moment.min.js')}}"></script>
   <script src="{{asset('/js/moment/moment-range.min.js')}}"></script>       


@stop