<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Ixudra\Curl\Facades\Curl;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\TicketController;
use App\User;
use App\Event;
use App\PasswordResets;
use App\TicketPurchased;
use App\TicketType;
use App\TicketTransaction;
use Mail;
use App;
use DB;
use Hash;
use Session;
use Crypt;
use PDF;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\PurchaseTicketTwo;

class LoginController extends Controller
{
    //

    public function __construct()
    {

    }


    public function register()
    {
        return $this->showRegistrationForm();
    }

    public function showRegistrationForm()
    {
        return view('Vitee_Website_Views.user.register');
    }

    public function submitUserDetails(Request $request)
    {
        $hash = md5( rand(0,1000) );
        $email=$request->email;
//        $validator = $this->validator($request->all());
//
//        if ($validator->fails()) {
//            $this->throwValidationException(
//                $request, $validator
//            );
//        }
//dd($request);
        $User=User::where('email',$request->email)
            ->first();
//dd($User);
        if($User==null)
        {
//            dd($request);
            $USER = new User;
            $USER->email = $request->email;
            $USER->USERNAME = $request->username;
            $USER->password = password_hash($request->password, PASSWORD_DEFAULT, array("cost" => 10));
            $USER->save();
//dd($USER->id);
            $VIT_USERVERIFY=DB::insert("INSERT INTO VIT_USERVERIFY(USERID, HASH) VALUES(
					:userId,:hash) ",['userId'=>$USER->USERID,'hash'=>$hash]);

            if($VIT_USERVERIFY)
            {
//                $this->sendRegisterMail($request->email,$request->username,$request->password,$hash);
                return redirect('user/register')->with(['status' => 1]);
            }

        }else{
            return redirect('user/register')->with(['msg' => 'user already exist']);
        }

    }

    public function showLoginForm()
    {
        return view('Vitee_Website_Views.user.login');
    }

    public function loginCheck(Request $request)
    {
//        $this->validate($request, [
//            'email' => 'required|email',
//            'password' => 'required|alpha_dash',
//        ]);

        $email = $request->email;
        
        $user = User::where('email', '=', $email)->first();


        // $status = Hash::check($request->password, $user->password);

        //dd($status);

        $password = $request->password;//password_hash($request->password , PASSWORD_DEFAULT, array("cost" => 10));

        if (count($user))
        {
            if (password_verify($password, $user->password)) {

                $ACTIVE = $user->ACTIVE;
                if($ACTIVE == 1)
                {
                    $UID = $user->USERID;
                    $USERNAME = $user->USERNAME;


                    session([
                        'userId' => $UID,
                        'userNAme' => $USERNAME,
                        'usertype' => '1'
                    ]);

                    //return redirect('events/all')->with(['values'=>$values]);
                    //return redirect('myTickets');
                    echo json_encode(['result' => '1']); // Success

                }
                else
                {
                    echo json_encode(['result' => '4']); // User Inactive
                }


            } else {
                echo json_encode(['result' => '3']); // Incorrect Password
            }
        }else
        {
            echo json_encode(['result' => '2']); // User Does not Exist
        }

    }

    public function userDetailsSubmit(Request $request)
    {
        $DBPath = "";
        if (!empty($request->userImage)) {
            $userImageFile = Input::file('userImage')->getFilename();

            $extension = Input::file('userImage')->getClientOriginalExtension();
            $storeFolder = 'UserImages/' . $request->USERID;

            $userImage = $userImageFile . '.' . $extension;

            $DBPath = $storeFolder . "/" . $userImage;
            if (Input::file('userImage')->isValid()) {

                Input::file('userImage')->move($storeFolder, $userImage);

            }


        }

//        dd($DBPath);
        $userDetails = '';

//        dd($request);

        if ($request->password == $request->conformPassword) {
            $userDetails = User::where('USERID', $request->USERID)
                ->update(
                    [
                        'USERNAME' => $request->USERNAME,
                        'USERGENDER' => $request->USERGENDER,
                        'DOB' => $request->DOB,
                        'password' => bcrypt($request->password),
                        'USERDESCRIPTION' => $request->USERDESCRIPTION,
                        'USERIMAGE' => $DBPath
                    ]
                );
            if ($userDetails) {
                echo json_encode(['result' => 'update']);
            } else {
                echo json_encode(['result' => 'not update']);
            }
        } else {
            echo json_encode(['result' => 'password not match']);
        }
//dd($userDetails);

    }

    public function sendRegisterMail($email,$username,$password,$hash)
    {
        $data = ['email' => $email,'name'=>$username,'password'=>$password,'hash'=>$hash];
        Mail::send('Vitee_Website_Views.user.sendRegisterMail', $data, function ($m) {
            $m->from('noreply@vitee.net', 'Your Application');

            $m->to('ajay@acmeconnect.com', 'test')->subject('Forgot Password');
        });
    }

    public function accountVerify(Request $request)
    {
        $matchUser=DB::select('SELECT VIT_USER.email, VIT_USER.ACTIVE, VIT_USERVERIFY.HASH
				FROM VIT_USER
				INNER JOIN VIT_USERVERIFY
				ON VIT_USER.USERID = VIT_USERVERIFY.USERID
				WHERE email = :email AND HASH = :hash',['email'=>$request->email,'hash'=>$request->hash]);

        $matchUserActive=DB::select("SELECT VIT_USER.email, VIT_USER.ACTIVE, VIT_USERVERIFY.HASH
				FROM VIT_USER
				INNER JOIN VIT_USERVERIFY
				ON VIT_USER.USERID = VIT_USERVERIFY.USERID
				WHERE email = :email AND HASH = :hash AND ACTIVE = :active ",['email'=>$request->email,'hash'=>$request->hash,'active'=>0]);

        if($matchUser > 0 && $matchUserActive == null)
        {
            return redirect('Vitee_Website_Views.user.register')->with('status', 'Account has already been activated');
        }
        elseif($matchUserActive > 0)
        {
            DB::update("UPDATE VIT_USER
					SET ACTIVE='1'
					WHERE email = :email AND ACTIVE=:active",['email'=>$request->email,'active'=>0]);
            return view('Vitee_Website_Views.user.register')->with('status', 'Account has successfully been activated');
        }else
        {
            return view('Vitee_Website_Views.user.register')->with('status', 'Invalid approach, please use the link that has been send to your email');
        }
    }

    public function passwordReset(Request $request)
    {
        return view('Vitee_Website_Views.user.passwordReset',['email'=>$request->email,'token'=>$request->token]);
    }

    public function passwordResetVerify(Request $request)
    {
        $password_resets=DB::select('SELECT *
		     	FROM password_resets
		    	WHERE email = :email AND token = :token',['email'=>$request->email,'token'=>$request->token]);
//        dd($request);

        if(count($password_resets)>0)
        {
            DB::update('UPDATE VIT_USER
     			    SET password = :pass
			      	WHERE email = :email',['email'=>$request->email,'pass'=>password_hash($request->passwordV, PASSWORD_DEFAULT, array("cost" => 10))]);

            DB::delete('DELETE FROM password_resets
				    WHERE email = :email',['email'=>$request->email]);

            return redirect('passwordReset')->with(['status'=>'success','email'=>$request->email,'token'=>$request->token]);
        }
        else{
            return redirect('passwordReset')->with(['status'=>'fail','email'=>$request->email,'token'=>$request->token]);
        }

    }

    public function ForgetpasswordReset(Request $request)
    {
        $email = $request->email;
        $token1 = md5(rand(0, 1000));
        $token2 = md5(rand(0, 1000));
        $token = $token1 . $token2;

        $User = User::where('email', $email)
            ->first();

        if ($User) {
            $PasswordResets = PasswordResets::create([
                'email' => $email,
                'token' => $token
            ]);

            return redirect('passwordReset')->with([
                'email' => $email,
                'token' => $token
            ]);
//            $this->passwordResetSendEmail($email, $token);

        }

//        return view('Vitee_Website_Views.user.ForgetPassword');
    }

    public  function downloadInvoicePDF(Request $request)
    {
        DB::enableQueryLog();
//        dd($request);

        $userId=User::find('803');
//        dd(DB::getQueryLog());
//        dd($userId);
//        return $userId->download($request->invoiceId, [
//            'vendor'  => 'Your Company',
//            'product' => 'Your Product',
//        ]);
        $parameter['param'] = "Hello World!!";
        $pdf = PDF::loadView('Vitee_Website_Views.PDF.PDFformat', $parameter);
        return $pdf->download('test.pdf'); //this code is used for the name pdf
//        $pdf = PDF::loadHTML('<h1>Hello World!!</h1>');
//        return $pdf->stream();
    }
}
