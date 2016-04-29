<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Vit_eventtype;
use App\Model\Vit_tickettype;
use App\Model\Vit_event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;


class InsightsController extends Controller {


    private $event_id,$tickettype_id;
	public $gender= null;

/*
	 
--------------------------------------------------------
PIE CHART

Query definition:

SELECT count(vit_userattending.USERID) as count, USERGENDER, EVENTNAME FROM `vit_userattending` 
INNER JOIN vit_user ON vit_userattending.USERID = vit_user.USERID INNER JOIN vit_event ON vit_userattending.EVENTID = vit_event.EVENTID
WHERE vit_userattending.EVENTID='6' GROUP BY USERGENDER
--------------------------------------------------------
LINE GRAPH

Query definition: display the number of tickets purchased for a tickettype at a given date for a particular event
 
SELECT vit_event.EVENTNAME, DATE(TIMEOFPURCHASE), vit_tickettype.TICKETTYPENAME, vit_ticket_purchased.TICKETTYPEID, count(TICKETID) as count FROM vit_ticket_purchased INNER JOIN 
vit_tickettype ON vit_tickettype.TICKETTYPEID = vit_ticket_purchased.TICKETTYPEID INNER JOIN vit_event ON vit_event.EVENTID = vit_tickettype.EVENTID WHERE 
vit_event.EVENTNAME = 'Yeti #3 China' GROUP BY DATE(TIMEOFPURCHASE), vit_ticket_purchased.TICKETTYPEID
--------------------------------------------------------

QUERY STATISTICS

Query Definition:  total attending for an event

SELECT COUNT(vit_userattending.USERID) as TOTALATTENDING FROM vit_userattending INNER JOIN 
vit_event ON vit_userattending.EVENTID = vit_event.EVENTID WHERE vit_event.EVENTID = 9


Query Definition:  total tickets sold for an event

SELECT IFNULL(SUM(`TICKETTOTAL`-`TICKETREMAINING`),0) as TOTALTICKETSSOLD FROM vit_tickettype INNER JOIN 
vit_event ON vit_event.EVENTID = vit_tickettype.EVENTID WHERE vit_event.EVENTID = 20


Query Definition:  total ticket type sold for an event

SELECT TICKETTYPENAME,SUM(`TICKETTOTAL`-`TICKETREMAINING`) FROM vit_tickettype INNER JOIN vit_event 
ON vit_event.EVENTID = vit_tickettype.EVENTID WHERE vit_tickettype.EVENTID = 5 GROUP BY TICKETTYPENAME


Query Definition: display different age groups

SELECT SUM(AGE <= 17), SUM(AGE BETWEEN 18 and 24), SUM(AGE BETWEEN 25 and 34), SUM(AGE BETWEEN 35 and 44), SUM(AGE BETWEEN 45 and 54),  
SUM(AGE BETWEEN 55 and 64),  SUM(AGE >= 65) FROM ( SELECT YEAR(CURDATE()) - YEAR(DOFB) - (RIGHT(CURDATE(),5)<RIGHT(DOFB,5)) as AGE FROM vit_user ) as AGE
 
*/


// public function get_tickettypes()
// {

// $types= Vit_eventtype::all();
// $i=0;
// $newArray= array();

// foreach ($types as $type)
// {

// $Ttype=$type->TICKETTYPENAME;

// $newArray[$i]=$Ttype;
// $i++;


// }
// return view('insights')->with('Ttype',$newArray);


// }
public function getcharts($id)

{

//$tickettype = Input::get('ticketType');

//var_dump($tickettype);

$tickettype=$_POST['tickettype'];
 //var_dump($tickettype);

$td = \DB::table('vit_ticket_purchased')
			->groupBy('vit_ticket_purchased.TICKETTYPEID',\DB::raw('DATE(TIMEOFPURCHASE)'))
			->where('vit_tickettype.TICKETTYPENAME', '=', $tickettype)
			->where('vit_event.EVENTID', '=', $id)
            ->join('vit_tickettype', 'vit_tickettype.TICKETTYPEID', '=', 'vit_ticket_purchased.TICKETTYPEID')
            ->join('vit_event', 'vit_event.EVENTID', '=', 'vit_tickettype.EVENTID')
            ->select(\DB::raw('DATE(vit_tickettype.TICKETSTARTSALES) as STARTSALES,DATE(TICKETENDSALES) as ENDSALES, vit_event.EVENTNAME, DATE(TIMEOFPURCHASE) as TOP, vit_tickettype.TICKETTYPENAME, vit_ticket_purchased.TICKETTYPEID, count(TICKETID) as TICKETCOUNT'))			
            ->get();
			
$totalTicketTypeSold = \DB::table('vit_tickettype')	
						->where('vit_tickettype.TICKETTYPENAME', '=', $tickettype)
						->where('vit_event.EVENTID', '=', $id)
						->join('vit_event', 'vit_event.EVENTID','=','vit_tickettype.EVENTID')
						->select(\DB::raw('SUM(TICKETTOTAL-TICKETREMAINING) as TOTALTICKETTYPESALES'))
						->get();			

$response = array('val'=>$td, 'totalTypeSales' => $totalTicketTypeSold);
return Response::json($response);

}


	public function index($id)
		 
	
	{
	
	
		
		$tickettype = new Vit_tickettype;

		

			
		
		
		

	
	$getTicketName = \DB::table('vit_tickettype')	
					->where('EVENTID','=',$id)
					->select(\DB::raw('TICKETTYPENAME'))
					->get();
	
	
	
	
	
	

$i=0;
$newArray= array();

foreach ($getTicketName as $type)
{

$Ttype=$type->TICKETTYPENAME;
$newArray[$i]=$Ttype;
$i++;


}
	
	
	$nodata =0;

	
	//$e_id = Vit_event::find($id);
	
	
	$male = \DB::table('vit_userattending')
			->where('USERGENDER', '=',  'male')
			->where('vit_userattending.EVENTID', '=',  $id)
            ->join('vit_user', 'vit_userattending.USERID', '=', 'vit_user.USERID')
            ->join('vit_event', 'vit_userattending.EVENTID', '=', 'vit_event.EVENTID')
            ->select(\DB::raw('count(vit_userattending.USERID) as GENDERCOUNT,USERGENDER, EVENTNAME'))			
            ->get();
			
	$female = \DB::table('vit_userattending')
			->where('USERGENDER', '=',  'female')
			->where('vit_userattending.EVENTID', '=',  $id)
            ->join('vit_user', 'vit_userattending.USERID', '=', 'vit_user.USERID')
            ->join('vit_event', 'vit_userattending.EVENTID', '=', 'vit_event.EVENTID')
            ->select(\DB::raw('count(vit_userattending.USERID) as GENDERCOUNT,USERGENDER, EVENTNAME'))			
            ->get();
			


$ageGroup = \DB::select('SELECT SUM(AGE <= 17) as under17, SUM(AGE BETWEEN 18 and 24) as and1824, SUM(AGE BETWEEN 25 and 34) as and2534, SUM(AGE BETWEEN 35 and 44) as and3544, SUM(AGE BETWEEN 45 and 54) as and4554,  
			SUM(AGE BETWEEN 55 and 64) as and5564,  SUM(AGE >= 65) as over65 FROM ( SELECT YEAR(CURDATE()) - YEAR(DOFB) - (RIGHT(CURDATE(),5)<RIGHT(DOFB,5)) as AGE FROM vit_user ) as AGE');			
			
		
	
			
	$td = \DB::table('vit_ticket_purchased')
			->groupBy('vit_ticket_purchased.TICKETTYPEID',\DB::raw('DATE(TIMEOFPURCHASE)'))
			->where('vit_event.EVENTID', '=', $id)
            ->join('vit_tickettype', 'vit_tickettype.TICKETTYPEID', '=', 'vit_ticket_purchased.TICKETTYPEID')
            ->join('vit_event', 'vit_event.EVENTID', '=', 'vit_tickettype.EVENTID')
            ->select(\DB::raw('DATE(TICKETSTARTSALES) as STARTSALES,DATE(TICKETENDSALES) as ENDSALES, vit_event.EVENTNAME, DATE(TIMEOFPURCHASE) as TOP, vit_tickettype.TICKETTYPENAME, vit_ticket_purchased.TICKETTYPEID, count(TICKETID) as TICKETCOUNT'))			
            ->get();
			
	$totalAttending = 	\DB::table('vit_userattending')	
						->where('vit_event.EVENTID', '=', $id)
						->join('vit_event', 'vit_userattending.EVENTID', '=', 'vit_event.EVENTID')
						->select(\DB::raw('count(vit_userattending.USERID) as TOTALATTENDING'))
						->get();
	
	
	$totalTicketsSold = \DB::table('vit_tickettype')	
						->where('vit_event.EVENTID', '=', $id)
						->join('vit_event', 'vit_event.EVENTID', '=', 'vit_tickettype.EVENTID')
						->select(\DB::raw('IFNULL(SUM(TICKETTOTAL-TICKETREMAINING),0) as TOTALTICKETSSOLD'))
						->get();
						
	
			
			
	
	
	$values = [];
	
	
	
	$values[0] = "/images/No_graph_available.PNG";
	
	$values[1] = "";
	$values[2] = $td;
	$values[3] = $totalAttending;
	$values[4] = $totalTicketsSold;
	$values[5] = $male;
	$values[6] = $female;
	$values[7] = $ageGroup;
	
		
			
		return view('insights')->with('values',$values)->with('Ttype',$newArray)->with('eventId',$id);
			
		
		
		
		
	
		
	}


 
 

}
