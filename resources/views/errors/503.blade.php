@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => '503'))
@stop

@section('body-class', 'body-error')

@section('content')
<div class="booking-sec thanks-main">
    <div class="container">
        <h1>opps!</h1>
        <p>We're sorry, but something went wrong!</p> 
    </div>
</div>
@endsection 
