@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'book_now'))
@stop

@section('body-class', 'contact-us')

@section('content')
<div class="clear"></div>
<!-- <div class="wrapper contact-intro" id="success">
    <h1>Book Now</h1>
    <p>YACHT VIEWINGS, BOOKING INQUIRIES, QUESTIONS, AND SUGGESTIONS</p>
</div> -->

<div class="book-event-section row contact-form">
    <div class="bes-form row">
        <div class="wrapper">
            <div class="typeform-widget" data-url="https://legacycruisessd.typeform.com/to/Q6l8BL" data-transparency="50" data-hide-headers=true data-hide-footer=true style="width: 100%; height: 500px;" > </div> <script> (function() { var qs,js,q,s,d=document, gi=d.getElementById, ce=d.createElement, gt=d.getElementsByTagName, id="typef_orm", b="https://embed.typeform.com/"; if(!gi.call(d,id)) { js=ce.call(d,"script"); js.id=id; js.src=b+"embed.js"; q=gt.call(d,"script")[0]; q.parentNode.insertBefore(js,q) } })() </script> <div style="font-family: Sans-Serif;font-size: 12px;color: #999;opacity: 0.5; padding-top: 5px;" > powered by <a href="https://www.typeform.com//?utm_campaign=Q6l8BL&amp;utm_source=typeform.com-11391068-Basic&amp;utm_medium=typeform&amp;utm_content=typeform-embedded-poweredbytypeform&amp;utm_term=EN" style="color: #999" target="_blank">Typeform</a> </div>
        </div>
    </div>
</div>
@endsection
