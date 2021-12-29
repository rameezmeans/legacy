@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Add-ons List</h2><br/><a href="/admin/addons/create" class="btn btn-primary btn-xs">Add Addons</a>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Add-ons</th>
                                <th>Halfday Price</th>
                                <th>Fullday Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $index=1 ?>
                        @if ($entries->count())
                            @foreach ($entries as $entry)
                            <tr>
                                <th scope="row">{{$index}} </th>
                                <td>{{$entry->addons_name}}</td>
                                <td><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->hprice}}</span></td>
                                <td><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->fprice}}</span></td>
                                <td>
                                 <a class="btn btn-primary btn-xs" href="{{ route('admin::addons.show', $entry->id) }}" title="View">
                                    View
                                </a>

                                <a class="btn btn-primary btn-xs" href="{{ route('admin::addons.edit', $entry->id) }}" title="Edit">
                                    Edit
                                </a>
                                {!! Form::open(array('method' => 'DELETE', 'action' => array('App\Http\Controllers\Admin\AddonController@destroy', $entry->id), 'class' => 'inline-form')) !!}
                                    {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-xs', 'onclick' => "if(!confirm('Are you sure to delete this entry?')){return false;};")) !!}
                                {!! Form::close() !!}</td>
                            </tr>
                            <?php $index++;?>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                     No Record Found
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Table -->

@stop
