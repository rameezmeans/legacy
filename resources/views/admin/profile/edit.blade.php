@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Edit Profile</h2>
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
                 {!! Form::model($profile, array('method' => 'PATCH', 'action' => array('App\Http\Controllers\Admin\ProfileController@update', $profile, $profile->id))) !!}
                    <label for="Price">Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::password('password', null, array('class' => 'form-control','id'=> 'password')) !!}
                        </div>
                    </div>
                    <label for="Price">Confirm Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::password('confirm_password', null, array('class' => 'form-control','id'=>'confirmpassword')) !!}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Update">Update</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::profile.index') }}">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
