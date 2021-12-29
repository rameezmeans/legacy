@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'thanks'))
@stop

@section('body-class', 'thanks')

@section('content')
<div class="booking-sec thanks-main">
    <div class="container">
        <h1>THANK YOU!</h1>
        <img src="{{ asset('images/thanks-arrow.png') }}" alt="Thank you for booking your private yacht event">
        <p>Thank you for your booking. A member of our team will reach out to you directly with any questions. For immediate assistance, please call us anytime at <a href="tel:619-550-3800">(619) 550-3800</a>.
        </p>
        
    </div>
</div>
@endsection
