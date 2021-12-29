@extends('admin.layout.master')

@section('content')

<h3><i class="fa fa-angle-right"></i>User Detail</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <section>
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td style="width: 15%;"><h5>Name</h5></td>
                            <td><h5>{{ $entry->name }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Email</h5></td>
                            <td><h5>{{$entry->email}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Phone No.</h5></td>
                            <td><h5>{{ $entry->phone }}</h5></td>
                        </tr>
                        @if ($entry->created_at)
                            <tr>
                                <td><h5>Create at</h5></td>
                                <td><h5>{{ $entry->created_at }}</h5></td>
                            </tr>
                        @endif

                        @if (  ($entry->updated_at) && ($entry->created_at != $entry->updated_at) )
                            <tr>
                                <td><h5>Updated at</h5></td>
                                <td><h5>{{ $entry->updated_at }}</h5></td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="2">
                                <a class="btn btn-primary" href="{{ route('admin::users.index') }}">Back To List</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>
<div class="block-header">
    <h2>Booking List</h2>
</div>
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
                            <td>Sirara Yacht</td>
                            <td>{{$entry->booking_date}}</td>
                            <td>{{$entry->booking_time_from}} - {{$entry->booking_time_to}}</td>
                            <td>{{$entry->total}}</td>
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
