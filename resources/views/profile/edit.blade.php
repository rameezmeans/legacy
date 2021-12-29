@extends('layouts.basic')

@section('content')
<div class="yatch-content">
    <div class="wrapper" style="text-align: left;">
        <h1>Edit Profile</h1>  
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <section>
                        {!! Form::model($profile, array('method' => 'PATCH', 'class'=>'bes-form profile', 'action' => array('ProfileController@update', $profile, $profile->id))) !!} 
                        <table class="table table-bordered table-striped table-condensed" style="width:80%;">
                            <tbody> 
                                <tr>
                                    <td style="width:22%;"><h5>Name </h5></td>
                                    <td>{!! Form::text('name', null, array('class' => 'form-control','id'=> 'password')) !!}</td>
                                </tr>
                                <tr>
                                    <td><h5>Email </h5></td>
                                    {!! Form::hidden('email', null, array('class' => 'form-control','id'=> 'password')) !!}
                                    <td>{!! Form::text('email', null, array('class' => 'form-control','id'=> 'password', 'disabled')) !!}</td>
                                </tr>
                                <tr>
                                    <td><h5>Phone </h5></td>
                                    <td>{!! Form::text('phone', null, array('class' => 'form-control','id'=> 'password')) !!}</td>
                                </tr>
                                <tr>
                                    <td><h5>Password </h5></td>
                                    <td>{!! Form::password('password', null, array('class' => 'form-control','id'=> 'password')) !!}</td>
                                </tr> 
                                <tr>
                                    <td><h5>Confirm Password </h5></td>
                                    <td>{!! Form::password('confirm_password', null, array('class' => 'form-control','id'=>'confirmpassword')) !!}</td>
                                </tr> 
                                <tr>
                                    <td>
                                        <button type="submit" class="btn btn-profile update-btn" value="Update">Update</button>
                                    </td>
                                    <td>
                                        <a class="btn btn-profile" href="{{ route('user::profile.index') }}">Cancel</a> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div> 

      
@stop