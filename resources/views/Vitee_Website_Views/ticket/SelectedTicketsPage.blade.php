@extends('Vitee_Website_Views.master')


@section('title')

    <title> {{$event[0]->EVENTNAME}} - Buy Tickets </title>

@endsection


@section('page-title')

    <div class="container clearfix">
        <h1>{{$event[0]->EVENTNAME}} </h1>
        <span> Event Page - Buy Tickets</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li >Event</li>
            <li class="active">Tickets</li>
        </ol>
    </div>

@endsection


@section('content')

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="table-responsive bottommargin">

                <table class="table cart">
                    <thead>
                    <tr>
                        <th class="cart-product-remove">&nbsp;</th>
                        <th class="cart-product-thumbnail">Event</th>
                        <th class="cart-product-name">Ticket</th>
                        <th class="cart-product-price">Unit Price</th>
                        <th class="cart-product-quantity">Quantity</th>
                        <th class="cart-product-subtotal">Total</th>
                    </tr>
                    </thead>
                    <tbody>



                    {!! Form::open(['url' => '/event/'.$event[0]->EVENTID.'/tickets/purchase', 'method' => 'post', 'class' => 'nobottommargin','id'=>'billing-form'])!!}

                    @foreach($tickets as $ticket)

                        <tr class="cart_item" id="{{$ticket->id}}">
                            <td class="cart-product-remove">
                                <a href="#" class="remove" title="Remove this item"><i class="icon-trash2"></i></a>
                            </td>

                            <td class="cart-product-thumbnail">
                                {{$event[0]->EVENTNAME}}
                                <a href="#"><img width="64" height="64" src="{{asset('img/event/'.$event[0]->EVENTID.'/1.jpeg')}}" alt="{{$event[0]->EVENTNAME}}"></a>
                            </td>

                            <td class="cart-product-name">
                                <a href="#">{{$ticket->TICKETTYPENAME}}</a>
                            </td>

                            <td class="cart-product-price">
                                <span class="amount">{{$ticket->TICKETPRICE}}</span> <strong>BD</strong>
                            </td>

                            <td class="cart-product-quantity">
                                <div class="quantity clearfix">

                                    <select class="select-quantity" name="{{$ticket->TICKETTYPEID}}" class="sm-form-control" >
                                        <option value="0" selected="selected">-- Select Quantity --</option>

                                        @for ($i = $ticket->TICKETMIN; $i <= $ticket->TICKETMAX; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor

                                    </select>
                                </div>
                            </td>

                            <td class="cart-product-subtotal">
                                <strong>BD</strong> <span class="amount" >0</span>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>

            </div>

            <div class="row clearfix">
                <div class="col-md-6 clearfix">


                    <h3>Billing Information</h3>

                    <div class="form-process"></div>


                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col_half">
                        <label for="billing-form-name">First Name:</label>
                        <input type="text"  name="first_name" value="" minlength="3" class="sm-form-control" required/>
                    </div>

                    <div class="col_half col_last">
                        <label for="billing-form-lname">Last Name:</label>
                        <input type="text" id="billing-form-lname" name="last_name" value="" minlength="3" class="sm-form-control" required />
                    </div>

                    <div class="clear"></div>

                    <div class="col_full">
                        <label for="billing-form-address">Address:</label>
                        <input type="text" id="billing-form-address" name="adress" minlength="10" value="" class="sm-form-control" required />
                    </div>

                    <div class="col_half">
                        <label for="billing-form-name">City / Town:</label>
                        <input type="text" id="billing-form-name" name="city" value="" minlength="3"  class="sm-form-control" required />
                    </div>

                    <div class="col_half col_last">
                        <label for="billing-form-lname">Postal Code: </label>
                        <input type="number" id="billing-form-lname" name="postal_code" value="" class="sm-form-control" required />
                    </div>

                    <div class="col_half">
                        <label for="billing-form-email">Email Address:</label>
                        <input type="email" name="email" value="" class="sm-form-control" required />
                    </div>



                    <div class="col_half col_last">
                        <label for="billing-form-phone">Phone:</label>
                        <input type="text" value="+973"  maxlength="4" disabled />
                        <input type="number" id="billing-form-phone" name="phone_number" value="" minlength="8" class="sm-form-control" required/>
                    </div>

                    {!! Form::submit('Procced To Checkout',array( 'class'=> 'button button-3d notopmargin fright disabled' , 'id' => 'checkout-button' ,' disabled', 'style' => 'background-color : grey')  ) !!}
                    {!! Form::close() !!}

                </div>



                <script type="text/javascript">

                    console.log ($("#billing-form"));

                </script>

                <div class="col-md-6 clearfix">

                    <div class="table-responsive">
                        <h4>Tickets Totals</h4>

                        <table class="table cart">
                            <tbody>

                            <tr class="cart_item">
                                <td class="cart-product-name">
                                    <strong>Total</strong>
                                </td>

                                <td class="cart-product-name">
                                    <span class="amount color lead"> <strong>BD <span id="totalPrice"> 0 </span></strong></span>
                                </td>
                            </tr>

                            </tbody>

                        </table>

                    </div>


                    <div class="accordion clearfix">
                        <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>PayTabs</div>
                        <div class="acc_content clearfix">Secure Online Paymet Gateway for The middle east . </div>


                    </div>
                </div>
            </div>


            <div class="row clearfix">

                <div class="col-md-6 clearfix">



                </div>

                <div class="col-md-6 clearfix">

                </div>

            </div>


        </div>

    </div>


    <script>


        $(document).ready(function() {


            $('.select-quantity').val('0').trigger('chosen:updated');

        });

        $('.select-quantity').on('focus', function () {
            // Store the current value on focus and on change

        }).change(function(){

            var  id = $(this).closest('tr.cart_item').attr('id');
            var unitPrice = $(this).closest('tr').find('td.cart-product-price span.amount').text();

            $(this).closest('tr').find('td.cart-product-subtotal span.amount').text(this.value*unitPrice);

            totalPrice = 0;

            $("td.cart-product-subtotal").each(function() {

                totalPrice += Number($(this).find('span.amount').text());

            });

            $('#totalPrice').text(totalPrice);

            if(totalPrice != 0){

                console.log('price > 0');

                $('#checkout-button').attr('style','background-color : #F47932');
                $('#checkout-button').removeAttr("disabled");

                // console.log($('#checkout-button').attr('style'));

            }else{

            }


        });

    </script>


@endsection
