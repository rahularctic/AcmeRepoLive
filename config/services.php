<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '459870604208517',
        'client_secret' => '6a7980e967f50b4220bbe521f030793f',
        'redirect' => 'http://phplaravel-16615-36254-102218.cloudwaysapps.com/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '911936376774-jkkvbpd7974bv17jo3pti5h44gb7mcl3.apps.googleusercontent.com',
        'client_secret' => '7s_1JTLBcGSKYXsqO2lcXFCS',
        'redirect' => 'http://phplaravel-16615-36254-102218.cloudwaysapps.com/auth/google/callback',
    ],

];
