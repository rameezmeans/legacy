@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Edit Beverage Service</h2>
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
                 {!! Form::model($beverage, array('method' => 'PATCH', 'action' => array('App\Http\Controllers\Admin\BeverageController@update', $beverage, $beverage->id))) !!}
                  {!! Form::hidden('p_id', 1, array('class' => 'form-control', 'required' => 'required')) !!}
                    <label for="Beverage">Heading*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('beverage_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">halfday Price*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('hprice', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Fullday Price*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('fprice', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Update">Update</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::beverages.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
