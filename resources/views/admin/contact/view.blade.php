@extends('admin.layout.master')

@section('content')

<h3><i class="fa fa-angle-right"></i>Lead Detail</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <section>
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td style="width: 15%;"><h5>Name</h5></td>
                            <td><h5>{{ $entry->name }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Email</h5></td>
                            <td><h5>{{ $entry->email }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Phone</h5></td>
                            <td><h5>{{ $entry->phone }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Company</h5></td>
                            <td><h5>{{$entry->company}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Date of Event</h5></td>
                            <td><h5>{{$entry->dayofevent}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Additional</h5></td>
                            <td><h5>{{$entry->additional}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Page</h5></td>
                            <td><h5>{{$entry->category}}</h5></td>
                        </tr>
                        @if ($entry->created_at)
                            <tr>
                                <td><h5>Create at</h5></td>
                                <td><h5>{{ $entry->created_at }}</h5></td>
                            </tr>
                        @endif

                        @if (  ($entry->updated_at) && ($entry->created_at != $entry->updated_at) )
                            <tr>
                                <td><h5>Updated at</h5></td>
                                <td><h5>{{ $entry->updated_at }}</h5></td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="2">
                                {!! Form::open(array('method' => 'DELETE', 'action' => array('App\Http\Controllers\Admin\ContactController@destroy', $entry->id), 'class' => 'inline-form')) !!}
                                    {!! Form::submit('Delete', array('class' => 'btn btn-danger ', 'onclick' => "if(!confirm('Are you sure to delete this entry?')){return false;};")) !!}
                                {!! Form::close() !!}
                                <a class="btn btn-primary" href="{{ route('admin::contacts.index') }}">Back To List</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

@stop
