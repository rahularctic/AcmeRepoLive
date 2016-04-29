<?php namespace App\Http\Controllers;

use App\User;
use Redirect;
use Session;

class RegistrationController  extends Controller {


    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::home();  
          
        }

		$userVerify = \DB::table('VIT_USERVERIFY')->where('HASH',$confirmation_code)->first();
		
       /* $user = User::whereConfirmationCode($confirmation_code)->first(); */

        if ( ! $userVerify)
        {
            return Redirect::home();
         
        }

	$user = User::where('USERID', $userVerify->USERID)->first();
		
        $user->active = 1;
      
        $user->save();

      
       Session::flash('verify_msg', 'You have successfully verified your account. You can now login');

        return Redirect::to('auth/login');
    }

    public function register(Request $request)
    {
        return 1;

    }

}