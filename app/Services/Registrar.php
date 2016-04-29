<?php namespace App\Services;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Mail;
use Session;

class Registrar implements RegistrarContract {

    /**
     * The validation factory implementation.
     *
     * @var ValidationFactory
     */
    protected $validator;

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * The hasher implementation.
     *
     * @var HasherContract
     */
    protected $hasher;

    /**
     * Create a new registrar instance.
     *
     * @param  ValidationFactory  $validator
     * @param  UserRepository     $users
     * @param  HasherContract     $hasher
     */
    public function __construct(ValidationFactory $validator, UserRepository $users, HasherContract $hasher)
    {
        $this->validator = $validator;
        $this->VIT_USER = $users;
        $this->hasher = $hasher;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    public function validator(array $data)
    {
        return $this->validator->make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:VIT_USER',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
          $user = User::create([
            'USERNAME' => $data['username'],
            'email' => $data['email'],
            'password' => $this->hasher->make($data['password']),
        ]);
        
        //get the id of created user

        $userId = $user->USERID;
        
        //generate a confirmation code
        $confirmation_code = str_random(32);
        
        $userVerify = \DB::table('VIT_USERVERIFY')->insert(
        array('USERID' => $userId,'HASH' =>  $confirmation_code)
        );
	
	//add a profile picture

        // TODO UPLOAD IMAGE TO S3
	
/*        $user_picture = public_path().'/img/user/default.jpeg';

        $path = public_path().'/img/user/'.$userId;

        $userPicturePath = $path."/1.jpeg";

        \File::makeDirectory($path, $mode = 0777, true, true);

        file_put_contents($userPicturePath, file_get_contents($user_picture));*/
        
        //send verification email
        
        $data = array( 'confirmation_code' => $confirmation_code , 'email' => $user->email , 'username' => $user->USERNAME);
  
        
/*      Mail::send('emails.verify',$data, function($message) use ($data) {
            $message->to( $data['email'], $data['username'])->subject('Verify your email address');
        });

     Session::flash('verify_msg', 'Thanks for signing up! Please check your email and follow the instructions to complete the sign up process');
  */

        return $user;
    }

}