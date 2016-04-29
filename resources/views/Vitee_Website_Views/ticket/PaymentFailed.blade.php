@extends('Vitee_Website_Views.master')


@section('title')

    <title> Completed Failed </title>

@endsection


@section('page-title')

    {{--
        <div class="container clearfix">
            <h1>{{$event[0]->EVENTNAME}} </h1>
            <span> Event Page - Buy Tickets</span>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li >Event</li>
                <li class="active">Tickets</li>
            </ol>
        </div>
    --}}

@endsection





@section('content')




    <div class="clear"></div>

    <div class="col_full">

        <div class="feature-box fbox-center fbox-plain">
            <div class="fbox-icon">
                <i class="icon-remove"></i>
            </div>
            <h3>Payment Failed. Please Try Again.</h3>
        </div>

        {{--TODO GET EMAIL FROM DATABASE--}}

    </div>


@endsection