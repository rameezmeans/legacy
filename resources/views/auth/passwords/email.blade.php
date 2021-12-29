@extends('layouts.basic')

@section('content')
<div id="myModal-logins" class="modal register-popup" style="display:block;position: relative;background-color:#fff;padding: 30px 0;">
        <div class="modal-content"> 
           <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <h1>Reset Password</h1> 
                <input id="email" type="email" name="email" placeholder="EMAIL ADDRESS" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <label class="error"> {{ $errors->first('email') }} </label>
                @endif
                <input type="submit" value="Send Password Reset Link"> 
            </form>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
@endsection 