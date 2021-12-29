<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $request)
    {


		$this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirmation',
        ]);
        $userCreate = User::create([
            'email' => $request->email,
			'name'  => $request->name,
            'phone'  => $request->phone,
			'provider' => '',
            'provider_id' => '',
            'password' => bcrypt($request->password),
            'role' => 'S',
        ]); 

		if($userCreate){
			if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $legacy_conf = \Config::get('legacy');
                $toMail = $legacy_conf['newuser_email_alert'];
                $fromMail = $legacy_conf['from_email_alert'];
                $userData['email'] = $request->email;

                Mail::send('emails.registration', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to($userData['email'], 'Legacy')->subject('Welcome to Legacy Cruises & Events');
                });

                Mail::send('emails.registrationadmin', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to($toMail, 'Legacy')->subject('New User Registered Notifications');
                });

				return response()->json([
					'email' => 'registere'
				], 200);

			}else{
				 return response()->json([
					'email' => \Lang::get('auth.failed')
				], 401);
			}
		}
		return response()->json([
			'email' => \Lang::get('auth.failed')
		], 401);

    }
}
