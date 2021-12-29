@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Booking List</h2>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Yacht</th>
                                <th>Booking Date</th>
                                <th>Booking Time</th>
                                <th>Total</th>
                               <!--  <th>Name</th> -->
                                <th>Email</th>
                                <!-- <th>Status</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Yacht</th>
                                <th>Booking Date</th>
                                <th>Booking Time</th>
                                <th>Total</th>
                                <!-- <th>Name</th> -->
                                <th>Email</th>
                                <!-- <th>Status</th> -->
                                <th>Action</th>
                            </tr>
                        </tfoot>
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
                                <td>{{$entry->time_html}}</td>
                                <td>${{$entry->total}}</td>
                                <!-- <td>{{$entry->name}}</td> -->
                                <td>{{$entry->email}}</td>
                               <!--  @if($entry->booking_date > date('Y-m-d'))
                                    <td><a class="btn btn-xs bg-pink " href="javascript:void(0);" title="Upcoming">Upcoming</a></td>
                                @elseif($entry->booking_date == date('Y-m-d'))
                                    <td><a class="btn btn-xs bg-blue" href="javascript:void(0);" title="Today">Today</a></td>
                                @else
                                    <td><a class="btn btn-xs bg-green " href="javascript:void(0);" title="Complete">Complete</a></td>
                                @endif -->
                                <td>
                                    <a class="btn btn-primary btn-xs" href="{{ route('admin::orders.show', ['id' => $entry->id]) }}" title="View">
                                        View
                                    </a>
                                    <a class="btn btn-primary btn-xs" href="{{ route('admin::orders.edit', ['id' => $entry->id]) }}" title="Edit">
                                        Edit
                                    </a>
                                </td>
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
