@extends('app')

@section('assets')

    <!-- DATA TABLES -->
    <link href="{{asset('/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />

@stop

@section('asset-footer')
    <!-- DATA TABES SCRIPT -->
    <script src="{{asset('/plugins/datatables/jquery.dataTables.js')}}" type="text/javascript"></script>
    <script src="{{asset('/plugins/datatables/dataTables.bootstrap.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $("#example1").dataTable();
            $('#example2').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false
            });
        });
    </script>

    <script>
        $('#modal-from-dom').on('show.bs.modal', function() {

            var id = $(this).data('id');
            removeBtn = $(this).find('.danger');

            removeBtn.attr('href', removeBtn.attr('href').replace(/\d*/, '/dashboard/event/delete/'+id));


        });

        $('.confirm-delete').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#modal-from-dom').data('id', id).modal('show');
        });
    </script>
@stop



@section('title')
    Vitee - My Events
@stop


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
    @if (Session::has('delete_event'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{{ Session::get('delete_event') }}</p>
        </div>
        @endif
    <!-- end alert -->

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{url('/dashboard/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Events List</li>
        </ol>
    </section>




    <!-- Modal for deleting Event -->

    <div  id="modal-from-dom" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

    <h1> My Events </h1>


    <div class="row">
        <div class="col-xs-12">


            <div class="box">
                <div class="box-header">
                    <h2 class="box-title"><b class="label label-success">Live Events</b></h2>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Event Name</th>
                            <th> <span class="glyphicon glyphicon-pushpin" aria-hidden="true"> &nbsp;</span>  Location</th>
                            <th> <span class="glyphicon glyphicon-time" aria-hidden="true"> &nbsp;</span> Start Date </th>
                            <th><span class="glyphicon glyphicon-time" aria-hidden="true"> &nbsp;</span> End Date</th>
                            <th>Manage</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($live_events as $event)

                            <tr>

                                <td><a href="/dashboard/event/{{$event->EVENTID}}"> {{$event->EVENTNAME}}</a></td>
                                <td>{{$event->EVENTLOCATION}}</td>
                                <td>{{$event->EVENTSTART}}</td>
                                <td>{{$event->EVENTEND}}</td>
                                <td>

                                    <a href="#" class="confirm-delete" data-id="{{$event->EVENTID}}"> <button type="button" class="btn btn-default btn-sm"  data-toggle="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
                                    <a href="/dashboard/event/update/{{$event->EVENTID}}" ><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>

                                </td>
                            </tr>


                        @endforeach

                        </tbody>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->



            <div class="box">
                <div class="box-header">
                    <h2 class="box-title"><b class="label label-warning">Upcoming Events</b></h2>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Event Name</th>
                            <th> <span class="glyphicon glyphicon-pushpin" aria-hidden="true"> &nbsp;</span>  Location</th>
                            <th> <span class="glyphicon glyphicon-time" aria-hidden="true"> &nbsp;</span> Start Date </th>
                            <th><span class="glyphicon glyphicon-time" aria-hidden="true"> &nbsp;</span> End Date</th>
                            <th>Manage</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($upcoming_events as $event)

                            <tr>

                                <td><a href="/dashboard/event/{{$event->EVENTID}}"> {{$event->EVENTNAME}}</a></td>
                                <td>{{$event->EVENTLOCATION}}</td>
                                <td>{{$event->EVENTSTART}}</td>
                                <td>{{$event->EVENTEND}}</td>
                                <td>

                                    <a href="#" class="confirm-delete" data-id="{{$event->EVENTID}}"> <button type="button" class="btn btn-default btn-sm"  data-toggle="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>
                                    <a href="/dashboard/event/update/{{$event->EVENTID}}" ><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>

                                </td>
                            </tr>


                        @endforeach

                        </tbody>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->





            <div class="box">
                <div class="box-header">
                    <h2 class="box-title"><b class="label label-danger" >Past Events</b></h2>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Event Name</th>
                            <th> <span class="glyphicon glyphicon-pushpin" aria-hidden="true"> &nbsp;</span>  Location</th>
                            <th> <span class="glyphicon glyphicon-time" aria-hidden="true"> &nbsp;</span> Start Date </th>
                            <th><span class="glyphicon glyphicon-time" aria-hidden="true"> &nbsp;</span> End Date</th>
                            <th>Attendees</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($old_events as $event)

                            <tr>

                                <td><a href="/dashboard/event/{{$event->EVENTID}}">{{$event->EVENTNAME}} </a></td>
                                <td>{{$event->EVENTLOCATION}}</td>
                                <td>{{$event->EVENTSTART}}</td>
                                <td>{{$event->EVENTEND}}</td>
                                <td>{{$event->Attendees}} </td>
                            </tr>


                        @endforeach

                        </tbody>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->


        </div><!-- /.col -->
    </div><!-- /.row -->








@stop
