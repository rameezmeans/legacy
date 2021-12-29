@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Add New Add-ons</h2>
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
                {!! Form::open(array('action' => 'App\Http\Controllers\Admin\AddonController@store')) !!}
                    {!! Form::hidden('p_id', 1, array('class' => 'form-control', 'required' => 'required')) !!}
                    <label for="addon">Heading*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('addons_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>

                    <label for="price">Halfday Price*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('hprice', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="price">Fullday Price*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('fprice', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Add">Add</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::addons.index') }}">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
