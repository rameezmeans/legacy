@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'register'))
@stop

@section('content')
<div id="myModal-registers" class="modal register-popup" style="display:block;position: relative;background-color:#fff;padding: 30px 0;">
    <div class="modal-content">
        <form class="form-horizontal" id="registeration-form" role="form" method="POST" action="{{ url('/register-user') }}">
            {{ csrf_field() }}
            Create Account
            <a href="{{ url('/auth/facebook') }}" style="margin-bottom: 10px; display: block;">
                <img src="{{ asset('images/fb.jpg') }}" alt="Register with Facebook">
            </a>
            <a href="{{ url('/auth/google') }}">
                <img src="{{ asset('images/google.jpg') }}" alt="Register with Google">
            </a>
            OR
            <hr>
            <input id="email" type="email" name="email" class="" value="{{ old('email') }}"  placeholder="EMAIL ADDRESS" required>
            
            <input id="password" type="password" class="" name="password" placeholder="PASSWORD" required>
           
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="CONFIRM PASSWORD" required>
            <input type="submit" value="CREATE ACCOUNT">
            <p>Clicking on the “Creat Account” means you agreee to Legacy Cruises <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy.</a><p>
        </form>
    </div>
</div>
@endsection
