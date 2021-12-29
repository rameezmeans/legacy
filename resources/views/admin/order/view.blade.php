@extends('admin.layout.master')

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
<h3><i class="fa fa-angle-right"></i>Order Detail</h3>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Booking Details
                </h2>
            </div>
            <div class="body">
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h5>Yacht</h5></td>
                            <td><h6>{{$entry->product->product_name}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>Booked Date</h5></td>
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
                            <td><h6>{{$entry->time_html}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>Advance Paid</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->payadvance}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Due Amount</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->due}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Total</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->total}}</span></h6></td>
                        </tr>

                        @if ($entry->created_at)
                            <tr>
                                <td><h5>Order placed on</h5></td>
                                <td><h6>{{ $entry->created_at }}</h6></td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    User Details
                </h2>
            </div>
            <div class="body">
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h5>Name</h5></td>
                            <td><h6>{{$entry->name}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>Email</h5></td>
                            <td><h6>{{$entry->email}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>Phone</h5></td>
                            <td><h6>{{$entry->phone}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>Booking Role</h5></td>
                            <td><h6>{{$booking_details[0]['booking_role']}}</h6></td>
                        </tr>
                        @if($booking_details[0]['other'] != '')
                            <tr>
                                <td><h5>Other</h5></td>
                                <td><h6>{{$booking_details[0]['other']}}</h6></td>
                            </tr>
                        @endif
                        <tr>
                            <td><h5>Special Request</h5></td>
                            <td><h6>{{$booking_details[0]['booking_special_request']}}</h6></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Event Details
                </h2>
            </div>
            <div class="body">
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h5>Type of Event</h5></td>
                            <td><h6>{{$booking_details[0]['event_type']}}</h6></td>
                        </tr>
                        @if($booking_details[0]['event_other'] != '')
                            <tr>
                                <td><h5>Other</h5></td>
                                <td><h6>{{$booking_details[0]['event_other']}}</h6></td>
                            </tr>
                        @endif
                        <tr>
                            <td><h5>Total No. of Guests</h5></td>
                            <td><h6>{{$booking_details[0]['event_no_guest']}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>of Adults(over age 21)</h5></td>
                            <td><h6>{{$booking_details[0]['event_no_adult']}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>of Children</h5></td>
                            <td><h6>{{$booking_details[0]['event_no_child']}}</h6></td>
                        </tr>
                        <tr>
                            <td><h5>Special Request</h5></td>
                            <td><h6>{{$booking_details[0]['event_special_request']}}</h6></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    PICK UP LOCATION (S)
                </h2>
            </div>
            <div class="body">
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Docking Location</th>
                            <th>No. of Guests Boarding</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $lc=1; ?>
                        @if (count($location_details)>0)
                            @foreach($location_details as $location)
                                <tr>
                                    <td><h5>{{$lc}}</h5></td>
                                    <td><h6>{{$location['location_name']}}</h6></td>
                                    <td><h6>{{$location['location_qty']}}</h6></td>
                                    <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$location['location_price']}}</span></h6></td>
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
<div class="row clearfix">

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Buffet Details
                </h2>
            </div>
            <div class="body">
                <?php $bc=1; ?>
                @if (count($buffet_details)>0 && $buffet_details != 'Skip')
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Buffet Style</th>
                                <th># of Guests</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buffet_details as $buffet)
                                <tr>
                                    <td><h5>{{$bc}}</h5></td>
                                    <td><h6>{{$buffet['buffet_name']}}</h6></td>
                                    <td><h6>{{$buffet['buffet_qty']}}</h6></td>
                                    <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$buffet['buffet_price']}}</span></h6></td>
                                </tr>
                                <?php $bc++;?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><h6>{{$booking_details[0]['food_special_detail']}}</h6></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    Skip
                @endif
            </div>
        </div>
    </div>
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Trays Details
                </h2>
            </div>
            <div class="body">
                <?php $tc=1; ?>
                @if (count($tray_details)>0 && $tray_details != 'Skip')
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Trays</th>
                                <th># of Trays</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tray_details as $tray)
                                <tr>
                                    <td><h5>{{$tc}}</h5></td>
                                    <td><h6>{{$tray['tray_name']}}</h6></td>
                                    <td><h6>{{$tray['tray_qty']}}</h6></td>
                                    <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$tray['tray_price']}}</span></h6></td>
                                </tr>
                                <?php $tc++;?>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    Skip
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Bar Details
                </h2>
            </div>
            <div class="body">
                <?php $brc=1; ?>
                @if (count($bar_details)>0 && $bar_details != 'Skip')
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hosted Bar Options</th>
                                <th># of Guests</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bar_details as $bar)
                                <tr>
                                    <td><h5>{{$brc}}</h5></td>
                                    <td><h6>{{$bar['bar_name']}}</h6></td>
                                    <td><h6>{{$bar['bar_qty']}}</h6></td>
                                    <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$bar['bar_price']}}</span></h6></td>
                                </tr>
                                <?php $brc++;?>
                            @endforeach
                        </tbody> 
                        <tfoot>
                            <tr>
                                <td colspan="3"><h6>{{$booking_details[0]['beverage_special_detail']}}</h6></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    Skip
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Bottles Details
                </h2>
            </div>
            <div class="body">
                <?php $btc=1; ?>
                @if (count($bottle_details)>0 && $bottle_details != 'Skip')
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bottles</th>
                                <th>No of Bottles</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bottle_details as $bottle)
                                <tr>
                                    <td><h5>{{$btc}}</h5></td>
                                    <td><h6>{{$bottle['bottle_name']}}</h6></td>
                                    <td><h6>{{$bottle['bottle_qty']}}</h6></td>
                                    <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$bottle['bottle_price']}}</span></h6></td>
                                </tr>
                                <?php $btc++;?>
                            @endforeach

                        </tbody> 
                    </table>
                @else
                    Skip
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Bartender Detail
                </h2>
            </div>
            <div class="body">
                @if ($bartender_details['bartenderQty'] > 0 )
                    <table class="table table-striped table-condensed">
                        <tbody> 
                            <tr>
                                <td style="width:50%;"><h5>Bartender Fee</h5></td><td style="width:10%;">:</td>
                                <td style="width:40%;"><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$bartender_details['bartenderFee']}}</span></h6></td>
                            </tr>
                            <tr>
                                <td style="width:50%;"><h5>Bartender Qty</h5></td><td style="width:10%;">:</td>
                                <td style="width:40%;"><h6><span class="icon-name">{{$bartender_details['bartenderQty']}}</span></h6></td>
                            </tr>
                            <tr>
                                <td style="width:50%;"><h5>Bartender Time</h5></td><td style="width:10%;">:</td>
                                <td style="width:40%;"><h6><span class="icon-name">@if( $bartender_details['bartenderTime'] == 'bartendfull') FullDay @else Halfday @endif</span></h6></td>
                            </tr> 
                        </tbody>
                    </table>
                @else
                    Skip
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    AddOns Details
                </h2>
            </div>
            <div class="body">
                <?php $adc=1; ?>
                @if (count($addon_details)>0 && $addon_details != 'Skip')
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Add-On</th>
                                <th>Times</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addon_details as $addon)
                                <tr>
                                    <td><h5>{{$adc}}</h5></td>
                                    <td><h6>{{$addon['addon_name']}}</h6></td>
                                    <td><h6>@if( $addon['addon_qty'] == 'full') FullDay @else Halfday @endif </h6></td>
                                    <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$addon['addon_price']}}</span></h6></td>
                                </tr>
                                <?php $adc++;?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><h6>{{$booking_details[0]['addons_special_detail']}}</h6></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    Skip
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h5>Sub Total</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->stotal}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Discount</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->discount}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Tax</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->tax}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Advance Paid</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->payadvance}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Due Amount</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->due}}</span></h6></td>
                        </tr>
                        <tr>
                            <td><h5>Total</h5></td>
                            <td><h6><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->total}}</span></h6></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <section>
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                {!! Form::open(array('method' => 'DELETE', 'action' => array('Admin\OrderController@destroy', $entry->id), 'class' => 'inline-form')) !!}
                                    {!! Form::submit('Cancel', array('class' => 'btn btn-danger ', 'onclick' => "if(!confirm('Are you sure to cancel this booking?')){return false;};")) !!}
                                {!! Form::close() !!}
                                <a class="btn btn-primary" href="{{ route('admin::orders.index') }}">Back To List</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

@stop
