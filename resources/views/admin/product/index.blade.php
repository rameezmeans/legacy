@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Yacht List</h2><br/><a href="/admin/products/create" class="btn btn-primary btn-xs">Add Yacht</a>
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
                                <th>Yacht Name</th>
                                <th>Default Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $index=1 ?>
                        @if ($entries->count())
                            @foreach ($entries as $entry)
                            <tr>
                                <th scope="row">{{$index}}</th>
                                <td>{{$entry->product_name}}</td>
                                <td><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->default_price}}</span></td>
                                <td>@if ($entry->status ==='Y') <span class="btn btn-success waves-effect btn-xs">Active</span> @else <span class="btn btn-danger waves-effect btn-xs">Disable</span> @endif</td>
                                <td>
                                    <a class="btn btn-primary btn-xs" href="{{ route('admin::products.show',  $entry->id) }}" title="View Food">
                                        View
                                    </a>

                                    <a class="btn btn-primary btn-xs" href="{{ route('admin::products.edit',  $entry->id) }}" title="Edit Food">
                                        Edit
                                    </a>
                                </td>
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
