@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'thanks'))
@stop

@section('body-class', 'thanks')

@section('content')
<div class="booking-sec thanks-main">
    <div class="container">
        
        <img src="{{ asset('images/thank-you.png') }}" alt="Thank you for subscribing!">
        <p>Your subscription to our guestlist has been confirmed. Thank you for subscribing!
        </p>
        
    </div>
</div>
@endsection
