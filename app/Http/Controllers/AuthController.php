<?php namespace App\Http\Controllers;

use App\AuthenticateUser;
use App\AuthenticateUserListener;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Socialite;

class AuthController extends Controller implements AuthenticateUserListener
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */



    public function login(AuthenticateUser $authenticateUser,Request $request,$provider = null){


        return $authenticateUser->execute($request->all(),$this,$provider);

    }

    public function userHasLoggedIn($user){

        return redirect('/dashboard/home');

    }


    /**
     * Attempt to confirm a users account.
     *
     * @param $confirmation_code
     *
     * @throws InvalidConfirmationCodeException
     * @return mixed
     */
    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::home();
        }
        $user = User::whereConfirmationCode($confirmation_code)->first();
        if ( ! $user)
        {
            return Redirect::home();
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        Flash::message('You have successfully verified your account. You can now login.');
        return Redirect::route('login_path');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        // $user->token;
    }




}
