@extends('Vitee_Website_Views.index')

<style>
    .login-box-body, .register-box-body {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #ccc !important;
        color: #666;
        margin: 10px;
        padding: 20px;
    }
    .loginBtn {
        background: #ccc none repeat scroll 0 0;
        color: #000;
        float: right;
        padding: 12px;
        text-align: center;
        width: 60%;
    }
    .signUp {
        background: #f47932 none repeat scroll 0 0;
        color: #fff;
        float: left;
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
</style>
@section('content')

    <div class="register-box">
        <div class="register-logo">
            <a href="/welcome"><b> Welcome </b> <br> To <br> <b>Vitee</b></a>
        </div>

        <div class="row">
            <div class="col-md-6"><a href="/user/login" class="loginBtn"> LOG ME IN </a></div>
            <div class="col-md-6"><a href="/user/register" class="signUp">SIGN ME UP</a></div>
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
            <form  method="post" action="{{ url('user/register') }}">
                <fieldset>
                <legend>Register for an account</legend>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <label for="name">USERNAME</label>
                    <input type="text" class="form-control" placeholder=""  name="username" value="{{ old('name') }}" required/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="text" class="form-control" placeholder="Gender"  name="usergender" value="{{ old('usergender') }}" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}

                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="text" class="form-control" placeholder="Date of Birth"  name="dob" value="{{ old('dob') }}" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}

                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="text" class="form-control" placeholder="User Description"  name="userdescription" value="{{ old('userdescription') }}" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}

                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="text" class="form-control" placeholder="User Notify"  name="usernotifykey" value="{{ old('usernotifykey') }}" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}

                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="text" class="form-control" placeholder="Promoter"  name="promoter" value="{{ old('Promoter') }}" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}


                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="text" class="form-control" placeholder="User Name"  name="username" value="{{ old('username') }}" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}

                <div class="form-group has-feedback">
                    <label for="name">EMAIL ADDRESS:</label>
                    <input type="email" class="form-control" placeholder="" name="email" value="{{ old('email') }}" required/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>


                <div class="form-group has-feedback">
                    <label for="name">CHOOSE PASSWORD:</label>
                    <input type="password" class="form-control" placeholder=""  name="password" required/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <label for="name">RE-ENTER PASSWORD:</label>
                    <input type="password" class="form-control" placeholder="" name="password_confirmation" required/>
                    <span class="glyphicon glyphicon-lock  form-control-feedback"></span>
                </div>

                {{--<div class="form-group has-feedback">--}}
                    {{--<input type="file" class="form-control" placeholder="User Image"  name="na" />--}}
                    {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
                {{--</div>--}}

                <div class="row">
                    {{--<div class="col-xs-8">--}}
                        {{--<div class="checkbox icheck">--}}
                            {{--<label>--}}
                                {{--<input type="checkbox"> I agree to the <a href="#">terms</a>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div><!-- /.col -->--}}
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat btn-register">Register</button>
                    </div><!-- /.col -->
                    @if(Session::has('msg'))
                        <div class="alert alert-success">
                            <h2>{{ Session::get('msg') }}</h2>
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <h2>{{ Session::get('success') }}</h2>
                        </div>
                    @endif

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
        });



    </script>

@endsection
