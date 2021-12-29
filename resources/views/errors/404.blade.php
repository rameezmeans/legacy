@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => '404'))
@stop

@section('body-class', 'body-error')

@section('content')
<div class="booking-sec thanks-main">
    <div class="container">
        <h1>404</h1>
        <p>PAGE NOT FOUND!</p> 
    </div>
</div>
@endsection 