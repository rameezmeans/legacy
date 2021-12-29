@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Add New Product Price</h2>
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
                {!! Form::open(array('action' => 'App\Http\Controllers\Admin\PpriceController@store')) !!}
                    <label for="Location">Yacht*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('p_id', $products, null, array('class' => 'fform-control show-tick', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Location">Day*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('day', ['su' => 'Sunday', 'mo' => 'Monday', 'tu' => 'Tuesaday', 'we' => 'Wednesday', 'th' => 'Thursday', 'fr' => 'Friday', 'sa' => 'Saturday' , 'hd' => 'Holiday'], null, array('class' => 'fform-control show-tick')) !!}
                        </div>
                    </div>
                    <label for="Location">Date</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('date', null, array('class' => 'datepicker form-control')) !!}
                        </div>
                    </div>
                    <label for="Price">Price*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('price', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Add">Add</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::pprices.index') }}">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
