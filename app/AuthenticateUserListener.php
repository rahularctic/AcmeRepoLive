<?php
/**
 * Created by PhpStorm.
 * User: SAM-PC
 * Date: 4/15/2015
 * Time: 3:30 PM
 */
namespace App;

interface AuthenticateUserListener
{
    public function userHasLoggedIn($user);
}