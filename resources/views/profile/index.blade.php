@extends('layouts.basic')

@section('content')
<div class="yatch-content">
    <div class="wrapper" style="text-align: left;">
        <h1>My Account</h1>
        <div class="row mt">
		    <div class="col-lg-12">
		        <div class="content-panel">
		            <section>
		                <table class="table table-bordered table-striped table-condensed">
		                    <tbody>
		                        <tr>
		                            <td style="width:30%;"><h5>Name </h5></td>
		                            <td><h5><span class="icon-name">{{$entry->name}}</span></h5></td>
		                        </tr>
		                        <tr>
		                            <td><h5>Email </h5></td>
		                            <td><h5><span class="icon-name">{{$entry->email}}</span></h5></td>
		                        </tr>
		                        <tr>
		                            <td><h5>Phone </h5></td>
		                            <td><h5><span class="icon-name">{{$entry->phone}}</span></h5></td>
		                        </tr>
		                        <tr>
		                            <td><h5>Password </h5></td>
		                            <td><h5> xxxxxxxxxxxxxx</h5></td>
		                        </tr>
		                        <tr>
		                            <td colspan="2">
		                                <a class="btn btn-profile" href="{{ route('user::profile.edit', ['id' => $entry->id]) }}">Edit</a>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		            </section>
		        </div>
		    </div>
		</div>
		<h1>My Bookings</h1>
	    <div class="row clearfix">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="card">
	                <div class="body table-responsive">
	                    <table class="yatchtable" style="width:100%">
	                        <thead>
	                            <tr>
	                                <th>#</th>
	                                <th>Yacht</th>
	                                <th>Booking Date</th>
	                                <th>Booking Time</th>
	                                <th>Total</th>
	                                <th>Name</th>
	                                <th>Email</th>
	                                <th>Action</th>
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
	                                <td>{{$entry->time_html}}</td>
	                                <td>{{$entry->total}}</td>
	                                <td>{{$entry->name}}</td>
	                                <td>{{$entry->email}}</td>
	                                <td>
	                                 <a class="btn-xs" href="{{ route('user::profile.show', ['id' => $entry->id]) }}" title="View">
	                                    View
	                                </a> </td>
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
    </div>
</div>


@stop
