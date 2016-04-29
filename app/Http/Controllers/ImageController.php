<?php namespace App\Http\Controllers;
use Carbon\Carbon;





    class ImageController extends Controller{
    
        public function __construct()
        {
         //   $this->middleware('auth');
        }


     /*
        public  function getURL() {
            
            
            $imgURL = "http://vitee.me/img/";
            return $imgURL;
        
        }
      
    */
        public function getUserImg($id,$fileName){




            /*
             * TODO Check if the user image exist or not
             */

            $imagePath = '/img/user/'.$id.'/'.$fileName;
            $path =  getenv('Aws_Bucket_URL').$imagePath;

            return \Response::redirectTo($path);


        
        }
		

		public function getEventImgExtra($eventID,$type,$fileName){


            $imagePath = '/img/event/'.$eventID.'/'.$type.'/'.$fileName;

            $path = getenv('Aws_Bucket_URL').$imagePath;

            return \Response::redirectTo($path);


        
        }

        public function getEventImg($eventID,$fileName){


            $imagePath = '/img/event/'.$eventID.'/'.$fileName;


            $path = getenv('Aws_Bucket_URL').$imagePath;

            return \Response::redirectTo($path);



        }


    }