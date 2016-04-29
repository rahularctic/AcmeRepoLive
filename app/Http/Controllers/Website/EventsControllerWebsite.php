<?php namespace App\Http\Controllers\Website;

use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use Validator;
use Redirect;
use Session;
use DB;

use Response;
use Input;
use App\Model\Vit_eventtype;
use App\Http\Requests\RequestVal;
use App\Model\Vit_tickettype;

class EventsControllerWebsite extends Controller
{



    public function __construct()
    {
       // $this->middleware('auth');
    }


    private $event_id;


    public $last_event;



    /**
     * @return list of events for the home Page
     */
    public function index()
    {

        $now = Carbon::now();
        

        //GET THE LATEST EVENTS
        $latest_events = \DB::table('VIT_EVENT')
            ->leftJoin('VIT_EVENTTYPE',	'VIT_EVENT.EVENTTYPEID','=','VIT_EVENTTYPE.EVENTTYPEID')
            ->where('VIT_EVENT.EVENTEND', '>', $now)
            ->select(\DB::raw('VIT_EVENT.EVENTID,VIT_EVENT.EVENTNAME,VIT_EVENT.EVENTPAID,VIT_EVENT.EVENTLOCATION,
            DATE_FORMAT(EVENTSTART,"%W, %d %b %Y  %H:%i ") as EVENTSTART,VIT_EVENTTYPE.EVENTTYPENAME,VIT_EVENT.EVENTIMAGE'))
            ->orderBy('VIT_EVENT.CREATED_AT', 'desc')->take(4)->get();


       // return $latest_events;


        /*
         *
         * POPULAR EVENTS
         *
         */
        $pe = \DB::table('VIT_EVENT')
            ->select(\DB::raw('VIT_EVENT.EVENTNAME,count(VIT_USERATTENDING.USERID) as attendees,VIT_EVENT.EVENTPAID,VIT_EVENT.EVENTID,VIT_EVENT.EVENTSTART,VIT_EVENT.EVENTIMAGE'))
            ->join('VIT_USERATTENDING', function($join)
            {
                $now = Carbon::now();
                $join->on('VIT_EVENT.EVENTID', '=', 'VIT_USERATTENDING.EVENTID')
                    ->where('VIT_EVENT.EVENTSTART', '>', $now);
            })
            ->groupBy('VIT_EVENT.EVENTID')
            ->orderBy('attendees','desc')
            ->take(4)
            ->get();
        $popular_events = [];
        if(count($pe) < 4){
            foreach($latest_events as $event){
                $eventArray = (array) $event;
                array_push($eventArray,5);
                array_push($popular_events,$eventArray);
            }
        }else{
            $max = DB::table(\DB::raw('(SELECT count(USERID) as c FROM VIT_USERATTENDING GROUP BY EVENTID) as UA'))
                ->max('UA.c');
            foreach($pe as $event ){
                $eventArray = (array) $event;
                $divider = ($max)/5;
                $rating = ($event->attendees)/$divider;
                array_push($eventArray,$rating);
                array_push($popular_events,$eventArray);
            }
        }



// GET ALL UPCOMMING EVENTS
        $all_events = \DB::table('VIT_EVENT')
            ->leftJoin('VIT_EVENTTYPE',	'VIT_EVENT.EVENTTYPEID','=','VIT_EVENTTYPE.EVENTTYPEID')
            ->where('VIT_EVENT.EVENTEND', '>', $now)
            ->select(\DB::raw('VIT_EVENT.EVENTID,VIT_EVENT.EVENTNAME,
             DATE_FORMAT(VIT_EVENT.EVENTSTART,"%W, %b %d %Y") as STARTDATE,
             DATE_FORMAT(VIT_EVENT.EVENTSTART,"%h:%i %p") as STARTTIME,
             VIT_EVENTTYPE.EVENTTYPENAME,VIT_EVENT.EVENTPAID,VIT_EVENT.EVENTLONGITUDE,VIT_EVENT.EVENTLATITUDE,VIT_EVENT.EVENTLOCATION,VIT_EVENT.EVENTIMAGE'))
            ->orderBy('VIT_EVENT.EVENTSTART')->get();


        /**
         * TODO ADD GENERIC EVENT CATERGORIES
         */


     return view('Vitee_Website_Views.home.home')->with('latest_events', $latest_events)->with('popular_events',$popular_events)->with('all_events',$all_events);
    }


    /**  showEventsOfCategory
     * @param $categoryID - the Category ID of the event
     * @return list of events
     */

    public function showEventsOfCategory($categoryID){

        $now = Carbon::now();


        /**
         * Category Events
         */

        $category_events = \DB::table('VIT_EVENT')
            ->select(\DB::raw('EVENTID,EVENTNAME,EVENTPAID,EVENTLOCATION,DAYOFMONTH(EVENTSTART) as DAYOFMONTH,MONTHNAME(EVENTSTART) as MONTHNAME, DATE_FORMAT(EVENTSTART,"%h:%i %p") as STARTTIME ,DATE_FORMAT(EVENTEND,"%h:%i %p") as ENDTIME,EVENTIMAGE'))
            ->where('VIT_EVENT.EVENTTYPEID',"=",$categoryID)
            ->where('VIT_EVENT.EVENTEND',">",$now)
            ->orderBy('VIT_EVENT.EVENTSTART')
            ->paginate(5);



        /**
         * EVENT TYPES
         */

        $eventCategories = Vit_eventtype::all();


        /*
         *
         * POPULAR EVENTS
         *
         */

        $pe = \DB::table('VIT_EVENT')
            ->join('VIT_USERATTENDING','VIT_EVENT.EVENTID','=','VIT_USERATTENDING.EVENTID')
            ->where('VIT_EVENT.EVENTEND', '>', $now)
            ->select(\DB::raw('VIT_EVENT.EVENTNAME,count(VIT_USERATTENDING.USERID) as attendees,VIT_EVENT.EVENTPAID,VIT_EVENT.EVENTID,VIT_EVENT.EVENTIMAGE'))
            ->groupBy('VIT_EVENT.EVENTID')
            ->orderBy('attendees','desc')
            ->take(4)
            ->get();

        $max = DB::table(\DB::raw('(SELECT count(USERID) as c FROM VIT_USERATTENDING GROUP BY EVENTID) as UA'))
            ->max('UA.c');

        $popular_events = [];

        foreach($pe as $event ){

            $eventArray = (array) $event;

            $divider = ($max)/5;
            $rating = ($event->attendees)/$divider;

            array_push($eventArray,$rating);
            array_push($popular_events,$eventArray);

        }


    //KEY : 0 - stands for rating starts ( 0-5)

        //return $popular_events;



        //GET THE RECENT CREATED EVENTS


        $recent_created_events = \DB::table('VIT_EVENT')
            ->where('VIT_EVENT.EVENTEND', '>', $now)
            ->select('VIT_EVENT.EVENTID','VIT_EVENT.EVENTNAME','VIT_EVENT.EVENTSTART','VIT_EVENT.EVENTPAID','VIT_EVENT.EVENTLOCATION','VIT_EVENT.EVENTIMAGE')
            ->orderBy('VIT_EVENT.CREATED_AT', 'desc')->take(4)->get();

        $category_name = \DB::table('VIT_EVENTTYPE')
            ->select('EVENTTYPENAME')
            ->where('EVENTTYPEID',"=",$categoryID)
            ->get();

      // return $category_name;
       return view('Vitee_Website_Views.event.EventListOfCategory')
            ->with('category_events',$category_events)
            ->with('event_categories', $eventCategories)
            ->with('popular_events',$popular_events)
            ->with('recent_created_events',$recent_created_events)
            ->with('category_name',$category_name);

}


    /**
     * @param $id -> Event ID
     * @return Event Page
     */
    public function show($id)
    {

        //GETTING IMAGES FOR GALLERY

        $imagesPath = public_path() . '/img/event/' . $id . '/';
        //getting images for the gallery
        $images = [];
        $gallery = \File::Files($imagesPath);

        foreach ($gallery as $image) {
            $images[] = pathinfo($image);
        }

        //GET EVENT INFO - FREE EVENT
        $event = \DB::table('VIT_EVENT')
            ->select(\DB::raw('VIT_EVENT.EVENTID,EVENTNAME,EVENTDESCRIPTION,EVENTPAID,EVENTLOCATION,EVENTLONGITUDE,EVENTLATITUDE,DATE_FORMAT(EVENTSTART,"%W, %b %d, %Y") as STARTDATE, DATE_FORMAT(EVENTSTART,"%h:%i %p") as STARTTIME,DATE_FORMAT(EVENTEND,"%h:%i %p") as ENDTIME,UNIX_TIMESTAMP(EVENTSTART) as STARTTIMESTAMP,EVENTIMAGE'))
            ->where('VIT_EVENT.EVENTID', '=',$id)
            ->get();

        //GET EVENT INFO - PAID EVENT
        if($event[0]->EVENTPAID == 1){

         $tickets = \DB::table('VIT_TICKETTYPE')
             ->select('TICKETTYPEID','TICKETTYPENAME','TICKETPRICE','TICKETSTARTSALES','TICKETENDSALES')
             ->where('EVENTID','=',$id)
             ->get();
            return view('Vitee_Website_Views.event.EventPage')->with('event', $event)->with('images',$images)->with('tickets',$tickets);
        }
        else{

            return view('Vitee_Website_Views.event.EventPage')->with('event', $event)->with('images',$images);

        }



        //end if
    }


    /**
     * @param $id -> Event ID
     * @return Event Page
     */
    public function showSeatedEvent($id)
    {

        $id = 287;

        //GETTING IMAGES FOR GALLERY

        $imagesPath = public_path() . '/img/event/' . $id . '/';
        //getting images for the gallery
        $images = [];
        $gallery = \File::Files($imagesPath);

        foreach ($gallery as $image) {
            $images[] = pathinfo($image);
        }

        //GET EVENT INFO - FREE EVENT
        $event = \DB::table('VIT_EVENT')
            ->select(\DB::raw('VIT_EVENT.EVENTID,EVENTNAME,EVENTDESCRIPTION,EVENTPAID,EVENTLOCATION,EVENTLONGITUDE,EVENTLATITUDE,DATE_FORMAT(EVENTSTART,"%W, %b %d, %Y") as STARTDATE, DATE_FORMAT(EVENTSTART,"%h:%i %p") as STARTTIME,DATE_FORMAT(EVENTEND,"%h:%i %p") as ENDTIME,UNIX_TIMESTAMP(EVENTSTART) as STARTTIMESTAMP'))
            ->where('VIT_EVENT.EVENTID', '=',$id)
            ->get();

        //GET EVENT INFO - PAID EVENT
        if($event[0]->EVENTPAID == 1){

            $tickets = \DB::table('VIT_TICKETTYPE')
                ->select('TICKETTYPENAME','TICKETPRICE','TICKETSTARTSALES','TICKETENDSALES')
                ->where('EVENTID','=',$id)
                ->get();
            return view('Vitee_Website_Views.event.SeatedEventPage')->with('event', $event)->with('images',$images)->with('tickets',$tickets);
        }
        else{

            return view('Vitee_Website_Views.event.SeatedEventPage')->with('event', $event)->with('images',$images);

        }



        //end if
    }


    public function showAllEvents(){

        $now = Carbon::now();


        $allEvents = DB::table('VIT_EVENT')
            ->select(\DB::raw('EVENTID,EVENTNAME,EVENTPAID,EVENTLOCATION,
            DATE_FORMAT(EVENTSTART,"%W, %d %b %Y  %H:%i ") as STARTDATE,
            UNIX_TIMESTAMP(EVENTSTART) as StartTimeStamp,
            VIT_EVENT.EVENTTYPEID, VIT_EVENT.EVENTIMAGE '))
            ->leftJoin('VIT_EVENTTYPE',	'VIT_EVENT.EVENTTYPEID','=','VIT_EVENTTYPE.EVENTTYPEID')
            ->where('VIT_EVENT.EVENTEND','>',$now)
            ->orderBy('VIT_EVENT.EVENTSTART')
            ->paginate(16);

        // return $allEvents;


        // return $allEvents;

        return view('Vitee_Website_Views.event.AllEvents')->with('allEvents', $allEvents);




    }

function showCalendarEvents(){


    $now = Carbon::now();


    $allEvents = DB::table('VIT_EVENT')
        ->select(\DB::raw('EVENTID,EVENTNAME,EVENTPAID,EVENTLOCATION,
            DATE_FORMAT(EVENTSTART,"%W, %d %b %Y  %H:%i ") as STARTDATE,USERNAME,
            VIT_EVENT.EVENTTYPEID,VIT_EVENT.EVENTIMAGE'))
        ->leftJoin('VIT_USER',	'VIT_EVENT.USERID','=','VIT_USER.USERID')
        ->where('VIT_EVENT.EVENTEND','>',$now)
        ->orderBy('VIT_EVENT.EVENTSTART')
        ->get();


  // return $allEvents;

    return view('Vitee_Website_Views.event.EventCalendar')->with('allEvents', $allEvents);
}


    function  test(){


        return view('Vitee_Website_Views.ticket.cartPage');
    }



    public function edit($id)
    {
        //
    }



    public function destroy($id)
    {
    
    


    }

}