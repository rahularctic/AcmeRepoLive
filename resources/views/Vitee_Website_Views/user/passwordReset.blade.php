@extends('Vitee_Website_Views.index')
@section('content')
    <div class="container">

        <div class="panel  col-sm-5 col-sm-offset-3">
        <div class="statusmsg"></div>
        <script type='text/javascript'>showMe();</script>

        <div class="panel panel-default" id="showhide">
        <div class="panel-heading"><b>Reset Password </b></div>
        <div class="panel-body">

            <form class="form-horizontal" role="form" method="POST" action="{{URL::to('passwordResetVerify')}}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                <div class="form-group">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                        <span class="error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="passwordV">
                        <span class="error"></span>
                    </div>
                </div>

                <input type="hidden" name="email" value="{{Session::get('email')}}">
                <input type="hidden" name="token" value="{{Session::get('token')}}">

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </div>
                </div>
                @if(Session::has('status'))
                    <div class="alert alert-success">
                        <h2>{{ Session::get('status') }}</h2>
                    </div>
                @endif
            </form>
        </div>
        </div>
        </div>
</div>

@endsection