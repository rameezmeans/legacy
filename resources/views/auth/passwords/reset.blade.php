@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'reset_password'))
@stop

@section('content')
<div id="myModal-logins" class="modal register-popup" style="display:block;position: relative;background-color:#fff;padding: 30px 0;">
        <div class="modal-content"> 
            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <h1>Reset Password</h1> 
                <input id="email" type="email" class="form-control" placeholder="EMAIL ADDRESS" name="email" value="{{ $email or old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <label class="error"> {{ $errors->first('email') }} </label>
                @endif
                <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>
                @if ($errors->has('password'))
                    <label class="error"> {{ $errors->first('password') }} </label>
                @endif
                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required>
                 @if ($errors->has('password_confirmation'))
                    <label class="error"> {{ $errors->first('password_confirmation') }} </label>
                @endif
                <input type="submit" value="Reset Password"> 
            </form>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
@endsection 