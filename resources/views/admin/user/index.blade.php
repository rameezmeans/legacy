@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Users List</h2>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No.</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $index=1 ?>
                        @if ($entries->count())
                            @foreach ($entries as $entry)
                            <tr>
                                <th scope="row">{{$index}}</th>
                                <td>{{$entry->name}}</td>
                                <td><a class="" href="{{ route('admin::users.show', $entry->id) }}" title="View User Info">{{$entry->email}}</a></td>
                                <td>{{$entry->phone}}</td>
                                <td>{{$entry->created_at}}</td>
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
