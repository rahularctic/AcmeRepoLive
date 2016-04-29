<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class SessionController extends Controller
{
    //
    public
    function startSession()
    {
//        session_start();
//        $_SESSION['Transaction'] = 1;
//        $_SESSION['TransactionRes'] = 1;
//        dd("Session Start");

        $userDetails = User::where('USERID', '789')
            ->update(
                [
                    'orderTimeout' => 1,
                ]
            );

    }

    public
    function destroySession()
    {
        session_start();
        session_destroy();
        dd("Session Destroyed");
    }

}
