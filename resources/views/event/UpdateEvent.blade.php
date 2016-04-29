@extends('app')


@section('assets')

    <meta name="_token" content="{{ csrf_token() }}"/>

    <!--
<link href="{{ asset('css/bootstrap-theme.css') }}" rel="stylesheet" type="text/css">



-->


    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" type="text/css" href="/css/validationEngine.jquery.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/fileinput.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/Create_event_org.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css"/>


    <!-- NEw Template Css
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="/plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <!-- Date Picker -->
    <link href="/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-switch.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{asset('css/vitee1.css')}}"/>

    <script type="text/javascript" src="{{ asset('/js/jquery-2.1.3.min.js') }}"></script>

    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/languages/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="/js/jquery.validationEngine.js"></script>
    <script type="text/javascript" src="{{ asset('/js/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/moment.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.js') }}"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-switch.js') }}"></script>
    <!-- For Scroll Link Animation -->
    <script>

        $(document).ready(function () {


            //LOAD TOKEN
            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });


        });

    </script>

    <!--
       GeoMap Plugin
    *******************************************************************************************
    -->
    <script src="/js/jquery.geocomplete.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

    <script>
        $(function () {
            $("#geocomplete").geocomplete({
                map: ".map_canvas",
                details: "form",
                types: ["geocode", "establishment"]
            });

            $("#find").click(function () {
                $("#geocomplete").trigger("geocode");
            });
        });

    </script>

    <!-- Date Range picker script -->
    <script type="text/javascript">
        $(function () {
            $('input[name="StartEndTime"]').daterangepicker({
                timePicker: true,
                format: 'YYYY-MM-DD HH:mm',
                timePickerIncrement: 5,
                timePicker12Hour: false,
                use24hours: true,
                timePickerSeconds: false
            });
            //Load MAP
            $("#geocomplete").trigger("geocode");
        });
    </script>

    <!-- ScrollBar Script -->
    <script>

        $('#menuselect').on('click', function (event) {
            alert('hi');
            $(this).parent().find('a').removeClass('active');
            $(this).addClass('active');
        });

    </script>


    <!-- SCRIPTS UTILITIES

    ***************************************************************************************

    -->


    

    <script type="text/javascript">

        $(document).ready(function () {
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#creaform").validationEngine();
            });


            $('input[id="Ticketdate"]').daterangepicker({
                timePicker: true,
                format: 'YYYY-MM-DD HH:mm',
                timePickerIncrement: 1,
                timePicker12Hour: false,
                use24hours: true,
                timePickerSeconds: false
            });


        });
    </script>

    <script>

        // Delete ticket Function
        function deleteticket() {

            var r = confirm('Are you sure to delete ticket !');
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: '/dashboard/event/deleteTicket/' + arguments[1],
                    data: {ticketid: arguments[0]},
                    success: function (data) {
                        console.log(data);
                    }
                }, "html");

                $("#t" + arguments[0]).parent('div').remove();
            }
        }

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



    <!-- Content Header (Page header) -->
    <section class="content-header" style="z-index: 99">
        <h1>
            Edit Event
            <small>make your changes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/dashboard/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Event Page</li>
        </ol>
    </section>
    </br>
    <section class="content-header" id="page-wrap">

        {!! Form::open(['action' => array('EventsController@update',$EventData[0]->EVENTID) , 'method' => 'post',
        'class' => 'form','files'=>true ,'id'=>'creaform',
        'onsubmit'=>"return confirm('Do you really want to update this Event?')"])!!}

        <!-- Create Event Form
        ****************************************************************************************
        !-->

        <div class="box box-primary" id="creaeventpart">
            <div class="box-header">
                <h3 class="box-title">Event Informations :</h3>
            </div>
            <div class="box-body">
                <p> {!!Form::label('eventName', 'Event Title')!!}<br/>
                    <input id="req" class="validate[required,maxSize[20]] form-control maxw" type="text" name="eventName"
                           value="{{$EventData[0]->EVENTNAME}}">
                    {!!$errors->first('eventName','
                <li>:message</li>
                ')!!}
                </p>

                <p> {!!Form::label('eventType', 'Category')!!}<br/>
                    {!!Form::select('eventType', $eventType,['SelectedIndex' => $EventData[0]->EVENTTYPEID ], array('class' => 'maxw'))!!}

                </p>

                <!-- Map input **************************************************-->



                <label>Location : </label><br/>

                <input id="geocomplete" type="text" placeholder="Type in an address" class="form-control maxw"
                       value="{{$EventData[0]->EVENTLOCATION}}" name="eventLocation"/>

                <div class="col-md-4 map_canvas"></div>

                </br>
                <fieldset>
                    <input name="lat" type="text" value="{{$EventData[0]->EVENTLATITUDE}}"
                           style="visibility:hidden;display: none;">
                    <input name="lng" type="text" value="{{$EventData[0]->EVENTLONGITUDE}}"
                           style="visibility:hidden ;display: none;">
                </fieldset>
                <!-- MAP INPUT ENDS -->
                </br>
                </br>
                </br>
                <textarea id="eventDesc" rows="10" cols="50" name="eventDesc"
                          class="form-control">{{$EventData[0]->EVENTDESCRIPTION}}</textarea>

                <label>Event Start-End Date :</label><br/>
                <input type="text"
                       value="{{$EventData[0]->EVENTSTART}} - {{$EventData[0]->EVENTEND}}"
                       name="StartEndTime" class="form-control validate[custom[integer],required] maxw"/>

                </br>
                <label>Private event :</label>
                @if( $EventData[0]->EVENTPRIVACY == 1 )

             <div  align="right">
                    <input id="eventPrivacy" class="flat-red" type="checkbox" checked name="eventPrivacy">
                                     </div>
                @else
                    <input id="eventPrivacy" class="flat-red" type="checkbox" name="eventPrivacy">

                @endif


              <!--  <p>
                    <label>Payed Event : </label>
                    @if( $EventData[0]->EVENTPAID == 1 )

                        <input id="eventPaid" class="flat-red" type="checkbox" value="1" checked name="eventpaid">

                    @else
                        <input id="eventPaid" class="flat-red" type="checkbox" value="1" name="eventpaid">
                    @endif

                </p> -->


            </div>
        </div>




        <!--
         *****  Update Main Image
         !-->




        <label class="control-label">Event Image</label>
        <input id="input-25" type="file"  class="file-loading" name="file">





        

        <!-- Update Media Section 2
       ****************************************************************************************
       !-->


        <label class="control-label">Event Gallery</label>
       <input id="input-707" class="file" type="file" name="files[]" multiple >
       
      
       

        <!-- EDIT EXISTING TICKETS -->
        
         @if ($nbtickets>0)
            
        <div class="box box-success" id="editticketpart">
            <div class="box-header">
                <h3 class="box-title">Edit Tickets :</h3>

                @for ($i = 0; $i < $nbtickets ; $i++)


                    <div class="box-body ticketdata" id="ticketnumber{{$i}}">

                        </br> <h4>Ticket Number {{$i+1}}</h4>


                        </br>
                        <label>Ticket Name</label><br/>
                        <input class="validate[required,,maxSize[20]] form-control maxw" type="text" name="ticketname{{$i}}"
                               value="{{$tickets[$i]->TICKETTYPENAME}}">

                        <br/>
                        <label>Quantity</label><br/>
                        <input class="validate[required,custom[onlyNumberSp],max[99999]] form-control maxw" type="text"
                               name="ticketqte{{$i}}" value="{{$tickets[$i]->TICKETTOTAL}}" disabled>

                        <br/>

                        <label>Price (BHD) :</label><br/>

                        <input class="validate[required,custom[onlyNumberSp],max[99999]] form-control maxw" type="text"
                               name="ticketprice{{$i}}" value="{{$tickets[$i]->TICKETPRICE}}">


                        <br/>

                        <label>Description :</label><br/>

                        <textarea rows="10" cols="50" class="form-control"
                                  name="ticketdesc{{$i}}">{{$tickets[$i]->TICKETTYPEDESCRIPTION}} </textarea>

                        <br/>
                        <label>Ticket Start-End Sales :</label><br/>
                        <input type="text" id="Ticketdate" name="TicketStartEndTime{{$i}}"
                               value="{{$tickets[$i]->TICKETSTARTSALES}} - {{$tickets[$i]->TICKETENDSALES}}"
                               class="form-control validate[custom[integer],required] maxw"/>

                        <br/>
                        <label>Minimum :</label><br/>

                        <input type="number" class="validate[required] form-control maxw" value="{{$tickets[$i]->TICKETMIN}}"
                               name="ticketmin{{$i}}" min="1">


                        <br/>
                        <label>Maximum :</label><br/>

                        <input type="number" class="validate[required] form-control maxw" value="{{$tickets[$i]->TICKETMAX}}"
                               name="ticketmax{{$i}}" min="1">
                        <br/>
                        <br/>

                        <input type="number" name="ticketid{{$i}}" value="{{$tickets[$i]->TICKETTYPEID}}"
                               style="visibility:hidden;">

                        <a style="float:right;" href="#" class="editremoveticket" id="t{{$tickets[$i]->TICKETTYPEID}}"
                           onclick="deleteticket({{$tickets[$i]->TICKETTYPEID}} , {{$tickets[$i]->EVENTID}});"
                           style="display: inline">
                            <i class="fa fa-trash-o fa-2x"></i>
                        </a>

                    </div>

                    <hr>

                @endfor


            </div>
        </div>
@endif


        <div class="box-footer">

        </div>
        <div class="box-footer">
            <div class="input-group">
                <!--<input class="form-control" placeholder="Type message..."/> -->
                <div class="input-group-btn">
                    {!! Form::submit('Update Event',array( 'class'=> 'submit btn btn-primary pull-right')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <input type="number" id="ticketsnumber" name="ticketsnumber" value="{{$nbtickets}}"
                   style="visibility:hidden;">

        </div>

    </section>


@endsection

@section('footer')


    <script type="text/javascript">

        $(document).ready(function () {
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#creaform").validationEngine();
            });
            
             $("[name='eventPrivacy']").bootstrapSwitch();

        });
    </script>


    <script>
            $("#input-25").fileinput({
                showUpload: false,
                showRemove: false,
                maxFileCount: 1,
                initialPreview: [
                " <img src='{{asset('img/event/'.$EventData[0]->EVENTID.'/'.$image['basename'])}}' height='150px'> "
            ],
                overwriteInitial: true,
                initialCaption: "Event Main Image"
            });

    </script>




    <script>
        $("#fileupload").fileinput({
//            uploadUrl: 'event/create', // you must set a valid URL here else you will get an error
            allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif'],
            overwriteInitial: true,
            maxFileSize: 1500,
            maxFilesNum: 10,
            showUpload: false,
            maxFileCount: 5,
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

<script>
    $("#input-707").fileinput({
        uploadUrl: "updateMedia/{{$EventData[0]->EVENTID}}",

        
        uploadAsync: false,
        minFileCount: 0,
        maxFileCount: 5,
        allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif'],
        allowedFileTypes: ['image'],
        overwriteInitial: false,
        initialPreview: [
        
        @foreach($images as $image)
         @if($image['basename'] == $EventData[0]->EVENTIMAGE)

             @else
       "<img src='{{asset('img/event/'.$EventData[0]->EVENTID.'/'.$image['basename'])}}' height='150px' style=' filename : {{$image['filename']}} == {{$EventData[0]->EVENTIMAGE}}' >",
            @endif
    @endforeach

    ],
        initialPreviewConfig: [
        
        @foreach($images as $image)
             @if($image['basename'] == $EventData[0]->EVENTIMAGE)

             @else
       {caption: "Image-{{$image['basename']}}", width: "100px", url:  "deleteMedia/{{$EventData[0]->EVENTID}}/{{$image['filename']}}", key: {{$image['filename']}}},
             @endif
        @endforeach

        ],
        uploadExtraData: {
            img_key: "1000",
            img_keywords: "happy, nature",
        }
    });
    $("#input-707").on("filepredelete", function(jqXHR) {
        var abort = true;
        if (confirm("Are you sure you want to delete this image?")) {
            abort = false;
        }
        console.log("delete");
        return abort;
    });
    

 </script>
 

@endsection

@stop