<!-- view/auth/login.blade.php -->
@extends('admin.layout.login')

@section('content')
    <div class="logo">
        <a href="javascript:void(0);">Admin</a>
        <small>{{ config('legacy.site_name') }}</small>
    </div>
    <div class="card">
        <div class="body"> 
            <form class="form-login" id="sign_in" action="{{ url('/legacy-login') }}" method="post" accept-charset="utf-8" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Error message -->
                @if($errors->all())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    </div>
                @endif
                <!-- End of Error message -->
                <div class="msg">Sign in to start your session</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="your@email.com"   autofocus>                     
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                         <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" placeholder="Password"  > 
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" id="rememberme" value="1" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-pink">
                        <label for="rememberme">Remember Me</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
 @stop