@extends('Vitee_Website_Views.master')


@section('title')

    <title> {{$event[0]->EVENTNAME}} - Buy Tickets </title>

@endsection


@section('assets')

    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/jquery.seat-charts.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('Vitee_Website_Assets/css/seats-style.css')}}" type="text/css" />

    <script src="{{asset('Vitee_Website_Assets/js/steats-js.js')}}"></script>
    <script src="{{asset('Vitee_Website_Assets/js/jquery.seat-charts.js')}}"></script>


@endsection


@section('page-title')

    <div class="container clearfix">
        <h1>{{$event[0]->EVENTNAME}} </h1>
        <span> Event Page - Select Seats Tickets</span>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li >Event</li>
            <li class="active">Tickets</li>
        </ol>
    </div>

@endsection




@section('nav-bar')



    <ul>
        <li><a href="{{URL('/')}}"><div>Home</div></a>

        </li>
        <li class="current"><a href="#"><div>Events</div></a>

            <ul>
                <li><a href="#"><div>Popular Events</div></a></li>
                <li><a href="#"><div>Latest Events</div></a></li>
                <li><a href="#"><div>Featured Events</div></a></li>
            </ul>

        </li>
        <li class="mega-menu"><a href="{{URL('/about')}}"><div>About</div></a></li>
        <li class="mega-menu"><a href="{{URL('/blog')}}"><div>Blog</div></a></li>
        <li class="mega-menu"><a href="{{URL('/contact')}}"><div>Contact us</div></a>

        </li>

    </ul>


    <!-- Top Search
    ============================================= -->
    <div id="top-search">
        <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
        <form action="search.html" method="get">
            <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
        </form>
    </div><!-- #top-search end -->


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
                            <a href="#"><img width="64" height="64" src="{{asset('img/event/'.$event[0]->EVENTID.'/1.jpeg')}}" alt="Pink Printed Dress"></a>
                        </td>

                        <td class="cart-product-name">
                            <a href="#">{{$ticket->TICKETTYPENAME}}</a>
                        </td>

                        <td class="cart-product-price">
                            <span class="amount">{{$ticket->TICKETPRICE}}</span> <strong>BD</strong>
                        </td>

                        <td class="cart-product-quantity">
                            <div class="quantity clearfix">

                                <select class="select-quantity" name="{{$ticket->TICKETTYPEID}}" class="sm-form-control">
                                    <option value="0">-- Select Quantity --</option>

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

            {{-- SEATED EVENT SCRIPT }--}}

            <script>
                var firstSeatLabel = 1;

                $(document).ready(function() {
                    var $cart = $('#selected-seats'),
                            $counter = $('#counter'),
                            $total = $('#total'),
                            sc = $('#seat-map').seatCharts({
                                map: [
                                    'ff_ff',
                                    'ff_ff',
                                    'ee_ee',
                                    'ee_ee',
                                    'ee___',
                                    'ee_ee',
                                    'ee_ee',
                                    'ee_ee',
                                    'eeeee',
                                ],
                                seats: {
                                    f: {
                                        price   : 100,
                                        classes : 'first-class', //your custom CSS class
                                        category: 'First Class'
                                    },
                                    e: {
                                        price   : 40,
                                        classes : 'economy-class', //your custom CSS class
                                        category: 'Economy Class'
                                    }

                                },
                                naming : {
                                    top : false,
                                    getLabel : function (character, row, column) {
                                        return firstSeatLabel++;
                                    },
                                },
                                legend : {
                                    node : $('#legend'),
                                    items : [
                                        [ 'f', 'available',   'First Class' ],
                                        [ 'e', 'available',   'Economy Class'],
                                        [ 'f', 'unavailable', 'Already Booked']
                                    ]
                                },
                                click: function () {
                                    if (this.status() == 'available') {
                                        //let's create a new <li> which we'll add to the cart items
                                        $('<li>'+this.data().category+' Seat # '+this.settings.label+': <b>$'+this.data().price+'</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
                                                .attr('id', 'cart-item-'+this.settings.id)
                                                .data('seatId', this.settings.id)
                                                .appendTo($cart);

                                        /*
                                         * Lets update the counter and total
                                         *
                                         * .find function will not find the current seat, because it will change its stauts only after return
                                         * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
                                         */
                                        $counter.text(sc.find('selected').length+1);
                                        $total.text(recalculateTotal(sc)+this.data().price);

                                        return 'selected';
                                    } else if (this.status() == 'selected') {
                                        //update the counter
                                        $counter.text(sc.find('selected').length-1);
                                        //and total
                                        $total.text(recalculateTotal(sc)-this.data().price);

                                        //remove the item from our cart
                                        $('#cart-item-'+this.settings.id).remove();

                                        //seat has been vacated
                                        return 'available';
                                    } else if (this.status() == 'unavailable') {
                                        //seat has been already booked
                                        return 'unavailable';
                                    } else {
                                        return this.style();
                                    }
                                }
                            });

                    //this will handle "[cancel]" link clicks
                    $('#selected-seats').on('click', '.cancel-cart-item', function () {
                        //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
                        sc.get($(this).parents('li:first').data('seatId')).click();
                    });

                    //let's pretend some seats have already been booked
                    sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');

                });

                function recalculateTotal(sc) {
                    var total = 0;

                    //basically find every selected seat and sum its price
                    sc.find('selected').each(function () {
                        total += this.data().price;
                    });

                    return total;
                }

            </script>





            <div class="row clearfix">
                <div class="col-md-6 clearfix">


                    <h3>Billing Address</h3>


                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="col_half">
                            <label for="billing-form-name">First Name:</label>
                            <input type="text" id="billing-form-name" name="first_name" value="" class="sm-form-control" />
                        </div>

                        <div class="col_half col_last">
                            <label for="billing-form-lname">Last Name:</label>
                            <input type="text" id="billing-form-lname" name="last_name" value="" class="sm-form-control" />
                        </div>

                        <div class="clear"></div>

                        <div class="col_full">
                            <label for="billing-form-address">Address:</label>
                            <input type="text" id="billing-form-address" name="adress" value="" class="sm-form-control" />
                        </div>

                        <div class="col_half">
                            <label for="billing-form-name">City / Town:</label>
                            <input type="text" id="billing-form-name" name="city" value="" class="sm-form-control" />
                        </div>

                        <div class="col_half col_last">
                            <label for="billing-form-lname">Postal Code: </label>
                            <input type="text" id="billing-form-lname" name="postal_code" value="" class="sm-form-control" />
                        </div>

                        <div class="col_half">
                            <label for="billing-form-email">Email Address:</label>
                            <input type="email" id="billing-form-email" name="email" value="" class="sm-form-control" />
                        </div>

                        <div class="col_half col_last">
                            <label for="billing-form-phone">Phone:</label>
                            <input type="text" value="+973"  maxlength="4" disabled />
                            <input type="text" id="billing-form-phone" name="phone_number" value="" class="sm-form-control" />
                        </div>

                    {!! Form::submit('Procced To Checkout',array( 'class'=> 'button button-3d notopmargin fright')) !!}
                    {!! Form::close() !!}

                </div>

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
                        <div class="acc_content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

                      {{--  <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Cheque Payment</div>
                        <div class="acc_content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>

                        <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Paypal</div>
                        <div class="acc_content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>
                   --}}
                    </div>
                </div>
            </div>


            <div class="row clearfix">

                <div class="col-md-6 clearfix">


    <div class="seatCharts-container" id="seat-map">

        <div class="front-indicator">Front</div>

    </div>


                </div>

                <div class="col-md-6 clearfix">

                </div>

            </div>




        </div>



    </div>


    <script>



        var totalPrice;

        $(document).ready(function() {

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

            // console.log("Total price :"+totalPrice);

        });

    </script>



@endsection