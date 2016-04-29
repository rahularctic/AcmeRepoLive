<?php
/**
 * Created by PhpStorm.
 * User: SAM-PC
 * Date: 4/15/2015
 * Time: 12:38 PM
 */

namespace App;


use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\UserRepository;


class AuthenticateUser {

    private $users;
    private $socialite;
    private $auth;
    private $driver = null;


    /**
     * @param UserRepository $users
     * @param Socialite $socialite
     * @param Guard $auth
     */
    public function __construct(UserRepository $users,Socialite $socialite,Guard $auth)
    {

        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;

    }

    /**
     * @param $hascode
     * @param AuthenticateUserListener $listener
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($request,AuthenticateUserListener $listener,$provider){


        if (!$request) {

            return $this->getAuthorizationFirst($provider);
        }

      //  dd($this->getSocialUser($provider));

        $user = $this->users->findByUsernameOrCreate($this->getSocialUser($provider));




        $this->auth->login($user,true);



       return $listener->userHasLoggedIn($user);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public  function  getAuthorizationFirst($provider){


        return $this->socialite->driver($provider)->redirect();

    }

    /**
     * @return \Laravel\Socialite\Contracts\User
     */


    private function getSocialUser($provider){


        return $this->socialite->driver($provider)->user();

    }


}