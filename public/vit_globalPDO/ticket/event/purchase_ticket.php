

<?php

/*
 *
 */

set_time_limit(360);
$basedir = realpath(__DIR__);
require_once($basedir . '/../../libs/CRUD.php');
$db = new CRUD();

// check for required fields
if (isset($_POST['Ticket']) && isset($_POST['USERID']) && isset($_POST['EVENTID'])){

    $ticketList = $_POST['Ticket'];
    $userId = $_POST['USERID'];
    $eventId = $_POST['EVENTID'];
    $msg = "";
    $orderId = "";

    $obj =  json_decode($ticketList, true);

    $success = false;


    // set transaction to 0
    // (forces any currently running phps to unreserve tickets)
    session_id($userId);
    session_start();

    $_SESSION['Transaction'] = 1;
    $_SESSION["userId"] = null;
    $_SESSION["eventId"] = null;

    session_write_close();


    // ============================================================
    // 				TRANSACTION
    // ============================================================

    $orderId = uniqid().mt_rand(10,99);

    $db->begin();
    $count = 0;

    foreach ($obj as $ticketObj) {

        $ticket =  json_decode($ticketObj, true);
        $ticketTypeId = $ticket['TICKETTYPEID'];
        $ticketQuan = $ticket['TICKETQUANTITY'];
        $ticketPrice = $ticket['TICKETPRICE'];

        $totalCost = $ticketPrice * $ticketQuan; //total cost of each ticket
        // $msg = $ticket['TICKETTYPEID'];
        //$msg = "Count of Tickets: ".count($ticketObj)."   TicketTypeId: ". $ticketTypeId."   TicketQuantity: ". $ticketQuan;

        //-------------------------------------------------------------------------------------------------------------
        $orderParams = 	[
            ":ticketQuan" => $ticketQuan,
            ":ticketTypeId" => $ticketTypeId,
            ":userId" => $userId,
            ":orderId" => $orderId,
            ":eventId" => $eventId,
            ":totalCost" => $totalCost
        ];
        $orderQuery = " INSERT INTO VIT_TICKET_TRANSACTION(order_id,user_id,tickettype_id, event_id, quantity,amount) VALUES(:orderId, :userId, :ticketTypeId, :eventId, :ticketQuan, :totalCost)";
        $db->executeMySQL($orderQuery, $orderParams);


        //--------------------------------------------------------------------------------------------------------------
        $params = 	[
            ":ticketQuan" => $ticketQuan,
            ":ticketTypeId" => $ticketTypeId
        ];

        $count += $ticketQuan;
        $query = "  UPDATE VIT_TICKETTYPE
					SET TICKETRESERVED = (TICKETRESERVED + :ticketQuan), TICKETREMAINING = (TICKETREMAINING - :ticketQuan)
					WHERE TICKETREMAINING >= :ticketQuan AND TICKETTYPEID = :ticketTypeId";

        $db->executeMySQL($query, $params);
        if($db->rowCount() > 0){
            $success = true;
        }
    }


    // ============================================================
    // 				RESULT
    // ============================================================

    if($success == true){

        // COMMIT the transaction
        $db->commit();

        // On SUCCESS
        $db->response["success"] = 1;
        $db->response["orderId"] = $orderId;
        // $db->response["message"] = $ticketPrice;

        // echoing JSON response with flush
        ob_start();
        $db->echoSuccess();
        //this is for the buffer achieve the minimum size in order to flush data
        echo str_repeat(' ',1024*64);
        ob_flush(); flush();


        $url = BASEURL . "/ticket/event/purchase_ticket_two.php";

        $data = [
            "Ticket" => $ticketList,
            "EVENTID" => $eventId,
            "USERID" => $userId,
            "ORDERID" => $orderId
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'api');
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

        $output = curl_exec($ch);
        curl_close($ch);

        exit;

    } else {

        // rollback any changes
        $db->rollback();

        // On Failed
        $db->response["success"] = 0;
        $db->response["message"] = "Not enough tickets in stock to make purchase: ". $msg;
        $db->echoSuccess();

        exit;
    }

} else {

    // No vars sent
    $db->response["success"] = 0;
    $db->response["message"] = "Oops, an error occurred!";
    $db->echoSuccess();
}
