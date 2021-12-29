@extends('admin.layout.master')

@section('content')
<?php
$booking_details = unserialize($order->booking_details);
$location_details = unserialize($order->location_details);
$buffet_details = unserialize($order->buffet_details);
$tray_details = unserialize($order->tray_details);
$bar_details = unserialize($order->bar_details);
$bottle_details = unserialize($order->bottle_details);
$addon_details = unserialize($order->addon_details);
$bartender_details = unserialize($order->bartender_details);
$buffetArrId = array();
$trayArrId = array();
$barArrId = array();
$bottleArrId = array();
$addonArrId = array();
?>
<div class="block-header">
    <h2>Edit Order No. - LEGACY#{{ $order->id }}</h2>
</div>
<!-- Error messages -->
<!-- Validation Error messages -->
@if (count($errors) > 0)

    <div class="alert alert-danger">
        <ul>

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>
    </div>

@endif
<!-- End of Validation Error messages -->
<!-- End of Error messages -->
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                {!! Form::model($order, array('method' => 'PATCH', 'action' => array('Admin\OrderController@update', $order, $order->id))) !!}
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                            <tr>
                                <td colspan="2"><h5>Booking Details</h5></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;"><h5>Order ID</h5></td>
                                <td><h6>LEGACY#{{ $order->id }}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Booked Date</h5></td>
                                <td>
                                    <h6>
                                        @if($order->next_day == 'Y')
                                            {{date('d-M-Y', strtotime($order->booking_date))}} - {{date('d-M-Y', strtotime($order->booking_date .' +1 day'))}}
                                        @else
                                            {{date('d-M-Y', strtotime($order->booking_date))}}
                                        @endif
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Booked Time</h5></td>
                                <td><h6>{{$order->time_html}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Yacht Name</h5></td>
                                <td><h6>{{$order->product->product_name}}</h6></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h4>User Details</h4></td>
                            </tr>
                            <tr>
                                <td><h5>Name</h5></td>
                                <td><h6>{{$order->name}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Email</h5></td>
                                <td><h6>{{$order->email}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Phone</h5></td>
                                <td><h6>{{$order->phone}}</h6></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Multiple Items To Be Open -->
                    <div class="row clearfix">
                        <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-danger">
                                    <div class="panel-heading" role="tab" id="headingOne_19">
                                        <h4 class="panel-title" style="padding: 5px 0;">
                                            <a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19">
                                                <i class="material-icons">restaurant</i> Food Catering
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne_19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_19">
                                        <div class="panel-body">

                                            <!-- Buffets Start -->
                                            <div class="card">
                                                <div class="header">
                                                    <h2>
                                                        Buffet Style
                                                    </h2>
                                                </div>
                                                <div class="body">
                                                    @if (!empty($foods))
                                                        @if (count($buffet_details)>0 && $buffet_details != 'Skip')
                                                            @foreach ($buffet_details as $buffet_detail)
                                                                <?php $buffetArrId[] = $buffet_detail['buffet_id']; ?>
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('buffets'.$buffet_detail['buffet_id'], $buffet_detail['buffet_name'], array('class' => 'buffets form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('buffets['.$buffet_detail['buffet_id'].'][buffet]', $buffet_detail['buffet_id']) !!}

                                                                                {!! Form::hidden('buffets['.$buffet_detail['buffet_id'].'][buffet_name]', $buffet_detail['buffet_name']) !!}

                                                                                {!! Form::hidden('buffets['.$buffet_detail['buffet_id'].'][buffet_base_price]', $buffet_detail['buffet_base_price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('buffets['.$buffet_detail['buffet_id'].'][buffet_price]', $buffet_detail['buffet_price'], array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('buffets['.$buffet_detail['buffet_id'].'][buffet_guest]', $buffet_detail['buffet_qty'], array('class' => 'total_qty')) !!}

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('buffets['.$buffet_detail['buffet_id'].'][buffet_guest]', $buffet_detail['buffet_qty'], array('class' => 'sqty buffet-guests form-control', 'maxlength' => '3', 'size' => '3', 'disabled' => 'disabled')) !!}
                                                                                <label class="form-label"># of Guests</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">${{$buffet_detail['buffet_price']}}</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_order" style="display:none;">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_order" style="display:block;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        @foreach( $foods as $food)
                                                            @if($food->type === 'Buffet' && !in_array($food['id'], $buffetArrId))
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('buffets'.$food['id'], $food['food_name'], array('class' => 'buffets form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('buffets['.$food['id'].'][buffet]', $food['id']) !!}

                                                                                {!! Form::hidden('buffets['.$food['id'].'][buffet_name]', $food['food_name']) !!}

                                                                                {!! Form::hidden('buffets['.$food['id'].'][buffet_base_price]', $food['price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('buffets['.$food['id'].'][buffet_price]', '', array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('buffets['.$food['id'].'][buffet_guest]','', array('class' => 'total_qty')) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('buffets['.$food['id'].'][buffet_guest]', '', array('class' => 'sqty buffet-guests form-control', 'maxlength' => '3', 'size' => '3')) !!}
                                                                                <label class="form-label"># of Guests</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">$0.00</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_order">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_order" style="display:none;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Buffets End -->

                                            <!-- Tray Start -->
                                            <div class="card">
                                                <div class="header">
                                                    <h2>
                                                        Premium Passed Trays
                                                    </h2>
                                                </div>
                                                <div class="body">
                                                    @if (!empty($foods))
                                                        @if (count($tray_details)>0 && $tray_details != 'Skip')
                                                            @foreach ($tray_details as $tray_detail)
                                                                <?php $trayArrId[] = $tray_detail['tray_id']; ?>
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('trays'.$tray_detail['tray_id'], $tray_detail['tray_name'], array('class' => 'trays form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('trays['.$tray_detail['tray_id'].'][tray]', $tray_detail['tray_id']) !!}

                                                                                {!! Form::hidden('trays['.$tray_detail['tray_id'].'][tray_name]', $tray_detail['tray_name']) !!}

                                                                                {!! Form::hidden('trays['.$tray_detail['tray_id'].'][tray_base_price]',
                                                                                $tray_detail['tray_base_price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('trays['.$tray_detail['tray_id'].'][tray_price]', $tray_detail['tray_price'], array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('trays['.$tray_detail['tray_id'].'][tray_guest]', $tray_detail['tray_qty'], array('class' => 'total_qty')) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('trays['.$tray_detail['tray_id'].'][tray_guest]', $tray_detail['tray_qty'], array('class' => 'sqty tray-guests form-control', 'maxlength' => '3', 'size' => '3', 'disabled' => 'disabled')) !!}
                                                                                <label class="form-label"># of Tray</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">${{$tray_detail['tray_price']}}</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_order" style="display:none;">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_order" style="display:block;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        @foreach( $foods as $food)
                                                            @if($food->type === 'Tray' && !in_array($food['id'], $trayArrId))
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('trays'.$food['id'], $food['food_name'], array('class' => 'trays form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('trays['.$food['id'].'][tray]', $food['id']) !!}

                                                                                {!! Form::hidden('trays['.$food['id'].'][tray_name]', $food['food_name']) !!}

                                                                                {!! Form::hidden('trays['.$food['id'].'][tray_base_price]', $food['price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('trays['.$food['id'].'][tray_price]', '', array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('trays['.$food['id'].'][tray_guest]','', array('class' => 'total_qty')) !!}


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('trays['.$food['id'].'][tray_guest]', '', array('class' => 'sqty tray-guests form-control', 'maxlength' => '3', 'size' => '3')) !!}
                                                                                <label class="form-label"># of Tray</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">$0.00</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_order">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_order" style="display:none;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Trays End -->
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-orange">
                                    <div class="panel-heading" role="tab" id="headingTwo_19">
                                        <h4 class="panel-title" style="padding: 5px 0;">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapseTwo_19" aria-expanded="false" aria-controls="collapseTwo_19">
                                                <i class="material-icons">local_bar</i> Beverage Service
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo_19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_19">
                                        <div class="panel-body">
                                            <!-- Bar Start -->
                                            <div class="card">
                                                <div class="header">
                                                    <h2>
                                                        Bartender Fee
                                                    </h2>
                                                </div>
                                                <div class="body">
                                                    <div class="form-line bartenderTime">
                                                        @if ($bartender_details['bartenderTime'] ==='bartendfull')
                                                            <input name="bartenderfee" value="bartendhalf" type="radio" id="radio_b1" disabled>
                                                            <label for="radio_b1">Half-Day (2-4 hours) ${{$settings->hprice}}</label>
                                                            <input name="bartenderfee" value="bartendfull" type="radio" id="radio_b2" checked disabled>
                                                            
                                                            <label for="radio_b2">Full-Day (5-8 hours) ${{$settings->fprice}}</label>
                                                        @elseif ($bartender_details['bartenderTime'] ==='bartendhalf')
                                                            <input name="bartenderfee" value="bartendhalf" type="radio" id="radio_b1" checked disabled>
                                                            <label for="radio_b1">Half-Day (2-4 hours) ${{$settings->hprice}}</label>
                                                            <input name="bartenderfee" value="bartendfull" type="radio" id="radio_b2" disabled>
                                                            <label for="radio_b2">Full-Day (5-8 hours) ${{$settings->fprice}}</label>
                                                        @else
                                                            <input name="bartenderfee" value="bartendhalf" type="radio" id="radio_b1" checked>
                                                            <label for="radio_b1">Half-Day (2-4 hours) ${{$settings->hprice}}</label>
                                                            <input name="bartenderfee" value="bartendfull" type="radio" id="radio_b2">
                                                            <label for="radio_b2">Full-Day (5-8 hours) ${{$settings->fprice}}</label>
                                                        @endif  
                                                    </div>
                                                     <input name="bartenderFee" value="{{$bartender_details['bartenderFee']}}" type="hidden" class="bartender_fee">
                                                       <input name="bartenderQty" value="{{$bartender_details['bartenderQty']}}" type="hidden" class="bartender_qty">
                                                       <input name="bartenderTime" value="{{$bartender_details['bartenderTime']}}" type="hidden" class="bartender_time">
                                                       <input name="bartenderhalf" value="{{$settings->hprice}}" type="hidden" class="bartenderhalf">
                                                       <input name="bartenderfull" value="{{$settings->fprice}}" type="hidden" class="bartenderfull">
                                                </div>
                                                <div class="header">
                                                    <h2>
                                                        Hosted Bar Options
                                                    </h2>
                                                </div>

                                                <div class="body barmain">
                                                    @if (!empty($beverages))
                                                        @if (count($bar_details)>0 && $bar_details != 'Skip')
                                                            @foreach ($bar_details as $bar_detail)
                                                                <?php $barArrId[] = $bar_detail['bar_id']; ?>
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bars'.$bar_detail['bar_id'], $bar_detail['bar_name'], array('class' => 'bar form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar]', $bar_detail['bar_id']) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar_name]', $bar_detail['bar_name']) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar_base_price]', $bar_detail['bar_base_price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar_price]', $bar_detail['bar_price'], array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar_guest]', $bar_detail['bar_qty'], array('class' => 'total_qty')) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar_half]', $bar_detail['bar_half'], array('class' => 'hprice')) !!}

                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][bar_full]', $bar_detail['bar_full'], array('class' => 'fprice') ) !!}
                                                                               
                                                                                {!! Form::hidden('bars['.$bar_detail['bar_id'].'][time_duration]', $bar_detail['time_duration'], array('class' => 'time_duration') ) !!}


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bars['.$bar_detail['bar_id'].'][bar_guest]', $bar_detail['bar_qty'], array('class' => 'sqty bar-guests form-control', 'maxlength' => '3', 'size' => '3', 'disabled' => 'disabled')) !!}
                                                                                <label class="form-label"># of Guests</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">${{$bar_detail['bar_price']}}</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_bar_order" style="display:none;">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_bar_order added_bar" style="display:block;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        @foreach( $beverages as $beverage)
                                                            @if(!in_array($beverage['id'], $barArrId))
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bars'.$beverage['id'], $beverage['beverage_name'], array('class' => 'bar form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar]', $beverage['id']) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar_name]', $beverage['beverage_name']) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar_base_price]','', array('class' => 'base_price' )) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar_price]', '', array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar_guest]', '', array('class' => 'total_qty')) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar_half]', $beverage['hprice'], array('class' => 'hprice')) !!}

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][bar_full]', $beverage['fprice'], array('class' => 'fprice')) !!}  

                                                                                {!! Form::hidden('bars['.$beverage['id'].'][time_duration]', '', array('class' => 'time_duration' )) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bars['.$beverage['id'].'][bar_guest]', '', array('class' => 'sqty bar-guests form-control', 'maxlength' => '3', 'size' => '3')) !!}
                                                                                <label class="form-label"># of Guests</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">$0.00</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_bar_order">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_bar_order" style="display:none;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Bars End -->

                                            <!-- Bar Start -->
                                            <div class="card">
                                                <div class="header">
                                                    <h2>
                                                        Bottle Service
                                                    </h2>
                                                </div>
                                                <div class="body">
                                                    @if (!empty($bottles))
                                                        @if (count($bottle_details)>0 && $bottle_details != 'Skip')
                                                            @foreach ($bottle_details as $bottle_detail)
                                                                <?php $bottleArrId[] = $bottle_detail['bottle_id']; ?>
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bottles'.$bottle_detail['bottle_id'], $bottle_detail['bottle_name'], array('class' => 'bottles form-control', 'disabled' => 'disabled')) !!}
                                                                                {!! Form::hidden('bottles['.$bottle_detail['bottle_id'].'][bottle]', $bottle_detail['bottle_id']) !!}

                                                                                {!! Form::hidden('bottles['.$bottle_detail['bottle_id'].'][bottle_name]', $bottle_detail['bottle_name']) !!}

                                                                                {!! Form::hidden('bottles['.$bottle_detail['bottle_id'].'][bottle_base_price]', $bottle_detail['bottle_base_price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('bottles['.$bottle_detail['bottle_id'].'][bottle_price]', $bottle_detail['bottle_price'], array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('bottles['.$bottle_detail['bottle_id'].'][bottle_guest]', $bottle_detail['bottle_qty'], array('class' => 'total_qty')) !!}

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bottles['.$bottle_detail['bottle_id'].'][bottle_guest]', $bottle_detail['bottle_qty'], array('class' => 'sqty bottle-guests form-control', 'maxlength' => '3', 'size' => '3', 'disabled' => 'disabled')) !!}
                                                                                <label class="form-label"># of Bottles</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">${{$bottle_detail['bottle_price']}}</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_order" style="display:none;">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_order" style="display:block;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        @foreach( $bottles as $bottle)
                                                            @if(!in_array($bottle['id'], $bottleArrId))
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bottles'.$bottle['id'], $bottle['bottle_name'], array('class' => 'bottles form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('bottles['.$bottle['id'].'][bottle]', $bottle['id']) !!}

                                                                                {!! Form::hidden('bottles['.$bottle['id'].'][bottle_name]', $bottle['bottle_name']) !!}

                                                                                {!! Form::hidden('bottles['.$bottle['id'].'][bottle_base_price]', $bottle['price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('bottles['.$bottle['id'].'][bottle_price]', '', array('class' => 'total_price')) !!}

                                                                                {!! Form::hidden('bottles['.$bottle['id'].'][bottle_guest]', '', array('class' => 'total_qty')) !!}

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('bottles['.$bottle['id'].'][bottle_guest]', '', array('class' => 'sqty bottle-guests form-control', 'maxlength' => '3', 'size' => '3')) !!}
                                                                                <label class="form-label"># of Bottles</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">$0.00</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_order">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_order" style="display:none;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Bottle End -->
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-col-teal">
                                    <div class="panel-heading" role="tab" id="headingThree_19">
                                        <h4 class="panel-title" style="padding: 5px 0;">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapseThree_19" aria-expanded="false" aria-controls="collapseThree_19">
                                                <i class="material-icons">more</i> Entertainment
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree_19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_19">
                                        <div class="panel-body">
                                            <!-- Bar Start -->
                                            <div class="card">
                                                <div class="header">
                                                    <h2>
                                                        Addons
                                                    </h2>
                                                </div>
                                                <div class="body">
                                                    @if (!empty($addons))
                                                        @if (count($addon_details)>0 && $addon_details != 'Skip')
                                                            @foreach ($addon_details as $addon_detail)
                                                                <?php $addonArrId[] = $addon_detail['addon_id']; ?>
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('addons'.$addon_detail['addon_id'], $addon_detail['addon_name'], array('class' => 'addons form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][addon]', $addon_detail['addon_id']) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][addon_name]', $addon_detail['addon_name']) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][addon_price]', $addon_detail['addon_price'], array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][addon_guest]', $addon_detail['addon_qty'], array('class' => 'total_qty')) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][addon_half]', $addon_detail['addon_half'], array('class' => 'addon_half')) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][addon_full]', $addon_detail['addon_full'], array('class' => 'addon_full')) !!}

                                                                                {!! Form::hidden('addons['.$addon_detail['addon_id'].'][time_duration]', $addon_detail['time_duration'], array('class' => 'time_duration')) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                 <select disabled class="addon_dd">
                                                                                    <option value="half" @if($addon_detail['addon_qty'] == 'half') selected @endif>Halfday ${{$addon_detail['addon_half']}}</option>
                                                                                    <option value="full" @if($addon_detail['addon_qty'] == 'full') selected @endif>Fullday ${{$addon_detail['addon_full']}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">${{$addon_detail['addon_price']}}</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_addon_order" style="display:none;">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_addon_order" style="display:block;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        @foreach( $addons as $addon)
                                                            @if(!in_array($addon['id'], $addonArrId))
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                {!! Form::text('addons'.$addon['id'], $addon['addons_name'], array('class' => 'addons form-control', 'disabled' => 'disabled')) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][addon_name]', $addon['addons_name']) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][addon]', $addon['id']) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][addon_price]', '', array('class' => 'base_price')) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][addon_guest]', '', array('class' => 'total_qty')) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][addon_half]', $addon['hprice'], array('class' => 'addon_half')) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][addon_full]', $addon['fprice'], array('class' => 'addon_full')) !!}

                                                                                {!! Form::hidden('addons['.$addon['id'].'][time_duration]', '', array('class' => 'time_duration')) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <select class="addon_dd">
                                                                                    <option value="half">Halfday ${{$addon['hprice']}}</option>
                                                                                    <option value="full">Fullday ${{$addon['fprice']}}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                                                        <label class="form-label item_total">$0.00</label>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect add_addon_order">ADD</button>
                                                                        <button type="button" class="btn btn-danger btn-lg m-l-15 waves-effect reset_addon_order" style="display:none;">REMOVE</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Bottle End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody> 
                            <tr>
                                <td><h5>Sub Total : </h5></td>
                                <td><h6 class="osub">${{$order->stotal}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Tax : </h5></td>
                                <td><h6 class="otax">${{$order->tax}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Total : </h5></td>
                                <td><h6 class="ototal">${{$order->total}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Advance Paid : </h5></td>
                                <td><h6 class="opaid">${{$order->payadvance}}</h6></td>
                            </tr>
                            <tr>
                                <td><h5>Due Amount : </h5></td>
                                <td><h6 class="odue">${{$order->due}}</h6></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- #END# Multiple Items To Be Open -->
                    {!! Form::hidden('ordertax', $order->tax, array('class' => 'ordertax')) !!}
                    {!! Form::hidden('defaulttax', $settings->tax, array('class' => 'defaulttax')) !!}
                    {!! Form::hidden('orderdiscount', $order->discount, array('class' => 'orderdiscount')) !!}
                    {!! Form::hidden('stotal', $order->stotal, array('class' => 'orderstotal')) !!}
                    {!! Form::hidden('total', $order->total, array('class' => 'ordertotal')) !!}
                    {!! Form::hidden('due', $order->due, array('class' => 'orderdue')) !!}
                    {!! Form::hidden('advance', $order->payadvance, array('class' => 'orderadvance')) !!}
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Update">Update</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::orders.index') }}">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
