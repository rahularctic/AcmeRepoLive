@extends('Vitee_Website_Views.index')
@section('content')
    <div class="page-title">
        <h2><span class="fa fa-pencil col-sm-offset-5"></span> Edit Profile</h2>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-8 col-xs-7 col-sm-offset-3">

            <form  id="uploadimage" method="post"  class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{--<h3><span class="fa fa-pencil"></span> Profile</h3>--}}
                        {{--<p>This information lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer faucibus, est quis molestie tincidunt, elit arcu faucibus erat.</p>--}}
                    </div>
                    <div class="panel-body form-group-separated">

                        <div class="form-group">
                            <input type="hidden"  name="USERID" id="USERID" value="{{$userDetails->USERID}}" class="form-control"/>
                            <label class="col-md-3 col-xs-5 control-label">User Name</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="text"  name="USERNAME" id="USERNAME" value="{{$userDetails->USERNAME}}" class="form-control" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">User Gender</label>
                            <div class="col-md-9 col-xs-7">
							@if($userDetails->USERGENDER == "male")                                
								<input type="radio" name="USERGENDER" value="male"  checked required> Male<br>
								<input type="radio" name="USERGENDER" value="female" required> Female<br>
								@elseif($userDetails->USERGENDER == "female") 
								<input type="radio" name="USERGENDER" value="male" required> Male<br>
								<input type="radio" name="USERGENDER" value="female" checked required> Female<br>	
								@else
								<input type="radio" name="USERGENDER" value="male" required> Male<br>
								<input type="radio" name="USERGENDER" value="female" required> Female<br>		
								@endif		 						
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Date of Birth</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="date" name="DOB" id='DOB' value="{{$userDetails->DOB}}" class="form-control" required/>
                            </div>
                        </div>
<div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Password</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="password" name="password" id='password' value ="" class="form-control" />
                            </div>
                        </div>
<div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Conform Password</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="password" name="conformPassword" id="conformPassword" value="" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Profile Image</label>
                            <div class="col-md-9 col-xs-7">
                                <input type="file" name="userImage" id="userImage" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">User Description</label>
                            <div class="col-md-9 col-xs-7">
                                <textarea class="form-control" id='USERDESCRIPTION'name="USERDESCRIPTION" rows="5">{{$userDetails->USERDESCRIPTION}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                <button id="submit"  type="submit" class="btn btn-primary btn-rounded pull-right">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scriptContent')

    <script>

        $('#DOB').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "yyyy-mm-dd"
        });

        $("#uploadimage").on('submit',(function(e) {
            e.preventDefault();

            var USERID=$('#USERID').val();
            var USERNAME=$('#USERNAME').val();
            var USERGENDER=$('#USERGENDER').val();
            var DOB=$('#DOB').val();
            var password=$('#password').val();
            var conformPassword=$('#conformPassword').val();
            var userImage=$('#userImage').val();
//alert(userImage);
            var USERDESCRIPTION=$('#USERDESCRIPTION').val();

            $.ajax({
                url: '{{URL::to('updateUserDetails')}}',
                type: 'post',
                data: new FormData(this),
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                },
                contentType: false,
                cache: false,
                processData:false,
                success: function (response)
                {

                    if(response.result=='update') {
                        swal({
                            title: "Success",
                            text: "Your Details have been updated.",
                            type: "success",
                            confirmButtonText: "OK"
                        });
                    }else{
                        swal({
                            title: "Error!",
                            text: response.result,
                            type: "error",
                            confirmButtonText: "OK"
                        });
                    }

                },

                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 500) {
                        alert('Internal error: ' + jqXHR.responseText);
                    } else {
                        alert('Unexpected error.' + errorThrown);
                    }
                }
            });



        }));
    </script>
@endsection

@section('assets-footer')
    <script>
        $(document).ready(function(){

            if (!$('#primary-menu').hasClass("current")) {
                $("li.current").removeClass("current");
                $('#primary-menu').find('li.profile').addClass("current");
            }
        });
    </script>
@endsection
