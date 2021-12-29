@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'others'))
@stop

@section('body-class', 'others-events')

@section('content')
<div class="home-banner innerpage row events-banner" style="background-image: url({{ asset('images/other-yacht-events-banner.jpg') }});">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>CREWED YACHT CHARTERS, HARBOR TOURS, DINNER CRUISES & OTHER PRIVATE EVENTS</h1> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>The elegant Sirara offers a comfortable and upscale venue for a wide variety of events and experiences.</p>
        </div>
    </div>
</div>

<div class="blue-with-img row">
    <div class="wrapper"> 
        <div class="bi-img">
            <img src="{{ asset('images/other-yacht-events-1.jpg') }}" alt="">
        </div>
        <div class="bi-content" style="text-align: center;">
            <h3>SOCIAL MIXERS AND NETWORKING EVENTS ON A YACHT</h3>
            <hr>
            <p>Business and pleasure mingle freely on our two luxurious open plan decks with stunning views of the surrounding Bay.</p>
        </div>        
    </div>
</div>
<div class="btc-row row"> 
    <div class="btc-leftcol">
        <img src="{{ asset('images/other-yacht-events-2.jpg') }}" alt="">
    </div>
    <div class="btc-rightcol">
        <h3>CINEMATIC EVENTS ON A PICTURESQUE YACHT</h3>
        <hr>
        <p>The Sirara provides a versatile vehicle to host filming, whether for shooting scenes on our decks, in the water, or as a launch pad for video-capture drones.</p>
    </div> 
</div>
<div class="blue-with-img row">
    <div class="wrapper"> 
        <div class="bi-img">
            <img src="{{ asset('images/other-yacht-events-3.jpg') }}" alt="">
        </div>
        <div class="bi-content" style="text-align: center;">
            <h3>SPORTING EVENTS</h3>
            <hr>
            <p>San Diego is a sporting city, and the Sirara provides an amazing platform for water sport spectators as well as participants, and an incomparable vantage point for fireworks and air shows.</p>
        </div>
    </div>
</div>
<div class="btc-row row"> 
    <div class="btc-leftcol">
            <img src="{{ asset('images/other-yacht-events-4.jpg') }}" alt="">
    </div>
    <div class="btc-rightcol">
        <h3>LIFE CYCLE CELEBRATIONS ON A PRIVATE YACHT</h3>
        <hr>
        <p>The Sirara provides a festive background for celebrating rites of passage such as a Bar/Bat mitzvah or a Quinceañera, graduations and anniversaries.</p>
    </div> 
</div>
<div class="blue-with-img row">
    <div class="wrapper">
         <div class="bi-content" style="text-align: center;">
            <h3>COMMEMORATIONS</h3>
            <hr>
            <p>The rhythms of the waves and the soft sounds of the eternal sea add dignity to funeral, memorial, or ash dispersal ceremonies aboard the Sirara.</p>
        </div>
        <div class="bi-img">
            <img src="{{ asset('images/other-yacht-events-5.jpg') }}" alt="">
        </div> 
    </div>
</div>
<div class="blue-content row">
    <div class="wrapper">
        <div>
            <h3>WHAT’S ON YOUR MIND?</h3>
            <p>The Sirara is a vehicle for whatever your imagination can conceive. Whatever themes and event ideas you may have, please feel free to contact our event specialists and consult with us to develop unique concepts for your special days and spectacular evenings at sea aboard our one-of-a-kind luxury craft.</p>
        </div>
    </div>
</div>

<!-- Include booking form -->
@include('partials.booking')
<!-- End of booking form -->  

@endsection
