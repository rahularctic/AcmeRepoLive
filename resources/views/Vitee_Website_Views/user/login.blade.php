@extends('Vitee_Website_Views.index')

<style>
    .login-box-body, .register-box-body {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #ccc !important;
        color: #666;
        margin: 10px;
        padding: 20px;
    }
    .btnInactive {
        background: #ccc none repeat scroll 0 0;
        color: #000;
        float: left;
        padding: 12px;
        text-align: center;
        width: 60%;
    }
    .btnActive {
        background: #f47932 none repeat scroll 0 0;
        color: #fff;
        float: right;
        padding: 12px;
        text-align: center;
        width: 60%;
    }
    .btn-register
    {
        background: #000 none repeat scroll 0 0 !important;
    }
    .login-box-body, .register-box-body {
        min-height: 550px;
    }
    a:hover, a:active, a:focus {
        color: #000 !important;
    }
</style>
@section('content')

    <div class="register-box">
        <div class="register-logo">
            <a href="/welcome"><b> Welcome </b> <br> To <br> <b>Vitee</b></a>
        </div>

        <div class="row">
            <div class="col-md-6"><a href="/user/login" class="btnActive"> LOG ME IN </a></div>
            <div class="col-md-6"><a href="/user/register" class="btnInactive">SIGN ME UP</a></div>
        </div>

        <div class="register-box-body">

            {{--@if (count($errors) > 0)--}}
            {{--<div class="alert alert-danger">--}}
            {{--<strong>Whoops!</strong> There were some problems with your input.<br><br>--}}
            {{--<ul>--}}
            {{--@foreach ($errors->all() as $error)--}}
            {{--<li>{{ $error }}</li>--}}
            {{--@endforeach--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--@endif--}}

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form  method="post" action="{{ url('user/loginCheck') }}">
                <fieldset>
                    <legend>Login to your account</legend>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <label for="name">EMAIL</label>
                        <input type="text" class="form-control" placeholder="" id="email" name="email" value="{{ old('name') }}" required/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="name">PASSWORD:</label>
                        <input type="password" class="form-control" placeholder="" id="password"  name="password" required/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>


                    <div class="row">

                        <div class="col-xs-5">
                            <button id="processLogin" type="submit" class="btn btn-primary btn-block btn-flat btn-register">Login</button>
                        </div><!-- /.col -->

                        <div class="col-xs-5 pull-right">
                            <a href="{{URL::to('ForgetPassword')}}" class="">Forgot Password ?</a>
                        </div><!-- /.col -->


                        @if(isset($status))
                            @if($status == "0")
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                </div>
                            @elseif($status == "1")
                                <div class="alert success">
                                    <strong>Registration Sucessfull.<br><br>
                                </div>
                            @endif
                        @endif
                    </div>
                </fieldset>
            </form>
            <hr/>

            <div class="social-auth-links text-center">
                <p>- OR Login With: -</p>
                <div class="col-md-6">
                    <a href="/auth/facebook" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Facebook</a>
                </div>

                <div class="col-md-6">
                    <a href="/auth/google" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Google+</a>
                </div>
            </div>
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->
@endsection

@section('assets-footer')


    <script>

        $(document).ready(function(){

            if (!$('#primary-menu').hasClass("current")) {
                $("li.current").removeClass("current");
                $('#primary-menu').find('li.profile').addClass("current");
            }

            $("#processLogin").on('click',(function(e) {

                e.preventDefault();

                var email = $('#email').val();

                var password=$('#password').val();

                $.ajax({
                    url: '{{URL::to('user/loginCheck')}}',
                    type: 'post',
                    data: {'email': email,
                        'password': password,},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    },
                    success: function (response)
                    {

                        if(response.result=='1') {
                            swal({
                                title: "Success",
                                text: "Welcome to VITEE !!!",
                                type: "success",
                                confirmButtonText: "OK"
                            });
                            window.location = "/myTickets";
                        }
                        else if(response.result=='2') {
                            swal({
                                title: "Error!",
                                text: "Use Does not Exist.",
                                type: "error",
                                confirmButtonText: "OK"
                            });
                        }
                        else if(response.result=='3') {
                            swal({
                                title: "Error!",
                                text: "Incorrect Login Details",
                                type: "error",
                                confirmButtonText: "OK"
                            });
                        }
                        else if(response.result=='4') {
                            swal({
                                title: "Error!",
                                text: "Please Verify your Account",
                                type: "error",
                                confirmButtonText: "OK"
                            });
                        }
                        else{
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
                        } else if(jqXHR.status == 422) {

                            alert(jqXHR.responseText);

                            $(jqXHR.responseText).each(function(index){
                                    alert(index);

                            });

                        }
                        else{
                            alert('Unexpected error.' + errorThrown);
                        }
                    }
                });



            }));
        });



    </script>

@endsection
