@extends('Vitee_Website_Views.index')


@section('content')

    <br>

    @if (Session::has('error'))
        {{ trans(Session::get('reason')) }}
    @elseif (Session::has('success'))
        An email with the password reset has been sent.
    @endif

    <div class="panel  col-sm-4 col-sm-offset-4">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Forget Password ? </b></h3>
        </div>
        <div class="panel-body">
            {!! Form::open(array('route' => array('ForgetpasswordReset')))!!}
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <p>
                <label>Please enter your Registered Email ID.</label>
                {!! Form::email('email', '',['class' => 'form-control','placeholder'=>'Enter Email']) !!}</p>

            <p>{!! Form::submit('Submit',['class' => 'form-control btn btn-primary']) !!}</p>

            {!! Form::close() !!}
        </div>

    </div>





@endsection