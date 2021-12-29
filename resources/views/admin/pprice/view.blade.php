@extends('admin.layout.master')

@section('content')

<h3><i class="fa fa-angle-right"></i>Product Price Detail</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <section>
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td style="width: 15%;"><h5>Yacht</h5></td>
                            <td><h5>{{$entry->product->product_name}}</h5></td>
                        </tr>
                        <tr>
                            <td style="width: 15%;"><h5>Day</h5></td>
                            <td><h5>@if ($entry->day == 'sa') Saturday @elseif($entry->day == 'su') Sunday @elseif($entry->day == 'mo') Monday @elseif($entry->day == 'tu') Tuesaday  @elseif($entry->day == 'we') Wednesday @elseif($entry->day == 'th') Thursday @elseif($entry->day == 'fr') Friday @else Holiday @endif</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Date</h5></td>
                            <td><h5>{{ $entry->date }}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Price</h5></td>
                            <td><h5><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->price}}</span></h5></td>
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
                                <a class="btn btn-info" href="{{ route('admin::pprices.edit',  $entry->id) }}">Edit</a>
                                <a class="btn btn-primary" href="{{ route('admin::pprices.index') }}">Back To List</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

@stop
