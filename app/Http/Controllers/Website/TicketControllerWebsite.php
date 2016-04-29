<?php namespace App\Http\Controllers\Website;

/**
 * Created by PhpStorm.
 * User: SAM-PC
 * Date: 8/24/2015
 * Time: 2:59 PM
 */

use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model;

use Carbon\Carbon;
//use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use Validator;
use Redirect;
use Session;
use DB;

use Response;
use Input;
use App\Vit_eventtype;
use App\User;

use App\Http\Requests\RequestVal;
use App\Vit_tickettype;
use App\TicketTransaction;
use Request;

use  App\Http\Controllers\Website\PayTabs\PayTabs;


class TicketControllerWebsite extends Controller
{


    public function __construct()
    {

        // $this->middleware('auth');

    }

    public function show($id){


    }

    public function hello(){


        $paytabs = new PayTabs();

        return $paytabs->validatePaytabs();

    }


    /**
     * @return array|int|string
     */
    public  function test($id)
    {
        $selectedTickets = [];

        $paytabs = new PayTabs();

        $userId = session('userId');//$request->userId;


//        $firstName = Input::get('first_name');
//
//        $lastName = Input::get('last_name');
//
//        $adress = Input::get('adress');
//
//        $city = Input::get('city');
//
//        $postal_code = Input::get('postal_code');
//
//        $email = Input::get('email');
//
//        $phone_number = Input::get('phone_number');
//
//        $clientIp =  Request::ip();




        //GET ALL TICKETS
        $ticketsType = Vit_tickettype::where('EVENTID', $id )->get();


        //$ticketsType = TicketTransaction::where('event_id', $id )->get();


        foreach ($ticketsType as $ticketType) {

           // if (1) {
                //IF SELECTED QUANTITY DIFFRENT THAN 0 - CHECK IF THE TICKETS IS AVIALABLE

                if ($ticketType->TICKETREMAINING != 0) {

                    $FetchQuantity = TicketTransaction::where('event_id', '=', $id)
                        ->where('tickettype_id', $ticketType->TICKETTYPEID)
                        ->where('user_id', $userId)
                        ->first();

                    //CALCULATE PRICE AND RESERVE A TICKET
                    $ticketName = $ticketType->TICKETTYPENAME;
                    $ticketID = $ticketType->TICKETTYPEID;
                    $price = $ticketType->TICKETPRICE;
                    $quantity = $FetchQuantity->quantity;
                    $totalPrice = $quantity * $price;

                    $ticket = array('ticketID'=>$ticketID,'ticketName'=>$ticketName,'ticketPrice'=>$price,'ticketQuantity'=>$quantity,'ticketTotalPrice'=>$totalPrice);
                     array_push($selectedTickets,$ticket);
                    $paytabs->add_item('Ticket : '.$ticketName, $price, $quantity);


                } else {

                    // TODO RETURN SESSION MSG NO TICKET LEFT
                }
           // }


        }

      //  return "Ticket count".count($selectedTickets)."  | ticket Name :".$selectedTickets[0]['ticketName'];

        $paytabs->set_page_setting('Vitee Payment ','ref number','BHD','127.0.0.1','English');

        $paytabs->set_customer('RAHUL','ACME','00091','12345678','rahul@acmeconnect.com');

        $paytabs->set_address("L T PUNE","MH","PUNE","411006","IND");

        //$paytabs->set_page_setting('Vitee - Ticket Purchase ','Ref Number','BHD',$clientIp,'English');
        //$paytabs->set_customer($firstName,$lastName ,'00973',$phone_number,$email);
        //$paytabs->set_address($adress,$city,$city,$postal_code,"BHD");

        $paytabs->set_discount(0);

        $paytabs->set_other_charges(0);


        $createPaymentPage = $paytabs->create_pay_page();

        //Payment Page Created Successfully
        if($createPaymentPage->response_code == 4012 ){

            //return dd($createPaymentPage);

            for ($i =0 ; $i< count($selectedTickets) ; $i++) {

                DB::table('VIT_TICKET_INVOICES')->insert(
                    ['InvoiceID' => $createPaymentPage->p_id, 'TicketTypeID' => $selectedTickets[$i]['ticketID'], 'TicketQuantity' =>  $selectedTickets[$i]['ticketQuantity'], 'TicketUnitPrice' =>  $selectedTickets[$i]['ticketPrice'], 'TicketTotalPrice' =>  $selectedTickets[$i]['ticketTotalPrice']]
                );

            }

            return redirect()->away($createPaymentPage->payment_url);


        }else{

            // IF NOT REDIRECT TO TH SAME PAGE WITH AN ERROR MESSAGE
            return dd($createPaymentPage);
            //return Redirect::back();

            /*

            return Redirect::back()->with('message','Operation Successful !');

            But since this is a redirected request, you have to access the message by using:

            echo Session::get('message');
            */

        }



    }


    public function createPayPage(){


        $paytabs = new PayTabs();


        $paytabs->validatePaytabs();

        $paytabs->set_page_setting('Vitee Payment ','ref number','BHD','127.0.0.1','English');

        $paytabs->set_customer('RAHUL','ACME','00091','12345678','rahul@acmeconnect.com');

        $paytabs->add_item('Ticket 1','1','1');
        //$paytabs->add_item('Ticket 2','2','2');


        $paytabs->set_other_charges(0);




        /*
            add discount
        */
        //$paytabs->set_discount(1);

        /*
            -customer address
            -customer state, required for USA and Canada
            -customer city
            -customer postal code
            -customer country
        */
        $paytabs->set_address("L T PUNE","MH","PUNE","411006","IND");




        //return 'hello';

       $createPaymentPage = $paytabs->create_pay_page();

        if($createPaymentPage->response_code == 4012 ){

                return redirect()->away($createPaymentPage->payment_url);
        }else{

            return redirect('/paytabs');

        }


    }


    /**
     * @return string
     *
     *
     * Error    Code  Description
    4001    Missing parameters
    4002    Invalid Credentials
    0404    You don’t have permissions
    4091    There are no transactions available.
    100     Payment is completed.
    481     This transaction may be suspicious. If this transaction is genuine,
    please contact PayTabs customer service to enquire about the
     *
     *
     *
     *
     *  +"result": "The payment is completed successfully!"
    +"response_code": "100"
    +"pt_invoice_id": "26487"
    +"amount": 52
    +"currency": "BHD"
    +"transaction_id": "24019"
     */
    public function verifyPayment(){

        // ID OF LOGGED IN USER - TODO IMPLEMENT LOGIN Proccess - TO GET THE USER ID


        $paytabs = new PayTabs();

        //GET PAYMENT REFERENCE TO CHECK IF THE PAYMENT HAS BEEN COMPLETED
        $payment_ref = \Request::input('payment_reference');

        // API CALL TO PAYTABS
        $verifyPayment = $paytabs->verify_payment($payment_ref);

        //SAVE TRANSACTION INTO DB
        DB::table('VIT_TICKET_TRANSACTION')->insert(
            ['transaction_id' => $verifyPayment->transaction_id, 'invoice_id' => $verifyPayment->pt_invoice_id, 'amount' =>   $verifyPayment->amount, 'result_code' =>  $verifyPayment->response_code, 'result_msg' =>   $verifyPayment->result ,'currency'  => $verifyPayment->currency]
        );


        // TODO MINUS TICKET NUMBER

        // Response code = 100 => SUCCESS


        if($verifyPayment->response_code == 800 ){

            $userDetails = User::where('USERID', '789')
                ->update(
                    [
                        'orderTimeout' => 1,
                    ]
                );


            $reservedTickets = \DB::table('VIT_TICKET_INVOICES')
                ->select('TicketTypeID','TicketQuantity','TicketUnitPrice')
                ->where('InvoiceID','=',$verifyPayment->pt_invoice_id)
                ->get();

            $ticketHashKey = "ioroeoepzkcnsdkcscsps";

            foreach ($reservedTickets as $ticket){

            for ($i = 0 ; $i < $ticket->TicketQuantity; $i++){

                DB::table('VIT_TICKET_PURCHASED')->insert(
                    ['TICKETTYPEID' => $ticket->TicketTypeID, 'USERID' => 789, 'TICKETHASHKEY' =>   $ticketHashKey]
                );
            }


            }
            /* TODO  GET THE EVENT NAME INFORMATION FROM THE DATABASE */


            $transactionSummary = array('EventName' => 'Karaoke Idol 2015 PAID ','transactionID' => $verifyPayment->transaction_id,'amount' => $verifyPayment->amount);

            return view('Vitee_Website_Views.ticket.PaymentCompleted')->with('transactionSummary',$transactionSummary);

           // return "Payment Success"." - Invoice ID ".$invoiceId." Transaction ID ".$verifyPayment->transaction_id;

        }else{
            return Redirect::to('/paymentFailed');
            //return view('Vitee_Website_Views.ticket.PaymentFailed')->with('transactionSummary',$verifyPayment);

        }


    }

    function showFailedPage(){
        //DB::enableQueryLog();

        $userId = session('userId');


        DB::table('VIT_TICKET_TRANSACTION')
            ->where('user_id', $userId)
            ->where('result_code',"=", NULL)
            ->delete();

        //dd(DB::getQueryLog());

        return view('Vitee_Website_Views.ticket.PaymentFailed');


    }


    function showPaymentPage(){

        $transactionSummary = array('EventName' => 'Formula 1','transactionID' => 1223);

       //return  dd($transactionSummary);
        return view('Vitee_Website_Views.ticket.PaymentCompleted')->with('transactionSummary',$transactionSummary);


    }



    /**
     * @param  event ID
     * @return Page of Tickets that belong to the event
     */
    function showEventTickets($id){



        $event = \DB::table('VIT_EVENT')
            ->select(\DB::raw('VIT_EVENT.EVENTID,EVENTNAME,EVENTPAID,DATE_FORMAT(EVENTSTART,"%W, %b %d, %Y") as STARTDATE, DATE_FORMAT(EVENTSTART,"%h:%i %p") as STARTTIME,DATE_FORMAT(EVENTEND,"%h:%i %p") as ENDTIME,UNIX_TIMESTAMP(EVENTSTART) as STARTTIMESTAMP'))
            ->where('VIT_EVENT.EVENTID', '=',$id)
            ->get();


        //CHECK IF THE EVENT IS PAID EVENT
        if($event[0]->EVENTPAID == 1) {


/*            $tickets = DB::table('VIT_TICKETTYPE','(SELECT @i:= 0) AS i')
                ->select(\DB::raw('TICKETTYPENAME,TICKETTYPEID,TICKETPRICE,TICKETMIN,TICKETMAX,@i:=@i+1  as id'))
                ->where('EVENTID', $id)->get();*/

            $tickets = DB::select('select TICKETTYPENAME,TICKETTYPEID,TICKETPRICE,TICKETMIN,TICKETMAX,@i:=@i+1  as id
            FROM VIT_TICKETTYPE,(SELECT @i:= 0) AS i WHERE EVENTID = ?', array($id));



            //return  $tickets;
           return view('Vitee_Website_Views.ticket.SelectedTicketsPage')->with('event',$event)->with('tickets',$tickets);

        }
        else{
            //IF THE EVENT IS NOT PAID REDIRECT TO THE EVENT PAGE

            return Redirect::to('/event/'.$id);
        }


    }



    /**
     * @param  event ID
     * @return Page of Tickets that belong to the event
     */
    function showSeatedEventTickets($id){

$id = 287;

        $event = \DB::table('VIT_EVENT')
            ->select(\DB::raw('VIT_EVENT.EVENTID,EVENTNAME,EVENTPAID,DATE_FORMAT(EVENTSTART,"%W, %b %d, %Y") as STARTDATE, DATE_FORMAT(EVENTSTART,"%h:%i %p") as STARTTIME,DATE_FORMAT(EVENTEND,"%h:%i %p") as ENDTIME,UNIX_TIMESTAMP(EVENTSTART) as STARTTIMESTAMP'))
            ->where('VIT_EVENT.EVENTID', '=',$id)
            ->get();


        //CHECK IF THE EVENT IS PAID EVENT
        if($event[0]->EVENTPAID == 1) {


            /*            $tickets = DB::table('VIT_TICKETTYPE','(SELECT @i:= 0) AS i')
                            ->select(\DB::raw('TICKETTYPENAME,TICKETTYPEID,TICKETPRICE,TICKETMIN,TICKETMAX,@i:=@i+1  as id'))
                            ->where('EVENTID', $id)->get();*/

            $tickets = DB::select('select TICKETTYPENAME,TICKETTYPEID,TICKETPRICE,TICKETMIN,TICKETMAX,@i:=@i+1  as id
            FROM VIT_TICKETTYPE,(SELECT @i:= 0) AS i WHERE EVENTID = ?', array($id));



            //return  $tickets;
            return view('Vitee_Website_Views.ticket.TicketsPageSeatedEvent')->with('event',$event)->with('tickets',$tickets);

        }
        else{
            //IF THE EVENT IS NOT PAID REDIRECT TO THE EVENT PAGE

            return Redirect::to('/event/'.$id);
        }


    }




}
