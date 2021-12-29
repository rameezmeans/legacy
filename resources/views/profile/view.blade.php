@extends('layouts.basic')

@section('content')
<?php
$booking_details = unserialize($entry->booking_details);
$location_details = unserialize($entry->location_details);
$buffet_details = unserialize($entry->buffet_details);
$tray_details = unserialize($entry->tray_details);
$bar_details = unserialize($entry->bar_details);
$bottle_details = unserialize($entry->bottle_details);
$addon_details = unserialize($entry->addon_details);
$bartender_details = unserialize($entry->bartender_details);
?>
<div class="yatch-content booking-details">
    <div class="wrapper" style="text-align: left;">
        <h1>Booking Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;"><h5>Yacht</h5></td>
                                    <td style="width:10%;">:</td>
                                    <td style="width:50%;"><h6>{{$entry->product->product_name}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Booked Date</h5></td>
                                    <td>:</td>
                                    <td>
                                        <h6>
                                            @if($entry->next_day == 'Y')
                                                {{date('d-M-Y', strtotime($entry->booking_date))}} - {{date('d-M-Y', strtotime($entry->booking_date .' +1 day'))}}
                                            @else
                                                {{date('d-M-Y', strtotime($entry->booking_date))}}
                                            @endif
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h5>Booked Time</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$entry->time_html}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Total</h5></td>
                                    <td>:</td>
                                    <td><h6>$<span class="icon-name">{{$entry->total}}</span></h6></td>
                                </tr>

                                @if ($entry->created_at)
                                    <tr>
                                        <td><h5>Payment Date</h5></td>
                                        <td>:</td>
                                        <td><h6>{{ $entry->created_at }}</h6></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><h5>Name</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$entry->name}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Email</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$entry->email}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Phone</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$entry->phone}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Booking Role</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['booking_role']}}</h6></td>
                                </tr>
                                @if($booking_details[0]['other'] != '')
                                    <tr>
                                        <td><h5>Other</h5></td>
                                        <td>:</td>
                                        <td><h6>{{$booking_details[0]['other']}}</h6></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><h5>Special Request</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['booking_special_request']}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Type of Event</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['event_type']}}</h6></td>
                                </tr>
                                @if($booking_details[0]['event_other'] != '')
                                    <tr>
                                        <td><h5>Other</h5></td>
                                        <td>:</td>
                                        <td><h6>{{$booking_details[0]['event_other']}}</h6></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><h5>Total No. of Guests</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['event_no_guest']}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>of Adults(over age 21)</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['event_no_adult']}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>of Children</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['event_no_child']}}</h6></td>
                                </tr>
                                <tr>
                                    <td><h5>Special Request</h5></td>
                                    <td>:</td>
                                    <td><h6>{{$booking_details[0]['event_special_request']}}</h6></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br/>
        <h1 class="booking_details">PICK UP LOCATION (S)</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Docking Locations</th>
                                    <th>No. of Guests</th>
                                    <th>Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                           <?php $lc=1; ?>
                           @if (count($location_details)>0)
                                @foreach($location_details as $location)
                                    <tr>
                                        <td scope="row">{{$lc}}</td>
                                        <td>{{$location['location_name']}}</td> 
                                        <td>{{$location['location_qty']}}</td>
                                        <td>$<span class="icon-name">{{$location['location_price']}}</span></td> 
                                    </tr>
                                <?php $lc++;?>
                                @endforeach
                            @endif 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">Buffet Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Buffet Style</th>
                                    <th>No. of Guests</th>
                                    <th>Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @if ( count($buffet_details) > 0 && $buffet_details !='Skip' )
                                <?php $bc=1; ?> 
                                @foreach($buffet_details as $buffet)
                                    <tr>
                                        <td scope="row">{{$bc}}</td>
                                        <td>{{$buffet['buffet_name']}}</td> 
                                        <td>{{$buffet['buffet_qty']}}</td>
                                        <td>$<span class="icon-name">{{$buffet['buffet_price']}}</span></td> 
                                    </tr>
                                <?php $bc++; ?>
                                @endforeach 
                            @else
                                <tr>
                                    <td colspan="4">
                                        Skip
                                    </td>
                                </tr>
                            @endif
                                <tr>
                                    <td colspan="4">
                                        {{$booking_details[0]['food_special_detail']}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">Trays Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Trays</th>
                                    <th>No. of Trays</th>
                                    <th>Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($tray_details)>0 && $tray_details !='Skip')
                                <?php $tc=1; ?>
                                @foreach($tray_details as $tray)
                                    <tr>
                                        <td scope="row">{{$tc}}</td>
                                        <td>{{$tray['tray_name']}}</td> 
                                        <td>{{$tray['tray_qty']}}</td>
                                        <td>$<span class="icon-name">{{$tray['tray_price']}}</span></td> 
                                    </tr>
                                <?php $tc++;?>
                                @endforeach 
                            @else
                                <tr>
                                    <td colspan="4">
                                        Skip
                                    </td>
                                </tr>
                            @endif 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">Bar Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hosted Bar Options</th>
                                    <th>No. of Guests</th>
                                    <th>Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                             @if (count($bar_details)>0 && $bar_details !='Skip')
                                <?php $brc=1; ?>
                                @foreach($bar_details as $bar)
                                    <tr>
                                        <td scope="row">{{$brc}}</td>
                                        <td>{{$bar['bar_name']}}</td> 
                                        <td>{{$bar['bar_qty']}}</td>
                                        <td>$<span class="icon-name">{{$bar['bar_price']}}</span></td> 
                                    </tr>
                                <?php $brc++;?>
                                @endforeach 
                            @else
                                <tr>
                                    <td colspan="4">
                                        Skip
                                    </td>
                                </tr>
                            @endif
                                <tr>
                                    <td colspan="4">
                                        {{$booking_details[0]['beverage_special_detail']}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">Bottle Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bottles</th>
                                    <th>No. of Bottles</th>
                                    <th>Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                             @if (count($bottle_details)>0 && $bottle_details !='Skip')
                                <?php $btc=1; ?>
                                @foreach($bottle_details as $bottle)
                                    <tr>
                                        <td scope="row">{{$btc}}</td>
                                        <td>{{$bottle['bottle_name']}}</td> 
                                        <td>{{$bottle['bottle_qty']}}</td>
                                        <td>$<span class="icon-name">{{$bottle['bottle_price']}}</span></td> 
                                    </tr>
                                <?php $btc++;?>
                                @endforeach 
                            @else
                                <tr>
                                    <td colspan="4">
                                        Skip
                                    </td>
                                </tr>
                            @endif 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">Bartender Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <tbody>
                                @if ( $bartender_details['bartenderQty'] > 0 )
                                    <tr>
                                        <td style="width:50%;"><h5>Bartender Fee</h5></td><td style="width:10%;">:</td>
                                        <td style="width:40%;"><h6>$<span class="icon-name">{{$bartender_details['bartenderFee']}}</span></h6></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%;"><h5>Bartender Qty</h5></td><td style="width:10%;">:</td>
                                        <td style="width:40%;"><h6><span class="icon-name">{{$bartender_details['bartenderQty']}}</span></h6></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%;"><h5>Bartender Time</h5></td><td style="width:10%;">:</td>
                                        <td style="width:40%;"><h6><span class="icon-name">@if( $bartender_details['bartenderTime'] == 'bartendfull') FullDay @else Halfday @endif</span></h6></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="width:50%;">Skip</td> 
                                    </tr> 
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">AddOns Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Add-On</th>
                                    <th>Halfday/Fullday</th>
                                    <th>Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($addon_details)>0 && $addon_details !='Skip')
                                <?php $adc=1; ?>
                                @foreach($addon_details as $addon)
                                    <tr>
                                        <td scope="row">{{$adc}}</td>
                                        <td>{{$addon['addon_name']}}</td> 
                                        <td>@if( $addon['addon_qty'] == 'full') FullDay @else Halfday @endif </td>
                                        <td>$<span class="icon-name">{{$addon['addon_price']}}</span></td> 
                                    </tr>
                                <?php $adc++;?>
                                @endforeach 
                            @else
                                <tr>
                                    <td colspan="4">
                                        Skip
                                    </td>
                                </tr>
                            @endif
                                <tr>
                                    <td colspan="4">
                                        {{$booking_details[0]['addons_special_detail']}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        <h1 class="booking_details">Payment Details</h1>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="width:50%;"><h5>Sub Total</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6>$<span class="icon-name">{{$entry->stotal}}</span></h6></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;"><h5>Discount</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6>$<span class="icon-name">{{$entry->discount}}</span></h6></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;"><h5>Tax</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6>$<span class="icon-name">{{$entry->tax}}</span></h6></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;"><h5>Total</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6>$<span class="icon-name">{{$entry->total}}</span></h6></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;"><h5>Pay With</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6><span class="icon-name">{{$entry->paywith}}</span></h6></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;"><h5>Advance Pay</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6>$<span class="icon-name">{{$entry->payadvance}}</span></h6></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;"><h5>Payment Due</h5></td><td style="width:10%;">:</td>
                                    <td style="width:40%;"><h6>$<span class="icon-name">{{$entry->due}}</span></h6></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body table-responsive">
                        <table class="yatchtable" style="width:100%">
                            <tbody> 
                                <tr>
                                    <td colspan="2">
                                        <a class="btn btn-profile" href="{{ route('user::profile.index') }}">Back To List</a>
                                        {!! Form::open(array('method' => 'DELETE', 'action' => array('ProfileController@destroy', $entry->id), 'class' => 'inline-form')) !!}
                                            {!! Form::submit('Booking Cancel ', array('class' => 'btn btn-profile btn-red', 'onclick' => "if(!confirm('Are you sure to cancel this booking?')){return false;};")) !!}
                                        {!! Form::close() !!}
                                        @if ( $entry->due > 0 )
                                        <br/>
                                            {!! Form::open(array('action' => 'OrderController@userCheckoutProcess')) !!}
                                                {!! Form::hidden('b_id', $entry->id, array('class' => 'form-control', 'required' => 'required')) !!}
                                                {!! Form::submit('Pay Now', array('class' => 'btn btn-profile ', 'onclick' => "if(!confirm('Are you sure to Pay due amount?')){return false;};")) !!}
                                            {!! Form::close() !!}
                                        @endif 
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop
