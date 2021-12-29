@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Edit Setting</h2>
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
                 {!! Form::model($setting, array('method' => 'PATCH', 'action' => array('App\Http\Controllers\Admin\SettingController@update', $setting, $setting->id))) !!}
                    <label for="Beverage">Bartender Halfday Fee*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('hprice', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Bartender Fullday Fee*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('fprice', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Tax*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('tax', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Payment Mode*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::select('payment_mode', ['sandbox' => 'Sandbox', 'live' => 'Live'],  null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Paypal Clinet ID*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('paypal_client_id', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Paypal Secret Key*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('paypal_secret', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Stripe Publishable Key*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('stripe_publishable_key', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Price">Stripe Secret Key*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('stripe_secret_key', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Update">Update</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::settings.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
