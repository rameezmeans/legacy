@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'contact_us'))
@stop

@section('body-class', 'contact-us')

@section('content')
<div class="home-banner innerpage row contact-banner" style="background-image: url({{ asset('images/contact-banner.jpg') }});">
    <div class="transparent">
        <div class="wrapper">
            <div class="banner-description ">
                <div>
                    <h2>Contact Us</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-content row">
    <div class="wrapper">
        <p>Legacy Cruises and Events<br>
            600 W Broadway, Suite 700<Br>
            San Diego, CA 92101<Br>
            Local: (619) 550-3800<Br>
            Toll-free: +1 (844) LEGASEA (1-844-534-2732)</p>
        <a href="mailto:team@legacycruisessd.com">team@legacycruisessd.com</a>
    </div>
</div>

<div class="wrapper contact-intro" id="success">
    <h1>CONTACT US</h1>
    <p>YACHT VIEWINGS, BOOKING INQUIRIES, QUESTIONS, AND SUGGESTIONS</p>
</div>

<div class="book-event-section row contact-form">
    <div class="bes-form row">
        <div class="wrapper">
            @if(Session::has('mailstatus'))
                <div style="text-align: center;">
                    <p class="mailstatus">{{ Session::get('mailstatus') }}</p>
                </div>
            @endif
            <form action="{{ url('/contact-us') }}" id="contactForm" method="post" onsubmit="return validateContact()">
                 {{ csrf_field() }}
                <div class="input-row row">
                    <div class="input-col2">
                        <label for="firstname">First Name:</label>
                        {!! Form::text('firstname', '', array('id' => 'firstname', 'tabindex' => '1')) !!}
                    </div>
                    <div class="input-col2">
                        <label for="Last Name">Last Name:</label>
                        {!! Form::text('lastname', '', array('id' => 'lastname', 'tabindex' => '2')) !!}
                    </div>
                </div>
                <div class="input-row row">
                    <div class="input-col3 contact-form-field1">
                        <label>Phone Number</label>
                        ( {!! Form::text('phone1', '', array('id' => 'phone1', 'class' => 'phone', 'maxlength' => '3', 'size' => '3', 'tabindex' => '4')) !!}  )
                        {!! Form::text('phone2', '', array('id' => 'phone2', 'class' => 'phone', 'maxlength' => '3', 'size' => '3', 'tabindex' => '5')) !!}  -
                        {!! Form::text('phone3', '', array('id' => 'phone3', 'class' => 'phone', 'maxlength' => '4', 'size' => '4', 'tabindex' => '6')) !!}
                        {!! Form::hidden('phone', '', array('id' => 'phone', 'required' => 'required')) !!}
                    </div>
                    <div class="input-col3 contact-form-field2">
                        <label for="email">Email:</label>
                        {!! Form::text('email', '', array('id' => 'email', 'tabindex' => '3')) !!}
                    </div>
                </div>
                <div class="input-row row">
                    <label for="form_message">Any additional details?</label>
                    {!! Form::textarea('message', '', array('id' => 'message', 'tabindex' => '7')) !!}
                </div>
                <div class="input-row row">
                    <div class="input-captcha">
                        <div class="g-recaptcha" data-sitekey="6LfmMygUAAAAAD9tDGbGvHcJdh-jb3rhIZuRf4DI"></div>
                        {!! Form::hidden('hiddenRecaptcha', '', array('id' => 'hiddenRecaptcha','class' => 'hiddenRecaptcha', 'tabindex' => '8')) !!}
                    </div>
                    <div class="input-submit">
                        <input type="submit" value="SEND" tabindex="9">
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
