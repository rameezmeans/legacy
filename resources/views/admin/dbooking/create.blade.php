@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Disable Booking</h2>
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
                {!! Form::open(array('action' => 'App\Http\Controllers\Admin\DbookingController@store')) !!}
                    {!! Form::hidden('p_id', 1, array('class' => 'form-control', 'required' => 'required')) !!}
                    <label for="start_date">Start Date*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('start_date', null, array('class' => 'datepicker form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="end_date">End Date*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('end_date', null, array('class' => 'datepicker form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="end_date">Start Time*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('dbooking_time_from', ['0' => "12:00 AM", '1' => "1:00 AM", '2' => "2:00 AM", '3' => "3:00 AM", '4' => "4:00 AM", '5' => "5:00 AM", '6' => "6:00 AM", '7' => "7:00 AM", '8' => "8:00 AM", '9' => "9:00 AM", '10' => "10:00 AM", '11' => "11:00 AM", '12' => "12:00 PM", '13' => "1:00 PM", '14' => "2:00 PM", '15' => "3:00 PM", '16' => "4:00 PM", '17' => "5:00 PM", '18' => "6:00 PM", '19' => "7:00 PM", '20' => "8:00 PM", '21' => "9:00 PM", '22' => "10:00 PM", '23' => "11:00 PM"], null, array('class' => 'location-guests', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="end_date">End Time*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('dbooking_time_to', ['0' => "12:00 AM", '1' => "1:00 AM", '2' => "2:00 AM", '3' => "3:00 AM", '4' => "4:00 AM", '5' => "5:00 AM", '6' => "6:00 AM", '7' => "7:00 AM", '8' => "8:00 AM", '9' => "9:00 AM", '10' => "10:00 AM", '11' => "11:00 AM", '12' => "12:00 PM", '13' => "1:00 PM", '14' => "2:00 PM", '15' => "3:00 PM", '16' => "4:00 PM", '17' => "5:00 PM", '18' => "6:00 PM", '19' => "7:00 PM", '20' => "8:00 PM", '21' => "9:00 PM", '22' => "10:00 PM", '23' => "11:00 PM"], null, array('class' => 'location-guests', 'required' => 'required')) !!}
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Add">Add</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::dbookings.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
