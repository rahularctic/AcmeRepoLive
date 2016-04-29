
@extends('app')


@section('assets')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="{{asset('/css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('/js/fileinput.js')}}" ></script>

@endsection


@section('side')

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">


          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li >
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


            <li class="active">
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



    <div class="row">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">General Settings </h3>
            </div><!-- /.box-header -->

            <!-- Alert Flash Message Event Created   -->
            @if (Session::has('success_update'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4> <i class="icon fa fa-check"></i> Sucess </h4>
                    <p>{{ Session::get('success_update') }}</p>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    <p>{{ Session::get('error') }}</p>
                </div>
                @endif
                        <!-- end alert -->

            <div class="col-xs-6">
                <br>
                {!! Form::open(['url' => '/dashboard/settings/update', 'method' => 'post', 'class' => 'form','files'=>true ,'id'=>'changesettings',
                'onsubmit'=>"return confirm('Do you really want to Save Changes ?')"])!!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div id="profile">
                    <a href="javascript:void(0);" class="thumbnail">


						<!-- <img src="/img/user/336" height="20%" width="20%" class="profile-image"  id="profileImg"/> -->

                         <img src="{{asset('/img/user/'.Auth::user()->USERID.'/'.Auth::user()->USERIMAGE)}}" height="20%" width="20%" class="profile-image"  id="profileImg"/>
                        <!-- <input name="document"  type="file"  id="file-id" class="active"/> -->
                        <input id="fileupload" class="file" type="file" name="profileimage" multiple />
                    </a>
                </div>

            </div>


            <div class="col-xs-6">
                <div class="box-body">


                        <!-- text input -->
                        <div class="form-group">
                            <label>UserName</label>
                            <input class="form-control" placeholder="" type="text" name="username" value="{{Auth::user()->USERNAME}}">
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                            <label>Profile Description</label>
                            <textarea  style="resize:none" class="form-control" rows="3" name="description">{{Auth::user()->USERDESCRIPTION}}</textarea>
                        </div>



                </div><!-- /.box-body -->

            </div>



        </div>

        <div class="input-group">
            <!--<input class="form-control" placeholder="Type message..."/> -->
            <div class="input-group-btn">
                {!! Form::submit('Save Settings',array( 'class'=> 'submit btn btn-primary pull-right')) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>
        $("#fileupload").fileinput({
            // you must set a valid URL here else you will get an error
            allowedFileExtensions: ['jpg', 'png', 'gif','jpeg'],
            overwriteInitial: true,
            maxFileSize: 1500,
            maxFilesNum: 10,
            showUpload: false,
            maxFileCount: 1,
            browseClass: "btn btn-success",
            browseLabel: " Pick Images",
            browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
            removeLabel: "Delete",
            //allowedFileTypes: ['image', 'video', 'flash'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }

        });
    </script>

    @endsection

@stop
