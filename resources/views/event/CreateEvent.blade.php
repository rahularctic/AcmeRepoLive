@extends('app')

@section('assets')

    <!--
<link href="{{asset('css/bootstrap-theme.css') }}" rel="stylesheet" type="text/css">

-->
    <link href="{{asset('/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" type="text/css" href="{{asset('css/validationEngine.jquery.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/fileinput.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/Create_event_org.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-switch.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css"/>


    <!-- NEw Template Css
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="{{asset('dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{{asset('dist/css/skins/_all-skins.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="{{asset('plugins/iCheck/flat/blue.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="{{asset('plugins/morris/morris.css')}}" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Date Picker -->
    <link href="{{asset('plugins/datepicker/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="{{asset('/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/vitee1.css')}}"/>



    <script type="text/javascript" src="{{asset('js/languages/jquery.validationEngine-en.js')}}"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>



    <script type="text/javascript" src="{{asset('js/jquery.validationEngine.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/fileinput.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/fileinput_locale_<lang>.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/moment.min.js') }}"></script>

    <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.js') }}"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-switch.js') }}"></script>
    <!-- ScrollBar Script -->
    <script>

        /*   $('#menuselect').on('click', function(event) {
         $(this).parent().find('a').removeClass('active');
         $(this).addClass('active');
         });*/

        $(window).on('scroll', function () {
            var scrollPos = $(document).scrollTop();
            $('.mylinks').each(function () {
                var currLink = $(this);

                var refElement = $(currLink.attr("href"));
                if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                    $('#menu-center ul li a').removeClass("active");
                    currLink.parent('li').first().addClass("active");
                }
                else {
                    currLink.parent('li').first().removeClass("active");
                }
            });

        });

    </script>

    <!--
       GeoMap Plugin
    *******************************************************************************************
    -->
    <script src="{{asset('js/jquery.geocomplete.js')}}"></script>
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
            $("#geocomplete").trigger("geocode");
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
                <li class="active"><a href="/dashboard/event/create"><i class="fa fa-edit"></i> Create New Event</a></li>
                <li ><a href="/dashboard/events"><i class="fa fa-calendar"></i> Show My Events</a></li>
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


{{-- 
@section('side')

    <aside class="main-sidebar" id="sidebar" style="z-index:99">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <br>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" id="menubar">

                <li class="active">
                    <br>
                </li>
                <li class="active">
                    <a class="mylinks" href="#creaeventpart">
                        <i class="fa fa-edit"></i> <span>Event info</span>
                    </a>
                </li>

                <li class="">
                    <a class="mylinks" href="#uploadmediapart">
                        <i class="fa fa-th"></i> <span>Upload media</span>
                    </a>
                </li>
<!--
                <li class="">
                    <a class="mylinks" href="#createticketpart">
                        <i class="fa fa-book"></i> <span>Add Tickets</span>
                    </a>
                </li>
-->

            </ul>
            </div>
        </section>
    </aside>

@endsection
--}}

@section('content')
    <!--  <h1> Add New Event </h1> -->

    <section class="content-header">
        <h1>
            Create Event
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/dashboard/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Event</li>
        </ol>
    </section>

    <!-- Content  -->
    <section class="content" id="page-wrap">

        {!! Form::open(['url' => 'dashboard/event/create', 'method' => 'post', 'class' => 'form','files'=>true ,'id'=>'creaform',
        'onsubmit'=>"return confirm('Do you really want to Create this Event?')"])!!}

        <!-- Create Event Form
        ****************************************************************************************
        !-->

        <div class="box box-primary" id="creaeventpart">
            <div class="box-header">
                <h3 class="box-title">Event Information :</h3>
            </div>
            <div class="box-body">
                <p> {!!Form::label('eventName', 'Event Title')!!}<br/>
                    <input id="req" class="validate[required,maxSize[100]] form-control maxw" type="text" name="eventName"
                            >
                    {!!$errors->first('eventName','
                <li>:message</li>
                ')!!}
                </p>

                <p> {!!Form::label('eventType', 'Category')!!}<br/>
                    {!!Form::select('eventType', $eventType,  null, array('class' => 'maxw'))!!}

                </p>

                <!-- Map input **************************************************-->

                <label>Location</label><br/>

                <input id="geocomplete" type="text" placeholder="Type in an address" class="form-control maxw"
                       value="Bahrain" name="eventLocation"/>

                <div class="col-md-4 map_canvas"></div>

                </br>
                <fieldset>
                    <input name="lat" type="text" value="26.2336" style="visibility:hidden;display: none;">
                    <input name="lng" type="text" value="50.5538" style="visibility:hidden ;display: none;">
                </fieldset>
                <!-- MAP INPUT ENDS -->
                </br>
                </br>
                </br>                
                 </br>
                 </br>                
                 </br>
                 </br>                
                 </br>
                 </br>               
                 </br>
                 </br>               
                 </br>
                 </br>

            	  <label> Event Description </label><br/>
                <textarea id="eventDesc" rows="10" cols="50" placeholder="Event Description" name="eventDesc"
                          class="form-control"></textarea>
                        </br>  
                        
               

                <label>Event Start-End Date</label><br/>
                <input type="text" name="StartEndTime" class="form-control validate[required,custom[integer]] maxw"/>

                </br>
                
                
  <p><label><font size="4">Private event</font></label>             
<div align= "right" >

                <input   id="eventPrivacy" class="flat-red" type="checkbox" value="1" name="eventPrivacy">
               </div>
                </p>
<!--
                <p>
                    <label><font size="4">Paid Event </font></label>
                    <div  align="right">
                    <input id="eventPaid" class="flat-red" type="checkbox" value="1" name="eventpaid">
                    </div>
                </p>
-->

            </div>
        </div>


        <!-- Create Media Section
       ****************************************************************************************
       !-->
        <div class="box box-danger" id="uploadmediapart">
            <div class="box-header">
                <h3 class="box-title">Upload Media :</h3>
            </div>
            <div class="box-body">


                <div class="about-section">
                    <div class="text-content">
                        <div class="span7 offset1">
                            @if(Session::has('success'))
                                <div class="alert-box success">
                                    <h2>{!! Session::get('success') !!}</h2>
                                </div>
                            @endif
                            <div class="secure"></div>
                            <div class="control-group">
                                <div class="controls">


                                    <div class="form-group">
                                        <input id="fileupload" class="file" type="file" name="files[]" multiple
                                               >
                                    </div>

                                    <p class="errors">{!!$errors->first('image')!!}</p>
                                    @if(Session::has('error'))
                                        <p class="errors">{!! Session::get('error') !!}</p>
                                    @endif
                                </div>
                            </div>
                            <div id="success"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Create Ticket Form
        ****************************************************************************************
        !-->


        <div class="box box-success" id="createticketpart">
            <div class="box-header">
                <h3 class="box-title">Ticket Details :</h3>

                <a alt="" aria-expanded="false" href="#">

                    <i class="fa fa-plus-square fa-2x" onclick="Ticket_append();" style="float: right;"></i>
                </a>


                <div class="ticketcontent">

                </div>
            </div>
        </div>


        <div class="box-footer">

        </div>
        <div class="box-footer">
            <div class="input-group">
                <!--<input class="form-control" placeholder="Type message..."/> -->
                <div class="input-group-btn">
                    {!! Form::submit('Publish Event',array( 'class'=> 'submit btn btn-primary pull-right')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <input type="number" id="ticketsnumber" name="ticketsnumber" value="0" style="visibility:hidden;">

        </div>

    </section>
    <!-- SCRIPTS UTILITIES

    ***************************************************************************************

    -->


    <script type="text/javascript">

        $(document).ready(function () {
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#creaform").validationEngine();
            });

        });
    </script>


    <!--    Add Ticket Script !!!!!

    ****************************************************************************-->
    <script>
        var idticket = 0;
        //  var iddate = 2;
        function Ticket_append() {
            idticket++;
            //iddate++;
            $("#ticketsnumber").attr("value", idticket);
            var sourcetxt = $("#ticketinterface").html();
            var sourcecollapsebtn = $("#collapsebtn").html();

            sourcetxt = sourcetxt.replace("ticketnumber", "ticketnumber" + idticket);
            sourcetxt = sourcetxt.replace("ticketname", "ticketname" + idticket);
            sourcetxt = sourcetxt.replace("ticketqte", "ticketqte" + idticket);
            sourcetxt = sourcetxt.replace("ticketdesc", "ticketdesc" + idticket);
            sourcetxt = sourcetxt.replace("ticketprice", "ticketprice" + idticket);
            sourcetxt = sourcetxt.replace("TicketStartEndTime", "TicketStartEndTime" + idticket);

            sourcetxt = sourcetxt.replace("ticketstartsales", "ticketstartsales" + idticket);
            sourcetxt = sourcetxt.replace("ticketendsales", "ticketendsales" + idticket);
            sourcetxt = sourcetxt.replace("ticketmin", "ticketmin" + idticket);
            sourcetxt = sourcetxt.replace("ticketmax", "ticketmax" + idticket);
            sourcetxt = sourcetxt.replace("ticketnumberhref", "#ticketnumber" + idticket);

            //sourcecollapsebtn2 = sourcecollapsebtn2.replace("ticketnumber", "#ticketnumber" + idticket);
            // sourcetxt = sourcetxt.replace("showticket", "showticket" + idticket);

            sourcetxt = sourcetxt.replace("id0", idticket);

            sourcecollapsebtn = sourcecollapsebtn.replace("ticketnumber", "#ticketnumber" + idticket);
            sourcecollapsebtn = sourcecollapsebtn.replace("showticket", "showticket" + idticket);

            $(".ticketcontent").append("<h5 id=" + idticket + ">Ticket Number " + idticket + " :</h5>");
            $(".ticketcontent").append(sourcecollapsebtn);
            $(".ticketcontent").append(sourcetxt);
            // $(".ticketcontent").after(sourcecollapsebtn2);

            //DatePickers

            $('input[id="Ticketdate"]').daterangepicker({
                timePicker: true,
                format: 'YYYY-MM-DD HH:mm',
                timePickerIncrement: 5,
                timePicker12Hour: false,
                use24hours: true,
                timePickerSeconds: false
            });


        }

        $(document).on("click", "a.remove", function () {


            var r = confirm('Are you sure to delete ticket !');
            if (r == true) {

                var $getid = $(this).attr('id');

                $("#" + $getid).remove();

                $(this).parent('div').parent('div').children("#showticket" + $getid).remove();

                $(this).closest('.box-body').remove();

            }

        });


    </script>

    <!-- interface Ticket Sample
    ****************************************************************
    -->
    <div id="ticketinterface" style="visibility:hidden ; display:none">
        <div class="box-body collapse ticketdata" id="ticketnumber">
            <!-- <h2>Ticket Number </h2> -->

            <a class="remove " id="id0" href="javascript:void(0);" style="display: inline">
                <i class="fa fa-trash-o fa-2x"></i>
            </a>
            </br>
            <label>Ticket Name</label><br/>
            <input class="validate[required,,maxSize[20]] form-control maxw" type="text" name="ticketname" value="">

            <br/>
            <label>Quantity</label><br/>
            <input class="validate[required,custom[onlyNumberSp],max[99999]] form-control maxw" type="text"
                   name="ticketqte"
                   value="">

            <br/>

            <label>Price (BHD) </label><br/>

            <input class="validate[required,custom[onlyNumberSp],max[99999]] form-control maxw" type="text"
                   name="ticketprice" value="">


            <br/>

            <label>Ticket Description </label><br/>

            <textarea rows="10" cols="50" class="form-control" name="ticketdesc"></textarea>

            <br/>

            <label>Ticket Start-End Sales </label><br/>
            <input type="text" id="Ticketdate" name="TicketStartEndTime" class="form-control validate[custom[integer],required] maxw"/>

            <br/>
            <label>Minimum </label><br/>

            <input type="number" class="validate[required] form-control maxw" name="ticketmin" min="1">


            <br/>
            <label>Maximum </label><br/>

            <input type="number" class="validate[required] form-control maxw" name="ticketmax" min="1">
            <br/>
            <br/>
            <a aria-expanded="false" data-toggle="collapse" alt="" href="ticketnumberhref" id="showticket">
                <i class="fa fa-hand-o-up"></i>
            </a>

        </div>
    </div>


    <!--     Button Collapse simple -->
    <div id="collapsebtn" style="visibility:hidden ; display:none">
        <a aria-expanded="false" data-toggle="collapse" alt="" href="ticketnumber" id="showticket">
            <i class="fa fa-hand-o-down"></i>
        </a>

    </div>
    <!--     Button Collapse simple2 -->
    <div id="collapsebtn2" style="visibility:hidden ; display:none">


    </div>

    <div id="updatecontent">


    </div>



@endsection

@section('footer')


    <script>
        $("#fileupload").fileinput({
//            uploadUrl: 'event/create', // you must set a valid URL here else you will get an error
            allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif'],
            overwriteInitial: true,
            maxFileSize: 4500,
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




    <!-- For Scroll Link Animation -->
    <script>

        $(document).ready(function () {
            $('a[href^="#"]').on('click', function (e) {
                e.preventDefault();

                var target = this.hash;
                var $target = $(target);

                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top
                }, 900, 'swing', function () {
                    window.location.hash = target;
                });
            });
            // Hide Show Ticket Form
          var ischecked= $(this).is(':checked');

            if(ischecked)
            {
                $("#createticketpart").show();
            }
            if(!ischecked)
            {
                $("#createticketpart").hide();
            }
              /*  $("#eventPaid").change(function() {
                    var ischecked= $(this).is(':checked');

                    if(ischecked)
                    {
                        $("#createticketpart").show();
                    }
                    if(!ischecked)
                    {
                        $("#createticketpart").hide();
                    }
                });*/
                
                // CheckboxStyle
                
                 $("[name='eventPrivacy']").bootstrapSwitch();
               $("[name='eventpaid']").bootstrapSwitch();
               
                $('input[name="eventpaid"]').on('switchChange.bootstrapSwitch', function(event, state) {
               if (state==true)
               {
              $("#createticketpart").show();
               }
               else 
               {
                  $("#createticketpart").hide();
               }
 
                 });
                
               
        
        
        });

    </script>

    <script>
        $("#body").attr("class", "skin-blue  layout-boxed");
    </script>

@endsection