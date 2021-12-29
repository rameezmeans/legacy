@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'book_now'))
@stop

@section('body-class', 'book-now')

@section('content')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <style>

        .ui-datepicker{

            width: 99% !important;
            height: 305px !important;
        }
        .ui-datepicker table{

            height: 275px !important;

        }

    </style>
<div class="clear"></div>

<div class="booking-sec">

    <div class="booking-menu">
        @if ($erromsg = Session::get('errorbooknow'))
            <div class="custom-alerts alert alert-danger fade in" style="color: red; text-align: center;">
                {!! $erromsg !!}
            </div>
            <?php Session::forget('errorbooknow');?>
        @endif

        <ul>
            <li class="active step1"><a href="javascript:void(0);" class="enable" data-step="step1">1. Date & Time</a></li>
            <li class="step2" style="display:none"><a href="javascript:void(0);" class="" data-step="step2">2. Your Yacht</a></li>
            <li class="step3"><a href="javascript:void(0);" class="" data-step="step3">2. Your Details</a></li>
            <li class="step4"><a href="javascript:void(0);" class="" data-step="step4">3. Event Details</a></li>
            <li class="step5"><a href="javascript:void(0);" class="" data-step="step5">4. Boarding Location(s)</a></li>
            <li class="step6"><a href="javascript:void(0);" class="" data-step="step6">5. Food Catering</a></li>
            <li class="step7"><a href="javascript:void(0);" class="" data-step="step7">6. Beverage Service</a></li>
            <li class="step8"><a href="javascript:void(0);" class="" data-step="step8">7. ENTERTAINMENT</a></li>
            <li class="step9"><a href="javascript:void(0);" class="" data-step="step9">8. BOOKING Summary</a></li>
        </ul>
    </div>

    {!! Form::open(array('action' => 'OrderController@store')) !!}
        <div class="container booking-box-a" id="step1">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <h2>DATE & TIME</h2>

            <div class="booking-calender">
                <div id="calendar"></div>
            </div>
            <div class="booking-right">
                <h2>RESERVATION</h2>
                <ul>
                    <li><input type="text" class="date" value="<?php echo date('m-d-Y');?>" disabled></li>

                    <li>
                        <label>START AT :</label>
                        <div class="time-dropdown">
                            <a href="javascript:void(0);" class="starttime">Select Time</a>
                            <div class="start-date-list" id="start-time">
                                @if (!empty($totalTimes))
                                    @php($i = 0)
                                    @foreach( $totalTimes as $key => $totalTime)
                                        @if( $i == 0)
                                            <ul>
                                        @endif
                                        @if (in_array($key, $bookedTimes))
                                            <li class="disable"><?php echo $totalTime;?></li>
                                        @else
                                            <li><a href="javascript:void(0);" data-time="<?php echo $key;?>"><?php echo $totalTime;?></a></li>
                                        @endif
                                        @php($i++)
                                        @if( $i == 8)
                                            </ul>
                                            @php($i = 0)
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </li>
                    <li> <input type="checkbox" name="nextdate" id="nextdate" value="yes">CHECK IF FINISH TIME IS IN NEXT DAY</li>
                    <li>
                        <label>FINISH AT :</label>
                        <div class="time-dropdown">
                            <a href="javascript:void(0);" class="finishtime">Select Time</a>
                            <div class="start-date-list" id="finish-time">
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <p style=" font-weight: 600; font-size: 13px; text-align: right;  line-height: 30px; " id="3hour">3 Hour Minimum</p>
            <div class="nav">
                <a href="javascript:void(0);" data-step="step3" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a> 
            </div>
        </div>
        <div class="container steps" id="step2">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left booking-box-b">
                <div class="text">
                     <h2>SELECT YOUR LUXURY YACHT</h2>
                    <label><input type="checkbox" checked disabled>{{ $product->product_name }}</label><br>
                    {!!html_entity_decode($product->description)!!}
                </div>
                <div class="img">
                    <img src="{{ asset('images/booking-img1.jpg') }}" align="right">
                </div>
                <div class="nav">
                    <a href="javascript:void(0);" data-step="step1" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step3" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step1" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step3" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step3">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left">
                <h2>YOUR DETAILS</h2>

                <div class="bes-form row booking-box-c">
                    <div class="wrapper">
                        <div class="input-row row">
                            <div class="input-col2">
                                <label>*First Name</label>
                                {!! Form::text('f_name', $userArr['fname'] , array('id' => 'fname', 'required' => 'required')) !!}
                            </div>
                            <div class="input-col2">
                                <label>*Last Name</label>
                                {!! Form::text('l_name', $userArr['lname'] , array('id' => 'lname', 'required' => 'required')) !!}
                            </div>
                        </div>
                        <div class="input-row row">
                            <div class="input-col3">
                                <label>*Phone Number</label>
                                ( {!! Form::text('phone1', $userArr['phone1'], array('id' => 'phone1', 'class' => 'phone', 'maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}  )
                                {!! Form::text('phone2', $userArr['phone2'], array('id' => 'phone2', 'class' => 'phone', 'maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}  -
                                {!! Form::text('phone3', $userArr['phone3'], array('id' => 'phone3', 'class' => 'phone', 'maxlength' => '4', 'size' => '4', 'required' => 'required')) !!}
                                {!! Form::hidden('phone', $userArr['phone'] , array('id' => 'phone', 'required' => 'required')) !!}
                                <span id="error1" class="lerror" style="display:none;color:red;">Please enter a valid phone number</span>
                            </div>
                            <div class="input-col3">
                                <label>*Email</label>
                                {!! Form::text('email', $userArr['email'] , array('id' => 'email1', 'required' => 'required')) !!}
                                <span id="error" class="lerror" style="display:none;color:red;">Please enter a valid email address</span>
                            </div>
                        </div>
                        <div class="input-row row">
                            <div class="input-col3">
                                <label>*Your Role For This Booking</label>
                                {!! Form::select('booking_role', [ '' => '-- PLEASE SELECT --', 'Host' => 'HOST', 'Event Planner' => 'EVENT PLANNER', 'Booking Agent' => 'BOOKING AGENT', 'Other' => 'OTHER (SPECIFY)'], null, array('id' => 'bookingrole', 'required' => 'required')) !!}
                            </div>
                            <div class="input-col3 select-other">
                                <label>&nbsp;</label>
                                {!! Form::text('other', '', array('id' => 'other', 'class' => 'othr', 'placeholder'=> 'Please specify if selected other')) !!}
                            </div>
                        </div>
                        <div class="input-row row">
                            <label>Special Requests</label>
                            {!! Form::textarea('booking_special_request', '', array('id' => 'booking_special_request' )) !!}
                        </div>

                    </div>
                </div>

                <div class="nav">
                    <a href="javascript:void(0);" data-step="step1" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step4" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step1" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step4" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step4">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left">
                <h2>EVENT DETAILS</h2>

                <div class="bes-form row booking-box-d">
                    <div class="wrapper">
                        <div class="input-row row">
                            <div class="input-col3" style="margin-right:15px;">
                                <label>*Type of Event</label>
                                {!! Form::select('event_type', ['' => '-- PLEASE SELECT --', 'Wedding' => 'WEDDING', 'Corporate' => 'CORPORATE', 'Birthday Party' => 'BIRTHDAY PARTY', 'Other' => 'OTHER (SPECIFY)'], null, array('id' => 'eventtype', 'required' => 'required')) !!}
                            </div>
                            <div class="input-col3 mmargin">
                                <label>&nbsp;</label>
                                {!! Form::text('event_other', '', array('id' => 'eventother' , 'class' => 'othr', 'placeholder'=> 'Please specify if other')) !!}
                            </div>
                        </div>
                        <div class="input-row row">
                            <div class="input-col3 below">
                                <label>*Total Number of Guests</label>
                                {!! Form::text('event_no_guest', '', array('id' => 'event_no_guest' , 'maxlength' => '3', 'size' => '3', 'placeholder'=> '')) !!}
                            </div>
                            <div class="input-col3 below">
                                <label>*Number of Adults (over age 21)</label>
                                {!! Form::text('event_no_adult', '', array('id' => 'event_no_adult' , 'maxlength' => '3', 'size' => '3', 'placeholder'=> '')) !!}
                            </div>
                             <div class="input-col3 below nochild">
                                <label>*Number of Children</label>
                                {!! Form::text('event_no_child', '', array('id' => 'event_no_child' , 'maxlength' => '2', 'size' => '2', 'placeholder'=> '')) !!}
                            </div>
                            <div class="row">
                                <div class="input-col12">
                                    <span id="lcerror1" class="lc-error"></span>
                                </div>
                            </div>   
                        </div>


                        <div class="input-row row mmtop">
                            <label>Special Requests</label>
                            {!! Form::textarea('event_special_request', '', array('id' => 'event_special_request', 'required' => 'required')) !!}
                        </div>

                    </div>
                </div>

                <div class="nav">
                    <a href="javascript:void(0);" data-step="step3" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step5" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step3" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step5" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step5">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left catering-title">
                <h2>BOARDING LOCATION(S)</h2>
                <div class="row">
                    <div class="input-col12">
                        <span class="lc-error" id="lcerror2"></span>
                    </div>
                </div>
                 <div class="bes-form row booking-box-e">
                    <div class="wrapper">
                        @if (!empty($locationsArr))
                            @php($l = 1)
                            @foreach( $locationsArr as $location)
                                <div class="input-row row dockings l{{ $l }}" <?php if ( $l >=2) {?>style="display:none;"<?php } ?>>
                                    <div class="input-col3">
                                        <label>Boarding Location {{ $l }}</label>
                                        {!! Form::select('locations'.$l, $locationsArr, null, array('class' => 'location', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col2">
                                        <label>Number of Guests Boarding</label>
                                        {!! Form::text('no_guest_location'.$l, '', array('class' => 'location-guests','maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col1">
                                        <a href="javascript:void(0);" class="add-location" data-id="">Add To This Booking</a>
                                    </div>
                                    <div class="row">
                                        <div class="input-col12">
                                            <span class="lc-error loc-error"></span>
                                        </div>
                                    </div>
                                </div>
                                @php($l++)
                            @endforeach
                        @endif
                        @if( count($locationsArr) > 1)
                            <div class="input-col-add">
                                <a href="javascript:void(0);" class="l_addmore" data-loc="{{ count($locationsArr) }}"><strong>+</strong> Add Additional Boarding Location</a>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="nav">
                    <a href="javascript:void(0);" data-step="step4" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step6" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step4" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step6" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step6">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left catering-title">
                <h2>FOOD CATERING <Br> 
                    <!-- <font>Choose from our exquisite Buffet and/or Trays-passed food catering service</font> -->
                    <font>Feel free to skip this section. You can easily return to it later.</font>
                </h2>
                <div class="row">
                    <div class="input-col12">
                        <span class="lc-error" id="lcerror3"></span>
                    </div>
                </div>

                <div class="bes-form row booking-box-e">
                    <div class="wrapper">
                        @if (!empty($buffetsArr))
                            @php($b = 1)
                            @foreach( $buffetsArr as $buffet)
                                <div class="input-row row buffet b{{ $b }}" <?php if ( $b >=2) {?>style="display:none;"<?php } ?>>
                                    <div class="input-col3">
                                        <label>Buffet Style</label>
                                        {!! Form::select('buffets'.$b, $buffetsArr, null, array('class' => 'buffets', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col2">
                                        <label>Number of Guests</label>
                                        {!! Form::text('no_guest_buffets'.$b, '', array('class' => 'buffet-guests', 'maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col1">
                                        <a href="javascript:void(0);" class="add-buffet" data-id="">Add to this Booking</a>
                                    </div>
                                    <div class="row">
                                        <div class="input-col12">
                                            <span class="lc-error bf-error"></span>
                                        </div>
                                    </div> 
                                </div>
                                @php($b++)
                            @endforeach
                        @endif
                        @if( count($buffetsArr) > 1)
                            <div class="input-col-add">
                                 <a href="javascript:void(0);" class="b_addmore" data-loc="{{ count($buffetsArr) }}"><strong>+</strong> Add Additional Buffet Option</a>
                            </div>
                        @endif
                        @if (!empty($traysArr))
                            @php($t = 1)
                            @foreach( $traysArr as $tray)
                                <div class="input-row row tray t{{ $t }}" <?php if ( $t >=2) {?>style="display:none;"<?php } ?>>
                                    <div class="input-col3">
                                        <label>Your choice of Premium Passed Trays</label>
                                        {!! Form::select('trays'.$t, $traysArr, null, array('class' => 'trays', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col2">
                                        <label>Number of Trays</label>
                                        {!! Form::text('no_guest_trays'.$t, '', array('class' => 'tray-guests', 'maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col1">
                                        <a href="javascript:void(0);" class="add-tray" data-id="">Add to this Booking</a>
                                    </div>
                                    <div class="row">
                                        <div class="input-col12">
                                            <span class="lc-error tr-error"></span>
                                        </div>
                                    </div> 
                                </div>
                                @php($t++)
                            @endforeach
                        @endif
                        @if( count($traysArr) > 1)
                            <div class="input-col-add">
                                 <a href="javascript:void(0);" class="t_addmore" data-loc="{{ count($traysArr) }}"><strong>+</strong> Add Additional Trays</a>
                            </div>
                        @endif
                        <div class="input-row row mmtop">
                            <label>Additional Details and/or Special Instructions</label>
                            {!! Form::text('food_special_detail', '', array('id' => 'food_special_detail')) !!}
                        </div>
                    </div>
                </div>

                <div class="nav">
                    <a href="javascript:void(0);" data-step="step5" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step7" data-cstep="step6" class="skip">Skip This Step </a>
                    <a href="javascript:void(0);" data-step="step7" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step5" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step7" data-cstep="step6" class="skip">Skip This Step </a>
                <a href="javascript:void(0);" data-step="step7" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step7">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left catering-title beverage-space">
                <h2>BEVERAGE SERVICE <Br>
                    <!-- <font>Choose from a hosted bar and/or bottle service</font> -->
                    <font>Feel free to skip this section. You can easily return to it later.</font> 
                </h2> 
                <font class="beverge">Bartender fee is added at ${{$settings->hprice}} per bartender for half-day or ${{$settings->fprice}} per bartender for full-day.</font>
                <font class="beverge">Number of bartenders is determined based on the size of beverage service.</font>
                <div class="row">
                    <div class="input-col12">
                        <span class="lc-error" id="lcerror4"></span>
                    </div>
                </div>

                <div class="beverage-top">
                    <ul> 
                        <li class="bartender"> 
                            <label><input type="radio" name="bartenderfee" value="bartendhalf" checked> Half-Day (2-4 hours)</label>
                            <label><input type="radio" name="bartenderfee" value="bartendfull"> Full-Day (5-8 hours)</label>
                        </li> 
                    </ul> 
                </div>
                <div class="bes-form row booking-box-e beverage-service">
                    <div class="wrapper">
                        @if (!empty($barsArr))
                            @php($br = 1)
                            @foreach( $barsArr as $bar)
                                <div class="input-row row bar br{{$br}}" <?php if ( $br >=2) {?>style="display:none;"<?php } ?>>
                                    <div class="input-col3">
                                        <?php if ( $br ===1) {?><h3>HOSTED BARS</h3> <?php } ?>
                                        <label>Charged per person, minimum 12 guests</label>
                                        {!! Form::select('bars'.$br, $barsArr, null, array('class' => 'bars', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col2">
                                        <?php if ( $br ===1) {?><h3>&nbsp;&nbsp;&nbsp;</h3> <?php } ?>
                                        <label>Number of Guests</label>
                                        {!! Form::text('no_guest_bars'.$br, null, array('class' => 'bar-guests', 'maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}
                                    </div>
                                    <?php if ( $br ===1) {?><h3>&nbsp;&nbsp;&nbsp;</h3> <?php } ?>
                                    <div class="input-col1">

                                        <a href="javascript:void(0);" class="add-bar" data-id="">Add to this Booking</a>
                                    </div>
                                    <div class="row">
                                        <div class="input-col12">
                                            <span class="lc-error br-error" ></span>
                                        </div>
                                    </div>
                                </div>
                                @php($br++)
                            @endforeach
                        @endif
                        @if( count($barsArr) > 1)
                            <div class="input-col-add">
                                <a href="javascript:void(0);" class="br_addmore" data-loc="{{ count($barsArr) }}"><strong>+</strong> Add Additional Bar Option</a>
                            </div>
                        @endif
                        
                        @if (!empty($bottlesArr))
                            @php($bt = 1)
                            @foreach( $bottlesArr as $bottle)
                                <div class="input-row row bottle bt{{ $bt }}" <?php if ( $bt >=2) {?>style="display:none;"<?php } ?>>
                                    <div class="input-col3">
                                        @if ($bt ==1)<h3>BOTTLE SERVICE</h3> @else<label>&nbsp;&nbsp;&nbsp;</label>@endif
                                        {!! Form::select('bottles'.$bt, $bottlesArr, null, array('class' => 'bottles', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col2">
                                        <label>Number of Bottles</label>
                                        {!! Form::text('no_guest_bottle'.$bt, null, array('class' => 'bottle-guests', 'maxlength' => '3', 'size' => '3', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col1">
                                        <a href="javascript:void(0);" class="add-bottle" data-id="">Add to this Booking</a>
                                    </div>
                                    <div class="row">
                                        <div class="input-col12">
                                            <span class="lc-error bt-error" ></span>
                                        </div>
                                    </div>
                                </div>
                                @php($bt++)
                            @endforeach
                        @endif
                        @if( count($bottlesArr) > 1)
                            <div class="input-col-add">
                                <a href="javascript:void(0);" class="bt_addmore" data-loc="{{ count($bottlesArr) }}"><strong>+</strong> Add Additional Bottles</a>
                            </div>
                        @endif
                        <div class="input-row row">
                            <label>Additional Details and/or Special Instructions</label>
                            {!! Form::text('beverage_special_detail', '', array('id' => 'beverage_special_detail')) !!}
                        </div>

                    </div>
                </div>
                <div class="nav">
                    <a href="javascript:void(0);" data-step="step6" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step8" data-cstep="step7" class="skip">Skip This Step </a>
                    <a href="javascript:void(0);" data-step="step8" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step6" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step8" data-cstep="step7" class="skip">Skip This Step </a>
                <a href="javascript:void(0);" data-step="step8" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step8">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left catering-title">
                <h2>PROFESSIONAL ENTERTAINMENT & EVENT ENHANCEMENTS<Br><Br>
                    <font>Feel free to skip this section. You can easily return to it later.</font>
                    <font>The following options are billed either half-day (2-4 hours) or full-day (5-8 hours).</font> 
                    
                </h2>
                <div class="row">
                    <div class="input-col12">
                        <span class="lc-error" id="lcerror5"></span>
                    </div>
                </div>

                <div class="bes-form row booking-box-e">
                    <div class="wrapper">
                        @if (!empty($addonsArr))
                            @php($a = 1)
                            @foreach( $addonsArr as $addon)
                                <div class="input-row row addon ad{{$a}}" <?php if ( $a >=2) {?>style="display:none;"<?php } ?>>
                                    <div class="input-col3">
                                        <label>Select Your Event Enhancement</label>
                                        {!! Form::select('addons'.$a, $addonsArr, null, array('class' => 'addons', 'id' => 'addons'.$a,  'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col2">
                                        <label>Select Times</label>
                                        {!! Form::select('no_guest_addons'.$a, $addonspriceArr, null, array('class' => 'addon-guests', 'required' => 'required')) !!}
                                    </div>
                                    <div class="input-col1">
                                        <a href="javascript:void(0);" class="add-addon" data-id="">Add to this Booking</a>
                                    </div>
                                    <div class="row">
                                        <div class="input-col12">
                                            <span class="lc-error ad-error" ></span>
                                        </div>
                                    </div>
                                </div>
                                @php($a++)
                            @endforeach
                        @endif
                        @if( count($addonsArr) > 1)
                            <div class="input-col-add">
                                <a href="javascript:void(0);" class="ad_addmore" data-loc="{{ count($addonsArr) }}"><strong>+</strong> Add Additional Add-On</a>
                            </div>
                        @endif
                        <div class="input-row row">
                            <label>Additional Details and/or Special Instructions</label>
                            {!! Form::text('addons_special_detail', '', array('id' => 'addons_special_detail')) !!}
                        </div>
                    </div>
                </div>

                <div class="nav">
                    <a href="javascript:void(0);" data-step="step7" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                    <a href="javascript:void(0);" data-step="step9" data-cstep="step8" class="skip">Skip This Step </a>
                    <a href="javascript:void(0);" data-step="step9" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>

            <!-- Include booking sidebar -->
            @include('partials.booking-sidebar')
            <!-- Include booking sidebar -->

            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step7" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
                <a href="javascript:void(0);" data-step="step9" data-cstep="step8" class="skip">Skip This Step </a>
                <a href="javascript:void(0);" data-step="step9" class="next-step">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="container steps" id="step9">
            <div class="legacy-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
            <div class="booking-left purchase-summary-left">
                <h2>BOOKING SUMMARY</h2>
                <div class="purchase_summary">
                    <ul>
                        <li><label>Start Time:</label><span class="sum_start"> </span></li>
                        <li><label>End Time:</label><span class="sum_finish"> </span></li>
                    </ul>
                </div>
                <div class="purchase_summary">
                    <ul>
                        <li><label>Organizer:</label><span class="sum_organizer"> </span></li>
                        <li><label>Booking Role:</label><span class="sum_role"> </span></li>
                    </ul>
                </div>
                <div class="purchase_summary">
                    <ul>
                        <li><label>Event Details:</label><span class="sum_event"> </span></li>
                        <li><label>Total Number of Guests:</label><span class="sum_total-guest"> </span><br><span class="sum_total-adult"> </span></li>
                    </ul>
                </div>
                <div class="purchase_summary sum_location">
                    <ul> 
                    </ul>
                </div>
                <div class="purchase_summary">
                    <ul>
                        <li class="summary_total_buffet"><span class="sum_buffets"><label>Food Catering:</label><div></div></span></li>
                        <li class="summary_total_tray"><span class="sum_trays"><label>Food Catering:</label><div></div></span></li> 
                    </ul>
                </div>
                <div class="purchase_summary">
                    <ul>
                        <li class="summary_total_bar"><span class="sum_bars"><label>Beverage Service:</label><div></div></span></li>
                        <li class="summary_total_bottle"><span class="sum_bottles"><label>Beverage Service:</label><div></div></span></li> 
                    </ul>
                </div>
                <div class="purchase_summary last-div">
                    <ul>
                        <li  class="summary_total_addon"><label>Extra Add-Ons:</label> <div></div></li> 
                    </ul>
                    <div class="nav">
                        <a href="javascript:void(0);" data-step="step8" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> Edit Event</a>
                    </div>
                </div>
                <br> 
            </div>
            <div class="booking-right purchase-summary-right">
                <div class="subtotal-block">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>SUBTOTAL</td>
                            <td class="sub-total">$0</td>
                        </tr>
                        @if ( $settings->tax !='' )
                            <tr>
                                <td>TAXES &amp; FEES</td>
                                <td class="taxamount">${{number_format($settings->tax, 2)}}</td>
                            </tr>
                        @endif
                    </table>
                    <a href="javascript:void(0)" class="myBtn-coupon">Click Here To Use Promo Code</a>
                </div>
                <div class="total">
                    Total: <strong> </strong>
                </div>
                <div class="total-saving" style="display:none">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>Promo Applied</td>
                            <td class="total-save">$0</td>
                        </tr>
                    </table>
                </div>

                <div class="to-complete-block">
                    <h3>TO COMPLETE YOUR BOOKING</h3>
                    @if (Route::has('login'))
    	      			@if (Auth::check())
                            <a href="javascript:void(0)" class="complete-purchase-btn" id="pay-purchase" data-user="{{ Auth::user()->email }}">COMPLETE BOOKING</a>
                        @else
                            <div class="to-complete">
                                <a href="javascript:void(0)" class="myBtn-register">REGISTER</a>
                                <span>OR</span>
                                <a href="javascript:void(0)" class="myBtn-login">SIGN IN</a>
                            </div>
                            <a href="javascript:void(0)" class="complete-purchase-btn complete-log">COMPLETE BOOKING</a>
                            <a href="javascript:void(0)" class="complete-purchase-btn" id="pay-purchase" style="display:none;">COMPLETE BOOKING</a>
                        @endif
    		        @endif

                </div>

            </div>
            <div class="nav bottom">
                <a href="javascript:void(0);" data-step="step8" class="pre-step"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</a>
            </div>
        </div>
        <div>
            {!! Form::hidden('p_id', 1, array('class' => 'form-control', 'required' => 'required')) !!}
            {!! Form::hidden('booking_date',  date('Y-m-d')  , array('class' => 'booking_date', 'required' => 'required')) !!}
            {!! Form::hidden('start_time', '', array('class' => 'start_time', 'required' => 'required')) !!}
            {!! Form::hidden('finish_time', '', array('class' => 'finish_time', 'required' => 'required')) !!}
            {!! Form::hidden('total', '', array('class' => 't_price', 'required' => 'required')) !!}
            {!! Form::hidden('tdate', date('d-m-Y') , array('class' => 'tdate', 'required' => 'required')) !!}
            {!! Form::hidden('eguest', '' , array('class' => 'eguest', 'required' => 'required')) !!}
        </div>
    {!! Form::close() !!}
</div>
<div id="myModal-coupon" class="modal register-popup">
    <div class="modal-content">
        <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <form class="form-horizontal" id="coupon-form" role="form" method="POST" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1>Redeem Coupon</h1>
            <input id="couponcode" type="text" name="coupon-code" value=""  placeholder="Coupon Code" required>
            <input id="redeem" type="submit" value="APPLY">
        </form>
        <div id="couponmsg"></div>
    </div>
</div>
<!-- Add CSRF-Token/Page name to Ajax request -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{{----}}
<script type="text/javascript">
//Seup csrf token in header
$.ajaxSetup({
    headers: $('meta[name="csrf-token"]').attr('content')
});

var disableddates = [<?php if($disabledDates){echo ($disabledDates);}?>];
var bkTime =  <?php echo json_encode($bookedTimes);?>;
 @if (Route::has('login'))
    @if ( !Auth::check()) 
        $(document).ready(function() { 
            setTimeout(function(){ $('.myBtn-login').trigger('click');}, 500); 
        });
    @endif
@endif
</script>
@endsection
