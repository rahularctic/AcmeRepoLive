<?php namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

//use Intervention\Image\Facades\Image;
use Validator;
use Redirect;
use Session;
use DB;
use Illuminate\Support\Facades\Input;

use Response;

use App\Model\Vit_eventtype;
use App\Http\Requests\RequestVal;
use App\Model\Vit_tickettype;

use Intervention\Image\Facades\Image;



class EventsController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }


    private $event_id;


    public $last_event;


    /**
     * Display a listing of the resource.
     *
     * @return Upcomming Events and Live Events
     */
    public function index()
    {

        $now = Carbon::now();


        $upcoming_events = \DB::table('VIT_EVENT')->where('USERID', '=', \Auth::id())->where('EVENTSTART', '>', $now)->get();

        $live_events = \DB::table('VIT_EVENT')->where('USERID', '=', \Auth::id())->where('EVENTSTART', '<', $now)->where('EVENTEND', '>', $now)->get();


        $old_events = \DB::table('VIT_EVENT')
            ->select('VIT_EVENT.EVENTID', 'VIT_EVENT.USERID', 'VIT_EVENT.EVENTTYPEID', 'VIT_EVENT.EVENTNAME', 'VIT_EVENT.EVENTSTART', 'VIT_EVENT.EVENTEND', 'VIT_EVENT.EVENTDESCRIPTION', 'VIT_EVENT.EVENTLOCATION', 'VIT_EVENT.EVENTLATITUDE', 'VIT_EVENT.EVENTLONGITUDE', 'VIT_EVENT.EVENTPAID', 'VIT_EVENT.EVENTPRIVACY', \DB::raw('COUNT(VIT_USERATTENDING.USERID) as Attendees'))
            ->where('VIT_EVENT.EVENTEND', '<', $now)
            ->where('VIT_EVENT.USERID', '=', \Auth::id())
            ->leftJoin('VIT_USERATTENDING', 'VIT_EVENT.EVENTID', '=', 'VIT_USERATTENDING.EVENTID')
            ->groupBy('VIT_EVENT.EVENTID')
            ->get();


        return view('event.events')->with('old_events', $old_events)->with('upcoming_events', $upcoming_events)->with('live_events',$live_events);
    }


    /**
     *          Show Event Information
     *
     * @param $id - event ID
     * @return event information
     */

    public function show($id)
    {
        //

        $event = Event::find($id);

        $this->event_id = $id;

        $attendees = \DB::table('VIT_USERATTENDING')
            ->join('VIT_USER', function ($join) {
                $join->on('VIT_USERATTENDING.USERID', '=', 'VIT_USER.USERID')
                    ->where('VIT_USERATTENDING.EVENTID', '=', $this->event_id);
            })
            ->select('VIT_USERATTENDING.USERID', 'VIT_USER.USERNAME')
            ->get();

        //GET LIST OF TICKETS TYPE

        $tickets = \DB::table('VIT_TICKETTYPE')->select('*')->where('EVENTID', $id)->get();

        //GET NUMBER OF TICKET SOLD

        $totalTicketsSold = \DB::table('VIT_TICKETTYPE')
            ->where('VIT_EVENT.EVENTID', '=', $id)
            ->join('VIT_EVENT', 'VIT_EVENT.EVENTID', '=', 'VIT_TICKETTYPE.EVENTID')
            ->select(\DB::raw('IFNULL(SUM(TICKETTOTAL-(TICKETREMAINING+TICKETRESERVED)),0) as TOTALTICKETSSOLD, SUM(TICKETTOTAL) as TICKETTOTAL'))
            ->get();

        $imagesPath = '/img/event/'.$id .'/header/';


        $images = [];

       // $gallery = \Storage::disk('s3')->files($imagesPath);

        $gallery = \Storage::disk('local')->files($imagesPath);

        foreach ($gallery as $image) {
            $images[] = pathinfo($image);
        }


        //Get MALE/ FEMAL  GENDER STATI

        $male = \DB::table('VIT_USERATTENDING')
            ->where('USERGENDER', '=', 'male')
            ->where('VIT_USERATTENDING.EVENTID', '=', $id)
            ->join('VIT_USER', 'VIT_USERATTENDING.USERID', '=', 'VIT_USER.USERID')
            ->join('VIT_EVENT', 'VIT_USERATTENDING.EVENTID', '=', 'VIT_EVENT.EVENTID')
            ->select(\DB::raw('count(VIT_USERATTENDING.USERID) as GENDERCOUNT,USERGENDER, EVENTNAME'))
            ->get();

        $female = \DB::table('VIT_USERATTENDING')
            ->where('USERGENDER', '=', 'female')
            ->where('VIT_USERATTENDING.EVENTID', '=', $id)
            ->join('VIT_USER', 'VIT_USERATTENDING.USERID', '=', 'VIT_USER.USERID')
            ->join('VIT_EVENT', 'VIT_USERATTENDING.EVENTID', '=', 'VIT_EVENT.EVENTID')
            ->select(\DB::raw('count(VIT_USERATTENDING.USERID) as GENDERCOUNT,USERGENDER, EVENTNAME'))
            ->get();

        //GET AGE GROUP


        $ageGroup = \DB::select('SELECT SUM(AGE <= 17) as under17, SUM(AGE BETWEEN 18 and 24) as and1824, SUM(AGE BETWEEN 25 and 34) as and2534, SUM(AGE BETWEEN 35 and 44) as and3544, SUM(AGE BETWEEN 45 and 54) as and4554,
			SUM(AGE BETWEEN 55 and 64) as and5564,  SUM(AGE >= 65) as over65 FROM ( SELECT YEAR(CURDATE()) - YEAR(DOB) - (RIGHT(CURDATE(),5)<RIGHT(DOB,5)) as AGE FROM VIT_USER  JOIN VIT_USERATTENDING ON VIT_USER.USERID = VIT_USERATTENDING.USERID WHERE VIT_USERATTENDING.EVENTID = ?  ) as AGE', array($id));


        $j = 0;
        $ticketT = [];

        foreach ($tickets as $ticket) {

            $ticketT[$j] = $ticket->TICKETTYPENAME;
            $j++;
        }


        $values = [];


        $values[0] = $ticketT;
        $values[1] = '';
        $values[2] = '';
        $values[3] = '';
        $values[4] = '';
        $values[5] = $male;
        $values[6] = $female;
        $values[7] = $ageGroup;

        return view('event.event')->with('event', $event)->with('attendees', $attendees)->with('tickets', $tickets)->with('images', $images)->with('totalTicketsSold', $totalTicketsSold)->with('values', $values);

        //end if
    }



    /**
     *                          GET CHARTS for an Event
     * @param $id - Event ID
     * @return \Symfony\Component\HttpFoundation\Response - Charts of an event
     */

    public function getChart($id)
    {

        //$tickettype = Input::get('ticketType');

//var_dump($tickettype);

        $tickettype = $_POST['tickettype'];
        //var_dump($tickettype);

        $td = \DB::table('VIT_TICKET_PURCHASED')
            ->groupBy('VIT_TICKET_PURCHASED.TICKETTYPEID', \DB::raw('DATE(TIMEOFPURCHASE)'))
            ->where('VIT_TICKETTYPE.TICKETTYPENAME', '=', $tickettype)
            ->where('VIT_EVENT.EVENTID', '=', $id)
            ->join('VIT_TICKETTYPE', 'VIT_TICKETTYPE.TICKETTYPEID', '=', 'VIT_TICKET_PURCHASED.TICKETTYPEID')
            ->join('VIT_EVENT', 'VIT_EVENT.EVENTID', '=', 'VIT_TICKETTYPE.EVENTID')
            ->select(\DB::raw('DATE(VIT_TICKETTYPE.TICKETSTARTSALES) as TICKETSTARTSALES,DATE(TICKETENDSALES) as TICKETENDSALES, VIT_EVENT.EVENTNAME, DATE(TIMEOFPURCHASE) as TOP, VIT_TICKETTYPE.TICKETTYPENAME, VIT_TICKET_PURCHASED.TICKETTYPEID, count(TICKETID) as TICKETCOUNT'))
            ->get();

        $totalTicketTypeSold = \DB::table('VIT_TICKETTYPE')
            ->where('VIT_TICKETTYPE.TICKETTYPENAME', '=', $tickettype)
            ->where('VIT_EVENT.EVENTID', '=', $id)
            ->join('VIT_EVENT', 'VIT_EVENT.EVENTID', '=', 'VIT_TICKETTYPE.EVENTID')
            ->select(\DB::raw('SUM(TICKETTOTAL-(TICKETREMAINING+TICKETRESERVED)) as TOTALTICKETTYPESALES, TICKETTYPENAME, TICKETTOTAL as TICKETTYPETOTAL'))
            ->get();

        $response = array('val' => $td, 'totalTypeSales' => $totalTicketTypeSold);
        return Response::json($response);
    }

    //DETLETE TICKET

    /**
     *
     *   Delete an EVent Ticket
     * @return mixed
     */

    public function deleteTicket()
    {



        $ticket = new VIT_TICKETTYPE();
        $id = $_POST['ticketid'];
        $ticket = VIT_TICKETTYPE::find($id);
        $ticket->delete();
        return $id;
    }


    public function NewEventForm(){

        $types = Vit_eventtype::all();

        $newArray = array();

        foreach ($types as $type) {

            $t_id = $type->EVENTTYPEID;
            $t_name = $type->EVENTTYPENAME;

            $newArray[$t_id] = $t_name;

        }

        return view('event.CreateNewEvent')->with('title', 'Add New Event')->with('eventType', $newArray);
    }


    /**
     *          SHOW EVENT DETAILS WHILE UPDATING AN EVENT
     * @param $id - Event ID
     * @return $this - Event information
     */

    public function showUpdate($id){
    
    
        //GETTING EVENT TYPES TO TEXTAREA
        $types = Vit_eventtype::all();
        $ticket = new VIT_TICKETTYPE();
        $newArray = array();

        foreach ($types as $type) {

            $t_id = $type->EVENTTYPEID;
            $t_name = $type->EVENTTYPENAME;
            $newArray[$t_id] = $t_name;

        }





        // GETTING THE EVENTINFORMATION
        $eventdata = array();
        $eventdata = DB::table('VIT_EVENT')->where('EVENTID', $id)->get();

        $eventdata[0]->EVENTSTART = $eventdata[0]->EVENTSTART;
        $eventdata[0]->EVENTEND =  $eventdata[0]->EVENTEND;

        //GETTING TICKETS

        $ticketdata = array();
        $ticketdata = DB::table('VIT_TICKETTYPE')->where('EVENTID', $id)->get();


        $ticketnumber = DB::table('VIT_TICKETTYPE')->where('EVENTID', $id)->count();

        for ($i = 0; $i < $ticketnumber; $i++) {
            $ticketdata[$i]->TICKETSTARTSALES = substr($ticketdata[$i]->TICKETSTARTSALES, 0, 16);
            $ticketdata[$i]->TICKETENDSALES = substr($ticketdata[$i]->TICKETENDSALES, 0, 16);


        }




        //TODO check if iamges exist in S3 bucket

        //GETTING IMAGES

        $imagePath = '/img/event/'.$id.'/thumbnails/';

        $images = [];


        //$imageFilename = \DB::table('VIT_EVENT')->where('EVENTID',$id)->pluck('EVENTIMAGE');

        $mainImagePath = $imagePath.$eventdata[0]->EVENTIMAGE;

        if(\Storage::disk('s3')->exists($mainImagePath)){

            $mainImage =   pathinfo($mainImagePath);


        } else{


            $mainImage = pathinfo('img/event/default.jpg');

        }



        $gallery = \Storage::disk('s3')->allFiles($imagePath);

        foreach ($gallery as $image){

            $images[] = pathinfo($image);

        }



return view('event.UpdateEvent')->with('EventData', $eventdata)->with('eventType', $newArray)->with('tickets', $ticketdata)->with('nbtickets',$ticketnumber)->with('images',$images)->with('image',$mainImage);

    }





    /**
     *
     *              UPDATE EVENT AND TICKET
     * @param $id - EventID
     * @param Request $request
     * @return Redirect - redirect to the event page
     */

    public function update($id,Request $request)
    {

  
        $s = substr(Input::get('StartEndTime'), 0,16);
	$e = $endtime = substr(Input::get('StartEndTime'), 19, 34);
	
        $event = new Event;

        $event->EVENTNAME = Input::get('eventName');
        $event->EVENTDESCRIPTION = Input::get('eventDesc');
        $event->EVENTLOCATION = Input::get('eventLocation');
        $event->EVENTTYPEID = Input::get('eventType');
        $event->EVENTLATITUDE = Input::get('lat');
        $event->EVENTLONGITUDE = Input::get('lng');


        $var = Input::get('eventPrivacy');
        $var2 = Input::get('eventpaid');
        
         $event->EVENTSTART = $s;
         $event->EVENTEND = $e;

        if ($var == NULL) {
            $event->EVENTPRIVACY = 0;
        } else {
            $event->EVENTPRIVACY = 1;
        }
        if ($var2 == NULL) {
            $event->EVENTPAID = 0;
        } else {
            $event->EVENTPAID = 1;
        }

        $d = array('EVENTNAME' => $event->EVENTNAME,
            'EVENTSTART' => $event->EVENTSTART,"EVENTTYPEID" => $event->EVENTTYPEID,
            "EVENTDESCRIPTION" => $event->EVENTDESCRIPTION, "EVENTLOCATION" => $event->EVENTLOCATION, "EVENTEND" => $event->EVENTEND,
            "EVENTLATITUDE" => $event->EVENTLATITUDE, "EVENTLONGITUDE" => $event->EVENTLONGITUDE,
            "EVENTPRIVACY" => $event->EVENTPRIVACY, "EVENTPAID" => $event->EVENTPAID

        );

        DB::table('VIT_EVENT')
            ->where('EVENTID', $id)
            ->update($d);

        // Update Ticket Info

        $ticket = new VIT_TICKETTYPE();
        $input = Input::all();
        $data = [];

        for ($i = 0; $i <= (Input::get('ticketsnumber')); $i++) {

            if (Input::get('ticketname' . $i) != null) {
                $ticket->EVENTID = $id;
                $ticket->TICKETCUID = "1";
                $ticket->TICKETTYPENAME = Input::get('ticketname' . $i);
                $ticket->TICKETTYPEDESCRIPTION = Input::get('ticketdesc' . $i);
                $ticket->TICKETPRICE = Input::get('ticketprice' . $i);
                $ticket->TICKETMIN = Input::get('ticketmin' . $i);
                $ticket->TICKETMAX = Input::get('ticketmax' . $i);
                $ticket->TICKETSTARTSALES = substr(Input::get('TicketStartEndTime' . $i), 0, 16);
                $ticket->TICKETENDSALES = substr(Input::get('TicketStartEndTime' . $i), 21, 34);
                $ticket->TICKETTOTAL = Input::get('ticketqte' . $i);
                $ticket->TICKETREMAINING = Input::get('ticketqte' . $i);

                $tick = array('EVENTID' => $ticket->EVENTID, 'TICKETTYPENAME' => $ticket->TICKETTYPENAME,
                    'TICKETTYPEDESCRIPTION' => $ticket->TICKETTYPEDESCRIPTION, "TICKETPRICE" => $ticket->TICKETPRICE,
                    "TICKETMIN" => $ticket->TICKETMIN, "TICKETMAX" => $ticket->TICKETMAX, "TICKETSTARTSALES" => $ticket->TICKETSTARTSALES,
                    "TICKETENDSALES" => $ticket->TICKETENDSALES, "TICKETTOTAL" => $ticket->TICKETTOTAL, "TICKETREMAINING" => $ticket->TICKETREMAINING

                );

                DB::table('VIT_TICKETTYPE')
                    ->where('TICKETTYPEID', Input::get('ticketid' . $i))
                    ->update($tick);

            }
        }

       $this->UpdateMedia($id,$request);

        \Session::flash('update_event', 'Event Has Been Updated  ! ');

        return redirect('dashboard/event/' . $id);


    }
    




    /**
     *          Get list of categories
     *
     * @return $this - list of event categories
     */
    public function get_new()
    {
   

        $types = Vit_eventtype::all();

        $newArray = array();

        foreach ($types as $type) {

            $t_id = $type->EVENTTYPEID;
            $t_name = $type->EVENTTYPENAME;

            $newArray[$t_id] = $t_name;

        }

        return view('event.CreateEvent')->with('title', 'Add New Event')->with('eventType', $newArray);

    }



    /**
     *        Creating New  Event form
     *
     * @return mixed
     */
    public function create_event_simple()
    {

	$s = substr(Input::get('StartEndTime'), 0,16);
	$e = $endtime = substr(Input::get('StartEndTime'), 19, 34);
	
	/*

        $startdate = substr(Input::get('StartEndTime'), 0,10);
        $starttime = substr(Input::get('StartEndTime'), 11, 15);
        $enddate = substr(Input::get('StartEndTime'), 19, 28);
        $endtime = substr(Input::get('StartEndTime'), 30, 34);

	*/

        $event = new Event;

        $event->EVENTNAME = Input::get('eventName');
        $event->EVENTDESCRIPTION = Input::get('eventDesc');
        $event->EVENTLOCATION = Input::get('eventLocation');
        $event->EVENTTYPEID = Input::get('eventType');
        $event->EVENTLATITUDE = Input::get('lat');
        $event->EVENTLONGITUDE = Input::get('lng');


        $var = Input::get('eventPrivacy');
        $var2 = Input::get('eventpaid');

	    $event->EVENTSTART = $s;
	    $event->EVENTEND = $e;
	
	

        if ($var == NULL) {
            $event->EVENTPRIVACY = 0;
        } else {
            $event->EVENTPRIVACY = 1;
        }
        if ($var2 == NULL) {
            $event->EVENTPAID = 0;
        } else {
            $event->EVENTPAID = 1;
        }

        $event->USERID = \Auth::id();
        
       // dd($event);

        $event->save();

        $this->last_event = $event->EVENTID;

        return $event->EVENTID;

    }


    /**
     *          Create New Ticket
     *
     * @param $last_event - the id of the created event
     */
    public function create_ticket_simple($last_event)
    {


        $ticket = new Vit_tickettype();
        $event = new Event();
        $input = Input::all();
        $data = [];

        for ($i = 1; $i <= (Input::get('ticketsnumber')); $i++) {

            if (Input::get('ticketname' . $i) != null) {
                $ticket->EVENTID = $last_event;
                $ticket->TICKETCUID = "1";
                $ticket->TICKETTYPENAME = Input::get('ticketname' . $i);
                $ticket->TICKETTYPEDESCRIPTION = Input::get('ticketdesc' . $i);
                $ticket->TICKETPRICE = Input::get('ticketprice' . $i);
                $ticket->TICKETMIN = Input::get('ticketmin' . $i);
                $ticket->TICKETMAX = Input::get('ticketmax' . $i);
                $ticket->TICKETSTARTSALES = substr(Input::get('TicketStartEndTime' . $i), 0, 16);
                $ticket->TICKETENDSALES = substr(Input::get('TicketStartEndTime' . $i), 21, 34);
                $ticket->TICKETTOTAL = Input::get('ticketqte' . $i);
                $ticket->TICKETREMAINING = Input::get('ticketqte' . $i);

                $d = array('EVENTID' => $ticket->EVENTID, 'TICKETTYPENAME' => $ticket->TICKETTYPENAME,
                    'TICKETTYPEDESCRIPTION' => $ticket->TICKETTYPEDESCRIPTION, "TICKETPRICE" => $ticket->TICKETPRICE,
                    "TICKETMIN" => $ticket->TICKETMIN, "TICKETMAX" => $ticket->TICKETMAX, "TICKETSTARTSALES" => $ticket->TICKETSTARTSALES,
                    "TICKETENDSALES" => $ticket->TICKETENDSALES, "TICKETTOTAL" => $ticket->TICKETTOTAL, "TICKETREMAINING" => $ticket->TICKETREMAINING

                );
                //array_push($data,$ticket);

                // $data[$i] = $ticket;
                VIT_TICKETTYPE::insert($d);
            }
        }


    }




    /**
    ***  Upload Images
    **/

    public function UploadMedia($eventID,Request $request)
    {
        $destinationPathEventImg =  'img/event/'.$eventID.'/';

        $i = 1;


        foreach ($request->file('files') as $image) {


            if (is_object($image) && ($image != null)) {


                $fileName =   Carbon::now()->getTimestamp().rand(111, 999).".jpeg";


                $mainImage = Image::make($image)->encode('jpeg',100)->save();
                $thumbImage = Image::make($image)->encode('jpeg',100)->widen(300)->save();
                if($mainImage->width() > 1080){
                $headerImage = Image::make($image)->encode('jpeg',100)->widen(1080)->save();
                }else{
                    $headerImage = $mainImage;
                }

                \Storage::disk('s3')->put($destinationPathEventImg.$fileName, $mainImage, 'public');
                \Storage::disk('s3')->put($destinationPathEventImg.'thumbnails/'.$fileName, $thumbImage, 'public');
                \Storage::disk('s3')->put($destinationPathEventImg.'header/'.$fileName, $headerImage, 'public');

                if( $i == 1 && \Storage::disk('s3')->exists($destinationPathEventImg.$fileName )){

                    \DB::table('VIT_EVENT')->where('EVENTID',$eventID)->update(['EVENTIMAGE' => $fileName]);

                }

            } else {

              $i--;
            }

            $i++;
        }


    }



    /**
     *
     *              DELETE EVENT IMAGES
     *
     * @param $eventID
     * @param $ImageID
     * @return string
     */
    public function deleteMedia($eventID,$ImageID){

        $pathImage = '/img/event/'.$eventID.'/';
        $fileName = $ImageID.'.jpeg';

        $pathHeader = $pathImage."header/";
        $pathThumb = $pathImage."thumbnails/";


        if(\Storage::disk('s3')->exists($pathImage.$fileName) || \Storage::disk('s3')->exists($pathHeader.$fileName) || \Storage::disk('s3')->exists($pathThumb.$fileName)){


            \Storage::disk('s3')->delete([$pathImage.$fileName, $pathHeader.$fileName,$pathThumb.$fileName]);


        }



        return "{}";



    }



    /**
     *                      Update Images - Upadte Images in Gallery
     * @param $eventID
     * @param Request $request
     * @return string - return json = {} - Ajax response
     */
    public function UpdateMedia($eventID, Request $request){

        $destinationPathEventImg = '/img/event/'.$eventID."/";

        // **************************************************************
        // ******************  UPDATE MAIN IMAGE  ***********************
        //***************************************************************


        if($image = Input::file('file') ){

            $fileName =   Carbon::now()->getTimestamp().rand(111, 999).".jpeg";

            if ( \Storage::disk('s3')->exists($destinationPathEventImg.$fileName))
            {
                \Storage::disk('s3')->delete($destinationPathEventImg.$fileName);
                \Storage::disk('s3')->delete($destinationPathEventImg.'thumbnails/'.$fileName);
                \Storage::disk('s3')->delete($destinationPathEventImg.'header/'.$fileName);
            }

            // Image Resizing

            $mainImage = Image::make($image)->encode('jpg',100)->save();
            $thumbImage = Image::make($image)->encode('jpg',100)->widen(300)->save();

            if($mainImage->width() > 1080){
                $headerImage = Image::make($image)->encode('jpeg',100)->widen(1080)->save();
            }else{
                $headerImage = $mainImage;
            }

            \Storage::disk('s3')->put($destinationPathEventImg.$fileName, $mainImage, 'public');
            \Storage::disk('s3')->put($destinationPathEventImg.'thumbnails/'.$fileName, $thumbImage, 'public');
            \Storage::disk('s3')->put($destinationPathEventImg.'header/'.$fileName, $headerImage, 'public');


            // Update the Event Name om the databse

            \DB::table('VIT_EVENT')->where('EVENTID',$eventID)->update(['EVENTIMAGE' => $fileName]);




        }


        // **************************************************************
        // ******************  UPDATE EVENT GALLERY - IMAGES  ***********************
        //***************************************************************


        if(Input::file('files')){

            $existingfiles = \Storage::disk('s3')->allFiles($destinationPathEventImg.'header/');



            if(count($existingfiles) < 5){

                $i = count($existingfiles);


                foreach ($request->file('files') as $file) {


                    if (is_object($file) && ($file != null)) {

                        $fileName =   Carbon::now()->getTimestamp().rand(111, 999).".jpeg";


                        $mainImage = Image::make($file)->encode('jpg',100)->save();
                        $thumbImage = Image::make($file)->encode('jpg',100)->widen(300)->save();

                        if($mainImage->width() > 1080){
                            $headerImage = Image::make($image)->encode('jpeg',100)->widen(1080)->save();
                        }else{
                            $headerImage = $mainImage;
                        }

                        \Storage::disk('s3')->put($destinationPathEventImg.$fileName, $mainImage, 'public');
                        \Storage::disk('s3')->put($destinationPathEventImg.'thumbnails/'.$fileName, $thumbImage, 'public');
                        \Storage::disk('s3')->put($destinationPathEventImg.'header/'.$fileName, $headerImage, 'public');



                    }

                    $i++;

                    // If there are more than 5 pictures don't allow upload (Break the Loop)

                    if ($i > 5)
                        break;

                }//END FOR EACH

            }//END IF
            else{

                //TODO Return response that you cant upload more than 5 images
            }
        }


        return "{}";

        //RETURN EMPTY JSON RESPONSE

    }


    /**
     *      Save Event into DB
     *
     * @param Request $request
     * @return Redirect
     */
    public function createP(Request $request)
    {


        $this->create_ticket_simple($eventID = $this->create_event_simple());
       // $this->UploadMedia($eventID, $request);
        \Session::flash('create_event', 'Event Has Been Created ! ');

        return redirect('dashboard/event/' . $eventID);
        //return Redirect::to('/home')->with('success', "Hooray, things are awesome!");

    }




    /**
     *      Delete an event
     *
     * @param $id - eventID
     * @return \Illuminate\Http\RedirectResponse - Redirection
     */
    public function destroy($id)
    {
    
    

		DB::table('VIT_EVENT')->where('EVENTID', '=', $id)->delete();

                \Session::flash('delete_event', 'Event Has Been Deleted ! ');
					

        return Redirect::to('dashboard/events');


    }


}