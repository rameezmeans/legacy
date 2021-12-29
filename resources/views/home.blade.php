@extends('layouts.basic') 
@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'home'))
@stop
@section('body-class', 'home')
@section('content')
<div class="home-banner row" style="background-image: url({{ asset('images/home-banner-private-yacht-charters.jpg') }});" title="Private Yacht Charters and Events in San Diego Bay">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>SAN DIEGO'S MOST ELEGANT PRIVATE YACHT CHARTER FOR YOUR SPECIAL EVENT</h1>
                    <a href="{{ url('/your-yachts') }}">TOUR LUXURY YACHT SIRARA <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="banner-tagline row">
    <div class="wrapper">
        <h2><a href="{{ url('/contact-us') }}">REGISTER FOR OUR GRAND OPENING YACHT CHARTER EVENT </a></h2>
    </div>
</div>
<div class="video-section row">
    <div class="wrapper">
        <div class="video-block">
            <a href="{{ url('/plan-your-event/corporate') }}"><img src="{{ asset('images/home-video-img-corporate-yacht-charters.jpg') }}" alt="Highest Quality Corporate Yacht Charters in San Diego Bay"></a>
            <!-- <a href="javascript: void(0)" class="play-icon">
                <img src="{{ asset('images/play-icon.png') }}" alt="Click here to play the video">
            </a> -->
        </div>
        <div class="video-description">
            <h3><span>“</span><a href="{{ url('/plan-your-event/corporate') }}">THE HIGHEST QUALITY VENUE <br>
                FOR <strong>CORPORATE YACHT <br>
                CHARTERS</strong>, <strong>TEAM BUILDING</strong>, & <br>
                <strong>CLIENT APPRECIATION EVENTS </strong><br>
                IN SAN DIEGO BAY</a><span>”</span></h3>
        </div>
    </div>
</div>
<div class="event-form-section row" id="success">
    <div class="wrapper">
        <h3>PLAN YOUR CUSTOM YACHT CHARTER EVENT</h3>
        <form class="" action="{{ url('/planevent') }}" id="planForm" method="post"  onsubmit="return validatePlan()">
            {{ csrf_field() }}
            {!! Form::text('name', '', array('id' => 'name','placeholder' => 'Your Name:')) !!}
            {!! Form::text('phone', '', array('id' => 'phone','placeholder' => 'Phone Number:  Optional')) !!}
            {!! Form::text('email', '', array('id' => 'email','placeholder' => 'Email Address:')) !!}
            {!! Form::text('datetime', '', array('id' => 'datetime','placeholder' => 'Day/Time:')) !!} 
            <input type="submit" value="GET STARTED">
        </form>

        @if(Session::has('mailstatus'))
            <p class="mailstatus">{{ Session::get('mailstatus') }}</p>
        @endif
    </div>
</div>
<div class="bottom-two-col row">
    <div class="wrapper">
        <div class="btc-row row">
            <div class="btc-leftcol">
                 <a href="{{ url('/your-yachts') }}"><img src="{{ asset('images/home-sirara-san-diego-bay.jpg') }}" alt="Luxury Yacht Sirara in San Diego Bay"></a>
            </div>
            <div class="btc-rightcol">
                <h3>SAVE YOUR DATE ON THE LUXURY YACHT SIRARA</h3>
                <hr>
                <a href="{{ url('/book-now') }}">RESERVE YOUR EXPERIENCE TODAY <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="btc-row row">
            <div class="btc-leftcol">
                 <a href="{{ url('/plan-your-event/wedding') }}"><img src="{{ asset('images/home-yacht-reception-venue.jpg') }}" alt="Finest Yacht Weddings in San Diego Bay"></a>
            </div>
            <div class="btc-rightcol">
                <h3><a href="{{ url('/plan-your-event/wedding') }}">THE MOST STYLISH <br>RECEPTION VENUE FOR <br>UPSCALE <strong>YACHT WEDDINGS</strong>, <br><strong>ENGAGEMENTS</strong> & <strong>ANNIVERSARIES</strong></a></h3>
                <hr>
                <a href="{{ url('/your-yachts') }}">EXPLORE THE SIRARA <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="btc-row row">
            <div class="btc-leftcol">
                <a href="{{ url('/plan-your-event') }}"><img src="{{ asset('images/home-private-yacht-charter.jpg') }}" alt="Private Yacht Charters for Birthdays, Parties, Memorials, Fundraising, & More."></a>
            </div>
            <div class="btc-rightcol">
                <h3> A STUNNINGLY IMPRESSIVE SETTING FOR PRIVATE YACHT PARTIES WITH 360&deg; VIEWS OF THE BAY</h3>
                <hr>
                <a href="{{ url('/plan-your-event') }}">SEE EVENT PACKAGES <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>  
</div>

@endsection

