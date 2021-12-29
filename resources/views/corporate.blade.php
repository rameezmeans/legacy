@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'corporate'))
@stop

@section('body-class', 'corporate')

@section('content')
<div class="home-banner innerpage row corporate-banner" style="background-image: url({{ asset('images/corporate-events-banner.jpg') }});" title="San Diego Bay Corporate Yacht Charters and Events">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>EXCLUSIVE CORPORATE YACHT CHARTERS FOR TEAM BUILDING & CLIENT APPRECIATION!</h1>
                    <a href="{{ url('/plan-your-event') }}">PLAN YOUR CORPORATE PARTY</a> OR <a href="{{ url('/book-now') }}">BOOK NOW</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>A first-class corporate yacht is an original and unforgettable venue for marking milestones, celebrating successes, and building esprit de corps among customers and colleagues. Picture yourself with your hardworking team and impress business contacts as you relax on deck and enjoy the stunning seascape of San Diego Bay from our classic luxury vessel. It’s great for tradeshows and conference events, incentive rewards for clients and employees. The Sirara, with its invested fittings and superbly designed decks, is ready and waiting to host your corporate events with an experienced captain and dedicated crew at your service to make you and all your guests feel at peace on the shining sea. </p>
        </div>
    </div>
</div>

<div class="blue-with-img row corporate-half-sec">
    <div class="wrapper">
        <div class="bi-img lc-img" style="background-image:url('{{ asset('images/corporate-team-building-events.jpg') }}');" title="Corporate Team Building & Customer Appreciation Events"> 
        </div>
        <div class="bi-content lc-text" style="text-align: center;">
            <h2>AN IMPRESSIVE VENUE FOR YOUR CORPORATE EVENTS</h2>
            <hr>
            <p>CATERED PREMIUM FOOD & BEVERAGES TO YOUR TASTE<hr class="hr"> 
            ENCLOSED LOWER DECK WITH DANCE FLOOR <hr class="hr">
            GORGEOUS UPPER DECK WITH 360 DEGREE SKY VIEWS OF SAN DIEGO BAY <hr class="hr">
            STATE OF THE ART MULTIMEDIA SYSTEM <hr class="hr">
            US COAST GUARD CERTIFIED FOR UP TO 120 GUESTS</p>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>The luxurious Sirara is a unique and idyllic venue for corporate events and team building activities. Raise a toast, celebrate your success and revel in lovely San Diego harbor views and sounds of the sea aboard our splendid 65-foot Legacy Yacht. For corporate event planning and customer appreciation event ideas, talk to one of our corporate event experts or book your event online now via the forms below:</p>
        </div>
    </div>
</div>

<!-- Include booking form -->
@include('partials.booking')
<!-- End of booking form -->  

@endsection
