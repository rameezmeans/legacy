@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'checkout'))
@stop

@section('body-class', 'checkout')

@section('content')
<script src='https://js.stripe.com/v2/' type='text/javascript'></script>
<div class="clear"></div>
<div class="booking-sec checkout">
    <div class="container">
        @if ($erromsg = Session::get('errorbooked'))
            <div class="custom-alerts alert alert-danger fade in">
                {!! $erromsg !!}
            </div>
            <?php Session::forget('errorbooked');?>
        @endif
        <h2>BILLING INFORMATION</h2>
        <div class="legacy-loader">
            <i class="fa fa-spinner fa-spin spin-big"></i>
        </div>
        <div class="booking-left booking-box-b">
            <?php if(Session::has('legacyOrders.payMethod')){
                    $payMethod = Session::get('legacyOrders.payMethod');
                    if($payMethod == 'paypartial') {
                        $checked = 'paypartial';
                    } else{
                        $checked = 'payfull';
                    }
                } else{
                    $checked = 'payfull';
                } ?>
            <?php if(!Session::has('legacyOrders.bookingId')){?>
                <form class="form-horizontal" method="POST" id="paymethods-form" role="form" action="{!! URL::route('payment.paylater') !!}" >
                    {{ csrf_field() }}
                    <input type="radio" class="paymethods" id="payfull" name="paymethods" value="payfull" <?php if ( $checked == 'payfull') { echo 'checked'; } ?> /><label for="payfull">&nbsp;&nbsp;Pay in Full Now</label>
                    <input type="radio" class="paymethods" id="paypartial" name="paymethods" value="paypartial" <?php if ( $checked == 'paypartial') { echo 'checked';  } ?> /><label for="paypartial">&nbsp;&nbsp;Pay 25% Deposit</label>
                    <input type="radio" class="paymethods" id="paylater" name="paymethods" value="paylater" /><label for="paylater">&nbsp;&nbsp;Hold My Booking and Pay Later</label>
                </form>
            <?php } else{ ?>
                <input type="radio" class="paymethods" id="payfull" name="paymethods" value="payfull" checked style="width:0px; height:0px; visibility:hidden; opacity:0;"/>
            <?php }?>
            <div class="pay-main">
                <div class="stripe-main">
                    <input type="radio" id="paycard" name="paymentOption" value="paycard" checked />
                    <label for="paycard">&nbsp;&nbsp;Credit/Debit/Prepaid Card</label>
                    <img src="{{ asset('images/cards.png') }}" alt="cards" class="cards">
                    <form accept-charset="UTF-8" action="{{ url('/checkout') }}" class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{$settings->stripe_publishable_key}}"
                    id="payment-form" method="post">
                    {{ csrf_field() }}
                    <div class="input-row row">
                        <div class="input-col2">
                            <label for="card-number">Card Number:</label>
                            {!! Form::text('card-number', '', array('id' => 'cardnumber','class' => 'card-number','autocomplete' => 'off', 'maxlength' => '20', 'size' => '20')) !!}
                        </div>
                        <div class="input-col2">
                            <label for="cvv">Security Code:</label>
                            {!! Form::text('card-cvc', '', array('id' => 'cardcvc','class' => 'card-cvc','autocomplete' => 'off', 'maxlength' => '4', 'size' => '4')) !!}
                            <div class="tooltip">
                                <span class="tooltipm">?</span>
                                <span class="tooltiptext">ex. 123</span>
                            </div>
                        </div>
                    </div>
                    <div class="input-row row">
                        <label for="name">Name on Card:</label>
                        {!! Form::text('nameoncard', '', array('id' => 'nameoncard','autocomplete' => 'off')) !!}
                    </div>
                    <div class="input-row row expiration">
                        <label for="expiration">Expiration Date:</label>
                        <div class="input-col2">
                            {!! Form::select('card-expiry-month', ['01' => '01 - January', '02' => '02 - February', '03' => '03 - March', '04' => '04 - April', '05' => '05 - May', '06' => '06 - June', '07' => '07 - July', '08' => '08 - August', '09' => '09 - September', '10' => '10 - October', '11' => '11 - November', '12' => '12 - December'], null,array('id' => 'cardexpirymonth','class' => 'card-expiry-month','autocomplete' => 'off')) !!}
                        </div>
                        <div class="input-col2">
                            {!! Form::select('card-expiry-year', ['2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020', '2021' => '2021', '2022' => '2022', '2023' => '2023', '2024' => '2024', '2025' => '2025'], null, array('id' => 'cardexpiryyear','class' => 'card-expiry-year','autocomplete' => 'off')) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="stripe-alert">
                        @if ((Session::has('success-message')))
                        <div class="alert alert-success col-md-12">
                            {{ Session::get('success-message') }}
                            <?php Session::forget('success-message');?>
                        </div>
                        @endif
                        @if ((Session::has('fail-message')))
                        <div class="alert alert-danger col-md-12">
                            {{Session::get('fail-message') }}
                            <?php Session::forget('fail-message');?>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="paypal-main">
                    <input type="radio" id="paypalpal" name="paymentOption" value="paypalpal" />
                    <label for="paypalpal"><img src="{{ asset('images/paypal.png') }}" alt="paypal" class="paypal"></label>
                    <form class="form-horizontal" method="POST" id="payment-form2" role="form" action="{!! URL::route('payment.paypal') !!}" >
                        {{ csrf_field() }}
                    </form>
                    <div class="paypal-alert">
                        @if ($message = Session::get('success'))
                        <div class="custom-alerts alert alert-success fade in">
                            {!! $message !!}
                        </div>
                        <?php Session::forget('success');?>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="custom-alerts alert alert-danger fade in">
                            {!! $message !!}
                        </div>
                        <?php Session::forget('error');?>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="booking-right purchase-summary-right">
            <h3>BOOKING SUMMARY</h3>
            <?php if(Session::has('legacyOrders.bookingId')){?>
                <div class="total">
                    Total: <strong>${{number_format($entries->due, 2)}}</strong>
                </div>
            <?php } else { ?>
                <div class="total">
                    Total: <strong>${{number_format($entries->total, 2)}}</strong>
                </div>
                @if($entries->discount > 0)
                    <div class="total-saving">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>Promo Applied</td>
                                <td class="total-save">${{number_format($entries->discount, 2)}}</td>
                            </tr>
                        </table>
                    </div>
                @endif
            <?php }?>
            <div class="to-complete-block">
                <p>By Clicking on the "COMPLETE YOUR BOOKING" button, you are agreeing to our <a href="/terms-of-service" target="_blank">Terms & Conditions</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.</p>
                <a href="javascript:void(0)" class="complete-purchase-btn" id="complete-purchase">COMPLETE YOUR BOOKING</a>
            </div>
        </div>
    </div>
</div>
<!-- Add CSRF-Token/Page name to Ajax request -->
<script type="text/javascript">
//Seup csrf token in header
$.ajaxSetup({
    headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' }
});
</script>
@endsection
