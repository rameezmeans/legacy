<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class Admin {
	
	/**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
	
    public function handle($request, Closure $next)
    {

//        dd($request->all());

//        $currentLocale = $request->route()->uri;

//        dd($currentLocale);

        if($this->auth->user()){
			if ($this->auth->user()->role === 'A')
			{
				return $next($request);
			}
//            else{
//
//                return $next($request);
//
//            }
		}

        return redirect('/legacy-admin');

    }

}