<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Ixudra\Curl\Facades\Curl;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\TicketController;
use App\User;
use App\Event;
use App\PasswordResets;
use App\TicketPurchased;
use App\TicketType;
use App\TicketTransaction;
use Mail;
use DB;
use Hash;
use Session;
use Cookie;
use Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\PurchaseTicketTwo;

class UsersController extends Controller
{
    //

    public function __construct()
    {


//        $this->middleware('auth');
        DB::enableQueryLog();
        if(!Session::has('userId'))
        {
            Redirect::to('user/login')->send();
        }

    }


    public function register()
    {
        return $this->showRegistrationForm();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitUserDetails(Request $request)
    {
//        $validator = $this->validator($request->all());
//
//        if ($validator->fails()) {
//            $this->throwValidationException(
//                $request, $validator
//            );
//        }


        $USER = new User;
        $USER->email = $request->email;
        $USER->USERNAME = $request->username;
        $USER->USERDESCRIPTION = $request->userdescription;
        $USER->USERGENDER = $request->usergender;
        $USER->password = password_hash($request->password, PASSWORD_DEFAULT, array("cost" => 10));
        $USER->active = '1';// $request->usernotifykey;
        $USER->DOB = $request->dob;

        if ($USER->save()) {
            $this->sendRegisterMail($request->email,$request->username);
            return redirect('user/register')->with(['status' => 1]);
        } else
            return redirect('user/register')->with(['status' => 0]);

    }

    public function showRegistrationForm()
    {
        return view('Vitee_Website_Views.user.register');
    }


    public function userProfile(Request $request)
    {

//        $cookie = Cookie::make("c1", 123);
//
//        dd($cookie);
//
//        dd(cookie('c1'));

//        Session::put('Transaction', 1);Session::put('TransactionRes', 1);
//        Session::save();
//
//
//        if (session('Transaction') != null) {
//            echo "not null";
//            if (session('TransactionRes') != null) {
//                $transaction = session('TransactionRes');
//                echo "not null";
//            }
//        }


        $userId = $request->userId;
        $userDetails = User::where('USERID', $userId)
            ->firstOrFail();

//        dd($userDetails->USERID);
        return view('Vitee_Website_Views.user.userProfile',
            [
                'userDetails' => $userDetails
            ]);
    }

    public function showLoginForm()
    {
        return view('Vitee_Website_Views.user.login');
    }

    public function loginCheck(Request $request)
    {

        $email = $request->email;

        $user = User::where('email', '=', $email)->first();


        // $status = Hash::check($request->password, $user->password);

        //dd($status);

        $password = $request->password;//password_hash($request->password , PASSWORD_DEFAULT, array("cost" => 10));


        if (password_verify($password, $user->password)) {

            $UID = $user->USERID;
            $USERNAME = $user->USERNAME;


            session([
                'userId' => $UID,
                'userNAme' => $USERNAME,
                'usertype' => '1'
            ]);

            //return redirect('events/all')->with(['values'=>$values]);
            return redirect('myTickets');
        } else {
            return "Exception to be Handled : No Results, Please Try Again.";
        }

    }

    public function updateUserDetails(Request $request)
    {
        $DBPath = "";
        $extensionflag = 0;
        $extension = "";
        if (!empty($request->userImage)) {
            $userImageFile = Input::file('userImage')->getFilename();

            $extension = Input::file('userImage')->getClientOriginalExtension();

            if(($extension == "jpg") || ($extension == "jpeg") || ($extension == "png"))
            {
                $storeFolder = 'UserImages/' . $request->USERID;

                $userImage = $userImageFile . '.' . $extension;



                $DBPath = $storeFolder . "/" . $userImage;
                if (Input::file('userImage')->isValid()) {

                    Input::file('userImage')->move($storeFolder, $userImage);

                }
            }
        }

//        dd($DBPath);
        $userDetails = '';

//        dd($request);

        if ($request->password == $request->conformPassword) {

            $userDetails = User::where('USERID', $request->USERID)
                ->update(
                    [
                        'USERNAME' => $request->USERNAME,
                        'USERGENDER' => $request->USERGENDER,
                        'DOB' => $request->DOB,
                        'password' => bcrypt($request->password),
                        'USERDESCRIPTION' => $request->USERDESCRIPTION
                    ]
                );

            //Update Image Only If Set
            // Image specific Extensions only
            if(($extension == "jpg") || ($extension == "jpeg") || ($extension == "png"))
            {
                if (!empty($request->userImage)) {

                    $userDetails = User::where('USERID', $request->USERID)
                        ->update(
                            [
                                'USERIMAGE' => $DBPath
                            ]
                        );
                }
            }
            else
                $extensionflag = 1;

            if ($userDetails) {
                echo json_encode(['result' => 'update','extensionflag' => $extensionflag]);
            } else {
                echo json_encode(['result' => 'not update']);
            }
        } else {
            echo json_encode(['result' => 'password not match']);
        }
//dd($userDetails);

    }


    public function checkSession()
    {
        $userId = '789';


        $userDetails = User::where('USERID', $userId)
            ->firstOrFail();

        if($userDetails->orderTimeout == '1')
        {
            return 1;
        }
        else{
            return 0;
        }

    }

    public function userEvent(Request $request)
    {




        $userId = session('userId');//$request->userId;

        $userEvents = Event::join('VIT_TICKET_PURCHASED', 'VIT_TICKET_PURCHASED.USERID', '=', 'VIT_EVENT.USERID')
            ->where('VIT_EVENT.USERID', $userId)
            ->get();

        return view('Vitee_Website_Views.user.userEvent',
            [
                'userEvents' => $userEvents
            ]
        );
    }

    public function userLogout()
    {
        session()->flush();
        return redirect('user/login');
    }

    public function myTickets(Request $request)
    {

        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $ticketsToday= array();
        $ticketsTomorrow = array();
        $ticketsAfterTomorrow = array();
        $ticketTypeToday = array();
        $ticketTypeTomorrow = array();
        $ticketTypeAfterTomorrow = array();

        DB::enableQueryLog();
        $userId = '336';//session('userId');
//        $Tickets=TicketTransaction::from('VIT_TICKET_TRANSACTION' ,'VIT_EVENT' , 'VIT_EVENTTYPE' )
//            ->where('VIT_TICKET_TRANSACTION.event_id','VIT_EVENT.EVENTID')
//            ->where('VIT_EVENT.EVENTTYPEID','VIT_EVENTTYPE.EVENTTYPEID')
//            ->where('VIT_TICKET_TRANSACTION.result_code',1)
//            ->where('VIT_TICKET_TRANSACTION.user_id',$userID)
//            ->get();


        $Tickets = DB::select(' SELECT VIT_TICKET_PURCHASED.*, TICKETTYPENAME, VIT_EVENT.EVENTID,VIT_EVENT.EVENTIMAGE , EVENTNAME, EVENTLOCATION, EVENTSTART, EVENTEND, USERNAME
    			FROM VIT_TICKET_PURCHASED
                INNER JOIN VIT_TICKETTYPE
				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
				INNER JOIN VIT_EVENT
				ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID
				WHERE VIT_TICKET_PURCHASED.USERID = :userId AND VIT_EVENT.EVENTSTART >= CURDATE()
                ORDER BY TIMEOFPURCHASE ASC ', [":userId" => $userId]);

        $ticketsToday =  DB::select("SELECT DISTINCT event_id,`VIT_EVENT`.* FROM `VIT_TICKET_TRANSACTION`,`VIT_EVENT` WHERE `user_id` = '336'
        AND `result_code` = '1'  AND `VIT_TICKET_TRANSACTION`.`event_id` = `VIT_EVENT`.`EVENTID`
        AND `VIT_EVENT`.`EVENTSTART` = CURDATE()");

        $ticketsTomorrow =  DB::select("SELECT DISTINCT event_id,`VIT_EVENT`.* FROM `VIT_TICKET_TRANSACTION`,`VIT_EVENT` WHERE    `user_id` = '336'
        AND `result_code` = '1'  AND `VIT_TICKET_TRANSACTION`.`event_id` = `VIT_EVENT`.`EVENTID`
        AND VIT_EVENT.EVENTSTART > CURDATE()
        AND VIT_EVENT.EVENTSTART < DATE_ADD(NOW(), INTERVAL 2 day)");



        $ticketsAfterTomorrow =  DB::select("SELECT DISTINCT event_id,`VIT_EVENT`.* FROM `VIT_TICKET_TRANSACTION`,`VIT_EVENT` WHERE    `user_id` = '336'
        AND `result_code` = '1'  AND `VIT_TICKET_TRANSACTION`.`event_id` = `VIT_EVENT`.`EVENTID`
        AND VIT_EVENT.EVENTSTART > CURDATE()
        AND VIT_EVENT.EVENTSTART > DATE_ADD(NOW(), INTERVAL 2 day)");

        foreach($ticketsToday as $ticket)
        {

            $ticketTypeToday[$count1] = DB::select(' SELECT VIT_TICKET_PURCHASED.*, TICKETTYPENAME
    			FROM VIT_TICKET_PURCHASED
                INNER JOIN VIT_TICKETTYPE
				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
				INNER JOIN VIT_EVENT
				ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID
				WHERE VIT_TICKET_PURCHASED.USERID = :userId
				AND VIT_EVENT.EVENTSTART = CURDATE()
				AND VIT_EVENT.EVENTID = :eventId
                ORDER BY TIMEOFPURCHASE ASC ', [":userId" => $userId,":eventId" => $ticket->event_id]);
            $count1++;
        }

        foreach($ticketsTomorrow as $ticket)
        {

            $ticketTypeTomorrow[$count2] = DB::select(' SELECT VIT_TICKET_PURCHASED.*, TICKETTYPENAME
    			FROM VIT_TICKET_PURCHASED
                INNER JOIN VIT_TICKETTYPE
				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
				INNER JOIN VIT_EVENT
				ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID
				WHERE VIT_TICKET_PURCHASED.USERID = :userId
				AND VIT_EVENT.EVENTSTART > CURDATE()
                AND VIT_EVENT.EVENTSTART < DATE_ADD(NOW(), INTERVAL 2 day)
				AND VIT_EVENT.EVENTID = :eventId
                ORDER BY TIMEOFPURCHASE ASC ', [":userId" => $userId,":eventId" => $ticket->event_id]);
            $count2++;
        }

        foreach($ticketsAfterTomorrow as $ticket)
        {
            $ticketTypeAfterTomorrow[$count3]= DB::select(' SELECT VIT_TICKET_PURCHASED.*, TICKETTYPENAME
    			FROM VIT_TICKET_PURCHASED
                INNER JOIN VIT_TICKETTYPE
				ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
				INNER JOIN VIT_EVENT
				ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
				INNER JOIN VIT_USER
				ON VIT_EVENT.USERID = VIT_USER.USERID
				WHERE VIT_TICKET_PURCHASED.USERID = :userId
                AND VIT_EVENT.EVENTSTART > DATE_ADD(NOW(), INTERVAL 2 day)
				AND VIT_EVENT.EVENTID = :eventId
                ORDER BY TIMEOFPURCHASE ASC ', [":userId" => $userId,":eventId" => $ticket->event_id]);

            $count3++;
        }


//        select * from `VIT_TICKET_TRANSACTION` ,`VIT_EVENT` , `VIT_EVENTTYPE`
//where `VIT_TICKET_TRANSACTION` . `event_id` = `VIT_EVENT`.`EVENTID`
//    AND `VIT_EVENT`.`EVENTTYPEID` = `VIT_EVENTTYPE`.`EVENTTYPEID`
//    AND `VIT_TICKET_TRANSACTION`.`user_id` = 336 and `VIT_TICKET_TRANSACTION`.`result_code` = 1

//        dd(DB::getQueryLog());

        return view('Vitee_Website_Views.user.myTickets',
            [
                'ticketsToday' => $ticketsToday,
                'ticketsTomorrow' => $ticketsTomorrow,
                'ticketsAfterTomorrow' => $ticketsAfterTomorrow,
                'ticketTypeToday' => $ticketTypeToday,
                'ticketTypeTomorrow' => $ticketTypeTomorrow,
                'ticketTypeAfterTomorrow' => $ticketTypeAfterTomorrow,
            ]);
    }

    public function BuyTicket(Request $request)
    {

        $orderId = uniqid() . mt_rand(10, 99);
        $userId = session('userId');



        foreach ($request->TICKETTYPEID as $key => $TicketTypeId) {


            $ticketTypeId = $request->TICKETTYPEID[$key];
            $eventId = $request->EVENTID;
            $ticketQuan = $request->quantity[$key];
            $ticketPrice = $request->TICKETPRICE[$key];

            $totalCost = $ticketPrice * $ticketQuan;

//
            $TicketTransaction = TicketTransaction::create(
                [
                    'order_id' => $orderId,
                    'user_id' => $userId,
                    'tickettype_id' => $ticketTypeId,
                    'event_id' => $eventId,
                    'quantity' => $ticketQuan,
                    'amount' => $totalCost
                ]
            );

            $TicketType = TicketType::where('TICKETREMAINING', '>=', $ticketQuan)
                ->where('TICKETTYPEID', $ticketTypeId);

//            dd($TicketType->TICKETTOTAL);
            $TicketType->increment('TICKETRESERVED', $ticketQuan);
            $TicketType->decrement('TICKETREMAINING', $ticketQuan);
        }

//        dd(DB::getQueryLog());
        if ($TicketTransaction && $TicketType)
            $result = 'success';
        else
            $result = 'fail';


//        return redirect("/event/".$eventId."/tickets/purchase");

        //$this->test($userId);
//        dd($userId,$request);

        // $this->dispatch(new PurchaseTicketTwo($userId, $request->all(), $orderId));

//        $data = [
//            "userId" => "789",
//            "orderId" => "57110f323a58029",
//            "_token" => "IgOBldBCwc4Fq9k3M8OebnlJcGWHv2Ip4lvGDCje",
//            "ticketData" => [
//                      "TICKETTYPEID" =>  [
//                        0 => "3",
//                        1 => "4"
//                      ],
//                      "TICKETPRICE" =>  [
//                        0 => "10",
//                        1 => "5"
//                      ],
//                      "quantity" =>  [
//                        0 => "1",
//                        1 => "1"
//                      ],
//                      "finalPrice" => [
//                        0 => "10",
//                        1 => "5"
//                      ],
//                      "EVENTID" => "3057"
//
//                    ]
//                ];
//
//        $this->PurchaseTicketTwo($data);
//dd($request->all());


        $curlService = new \Ixudra\Curl\CurlService();

        $curlService->to('phplaravel-16615-36254-102218.cloudwaysapps.com/purchaseticketTwo')
            ->withData( [
                'userId' => $userId,
                'ticketData' => $request->all(),
                'orderId' => $orderId,
            ] )
            ->get();


         return redirect("/event/".$eventId."/tickets/purchase");

//        $response = Curl::to('purchaseticketTwo')
//            ->withData( [
//                'userId' => $userId,
//                'request' => $request,
//                'orderId' => $orderId,
//            ] )
//            ->post();

//        $this->purchaseticketTwo($userId,$request,$orderId);

//        return redirect()->back();
    }


    public function purchaseticketTwo(Request $request)
    {
        $eventId = $request->ticketData['EVENTID'];
        $userId = $request->userId;
        $orderId = $request->orderId;


        $eventId = $request->ticketData['EVENTID'];
        $userId = $request->userId;
        $orderId = $request->orderId;
        $LASTACTIVITY = time();
        $timeout = time() + 300;
        $check = true;
        $success = false;
        $transaction = -1;
//         session_start();
//        $_SESSION["Transaction"] = null;
//        $_SESSION["userId"] = $userId;
//        $_SESSION["eventId"] = $eventId;
////        session(["Transaction" => null]);
////        session(["userId" => $userId]);
//        //session(["eventId" => $eventId]);
//        session_write_close();

//        for($i=0 ; $i<3; $i++)
//        {
//            $USER = new User;
//            $USER->email = $eventId."-".$userId."-".$orderId;
//            $USER->USERDESCRIPTION = "asd";
//            $USER->USERGENDER = "Male";
//            $USER->save();
//
//            sleep(10);
//        }


        While ($check) {

            if($this->checkSession()){
                $transaction = 1;

                // save value of transaction
//                if($_SESSION['TransactionRes'] == "1"){
//                    $transaction = $_SESSION['TransactionRes'];
//                }
//                $_SESSION["Transaction"] = null;
//                $_SESSION["TransactionRes"] = null;

                // break out of loop
                $check = false;

            }
            else if ($LASTACTIVITY >= $timeout) {
                session(["Transaction" => null]);
                session(["TransactionRes" => null]);

                session_write_close();
                // break out of loop
                $check = false;
            } else {
                $LASTACTIVITY = $LASTACTIVITY + 5;
            }
            sleep(2);
            TicketTransaction::where('user_id', '789')
                ->update([
                    'eta' => $LASTACTIVITY."-".$timeout
                ]);

        }

        $msg = "";
        switch ($transaction) {
            case "1":
                $msg = 'Payment Successful';
                break;
            case "0":
                $msg = 'Payment Canceled';
                break;
            default:
                $msg = 'Timed Out';
        }

        $t=time();
        $afterTimeout = date("Y-m-d h:i:s",$t);

        TicketTransaction::where('order_id', $orderId)
            ->update([
                'result_code' => $transaction,
                'result_msg' => $msg,
                'eta' => $afterTimeout
            ]);

        if ($transaction == "1") {

            foreach ($request->ticketData['TICKETTYPEID'] as $key => $ticketObj) {

                $ticketTypeId = $request->ticketData['TICKETTYPEID'][$key];
                $ticketQuan = $request->ticketData['TICKETTYPEID'][$key];

                $TicketType = TicketType::where('TICKETRESERVED', '>=', $ticketQuan)
                    ->where('TICKETTYPEID', $ticketTypeId);
                $TicketType->decrement('TICKETRESERVED', $ticketQuan);
                if ($TicketType) {
                    for ($c = 0; $c < $ticketQuan; $c++) {
                        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

                        $salted = $userId . $salt;

                        $hashkey = hash('sha256', "Ticket" . $salted);

                        $TicketPurchased = TicketPurchased::create([
                            'USERID' => $userId,
                            'TICKETTYPEID' => $ticketTypeId,
                            'TICKETHASHKEY' => $hashkey,
                            'ORDERID' => $orderId,
                        ]);

                        $ticketIds = $TicketPurchased->TICKETID();
                        array_push($tidArray, $ticketIds);
                    }
                }

                $check = DB::select('SELECT *
						FROM VIT_USERATTENDING
						WHERE EVENTID = :eventId AND USERID = :userId', [
                    ":userId" => $userId,
                    ":eventId" => $eventId
                ]);
                if (count($check) > 0) {
                    $success = true;
                } else {
                    $result = DB::insert('INSERT INTO VIT_USERATTENDING(USERID, EVENTID)
							VALUES(:userId, :eventId)', [
                        ":userId" => $userId,
                        ":eventId" => $eventId
                    ]);

                    if (count($result) > 0) {
                        $success = true;
                    }
                }

            }

            foreach ($tidArray as $value) {
                $query3 = DB::select("SELECT  VIT_EVENT.EVENTID as EVENTID, VIT_USER.USERID as USERID, email, TICKETTYPENAME,DATE_FORMAT(DATE(TIMEOFPURCHASE),'%d %M %Y') as TIMEOFPURCHASE, VIT_USER.USERNAME as USERNAME, EVENTPROMOTERNAME.USERNAME as EVENTPROMOTERNAME,
	                    TICKETHASHKEY, EVENTNAME, DATE_FORMAT( EVENTSTART  ,  '%W, %M %e at %l:%i %p'  ) as STARTDATETIME, TIME_FORMAT( TIME(EVENTEND)  ,  '%l:%i %p'  ) as ENDTIME, EVENTLOCATION
						FROM (SELECT USERNAME FROM VIT_USER INNER JOIN VIT_EVENT ON VIT_EVENT.USERID = VIT_USER.USERID WHERE EVENTID = :eventId) as EVENTPROMOTERNAME, VIT_TICKET_PURCHASED
						INNER JOIN VIT_TICKETTYPE ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
						INNER JOIN VIT_EVENT ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
						INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_TICKET_PURCHASED.USERID
						WHERE TICKETID = :value" . [
                        ":value" => $value,
                        ":eventId" => $eventId
                    ]);

                if (count($query3) > 0) {

                    $ticketInfo = $query3->attribute;
                    array_push($ticketInfoArray, $ticketInfo);

                }
            }

        } else {


            $success = true;
            // IF paytabs rejected/cancelled/timed-out
            // foreach tickettype loop
            foreach ($request['TICKETTYPEID'] as $key => $ticketObj) {


                $ticketTypeId = $request->ticketData['TICKETTYPEID'][$key];
                $ticketQuan = $request->ticketData['quantity'][$key];


                $TicketType = TicketType::where('TICKETRESERVED', '>=', $ticketQuan)
                    ->where('TICKETTYPEID', $ticketTypeId);

                $TicketType->decrement('TICKETRESERVED', $ticketQuan);
                $TicketType->increment('TICKETREMAINING', $ticketQuan);


            }
        }



    }




    public function passwordResetSendEmail($email, $token)
    {
        $data = ['email' => $email, 'token' => $token];
        Mail::send('Vitee_Website_Views.user.resetPasswordMailContent', $data, function ($m) {
            $m->from('noreply@vitee.net', 'Your Application');

            $m->to('ajay@acmeconnect.com', 'test')->subject('Forgot Password');
        });
    }

    public function sendRegisterMail($email,$name)
    {
        $data = ['email' => $email,'name'=>$name];
        Mail::send('Vitee_Website_Views.user.sendRegisterMail', $data, function ($m) {
            $m->from('noreply@vitee.net', 'Your Application');

            $m->to('ajay@acmeconnect.com', 'test')->subject('Forgot Password');
        });
    }

    public function downloadTicketPDF()
    {

    }

}