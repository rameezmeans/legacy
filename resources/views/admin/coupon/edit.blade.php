@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Edit Coupon</h2>
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
                 {!! Form::model($coupon, array('method' => 'PATCH', 'action' => array('App\Http\Controllers\Admin\CouponController@update', $coupon, $coupon->id))) !!}
                  {!! Form::hidden('p_id', 1, array('class' => 'form-control', 'required' => 'required')) !!}
                    <label for="coupon">Coupon*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('coupon_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>

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
                    <label for="discount">Discount*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('discount', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Update">Update</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::coupons.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
