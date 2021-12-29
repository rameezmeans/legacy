@extends('admin.layout.master')

@section('content')

<h3><i class="fa fa-angle-right"></i>My Profile</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <section>
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h5>Name</h5></td>
                            <td><h5><span class="icon-name">{{$entry->name}}</span></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Email</h5></td>
                            <td><h5><span class="icon-name">{{$entry->email}}</span></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Phone</h5></td>
                            <td><h5><span class="icon-name">{{$entry->phone}}</span></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Password</h5></td>
                            <td><h5>xxxxxxxxxxxxxx</h5></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-info" href="{{ route('admin::profile.edit',  $entry->id) }}">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

@stop
