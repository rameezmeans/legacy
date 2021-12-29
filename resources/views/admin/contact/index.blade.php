@extends('admin.layout.master')

@section('content')

    <div class="block-header">
        <h2>Contacts List</h2>
    </div>

    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                 <div class="header">
                    <h2>
                        LEADS
                    </h2>
                </div>
                <div class="body table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Date of Event</th>
                                <!-- <th>Additional</th>  -->
                                <th>Page</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $index=1 ?>
                        @if ($entries->count())
                            @foreach ($entries as $entry)
                            <tr>
                                <th scope="row">{{$index}} </th>
                                <td><a href="{{ route('admin::contacts.show',  $entry->id) }}">{{$entry->name}} </a></td>
                                <td>{{$entry->email}}</td>
                                <td>{{$entry->phone}}</td>
                                <td>{{$entry->company}}</td>
                                <td>{{$entry->dayofevent}}</td>
                                <!-- <td>{{$entry->additional}}</td> -->
                                <td>{{$entry->category}}</td>
                               <!--  <td>
                                 <a class="btn btn-primary btn-xs" href="{{ route('admin::contacts.show', $entry->id) }}" title="View">
                                    View
                                </a> </td> -->
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
