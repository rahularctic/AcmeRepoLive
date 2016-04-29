<?php namespace App\Repositories;
/**
 * Created by PhpStorm.
 * User: SAM-PC
 * Date: 4/15/2015
 * Time: 12:48 PM
 */

use App\User;



class UserRepository   {


    public function checkUserExist($userData){

        $user = User::where('email', $userData->email)->first();

        if($user) return true;
        else return false;

    }


    public function findByUsernameOrCreate($userData){



       $user = User::where('email', $userData->email)->first();


        if(!$user) {


            $user = User::create([
                'email' => $userData->email,
                'USERNAME' => $userData->name,
                'USERGENDER' => $userData->user['gender'],
                'active' => 1
            ]);

            $userId = $user->USERID;


            $user_picture = $userData->avatar;

            $path = public_path().'/img/user/'.$userId;

            $userPicturePath = $path."/1.jpeg";

            \File::makeDirectory($path, $mode = 0777, true, true);

            file_put_contents($userPicturePath, file_get_contents($user_picture));
        }

       // $this->checkIfUserNeedsUpdating($userData, $user);

        /*
         * Should check if the user has updated his data, if yes update data in DB
         */

            return $user;


    }

/*
    public function checkIfUserNeedsUpdating($userData, $user) {

        $socialData = [
            'avatar' => $userData->avatar,
            'email' => $userData->email,
            'name' => $userData->name,
            'username' => $userData->nickname,
        ];
        $dbData = [
            'avatar' => $user->avatar,
            'email' => $user->email,
            'name' => $user->name,
            'username' => $user->username,
        ];

        if (!empty(array_diff($socialData, $dbData))) {
            $user->avatar = $userData->avatar;
            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->username = $userData->nickname;
            $user->save();
        }
    }
*/

}