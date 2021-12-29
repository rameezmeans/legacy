@extends('admin.layout.master')

@section('content')

            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">shopping_basket</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL BOOKINGS</div>
                            <div class="number count-to" data-from="0" data-to="{{$totalBookings}}" data-speed="15" data-fresh-interval="20">{{$totalBookings}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">fiber_new</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW BOOKING</div>
                            <div class="number count-to" data-from="0" data-to="{{$newBookings}}" data-speed="1000" data-fresh-interval="20">{{$newBookings}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL USERS</div>
                            <div class="number count-to" data-from="0" data-to="{{$totalUsers}}" data-speed="1000" data-fresh-interval="20">{{$totalUsers}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

            <!-- Basic Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Yacht</th>
                                        <th>Booking Date</th>
                                        <th>Booking Time</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $index=1 ?>
                                @if ($entries->count())
                                    @foreach ($entries as $entry)
                                    <tr>
                                        <th scope="row">{{$index}}</th>
                                        <td>{{$entry->product->product_name}}</td>
                                        @if($entry->next_day == 'Y')
                                            <td>{{date('d-M-Y', strtotime($entry->booking_date))}} - {{date('d-M-Y', strtotime($entry->booking_date .' +1 day'))}}</td>
                                        @else
                                            <td>{{date('d-M-Y', strtotime($entry->booking_date))}}</td>
                                        @endif
                                        <td>{{$entry->booking_time_from}}:00 - {{$entry->booking_time_to}}:00</td>
                                        <td>${{$entry->total}}</td>
                                        <td>@if($entry->status ==='c') <span class="label bg-red">Completed</span> @else <span class="label bg-green">New</span> @endif </td>
                                    </tr>
                                    <?php $index++;?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            No Record Found
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Table -->

@stop
