<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');

/**
 * FORCE HTTPS
 */

//URL::forceSchema('https');


/**
 * *************************************************************************************************
 * *******************************      DASHBOARD ROUTES   *****************************************
 * *************************************************************************************************
 */





/**
 * User Routes
 */



Route::group(['middleware' => 'web'], function () {
    Route::auth();


    Route::get('sendRegisterMail', function(){
        return view('Vitee_Website_Views.user.sendRegisterMail');
    });

    Route::get('resetPasswordMailContent', function(){
        return view('Vitee_Website_Views.user.resetPasswordMailContent');
    });

    Route::get('user/login', 'LoginController@showLoginForm');

    Route::get('downloadInvoicePDF/{invoiceId}',  'LoginController@downloadInvoicePDF');

    Route::get('PDFformat',  function(){
        return view ('Vitee_Website_Views.PDF.PDFformat');
    });

    Route::post('user/loginCheck', 'LoginController@loginCheck'); // Check Login Details

    Route::get('user/register', 'LoginController@register'); // Register New User

    Route::post('user/register', 'LoginController@submitUserDetails'); // Submit New User Details

    Route::get('accountVerify/{email}/{hash}', 'LoginController@accountVerify'); // Verify First Time User Logged in

    Route::get('passwordReset', 'LoginController@passwordReset'); // Reset Password

    Route::get('passwordReset/{email}/{token}', 'LoginController@passwordReset');

    Route::get('passwordResetVerify/{email}/{token}', 'LoginController@passwordResetVerify');

    Route::post('passwordResetVerify', 'LoginController@passwordResetVerify');

    Route::get('userProfile/{userId}', 'UsersController@userProfile'); //Display Profile Page

    Route::post('updateUserDetails', 'UsersController@updateUserDetails'); // Update Profile

    Route::get('userEvent', 'UsersController@userEvent'); // Not Required

    Route::get('myTickets', 'UsersController@myTickets'); // Display My Tickets Page

    Route::post('buyTicket', 'UsersController@BuyTicket'); // Buy Ticket

    //Route::post('/purchaseticketTwo', 'UsersController@purchaseticketTwo');

    Route::get('/purchaseticketTwo', 'UsersController@purchaseticketTwo');

    Route::post('ForgetpasswordReset', ['as' => 'ForgetpasswordReset','uses' =>'LoginController@ForgetpasswordReset']);


    Route::get('ForgetPassword', function(){
        return view('Vitee_Website_Views.user.ForgetPassword');
    });


    Route::get('user/logout', 'UsersController@userLogout');

    Route::get('auth/google', 'Auth\AuthController@redirectToGoogle');
    Route::get('auth/facebook', 'Auth\AuthController@redirectToFacebook');

    Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderFacebook');

    Route::get('auth/google/callback', 'Auth\AuthController@handleProviderGoogle');

    Route::get('startSession', 'SessionController@startSession');

    Route::get('destroySession', 'SessionController@destroySession');

/**
 * Events Routes
 */

Route::get('dashboard/events', 'EventsController@index'); //deiplay list of user events

Route::get('dashboard/event/create', 'EventsController@get_new');

Route::get('dashboard/event/create_new','EventsController@NewEventForm'); //create new event form

Route::post('dashboard/event/create','EventsController@createP'); //save event



Route::group(['middleware' => ['eventMid']], function() {
    // protected routes here

    Route::get('dashboard/event/{id?}', 'EventsController@show');
    Route::get('dashboard/event/update/{id?}', 'EventsController@showUpdate');
    Route::post('dashboardevent/update/{id?}', 'EventsController@update');
    Route::post('dashboardevent/deleteTicket/{id?}', 'EventsController@deleteTicket');
    Route::any('dashboard/event/delete/{id?}', 'EventsController@destroy');
    Route::post('dashboard/event/{id?}', 'EventsController@getChart');


});

Route::post('dashboard/event/update/updateMedia/{eventID?}', 'EventsController@UpdateMedia'); //update event images
Route::any('dashboard/event/update/deleteMedia/{eventID?}/{imageID?}', 'EventsController@deleteMedia'); //delete event images




Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::get('register/verify/{confirmationCode?}', 'RegistrationController@confirm');



Route::get('forgot', function(){


    return view('auth.password');
});

Route::get('dashboard/settings', function(){

    if(Auth::check()){

    return view('settings.general');

    }else{

        return Redirect::to('/dashboard/home');

    }
});

Route::post('dashboard/settings/update', 'ProfileController@update');



Route::get('welcome', function(){


    return view('auth.welcome');
});



Route::get('dashboard/home', 'HomeController@index');


Route::get('/dashboard', function(){

    if(Auth::check()) return Redirect::to('/dashboard/home');


    return Redirect::to('auth/login');
});

Route::get('/login/{provider?}','AuthController@login');





/**
 * *************************************************************************************************
 * *******************************      Website ROUTES   *****************************************
 * *************************************************************************************************
 */



/**
 * Routes For Events
 */
Route::get('/', 'Website\EventsControllerWebsite@index');

Route::get('/events/c/{categoryID?}', 'Website\EventsControllerWebsite@showEventsOfCategory');

Route::get('/event/{id?}/{eventName?}', 'Website\EventsControllerWebsite@show');

Route::get('/events/all', 'Website\EventsControllerWebsite@showAllEvents');


Route::get('/events/calendar','Website\EventsControllerWebsite@showCalendarEvents');

/**
 * Routes for Tickets
 */

//TEST SEATED EVENT

Route::get('/event/s/{id?}', 'Website\EventsControllerWebsite@showSeatedEvent');
Route::get('/event/s/{id?}/tickets', 'Website\TicketControllerWebsite@showSeatedEventTickets');


Route::any('/event/{id?}/tickets', 'Website\TicketControllerWebsite@showEventTickets');


/**
 * Routes For Website Pages
 */

Route::get('/about',  function(){

    return view('Vitee_Website_Views.About.About');
});




Route::get('/blog',  function(){

    return view('Vitee_Website_Views.Blog.Blog');
});


Route::get('/contact',  function(){

    return view('Vitee_Website_Views.Contact.Contact');
});

Route::get('/faq',  function(){

    return view('Vitee_Website_Views.Faq.Faq');
});


/**
 * Routes For Paytabs
 */
//Route::any('/paytabs','Website\TicketControllerWebsite@hello');

Route::any('/paytabs','Website\TicketControllerWebsite@createPayPage');



Route::any('/event/{id?}/tickets/purchase','Website\TicketControllerWebsite@test');

Route::get('/payment','Website\TicketControllerWebsite@showPaymentPage');

Route::get('/paymentFailed','Website\TicketControllerWebsite@showFailedPage');


/**
 * Image controller
 */

Route::get('/img/user/{id?}/{fileName?}', 'ImageController@getUserImg');


Route::get('/img/event/{eventID?}/{fileName?}', 'ImageController@getEventImg');

Route::get('/img/event/{eventID?}/{type?}/{fileName?}', 'ImageController@getEventImgExtra');


/**
 * *************************************************************************************************
 * *******************************     Test  ROUTES   *****************************************
 * *************************************************************************************************
 */

/*
 * User profile routes
 *
 *
 */


});

Route::any('/paytabs/payment','Website\TicketControllerWebsite@verifyPayment');


/* END OF ROUTES */