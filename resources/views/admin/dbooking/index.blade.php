@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Disable Bookings</h2> <br/><a href="/admin/dbookings/create" class="btn btn-primary btn-xs">Add</a>
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
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $index=1 ?>
                        @if ($entries->count())
                            @foreach ($entries as $entry)
                            <tr>
                                <th scope="row">{{$index}} </th>
                                <td>{{$entry->dbooking_date}}</td>
                                 <td>{{$entry->dbooking_time_from}}:00</td>
                                 <td>{{$entry->dbooking_time_to}}:00</td>
                                <td>
                                {!! Form::open(array('method' => 'DELETE', 'action' => array('App\Http\Controllers\Admin\DbookingController@destroy', $entry->id), 'class' => 'inline-form')) !!}
                                    {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-xs', 'onclick' => "if(!confirm('Are you sure to delete this entry?')){return false;};")) !!}
                                {!! Form::close() !!}</td>
                            </tr>
                            <?php $index++;?>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
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
