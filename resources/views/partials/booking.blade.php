<div class="book-event-section row"  id="success">
    <div class="bes-heading row">
        <div class="wrapper">
            <h3>BOOK YOUR EVENT TODAY</h3>
            <p><a href="{{ url('/book-now') }}">BOOK ONLINE NOW</a> OR USE FORM BELOW TO GET MORE INFO</p>
        </div>
    </div>

    <div class="bes-form row">
        <div class="wrapper">
            @if(Session::has('mailstatus'))
                <div style="text-align: center;">
                    <p class="mailstatus">{{ Session::get('mailstatus') }}</p>
                </div>
            @endif
            <form class="" action="{{ url('/bookevent') }}" id="bookingForm" method="post"  onsubmit="return validateBooking()">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $redirectur}}" name="redirecturl">
                <div class="input-row row">

                    <div class="input-col2">
                        <label for="firstname">First Name:</label>
                        {!! Form::text('firstname', '', array('id' => 'firstname')) !!}
    					@if ($errors->has('firstname'))
    						<span class="help-block">
    							<strong>{{ $errors->first('firstname') }}</strong>
    						</span>
    					@endif
    				</div>
                    <div class="input-col2">
                        <label for="Last Name">Last Name:</label>
                        {!! Form::text('lastname', '', array('id' => 'lastname')) !!}
                    </div>
                </div>
                <div class="input-row row">
                    <div class="input-col3">
                        <label for="phone">Phone Number:</label>
                        ( {!! Form::text('phone1', '', array('id' => 'phone1', 'class' => 'phone', 'maxlength' => '3', 'size' => '3')) !!}  )
                        {!! Form::text('phone2', '', array('id' => 'phone2', 'class' => 'phone', 'maxlength' => '3', 'size' => '3')) !!}  -
                        {!! Form::text('phone3', '', array('id' => 'phone3', 'class' => 'phone', 'maxlength' => '4', 'size' => '4')) !!}
                        {!! Form::hidden('phone', '', array('id' => 'phone', 'required' => 'required')) !!}

    					@if ($errors->has('phone1') || $errors->has('phone2') || $errors->has('phone3'))
    						<span class="help-block">
    							<strong>phone number is required.</strong>
    						</span>
    					@endif
    				</div>
                    <div class="input-col3">
                        <label for="email">Email Address:</label>
                        {!! Form::text('email', '', array('id' => 'email')) !!}
    					@if ($errors->has('emailbook'))
    						<span class="help-block">
    							<strong>{{ $errors->first('emailbook') }}</strong>
    						</span>
    					@endif
    				</div>
                    <div class="input-col3">
                        <label for="event">Day of Event:</label>
                        {!! Form::date('dayofevent', \Carbon\Carbon::now(), array('id' => 'eventdate')) !!}
    					@if ($errors->has('dayofevent'))
    						<span class="help-block">
    							<strong>{{ $errors->first('dayofevent') }}</strong>
    						</span>
    					@endif
    				</div>
                </div>
                <div class="input-row row">
                    <label for="additional">Any additional details?</label>
                    {!! Form::textarea('message', '', array('id' => 'message')) !!}
                </div>
                <div class="input-row row">
                    <div class="input-captcha">
                        <div class="g-recaptcha" data-sitekey="6LfmMygUAAAAAD9tDGbGvHcJdh-jb3rhIZuRf4DI"></div>
                        {!! Form::hidden('hiddenRecaptcha', '', array('id' => 'hiddenRecaptcha','class' => 'hiddenRecaptcha')) !!}
                    </div>
                    <div class="input-submit">
                        <input type="submit" id="submit-booking" value="SEND">
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript">
    const scriptURL = 'https://script.google.com/macros/s/AKfycbzmlSRy5qb0wSx4mjOBGxI3aJRYNWrXWW-sAA9nydMsNJoY1bI/exec'
    const form = document.forms['bookingForm']

    //	if(form !== undefined){

    form.addEventListener('submit', e => {
        // e.preventDefault()
        fetch(scriptURL, { method: 'POST', body: new FormData(form)})
                .then(response => console.log('Success!', response))
    .catch(error => console.error('Error!', error.message))
    })



</script>
