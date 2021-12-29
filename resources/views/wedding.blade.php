@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'weddings'))
@stop

@section('body-class', 'weddings')

@section('content')
<div class="home-banner innerpage wedding-banner row" style="background-image: url({{ asset('images/weddings-on-a-yacht-banner.jpg') }});" title="San Diego Bay Wedding on a Yacht">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>A UNIQUE WEDDING RECEPTION VENUE FOR A LOVING COUPLE TO LAUNCH THEIR NEW LIFE!</h1>
                    <a href="{{ url('/plan-your-event') }}">PLAN YOUR WEDDING ON A YACHT</a> OR <a href="{{ url('/book-now') }}">BOOK NOW</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>Picture the happy couple surrounded with friends and loved ones as they celebrate their love amid the stunning scenes of San Diego Bay from our intimate beautifully designed craft. The Sirara, with its upscale fittings and tastefully designed decks, is ready and waiting to host your wedding on a yacht with a seasoned captain and dedicated crew at your service to help you and all your guests celebrate romance and partnership on the shimmering sea. </p>
        </div>
    </div>
</div>

<div class="blue-with-img row">
    <div class="wrapper">
        <div class="bi-img lc-img" style="background-image:url('{{ asset('images/wedding-yacht-charter.jpg') }}');" title="Wedding Yacht Charters in San Diego Bay"> 
        </div>
        <div class="bi-content lc-text" style="text-align: center;">
            <h2>THE PERFECT VENUE FOR YOUR WEDDING ON A YACHT</h2>
            <hr>
            <p>CATERED PREMIUM FOOD & BEVERAGES TO YOUR TASTE <hr class="hr"> 
                ENCLOSED LOWER DECK WITH DANCE FLOOR <hr class="hr"> 
                GORGEOUS UPPER DECK WITH 360 DEGREE VIEWS OF SAN DIEGO BAY <hr class="hr"> 
                STATE OF THE ART MULTIMEDIA SYSTEM <hr class="hr"> 
                US COAST GUARD CERTIFIED FOR UP TO 120 GUESTS</p>
        </div>
    </div>
</div>

<div class="points-highlighted row">
    <div class="wrapper">
        <div class="ph-icon">
            <img src="{{ asset('images/icon1.png') }}" alt="">
        </div>
        <div class="blue-content"> 
                <p>The stunning Sirara is an intimate romantic venue for a memorable engagement, wedding or anniversary on a yacht. Raise a toast to the happy couple, celebrate the power of love, and gaze out to splendid San Diego harbor views aboard our stylish 65-foot Legacy luxury yacht. </p> 
                <p>Our expert creative consultants will help you plan a truly unique wedding on a yacht that reflects your values, tastes and budget, from ceremony to reception. We take care of all the logistics so you can relax and enjoy your special day stress-free in the company of your family and friends. Legacy Cruises looks forward to making your yacht wedding aboard the Sirara an unforgettable voyage that joyfully celebrates your life together.</p> 
        </div>
    </div>
</div>

<!-- Include booking form -->
@include('partials.booking')
<!-- End of booking form -->  

@endsection
