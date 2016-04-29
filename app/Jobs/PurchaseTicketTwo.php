<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Event;
use App\TicketPurchased;
use App\TicketType;
use App\TicketTransaction;
use DB;


class PurchaseTicketTwo extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    protected $userId;
    protected $request;
    protected $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userIdThis,$requestThis,$orderIdThis)
    {
        $this->userId=$userIdThis;
        $this->request=$requestThis;
        $this->orderId=$orderIdThis;
//        dd($this->userId,$this->request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        echo'test';
//        dd($this->userId,$this->request);
        $eventId =$this->request['EVENTID'];
//        dd($eventId );
        $LASTACTIVITY = time();
        $timeout = time()+360;
        $check = true;
        $success = false;
        $transaction = -1;
        session(["Transaction" => null]);
        session(["userId" => $this->userId]);
        session(["eventId"=> $eventId]);
        While($check){
            if(session('Transaction')!=null){
                if(session('TransactionRes')!=null){
                    $transaction = session('TransactionRes');
                }
                session(["Transaction"=> null]) ;
                session(["TransactionRes"=> null]) ;

                // break out of loop
                $check = false;

            }else if($LASTACTIVITY >= $timeout) {
                session(["Transaction" => null]);
                session(["TransactionRes" => null]);

                // break out of loop
                $check = false;
            }else{

                sleep(1);
                $LASTACTIVITY++;

            }
            echo'in while';
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

        TicketTransaction::where('order_id',$this->orderId)
            ->update([
                'result_code'=>$transaction,
                'result_msg'=>$msg
            ]);

        if($transaction == "1"){
            foreach ($this->request->TICKETTYPEID as $key=>$ticketObj) {
                $ticketTypeId = $this->request->TICKETTYPEID[$key];
                $ticketQuan = $this->request->quantity[$key];

                $TicketType=TicketType::where('TICKETRESERVED','>=',$ticketQuan)
                    ->where('TICKETTYPEID',$ticketTypeId);
                $TicketType ->decrement('TICKETRESERVED', $ticketQuan);
                if($TicketType){
                    for ($c = 0; $c < $ticketQuan; $c++) {
                        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

                        $salted = $this->userId . $salt;

                        $hashkey = hash('sha256', "Ticket".$salted);

                        $TicketPurchased=TicketPurchased::create([
                            'USERID'=>$this->userId,
                            'TICKETTYPEID'=>$ticketTypeId,
                            'TICKETHASHKEY'=>$hashkey,
                            'ORDERID'=>$this->orderId,
                        ]);

                        $ticketIds = $TicketPurchased->TICKETID();
                        array_push($tidArray, $ticketIds);
                    }
                }

                $VIT_USERATTENDING =DB::select('SELECT *
						FROM VIT_USERATTENDING
						WHERE EVENTID = :eventId AND USERID = :userId',[
                    ":userId" => $this->userId,
                    ":eventId" => $eventId
                ]);
                if(count($VIT_USERATTENDING )>0)
                {
                    $success = true;
                } else {
                    $result = DB::insert('INSERT INTO VIT_USERATTENDING(USERID, EVENTID)
							VALUES(:userId, :eventId)',[
                        ":userId" => $this->userId,
                        ":eventId" => $eventId
                    ]);

                    if(count($result) > 0){
                        $success = true;
                    }
                }

            }

            foreach ($tidArray as $value) {
                $query3 =DB::select("SELECT  VIT_EVENT.EVENTID as EVENTID, VIT_USER.USERID as USERID, email, TICKETTYPENAME,DATE_FORMAT(DATE(TIMEOFPURCHASE),'%d %M %Y') as TIMEOFPURCHASE, VIT_USER.USERNAME as USERNAME, EVENTPROMOTERNAME.USERNAME as EVENTPROMOTERNAME,
	                    TICKETHASHKEY, EVENTNAME, DATE_FORMAT( EVENTSTART  ,  '%W, %M %e at %l:%i %p'  ) as STARTDATETIME, TIME_FORMAT( TIME(EVENTEND)  ,  '%l:%i %p'  ) as ENDTIME, EVENTLOCATION
						FROM (SELECT USERNAME FROM VIT_USER INNER JOIN VIT_EVENT ON VIT_EVENT.USERID = VIT_USER.USERID WHERE EVENTID = :eventId) as EVENTPROMOTERNAME, VIT_TICKET_PURCHASED
						INNER JOIN VIT_TICKETTYPE ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
						INNER JOIN VIT_EVENT ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
						INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_TICKET_PURCHASED.USERID
						WHERE TICKETID = :value".[
                        ":value" => $value,
                        ":eventId" => $eventId
                    ]);

                if (count($query3) > 0) {

                    $ticketInfo = $query3->attribute;
                    array_push($ticketInfoArray, $ticketInfo);

                }
            }

        }else {


            $success = true;
            // IF paytabs rejected/cancelled/timed-out
            // foreach tickettype loop
            foreach ($this->request['TICKETTYPEID'] as $key=>$TICKETTYPEID) {

//                dd($this->request['quantity'],$this->request['TICKETTYPEID']);
//                dd($this->request['quantity'][$key],$TICKETTYPEID[$key]);
                $ticketTypeId = $TICKETTYPEID;
                $ticketQuan = $this->request['quantity'][$key];

                $TicketType=TicketType::where('TICKETRESERVED','>=',$ticketQuan)
                    ->where('TICKETTYPEID',$ticketTypeId);

                $TicketType->decrement('TICKETRESERVED',$ticketQuan);
                $TicketType->increment('TICKETREMAINING',$ticketQuan);


                echo'$success = true';
            }
        }


        if(!$check)
            $this->release(10);


    }
}
