<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Socialite;
use App\User;
use Session;
use Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }

    protected function redirectTo()
    {
        if(Auth::user()->role === 'A') {
            return '/admin';
        }
        return '/';
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

//        dd($request->all());

        $this->validateLogin($request);

        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user){
            if($request->ajax()){
                 if( $user->role == 'A')    {
                    $errors = [$this->username() => trans('auth.notallowed')];
                    if ($request->expectsJson()) {
                        return response()->json($errors, 422);
                    }

                    return redirect()->back()->withErrors($errors);
                }
            }

            if($request->ajax()){

//                echo "here";exit;

                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){

//                    return back();

                    return response()->json([
                        'email' => 'logged'
                    ], 200);
                }else{
                     return response()->json([
                        'email' => \Lang::get('auth.failed')
                    ], 401);
                }
            }
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }else{
             return response()->json([
                'email' => \Lang::get('auth.failed')
            ], 401);
        }

    }

    /**
     * Admin Login Form
     *
     * @return \Illuminate\Http\Response
     */
    public function adminform()
    {
        return view('auth.legecylogin');
    }

    /**
    * Login Only For Admin
    */
    public function adminLogin(Request $request){

        $this->validateLogin($request);
        $user = DB::table('users')->where('email', $request->email)->first();
        if( $user->role != 'A'){
            $errors = [$this->username() => trans('auth.notuser')];
            if ($request->expectsJson()) {
                return response()->json($errors, 422);
            }

            return redirect()->back()

                    ->withErrors($errors);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);
        //return redirect($this->redirectTo);
        if (Session::has('legacyOrders.orderid')) {
            return redirect('/authcallback');
        } else {
            return redirect('/authcallback');
        }
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            $updatedUser = array(
                'provider_id' => $user->id,
                'provider' => $provider
            );
            User::where('email', $user->email)->where('role', 'S')->update($updatedUser);
            return $authUser;
        }

        $legacy_conf = \Config::get('legacy');
        $toMail = $legacy_conf['newuser_email_alert'];
        $fromMail = $legacy_conf['from_email_alert'];
        $userData['email'] = $user->email;
        Mail::send('emails.registration', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');
            $m->to($userData['email'], 'Legacy')->subject('Welcome to Legacy Cruises & Events');
        });

        Mail::send('emails.registrationadmin', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');
            $m->to($toMail, 'Legacy')->subject('New User Registered Notifications');
        });

        return User::create([
            'email'    => $user->email,
            'name'  => $user->name,
            'phone'  => '',
            'password'  => bcrypt($user->id),
            'provider' => $provider,
            'provider_id' => $user->id,
            'role' => 'S'
        ]);
    }
}
