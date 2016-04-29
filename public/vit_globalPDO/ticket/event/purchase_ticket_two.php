<?php

/*
 * Following code will wait 10 minutes to unreserve tickets
 * if paytabs rejected/cancelled/timed-out
 * The code will unreserve the tickets
 * if paytabs accepts transaction
 * the countdown will cancel
 * and the tickets will be generated for the user instead
 */

// ============================================================
// 				INCLUDE
// ============================================================

set_time_limit(360);
$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();


$ticketInfoArray = array();
$tidArray = array();

if (isset($_POST['Ticket']) && isset($_POST['USERID']) && isset($_POST['EVENTID']) && isset($_POST['ORDERID'])){


    // ============================================================
    // 				VARIABLES
    // ============================================================

    // setup vars
    $ticketList = $_POST['Ticket'];
    $userId = $_POST['USERID'];
    $eventId = $_POST['EVENTID'];
    $orderId = $_POST['ORDERID'];

    $obj =  json_decode($ticketList, true);

    $LASTACTIVITY = time();
    $timeout = time()+360;
    $check = false;
    $success = false;
    $transaction = -1;


    // set transaction to null
    session_id($userId);
    session_start();

    $_SESSION["Transaction"] = null;
    $_SESSION["userId"] = $userId;
    $_SESSION["eventId"] = $eventId;

    session_write_close();


    // ============================================================
    // 				SLEEP
    // ============================================================

    // SLEEP 10 seconds
    While(!$check){

        session_id($userId);
        session_start();


        // break loop if a transaction is sent OR 10 mins are up
        if(isset($_SESSION['Transaction'])){

            // save value of transaction
            if(isset($_SESSION['TransactionRes'])){
                $transaction = $_SESSION['TransactionRes'];
            }
            $_SESSION["Transaction"] = null;
            $_SESSION["TransactionRes"] = null;

            session_write_close();
            // break out of loop
            $check = true;

        }else if($LASTACTIVITY >= $timeout){

            $_SESSION["Transaction"] = null;
            $_SESSION["TransactionRes"] = null;

            session_write_close();

            // break out of loop
            $check = true;
        }else{

            session_write_close();
            sleep(1);
            $LASTACTIVITY++;
        }
    }


    // ============================================================
    // 				QUERIES
    // ============================================================



    //  $transaction =1;

    // Begin the transaction
    $db->begin();

    {
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
        $params6 = [
            ":resultCode" => $transaction,
            ":resultMsg" => $msg,
            ":orderId" => $orderId
        ];

        $query1 = "UPDATE VIT_TICKET_TRANSACTION
                            SET result_code=:resultCode, result_msg=:resultMsg
                            WHERE order_id=:orderId";
        $db->executeMySQL($query1, $params6);
    }

    // IF transaction result is recieved & paytabs successful
    if($transaction == "1"){


        foreach ($obj as $ticketObj) {


            $ticket =  json_decode($ticketObj, true);

            $ticketTypeId = $ticket['TICKETTYPEID'];
            $ticketQuan = $ticket['TICKETQUANTITY'];

            $params1 = 	[
                ":ticketQuan" => $ticketQuan,
                ":ticketTypeId" => $ticketTypeId
            ];




            $query1 = "UPDATE VIT_TICKETTYPE
						SET TICKETRESERVED = (TICKETRESERVED - :ticketQuan)
						WHERE TICKETRESERVED >= :ticketQuan AND TICKETTYPEID = :ticketTypeId";
            $db->executeMySQL($query1, $params1);

            if($db->rowCount() > 0) {



                // generate tickets
                for ($c = 0; $c < $ticketQuan; $c++) {

                    # generate a random salt to use for ticket
                    $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

                    $salted = $userId . $salt;

                    $hashkey = hash('sha256', "Ticket".$salted);

                    $params2 = [
                        ":userId" => $userId,
                        ":ticketTypeId" => $ticketTypeId,
                        ":hashkey" => $hashkey,
                        ":orderId" => $orderId
                    ];



                    $query2 = "	INSERT INTO VIT_TICKET_PURCHASED (USERID, TICKETTYPEID,TICKETHASHKEY, ORDERID)
								VALUES (:userId, :ticketTypeId,:hashkey,:orderId)";

                    $db->executeMySQL($query2, $params2);

                    //--------------------------------------------------------------------------------------------------

                    $ticketIds = $db->isInserted();
                    array_push($tidArray, $ticketIds);

                }
            }


            //------------------------------------------------------------------------------------------------------


            $resultParams = [
                ":userId" => $userId,
                ":eventId" => $eventId
            ];
            $check = " 	SELECT *
						FROM VIT_USERATTENDING
						WHERE EVENTID = :eventId AND USERID = :userId";

            $db->executeMySQL($check, $resultParams);
            if($db->rowCount() > 0){
                $success = true;
            } else {
                $result = "	INSERT INTO VIT_USERATTENDING(USERID, EVENTID)
							VALUES(:userId, :eventId)";
                $db->executeMySQL($result, $resultParams);
                if($db->rowCount() > 0){
                    $success = true;
                }
            }


        }




        foreach ($tidArray as $value) {

            $params3 = 	[
                ":value" => $value,
                ":eventId" => $eventId
            ];

            $query3 = "	SELECT  VIT_EVENT.EVENTID as EVENTID, VIT_USER.USERID as USERID, email, TICKETTYPENAME,DATE_FORMAT(DATE(TIMEOFPURCHASE),'%d %M %Y') as TIMEOFPURCHASE, VIT_USER.USERNAME as USERNAME, EVENTPROMOTERNAME.USERNAME as EVENTPROMOTERNAME,
	                    TICKETHASHKEY, EVENTNAME, DATE_FORMAT( EVENTSTART  ,  '%W, %M %e at %l:%i %p'  ) as STARTDATETIME, TIME_FORMAT( TIME(EVENTEND)  ,  '%l:%i %p'  ) as ENDTIME, EVENTLOCATION
						FROM (SELECT USERNAME FROM VIT_USER INNER JOIN VIT_EVENT ON VIT_EVENT.USERID = VIT_USER.USERID WHERE EVENTID = :eventId) as EVENTPROMOTERNAME, VIT_TICKET_PURCHASED
						INNER JOIN VIT_TICKETTYPE ON VIT_TICKET_PURCHASED.TICKETTYPEID = VIT_TICKETTYPE.TICKETTYPEID
						INNER JOIN VIT_EVENT ON VIT_TICKETTYPE.EVENTID = VIT_EVENT.EVENTID
						INNER JOIN VIT_USER ON VIT_USER.USERID = VIT_TICKET_PURCHASED.USERID
						WHERE TICKETID = :value";


            $db->executeMySQL($query3, $params3);

            if ($db->rowCount() > 0) {

                $ticketInfo = $db->fetchAll();
                array_push($ticketInfoArray, $ticketInfo);

            }
        }

        $jsonTicketInfo = json_encode($ticketInfoArray);

        $url = BASEURL . "/ticket/event/tickets_send_pdf.php";
        $data = [
            "ticketInfoArray" => $jsonTicketInfo,
            "Ticket" => $ticketList,
            "ORDERID" => $orderId
        ];

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, 'api');
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

        $output=curl_exec($ch);
        curl_close($ch);




        //end of if condition
    } else {


        $success = true;
        // IF paytabs rejected/cancelled/timed-out
        // foreach tickettype loop
        foreach ($obj as $ticketObj) {

            $ticket = json_decode($ticketObj, true);

            $ticketTypeId = $ticket['TICKETTYPEID'];
            $ticketQuan = $ticket['TICKETQUANTITY'];

            $params4 = [
                ":ticketQuan" => $ticketQuan,
                ":ticketTypeId" => $ticketTypeId
            ];
            $result = "	UPDATE VIT_TICKETTYPE
						SET TICKETRESERVED = (TICKETRESERVED - :ticketQuan), TICKETREMAINING = (TICKETREMAINING + :ticketQuan)
						WHERE TICKETRESERVED >= :ticketQuan AND TICKETTYPEID = :ticketTypeId";
            $db->executeMySQL($result, $params4);


        }
    }

    // On SUCCESS
    $db->response["success"] = 1;

    // Commit the transaction
    $db->commit();

    // echoing JSON response
    $db->echoSuccess();


} else {

    // No vars sent
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred!";

    // echoing JSON response
    $db->echoSuccess();
}
?>

