@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Product Prices List</h2><br/><a href="/admin/pprices/create" class="btn btn-primary btn-xs">Add Price</a>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Yacht</th>
                                <th>Day</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $index=1 ?>
                        @if ($entries->count())
                            @foreach ($entries as $entry)
                            <tr>
                                <th scope="row">{{$index}}</th>
                                <th scope="row">{{$entry->product->product_name}}</th>
                                 <td> @if ($entry->day == 'sa') Saturday @elseif($entry->day == 'su') Sunday @elseif($entry->day == 'mo') Monday @elseif($entry->day == 'tu') Tuesaday  @elseif($entry->day == 'we') Wednesday @elseif($entry->day == 'th') Thursday @elseif($entry->day == 'fr') Friday @else Holiday @endif</td>
                                <td> @if ($entry->date){{$entry->date}}@else - @endif</td>
                                <td><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->price}}</span></td>
                                <td>
                                 <a class="btn btn-primary btn-xs" href="{{ route('admin::pprices.show',  $entry->id) }}" title="View">
                                    View
                                </a>

                                <a class="btn btn-primary btn-xs" href="{{ route('admin::pprices.edit',  $entry->id) }}" title="Edit">
                                    Edit
                                </a>
                                {!! Form::open(array('method' => 'DELETE', 'action' => array('App\Http\Controllers\Admin\PpriceController@destroy', $entry->id), 'class' => 'inline-form')) !!}
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
