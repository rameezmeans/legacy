@extends('admin.layout.master')

@section('content')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <style>

        .form-control{

            border: 1px solid #ccc !important;
            margin-bottom: 5px !important;


        }

        .close{

            float: right;
            font-size: 12px;
            line-height: 0;
            color: #000;
             text-shadow: none !important;
             opacity: 1 !important;
            background-color: #ffffff !important;
        }

        .alert.alert-success {
            box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(76, 175, 80, 0.4);
        }
        .alert.alert-success {
            background-color: #55b559;
            color: #ffffff;
        }

        .form-check-input-all {
            opacity: 1 !important;
            position: absolute !important;
            left: 10px !important;
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid rgba(0,0,0, .54);
            overflow: hidden;
            z-index: 1;
            border-radius: 3px;
            background: #9c27b0;

            margin: -6px 0 0 !important;

        }
        .form-check-input {

            opacity: 1 !important;
            position: absolute !important;
            left: 20px !important;
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid rgba(0,0,0, .54);
            overflow: hidden;
            z-index: 1;
            border-radius: 3px;
            background: #9c27b0;

            margin: -6px 0 0 !important;
        }

        td{

            color: black;

            border: 2px solid #ffffff;

            /*border-top: none !important;*/
            /*border-bottom: none !important;*/
        }
        
        th{
            color: #aea070;
        }



        .btn-inner{
            padding: 6px 10px !important;

        }

        .alert.alert-with-icon {
            padding-left: 66px;
        }

        .alert {
            border: 0;
            border-radius: 3px;
            position: relative;
            padding: 20px 15px;
            line-height: 20px;
        }

        .card .card-body {
            padding: 0.9375rem 20px;
            position: relative;
        }

        .alert.alert-with-icon i[data-notify="icon"] {
            font-size: 30px;
            display: block;
            left: 15px;
            position: absolute;
            top: 50%;
            /*margin-top: -15px;*/
            color: #fff;
        }

        a{
            color: #aea070;
        }

        .btn:hover{
            color: #ffffff;
        }

        .alert-success {
            background-color: #dcefdc !important;
        }

        .alert-info {
            background-color: #eaf7fb !important;
        }

        .alert-danger {
            background-color: #f2dede !important;
        }

    </style>

    <div class="block-header">
        <h2>Event Editing Notification</h2><br/>
        <button class="btn btn-info approve-all-notifications">Approve</button>
        <button class="btn btn-danger remove-all-notifications">Reject</button>

    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">

                    @if($notifications->count() != 0)


                    <div class="row" style="display: inline;">
                        <input style="display: inline; top: 38px;" class="form-check-input-all" type="checkbox" id="checkAll"> <span style="margin-left: 12px;">Select All</span>

                    </div>



                    <table id="notification-table" class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th width="15%">Event Host</th>
                            <th width="50%">Update</th>
                            <th>Updated At</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($notifications as $n)


                            <tr class=" @if($n->approved == 0)  alert-info @elseif($n->approved == -1) alert-danger @elseif($n->approved == 1) alert-success @endif">
                                <td>
                                    <i class="material-icons" data-notify="icon">
                                        <input class="form-check-input" type="checkbox" value="{{ $n->id }}">
                                    </i>
                                </td>
                                <td>
                                    {{ \App\User::findOrfail( $n->editor_id )->name }}
                                </td>
                                <td>
                                    <span data-notify="message">
                                        {{ \App\User::findOrfail( $n->editor_id )->name }} updated {{  ucfirst( $n->type ) }} for <a href="{{ url('/events').'/'.\App\Event::findOrFail( $n->event_id )->slug_str }}">{{ \App\Event::findOrFail( $n->event_id )->name }}</a> to "{{ $n->value }}"
                                    </span>
                                </td>
                                <td>{{ $n->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if( $n->approved == 0 )

                                        <button

                                                data-id="{{ $n->id }}"
                                                data-event_id="{{ $n->event_id }}"
                                                data-type="{{ $n->type }}"
                                                data-value="{{ $n->value }}"
                                                data-btn="reject"

                                                style="margin-left: 2px;"

                                                data-toggle="tooltip" title="Reject"


                                                type="button" class="close btn btn-reject-notification btn-inner btn-danger btn-link btn-sm" data-dismiss="alert" aria-label="Close">
                                            <i class="fa fa-thumbs-down material-icons"></i>
                                        </button>

                                        <button

                                                data-id="{{ $n->id }}"
                                                data-event_id="{{ $n->event_id }}"
                                                data-type="{{ $n->type }}"
                                                data-value="{{ $n->value }}"
                                                data-btn="approve"

                                                data-toggle="tooltip" title="Approve"

                                                type="button" class="close btn btn-approve-notification btn-inner btn-success btn-link btn-sm" data-dismiss="alert" aria-label="Close">
                                            <i class="fa fa-thumbs-up material-icons"></i>
                                        </button>



                                    @else
                                        <button

                                                data-id="{{ $n->id }}"
                                                data-event_id="{{ $n->event_id }}"
                                                data-type="{{ $n->type }}"
                                                data-value="{{ $n->original_value }}"
                                                data-btn="undo"

                                                data-toggle="tooltip" title="Undo"


                                                type="button" class="close btn btn-approve-notification btn-inner btn-danger btn-link btn-sm" data-dismiss="alert" aria-label="Close">
                                            <i class="fa fa-undo material-icons"> Undo</i>
                                        </button>

                                    @endif

                                </td>
                            </tr>


                        @endforeach

                        </tbody>
                    </table>

                    @else
                        <div style="text-align: center;">
                            <h4>
                                No Notification Left.
                            </h4>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
