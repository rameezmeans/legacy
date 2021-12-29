@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'about_us'))
@stop

@section('body-class', 'about-us')

@section('content') 
<div class="home-banner innerpage row about-banner" style="background-image: url({{ asset('images/about-legacy-cruises-banner.jpg') }});" title="About Legacy Cruises and Events">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description">
                <div>
                    <h1>About Us</h1> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="blue-content row">
    <div class="wrapper">
        <div>
            <p>Legacy Cruises and Events is proud to introduce the Sirara, a one-of-a-kind cruising vessel for hosting events on the serene waters of beautiful San Diego Bay. We offer this classic, newly renovated, luxury commercial yacht for your event, setting sail around the Bay, providing – together with our partners superb all-encompassing personalized services and exclusive first-class experiences to make your special day or evening unforgettably spectacular.</p>
        </div>
    </div>
</div>

<div class="blue-with-img row">
    <div class="wrapper">
        <div class="bi-img">
            <img src="{{ asset('images/about-legacy-cruises-our-mission.jpg') }}" alt="Our Mission at Legacy Cruises and Events">
        </div>
        <div class="bi-content" style="text-align: center;">
            <h3>OUR MISSION</h3>
            <hr>
            <p>Legacy is dedicated to creating for our selective clientele the kind of luxury cruise experience that is typically available only to the ultra-rich. Our flagship yacht has a storied legacy of its own, constructed with an ingenious design in the 1970s and thoroughly overhauled and upgraded to our exacting specifications. In 2018, the Sirara is launched to realize our vision of making a luxurious yacht cruise experience available for your private and corporate events.</p>
        </div>
    </div>
</div>

<div class="about-content row">
    <div class="wrapper">
        <h3>OUR VISION</h3>
        <hr>
        <div class="blue-content">
            <p>This is a commercial vessel built to last. The quality and workmanship of the fiberglass hull is second to none. The exceptionally wide-beamed hull provides unusually expansive deck space. Legacy has now enhanced this ingenious craft with wholly new fittings and flooring, adding a luxurious top deck to further expand guest capacity and comfort. </p>
            <p>Legacy has been exceptionally fortunate in the realization of our vision. Along the way we have fostered a close relationship with the local US Coast Guard office from the planning phase through the restoration phase, ensuring the highest levels of safety in construction. We have consulted with leading ship builders, renovators, and interior designers to fulfill our exacting specifications.</p>
        </div>
    </div>
</div>
<div class="about-content row">
    <div class="wrapper">
        <div class="ph-icon">
            <img src="{{ asset('images/icon1.png') }}" alt="">
        </div>
        <h3>OUR PARTNERS</h3> 
        <div class="blue-content">
            <p>Legacy Cruises and Events works with leading corporate and personal event planners as well as leading booking and travel agencies. The Sirara is a unique luxury vessel with a USCG certified capacity of 120 passengers, exceeding most of the commercial craft in San Diego Bay and providing professional wedding and event planner with an incomparable venue for cost-effectively hosting larger ceremonies, receptions and parties as well as corporate events. If serving upscale individuals and businesses and delivering value-for-money is your focus and you wish to be considered for inclusion as a Legacy Partner, please complete our <a href="{{ url('/contact-us') }}"><strong>contact form</strong></a> and we will be in touch.</p>
        </div>
    </div>
</div>
<!--
<div class="book-event-section row contact-form" id="success">
    <div class="bes-form row">
        <div class="wrapper">
            @if(Session::has('mailstatus'))
                <p class="mailstatus">{{ Session::get('mailstatus') }}</p>
            @endif
            <form action="{{ url('/about-us') }}" id="aboutForm" method="post" onsubmit="return validateAbout()">
                 {{ csrf_field() }}
                <div class="input-row row">
                    <div class="input-col2">
                        <label for="firstname">Your Name</label>
                        {!! Form::text('yname', '', array('id' => 'yname', 'required' => 'required')) !!}
                    </div>
                    <div class="input-col2">
                        <label for="Company Name">Company Name</label>
                        {!! Form::text('cname', '', array('id' => 'cname', 'required' => 'required')) !!}
                    </div>
                </div>
                <div class="input-row row">
                    <div class="input-col2">
                        <label for="email">Email</label>
                        {!! Form::text('email', '', array('id' => 'email', 'required' => 'required')) !!}
                    </div>
                    <div class="input-col2">
                        <label>Phone Number</label> 
                        {!! Form::text('phone', '', array('id' => 'phone', 'required' => 'required')) !!}
                    </div> 
                </div>
                <div class="input-row row">
                    <label for="form_message">Details about your company, your services, and your interest in becoming a Legacy Partner</label>
                    {!! Form::textarea('message', '', array('id' => 'message', 'required' => 'required')) !!}
                </div>
                <div class="input-row row">
                    <div class="input-captcha">
                        <div class="g-recaptcha" data-sitekey="6LfmMygUAAAAAD9tDGbGvHcJdh-jb3rhIZuRf4DI"></div>
                        {!! Form::hidden('hiddenRecaptcha', '', array('id' => 'hiddenRecaptcha','class' => 'hiddenRecaptcha')) !!}
                    </div>
                    <div class="input-submit">
                        <input type="submit" value="SEND">
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
-->
@endsection
