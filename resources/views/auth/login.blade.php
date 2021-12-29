@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'login'))
@stop

@section('content')
<div id="myModal-logins" class="modal register-popup" style="display:block;position: relative;background-color:#fff;padding: 30px 0;">
        <div class="modal-content">
            <form class="form-horizontal" id="loginForm" role="form" method="POST" action="{{ url('/legacy-login') }}">
                {{ csrf_field() }}
                Sign In
                <a href="{{ url('/auth/facebook') }}" style="margin-bottom: 10px; display: block;">
                    <img src="{{ asset('images/fb.jpg') }}" alt="Log in with Facebook">
                </a>
                <a href="{{ url('/auth/google') }}">
                    <img src="{{ asset('images/google.jpg') }}" alt="Sign in with Google">
                </a>
                OR
                <hr>
                <input id="email" type="email" name="email" placeholder="EMAIL ADDRESS">
                <input id="password" type="password" name="password" placeholder="PASSWORD">
                <input type="submit" value="SIGN IN">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
                
            </form>
        </div>
    </div>
@endsection
