<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Input;
use Redirect;
use Validator;
use Session;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
	{
		//


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

    public function update(Request $request)
    {

        //Upload image to S3 bucket
        if ($image = $request->file('profileimage')){


            $rules = array(array('file' => 'required|mimes:bmp')); //mimes:jpeg,bmp,png and for max size max:10000
            // doing the validation, passing post data, rules and the messages
            $validator = Validator::make(array('file'=> $image), $rules);

            if ($validator->passes()) {

                $usrID = Auth::id();
                $filename = Carbon::now()->getTimestamp().rand(111, 999).".jpeg";
                $destinationPathUserImg = 'img/user/' . $usrID;

                if(\Storage::disk('s3')->put($destinationPathUserImg . '/' . $filename, fopen($image,'r'), 'public')){



					DB::connection('mysql')->table('VIT_USER')->where('USERID',$usrID)->update(['USERIMAGE' => $filename]);
				}



                // sending back with message
                Session::flash('success_update', 'You profile Image has been updated successfully');

            }else{

                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('dashboard/home');
            }

        }



        if($username = Input::get('username')  ){


            $rules = array(
                'username'=> 'regex:/(^[A-Za-z0-9 ]+$)+/|min:4'
            );

            $validator = Validator::make(array('username'=> $username), $rules);

            if ($validator->passes()) {

                $user = Auth::user();
                $user->USERNAME = $username;
                $user->USERDESCRIPTION = Input::get('description');
                $user->save();

                Session::flash('success_update', 'You profile  has been updated successfully');

            }else{
                Session::flash('error', 'username not valid ');
                return Redirect::to('dashboard/settings');
            }

        }

        return Redirect::to('dashboard/settings');


    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
