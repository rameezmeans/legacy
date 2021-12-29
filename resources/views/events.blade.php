@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'plan_an_event'))
@stop

@section('body-class', 'plan-an-event')

@section('content')
<div class="home-banner innerpage row event-banner" style="background-image: url({{ asset('images/plan-private-yacht-events-banner.jpg') }});" title="Private Luxury Yachts Charters & Events on the San Diego Bay">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>SAN DIEGO'S MOST ELEGANT PRIVATE YACHT CHARTER FOR YOUR UPSCALE EVENTS</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="banner-bottom">
    <div class="wrapper">
        <ul>
            <li><a href="{{ url('/plan-your-event/corporate') }}">Corporate Events</a></li>
            <li><a href="{{ url('/plan-your-event/wedding') }}">Weddings</a></li>
            <li><a href="{{ url('/plan-your-event/birthdays') }}">Birthdays</a></li>
            <li><a href="{{ url('/plan-your-event/others') }}">Other Events</a></li>
        </ul>
        <a href="{{ url('/book-now') }}" class="banner-book">Book Now</a>
    </div>
</div>
<div class="blue-content row">
    <div class="wrapper">
        <p>The Sirara is the only luxury yacht of its class available on-demand for private yacht charters. Your guests will remember every minute spent with you aboard this stunning vessel effortlessly cruising the beautiful waterways of San Diego. <br><br> 
        Whether you’re planning a holiday party, a movie shoot, a fundraiser, a wedding or bar mitzvah, a corporate dinner party or celebration, or just hanging out on a boat with some very special friends or clients, the Sirara is a unique private party venue to assure a charter experience that will live forever in the fond memories of you and your guests.<br> <br>
        Following are some suggestions of possible private yacht charter events and parties that we think would be perfect for the Sirara. But don’t let us limit your imagination. We invite you to dream up new events and experiences to be hosted aboard our luxury yacht on San Diego Bay!</p>
    </div>
</div>
<div class="event-content">
    <div class="wrapper"> 

        <div class="ph-icon">
            <img src="{{ asset('images/icon1.png') }}" alt="">
        </div>
        <h2>SELECT YOUR PRIVATE YACHT CHARTER EVENT TO LEARN MORE</h2>

        <ul>
            <li>
                <img src="{{ asset('images/events-corporate-yacht-charters.jpg') }}" alt="Corporate Yacht Charters on the San Diego Bay">
                <h3>Corporate Events</h3>
                <a href="{{ url('/plan-your-event/corporate') }}">Click Here</a>
            </li>
            <li>
                <img src="{{ asset('images/events-yacht-weddings.jpg') }}" alt="Yacht Weddings on the San Diego Bay">
                <h3>Yacht Weddings</h3>
                <a href="{{ url('/plan-your-event/wedding') }}">Click Here</a>
            </li>
            <li>
                <img src="{{ asset('images/events-yacht-birthday-parties.jpg') }}" alt="Private Yacht Birthday Parties in San Diego">
                <h3>Birthday Parties</h3>
                <a href="{{ url('/plan-your-event/birthdays') }}">Click Here</a>
            </li>
            <li>
                <img src="{{ asset('images/events-other-yacht-parties.jpg') }}" alt="Private Luxury Yacht Charters for Parties, Memorials, Fundraising, & More.">
                <h3>Other Events</h3>
                <a href="{{ url('/plan-your-event/others') }}">Click Here</a>
            </li>
        </ul>
    </div>
</div>

<!-- Include booking form -->
@include('partials.booking')
<!-- End of booking form -->  

@endsection
