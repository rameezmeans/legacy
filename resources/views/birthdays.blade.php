@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'birthdays'))
@stop

@section('body-class', 'birthdays')

@section('content')
<div class="home-banner innerpage row" style="background-image: url({{ asset('images/birthday-yacht-parties-banner.jpg') }});" title="Luxury Yacht Rentals for Birthdays">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>MAKE THIS BIRTHDAY THE MOST MEMORABLE OF A LIFETIME ABOARD A LUXURY YACHT!</h1>
                    <a href="{{ url('/plan-your-event') }}">PLAN A YACHT BIRTHDAY PARTY</a> OR <a href="{{ url('/book-now') }}">BOOK NOW</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>A luxury yacht is an original and unforgettable venue for celebrating a birthday or other special celebrations. Picture yourself among close friends and loved ones as you bask in the warm breeze and enjoy breathtaking views of San Diego Bay from our stylish private yacht. The Sirara, with its exquisite fittings and spacious double decks, is at the ready to host your special party with a superb captain and stellar crew at your service to make you and all your guests feel at home on the serene sea.</p>
        </div>
    </div>
</div>

<div class="blue-with-img row">
    <div class="wrapper">
        <div class="bi-img lc-img" style="background-image:url('{{ asset('images/birthday-private-yacht-parties.jpg') }}');" title="Private Yacht Birthday Party in San Diego"> 
        </div>
        <div class="bi-content lc-text" style="text-align: center;">
            <h2>THE PERFECT VENUE FOR YOUR YACHT BIRTHDAY PARTY</h2>
            <hr>
            <p>CATERED PREMIUM FOOD & BEVERAGES TO YOUR TASTE<hr class="hr">  
                ENCLOSED LOWER DECK WITH DANCE FLOOR <hr class="hr">
                GORGEOUS UPPER DECK WITH 360 DEGREE VIEWS OF SAN DIEGO BAY <hr class="hr"> 
                STATE OF THE ART MULTIMEDIA SYSTEM <hr class="hr"> 
                US COAST GUARD CERTIFIED FOR UP TO 120 GUESTS</p>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>The luxurious Sirara is the idyllic venue for yacht birthday parties and special events. Raise a toast, blow out some candles and revel in San Diego harbor views aboard our splendid 65-foot Legacy Cruises Yacht. With a stunning birthday party boat, gourmet food & beverages, open sky deck, posh dance floors and DJ music, it just can't get any better!</p>
        </div>
    </div>
</div>

<!-- Include booking form -->
@include('partials.booking')
<!-- End of booking form -->  

@endsection
