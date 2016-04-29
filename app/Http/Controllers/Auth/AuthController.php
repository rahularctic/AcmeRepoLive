<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Registrar;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use DB;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

    protected $redirectTo = '/dashboard/home';

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function redirectToFacebook()
	{
		return Socialite::driver('facebook')->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderFacebook()
	{

		$user = Socialite::driver('facebook')->user();

		// $user->token;

//		session(['userId' => $user->id,'userName'=>$user->name]);
//		dd($user);
		$this->registerUser($user);
//		return redirect('user.userEvents')->with(['userdetails'=>$user]);
		//return redirect()->action('UsersController@userEvent');
		return redirect('myTickets');
		
	}

public function redirectToGoogle()
	{
		return Socialite::driver('google')->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderGoogle()
	{
		$user = Socialite::driver('google')->user();

//		dd($user);
		$this->registerUser($user);
		//return redirect()->action('UsersController@userEvent');
		return redirect('myTickets');

//// OAuth Two Providers
//		$token = $user->token;
//
//// OAuth One Providers
//		$token = $user->token;
//		$tokenSecret = $user->tokenSecret;
//
//// All Providers
//		$user->getId();
//		$user->getNickname();
//		$user->getName();
//		$user->getEmail();
//		$user->getAvatar();
//
//		// $user->token;
	}

	public function registerUser($user)
	{
		DB::enableQueryLog();
		$checkUser=User::where('email',$user->email)
			->first();
		if($checkUser)
		{
			session(
				[
					'userId' => $checkUser->USERID,
					'userName'=>$checkUser->USERNAME
				]
			);

		}else{
			$userCreate=User::create(
				[
					'USERNAME' =>$user->name,
					'email' =>$user->email
				]
			);
//			dd( DB::getQueryLog() );

			session(
				[
					'userId' => $userCreate->USERID,
					'userName'=>$user->name
				]
			);

		}

	}

}
