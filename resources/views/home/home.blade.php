@extends('app')

@section('assets')
    <meta name="csrf-token" content="{{csrf_token()}}" xmlns="http://www.w3.org/1999/html"/>

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('plugins/morris/morris.js') }}"></script>
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>


    <script src="{{asset('/js/moment/moment.min.js')}}"></script>
    <script src="{{asset('/js/moment/moment-range.min.js')}}"></script>


@endsection


@section('side')

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">


          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="active">
              <a href="/dashboard/home">
                <i class="fa fa-home"></i> <span>Home</span>
               <!--  <small class="label pull-right bg-yellow">12</small> -->
              </a>
            </li>

            <li><a href="/dashboard/event/create"><i class="fa fa-edit"></i> Create New Event</a></li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-calendar"></i> <span>Manage Events</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/dashboard/event/create"><i class="fa fa-edit"></i> Create New Event</a></li>
                <li><a href="/dashboard/events"><i class="fa fa-calendar"></i> Show My Events</a></li>
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


    <section class="content">


        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8">

                <div class="jumbotron" style="background-color: #ffffff; padding-left: 2%;">
                    <h2>Welcome {{Auth::user()->USERNAME}},  <small> To Your   Dashboard </small> </h2>
                    <p>We at Vitee are proud to present to you, a personalised website to manage your events. On here you will be able to see all the important statistics that you will want to know about the AMAZING events that you have created. </p>
                    <p> <h4><small> If you require any support, please do not hesitate to email any problems you have to support@vitee.net or call us on 36651772 </small> </h4></p>
                </div>

            </div>
            <div class="col-xs-6 col-md-4">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        {{--<i class="fa fa-text-width"></i>--}}
                        <h3 class="box-title">GET STARTED NOW</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <h2>What are you waiting for ?</h2>
                        <br>
                        <a href="/dashboard/event/create" > <button class="btn btn-block btn-primary btn-lg">Create Your Event Now</button> </a>
                    </div><!-- /.box-body -->
                </div>

            </div>


        </div>




        <div class="row">


            <div class="col-xs-6 col-sm-4">

                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{count($upcoming_events)}}</h3>
                        <p>Upcoming Events</p>
                    </div>
                    <div class="icon">
                        <i class="fa ion-calendar"></i>
                    </div>

                </div>

            </div>

            <div class="col-xs-6 col-sm-4">

                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$totalRevnue}}<sup style="font-size: 20px">BD</sup></h3>
                        <strong><p>Total Revenue This Week </p></strong>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    {{--   <a href="#" class="small-box-footer">
                           More info <i class="fa fa-arrow-circle-right"></i>
                       </a>--}}
                </div>

            </div>

            <div class="clearfix visible-xs-block"></div>

            <div class="col-xs-6 col-sm-4">

                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{count($followers)}}</h3>
                        <strong><p>Total Followers</p></strong>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    {{--<a href="#" class="small-box-footer">--}}
                    {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
                    {{--</a>--}}
                </div>

            </div>
        </div>

        <br/>

        <div class="row">

            <div class="col-xs-12">

                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title"><strong>Revenue Made This Week</strong></h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart " id="chart" >


                        </div>
                    </div><!-- /.box-body -->
                </div>

            </div>

        </div>


</section>

@endsection



@section('footer')




    <script>

        $('#chart').html('');


        function dateFormat(today){


            var yyyy = today.getFullYear();
            var mm = today.getMonth()+1;
            var dd = today.getDate();

            if(dd<10){

                dd='0'+dd;
            }

            if(mm <10)
            {
                mm = '0' + mm;
            }

            var newTodayF = yyyy+'-'+mm+'-'+dd;


            return newTodayF;
        }


        var today = new Date();

        var newdate = new Date();
        var maxDate = today;
        var minDate  = today;

        minDate.setDate(newdate.getDate() - 3);
        min = new Date(minDate);


        maxDate.setDate(newdate.getDate() + 4);
        max = new Date(maxDate);


        var origData = {

            daterange: [ dateFormat(min),dateFormat(max)],

        };


       // console.log(dateFormat(min));

      //  console.log(dateFormat(max));

        function formatData() {


            dataTemp = {
                date: [],

            };
            dataOut = [];

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();

            if(dd<10) {
                dd='0'+dd
            }

            if(mm<10) {
                mm='0'+mm
            }


          // console.log(origData.daterange[0]);

           moment(origData.daterange[0], "YYYY-MM-DD");


            var range = moment().range(moment(origData.daterange[0], "YYYY-MM-DD"), moment(origData.daterange[1], "YYYY-MM-DD"));

            range.by(moment().range(moment(origData.daterange[0], "YYYY-MM-DD"), moment(origData.daterange[0], "YYYY-MM-DD").add("days", 1)), function(m) {
                dataTemp.date.push(m.format("YYYY-MM-DD"));
            });

            num = dataTemp.date.length;




            for (var i = 0; i < 7; i++) {


                var hasValueForDate = false;
                @foreach($revenues as $revenue)

                     //   console.log(' loop i : ' + i  );
                        if ("{{$revenue->dateOfPurchase}}" == dataTemp.date[i]) {

                           // console.log('if is excuted | i = ' + "{{$revenue->dateOfPurchase}}");


                            dataOut.push({
                                x: {{$revenue->revenue}},
                                y: "{{$revenue->dateOfPurchase}}"
                            });
                            hasValueForDate = true;
                        }
                @endforeach

                 if(!hasValueForDate) {
                          //  console.log('else is excuted | i = '+ dataTemp.date[i]);
                            dataOut.push({
                                x: 0,
                                y: dataTemp.date[i]
                            });
                        }
            }

            return dataOut;

        }

       // console.log(formatData());

        morrisData = formatData();


        Morris.Line({
            element: "chart",
            data: morrisData,
            xkey: 'y',
            ykeys: ['x'],
            xLabelFormat: function (x) { return moment(x).format("MMM D YY"); },
            dateFormat: function (x) { return moment(x).format("dddd, MMMM Do YYYY"); },
            labels: ["Revenue : "],
            lineColors: ["#e74c3c"],
            gridTextSize: 11,
            hideHover: true,
            hoverCallback: function (index, options, content) {
                var row = options.data[index];
                return '<div class="hover-title">' + options.dateFormat(row.y) + '</div><span>' + options.labels[0] + '</span> <b style="color: ' + options.lineColors[0] + '">' + row.x.toLocaleString() + " BD </b>";

            }
        });

    </script>




@endsection

@stop