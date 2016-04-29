<?php

require '../../libs/PHPMailerAutoload.php';

require '../../../fpdf17/fpdf.php';

require '../../../qrcode/qrcode.class.php';


if (isset($_POST['ticketInfoArray']) && isset($_POST['Ticket'])  && isset($_POST['ORDERID']) ){

    // ============================================================
    // 				VARIABLES
    // ============================================================

    $ticketInfo = $_POST['ticketInfoArray'];
    $ticketList = $_POST['Ticket'];
    $orderId = $_POST['ORDERID'];

    $result = json_decode($ticketInfo,true);

    $obj =  json_decode($ticketList, true);

    mkdir('../../../TicketPDF/' . $result[0][0]['USERID']); //make user id directory which contains their PDF ticket


    $mail = new PHPMailer;

    $mail->isSMTP();                                                        // Set mailer to use SMTP
    $mail->Host = 'smtp.zoho.com';                                          // Specify main and backup server
    $mail->SMTPAuth = true;                                                 // Enable SMTP authentication
    $mail->Username = 'noreply@vitee.net';                                  // SMTP username
    $mail->Password = 'MasterChief23!!';                                    // SMTP password
    $mail->SMTPSecure = 'tls';                                              // Enable encryption, 'ssl' also accepted
    $mail->Port = 587;                                                      // Set the SMTP port number - 587 for authenticated TLS
    $mail->setFrom('noreply@vitee.net');                                    // Set who the message is to be sent from
    $mail->addAddress($result[0][0]['email'], $result[0][0]['USERNAME']);   // Add a recipient
    $mail->isHTML(true);                                                    // Set email format to HTML

    class PDF extends FPDF {
        function Footer() {
            $this->SetY(-15);
            $this->AddFont('Ample','','AmpleMedium.php');
            $this->SetFont('Ample','',30);
            $this->SetFillColor(244,121,50);
            $this->SetTextColor(255,255,255);
            $this->SetX(0);
            $this->Cell(210,15,'vitee',0,0,'C',true);
        }
    }

    for($i = 0; $i < count($result); $i++){
        $res = $result[$i];

        // Instantiation of inherited class
        $pdf = new PDF();

        $pdf->AddPage();


        //-------------- START TICKET BODY ------------------

        $pdf->SetFont('Arial','B',15);
        // Move to the right
        //$pdf->Cell(5);
        $pdf->SetX(30);
        // Title
        $pdf->SetFillColor(255,255,255);
        // $pdf->cell(210,50,$res[0]['hello'],5,1,'C',true);

        $pdf->cell(150,100,'',1,1,'C',true);

        $qrcode = new QRcode('vitee:' . $res[0]['EVENTID'] . ':' . $res[0]['TICKETHASHKEY']); //The string you want to encode
        $qrcode->displayFPDF($pdf, 65, 20, 80); //PDF object, X pos, Y pos, Size of the QR code

        // $pdf->Image('1.jpg',25,35,160,105);

        $pdf->SetFont('Arial','B',12);
        // Move to the right
        //$pdf->Cell(5);
        $pdf->SetX(30);
        // Title
        $pdf->SetFillColor(229,229,229);
        // $pdf->cell(210,50,$res['eventName'],5,1,'C',true);

        $pdf->cell(150,28,'',1,1,'L',true);
        $pdf->SetXY(30,115);
        $pdf->SetX(31);
        $pdf->cell(148, 10, $res[0]['EVENTPROMOTERNAME'] . ' Presents', 5, 1, 'L', true);
        // $pdf->SetXY(150, 150); // position of text1, numerical, of course, not x1 and y1

        $pdf->SetX(31);
        $pdf->SetFont('Arial','B',18);
        $pdf->cell(148, 10, $res[0]['EVENTNAME'], 5, 1, 'L', true);


        $pdf->SetFont('Arial','B',18);
        // Move to the right

        $pdf->SetX(30);
        // $pdf->SetY(30);
        // Title

        $pdf->SetFillColor(255,255,255);
        // $pdf->cell(210,50,$res['eventName'],5,1,'C',true);
        $pdf->cell(150,52,'',1,1,'L',true);
        $pdf->SetXY(30,140);
        // $pdf->SetY(150);
        $pdf->SetX(31);
        $pdf->cell(148, 10, $res[0]['TICKETTYPENAME'], 5, 1, 'L', true);



        $pdf->SetFont('Arial','B',12);
        $pdf->SetX(31);
        $pdf->cell(148,5,'ADMISSION',5,1,'L',true);


        //$pdf->SetX(31);
        $pdf->Image('../../../googleIcons/ic_place_black_18dp.png',31,159);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetX(38);
        $pdf->cell(141, 15, $res[0]['EVENTLOCATION'], 5, 1, 'L', true);


        $pdf->Image('../../../googleIcons/ic_access_time_black_18dp.png',31,169);
        $pdf->SetX(38);
        $pdf->cell(141, 5, $res[0]['STARTDATETIME'], 5, 1, 'L', true);

        $pdf->SetXY(31,180);
        $pdf->SetFont('Arial','B',10);
        $pdf->cell(141, 5, 'ORDER# '.$orderId, 5, 1, 'L', true);

        //-------------- END TICKET BODY ------------------


        //Output the document
        $pdfDocument = $pdf->Output('../../../TicketPDF/' . $result[0][0]['USERID'] . '/Ticket00' . $i . '.pdf', 'F'); //'F' to save file on server
        //$pdfDocument = $pdf->Output('TicketInvoice.pdf','I'); //'F' to save file on server
        $mail->AddAttachment('../../../TicketPDF/' . $result[0][0]['USERID'] . '/Ticket00' . $i . '.pdf');


    }

    $mail->Subject = 'Your Ticket for '.$result[0][0]['EVENTNAME'];
    $mail->Body =   '

        <!DOCTYPE html>
<html doctype style="font-family: "Open Sans", sans-serif; font-size: 14px; background: #FAFAFA;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EMAIL TITLE</title>
</head>
<body style="font-family: "Open Sans", sans-serif; font-size: 14px; background: #FAFAFA;" bgcolor="#FAFAFA">
<style type="text/css">
@font-face {
font-family: "Open Sans"; font-style: normal; font-weight: 300; src: local("Open Sans Light"), local("OpenSans-Light"), url("https://fonts.gstatic.com/s/opensans/v13/DXI1ORHCpsQm3Vp6mXoaTYnF5uFdDttMLvmWuJdhhgs.ttf") format("truetype");
}
@font-face {
font-family: "Open Sans"; font-style: normal; font-weight: 400; src: local("Open Sans"), local("OpenSans"), url("https://fonts.gstatic.com/s/opensans/v13/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf") format("truetype");
}
@font-face {
font-family: "Open Sans"; font-style: normal; font-weight: 600; src: local("Open Sans Semibold"), local("OpenSans-Semibold"), url("https://fonts.gstatic.com/s/opensans/v13/MTP_ySUJH_bn48VBG8sNSonF5uFdDttMLvmWuJdhhgs.ttf") format("truetype");
}
.button:visited {
color: #f47932; text-decoration: none; font-weight: 600; text-transform: uppercase; border: 1px solid #f47932; border-radius: 4px; padding: 10px 20px; width: auto; display: block; text-align: center;
}
.button:hover {
color: #f47932; text-decoration: none; font-weight: 600; text-transform: uppercase; border: 1px solid #f47932; border-radius: 4px; padding: 10px 20px; width: auto; display: block; text-align: center;
}
.button:active {
color: #f47932; text-decoration: none; font-weight: 600; text-transform: uppercase; border: 1px solid #f47932; border-radius: 4px; padding: 10px 20px; width: auto; display: block; text-align: center;
}
.footer a:visited {
color: #f47932 !important; text-decoration: none;
}
.footer a:hover {
color: #f47932 !important; text-decoration: none;
}
.footer a:active {
color: #f47932 !important; text-decoration: none;
}
@media screen and (max-width: 500px) {
  .main_body {
    max-width: 90%;
  }
  .footer {
    max-width: 90%;
  }
}
</style>
<table class="container" style="max-width: 500px; box-sizing: content-box; display: block; margin: 0 auto;"><tr><td>
<table class="main_body" style="display: block; border-radius: 5px !important; box-shadow: 0px 1px 2px 0px rgba(204,204,204,0.50); overflow: hidden; clear: both; margin: 10px; border: 1px solid #cccccc;">
<tr class="logo" style="height: 100px; background: #f47932;" bgcolor="#f47932">
<td><img src="http://vitee.net/Vitee_Website_Assets/images/logo-dark.png" alt="Vitee" style="display: block; padding-top: 1%; margin: 0 auto;"></td>
  </tr>
<tr>
<td class="content" style="background: #ffffff; padding: 20px;" bgcolor="#ffffff">
            <h1 style="font-size: 2em; font-weight: 300; margin-bottom: 20px;">Hello, '.$result[0][0]['USERNAME'].'</h1>
            <p style="line-height: 20pt; margin-bottom: 20px; color: #808080;">We are sending you this message to confirm that you have purchased the following tickets from Vitee:</p>
        <table class="grey_table" style="width: 100%; height: auto; background: #F2F2F2; border: 1px solid #cccccc;" bgcolor="#F2F2F2"><tr>
<td style="padding: 10px;">
                    <table>
<tr>
<td><p style="line-height: 20pt; margin-bottom: 20px; color: #808080;"><b style="font-weight: 600;">EVENT NAME: </b><br>'.$result[0][0]['EVENTNAME'].'</p></td>
</tr>
<tr>
<td><p style="line-height: 20pt; margin-bottom: 20px; color: #808080;"><b style="font-weight: 600;">ORDER NUMBER: </b><br>'.$orderId.'</p></td>
                            <td style="padding-left: 60px"><p style="line-height: 20pt; margin-bottom: 20px; color: #808080;"><b style="font-weight: 600;">PURCHASE DATE: </b><br>'.$result[0][0]['TIMEOFPURCHASE'].'</p></td>
                        </tr>
</table>
<table class="tickets" style="width: 100%; text-align: left;">

<tr>



<th style="border-bottom-style: solid; border-bottom-color: #cccccc; border-bottom-width: 1px; border-top-style: solid; border-top-color: #cccccc; border-top-width: 1px;"><p style="line-height: 20pt; color: #808080; margin: 0;"><b style="font-weight: 600;">TICKET TYPE</b></p></th>
                            <th style="border-bottom-style: solid; border-bottom-color: #cccccc; border-bottom-width: 1px; border-top-style: solid; border-top-color: #cccccc; border-top-width: 1px;"><p style="line-height: 20pt; color: #808080; margin: 0;"><b style="font-weight: 600;">QUANTITY</b></p></th>
                            <th style="border-bottom-style: solid; border-bottom-color: #cccccc; border-bottom-width: 1px; border-top-style: solid; border-top-color: #cccccc; border-top-width: 1px;"><p style="line-height: 20pt; color: #808080; margin: 0;"><b style="font-weight: 600;">PRICE</b></p></th>
                        </tr>
<!--START OF TICKETS-->
';
    $costOfTicket = 0;
    $totalCostOfTickets = 0;

    foreach ($obj as $ticketObj) {

        $ticket = json_decode($ticketObj, true);
        $ticketQuan = $ticket['TICKETQUANTITY'];
        $ticketPrice = $ticket['TICKETPRICE'];
        $ticketTypeName = $ticket['TICKETTYPENAME'];

        $costOfTicket = $ticketPrice*$ticketQuan;

        $mail->Body .= '
       <tr>
       <td style = "padding: 5px 0;" ><p style = "line-height: 20pt; color: #808080; margin: 0;" >'.$ticketTypeName.'</p ></td >
                            <td style = "padding: 5px 0;" ><p style = "line-height: 20pt; color: #808080; margin: 0;" >'.$ticketQuan.'</p ></td >
                            <td style = "padding: 5px 0;" ><p style = "line-height: 20pt; color: #808080; margin: 0;" >BD '.$costOfTicket.'</p ></td >
       </tr >';

        $totalCostOfTickets += $costOfTicket;
    }

    $mail->Body .= '
<!--END OF TICKET LIST--><tr style="border-top-width: 1px; border-top-color: #cccccc; border-top-style: solid;">
<td style="padding: 5px 0;"></td>
                            <td style="padding: 5px 0;"></td>
                            <td style="padding: 5px 0;"><p style="color: #2B60A0; line-height: 20pt; margin: 0;"><b style="font-weight: 600;">BD '.$totalCostOfTickets.'</b></p></td>
                        </tr>
</table>
</td>
            </tr></table>
</td>
  </tr>
</table>
<table class="main_body" style="display: block; border-radius: 5px !important; box-shadow: 0px 1px 2px 0px rgba(204,204,204,0.50); overflow: hidden; clear: both; margin: 10px; border: 1px solid #cccccc;"><tr>
<td class="content" style="background: #ffffff; padding: 20px;" bgcolor="#ffffff">
            <h1 style="font-size: 2em; font-weight: 300; margin-bottom: 20px;">About the event</h1>


            <table class="logistics" style="float: left; clear: both;">
<tr>
<td><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/location.png" style="float: left; height: 24px; width: 24px; margin-right: 20px;" align="left"></td>
                    <td><p style="line-height: 20pt; margin-bottom: 20px; color: #808080;">'.$result[0][0]['EVENTLOCATION'].'</p></td>
                </tr>
<tr>
<td><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/date.png" style="float: left; height: 24px; width: 24px; margin-right: 20px;" align="left"></td>
                    <td><p style="line-height: 20pt; margin-bottom: 20px; color: #808080;">'.$result[0][0]['STARTDATETIME'].' - '.$result[0][0]['ENDTIME'].'</p></td>
                </tr>
<tr>
<td><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/link.png" style="float: left; height: 24px; width: 24px; margin-right: 20px;" align="left"></td>
                    <td><p style="line-height: 20pt; margin-bottom: 20px; color: #808080;"><a href="http://vitee.net/event/'.$result[0][0]['EVENTID'].'/'.$result[0][0]['EVENTNAME'].'" target="_blank">http://vitee.net/event/'.$result[0][0]['EVENTID'].'/'.$result[0][0]['EVENTNAME'].'</a></p></td>
                </tr>
</table>
</td>
    </tr></table>
<table class="main_body" style="display: block; border-radius: 5px !important; box-shadow: 0px 1px 2px 0px rgba(204,204,204,0.50); overflow: hidden; clear: both; margin: 10px; border: 1px solid #cccccc;"><tr>
<td class="content" style="background: #ffffff; padding: 20px;" bgcolor="#ffffff">
            <img class="phones" src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/phones.png" style="float: left; height: 208px; width: 152px; margin-right: 20px;" align="left"><h1 style="font-size: 2em; font-weight: 300; margin-bottom: 20px;">On the move!</h1>
            <p style="line-height: 20pt; margin-bottom: 20px; color: #808080;">Don"t have a printer? Download our app now and take your ticket with you!</p>
            <ul class="download" style="list-style-type:none">
<li style="float: left; margin-right: 10px;"><a target="_blank" href="https://play.google.com/store/apps/details?id=com.vt"><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/googleplay.png" alt="Download for Android"></a></li>
                <li style="float: left; margin-right: 10px;"><a target="_blank" href="https://itunes.apple.com/us/app/vitee/id1034390761?mt=8"><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/appstore.png" alt="Download for iPhone"></a></li>
            </ul>
</td>
    </tr></table>
<table class="footer" style="display: block; margin: 0 auto;">
<tr class="social">
<td>
        <ul style="width: 90px; height: 25px; margin: 0 auto; list-style-type:none">
<li style="float: left; margin: 10px;"><a href="http://fb.com/vitee.net" target="_blank" style="color: #f47932 !important; text-decoration: none;"><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/FB.png" alt="Facebook"></a></li>
            <li style="float: left; margin: 10px;"><a href="http://instagram.com/vitee.me" target="_blank" style="color: #f47932 !important; text-decoration: none;"><img src="https://s3.eu-central-1.amazonaws.com/vitee-media/img/emailPDFIcons/INSTA.png" alt="Instagram"></a></li>
        </ul>
</td>
  </tr>
<tr>
<td class="infomation">
        <p style="line-height: 20pt; margin-bottom: 20px; color: #808080;">Need help? You can contact us at <a href="mailto:contact@vitee.net?Subject=Help" style="color: #f47932 !important; text-decoration: none;">contact@vitee.net</a><br><span style="color: #B3B3B3;">Copyright © 2016 Vitee, W.L.L. All rights reserved.</span></p>
    </td>
  </tr>
</table>
</td></tr></table>
<!-- CONTAINER -->
</body>
</html>



                    ';

    $check = $mail->Send();
    delete_directory('../../../TicketPDF/' . $result[0][0]['USERID']);

    if(!$check) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
        exit;
    } else {
        echo 'Message has been sent.';
        $response["success"] = 0;
        $response["message"] = "Sent";
        echo json_encode($response);
        exit;
    }

}

function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
?>