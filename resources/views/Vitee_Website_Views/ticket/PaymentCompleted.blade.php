@extends('Vitee_Website_Views.master')


@section('title')

    <title> Completed Payment </title>

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

    <div class="col_one_third">

        <div class="feature-box fbox-center fbox-plain">
            <div class="fbox-icon">
                <i class="icon-ok"></i>
            </div>
            <h3>Payment Completed Successfully</h3>
            <p> Thank You For Choosing Vitee </p>
            <p> Tickets has been sent to your email, "user@domain.com"</p>
        </div>

{{--TODO GET EMAIL FROM DATABASE--}}

     </div>

    <div class="col_one_third">
        <br>

       <h4>  Transaction Summary  </h4>



        <table class="table table-hover">

            <thead>
            <tr>
                <th></th>
                <th>  </th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <td> Event Name : {{$transactionSummary['EventName']}} </td>
                <td> </td>
            </tr>
            <tr>
                <td>Transaction ID :</td>
                <td> </td>
            </tr>
            <tr>
                <td> Number of Tickets : </td>
                <td> </td>
            </tr>
            <tr>
                <td> Total Amount : </td>
                <td> </td>
            </tr>

            </tbody>
        </table>

    </div>





    <div class="col_one_third col_last">
        <br>
        <div class="col_one_third col_last nobottommargin">
            <address>
                <strong>For Support Contact </strong><br><br>
                Vitee W.L.L<br>
                2nd Floor, Batelco Building<br>
                Bab Al Bahrain<br>
                Manama, Kingdom of Bahrain
            </address>
            <abbr title="Phone Number"><strong>Phone:</strong></abbr>  (973) 36651772 <br>
            <abbr title="Email Address"><strong>Email:</strong></abbr> contact@vitee.net
        </div>

    </div>






 @endsection