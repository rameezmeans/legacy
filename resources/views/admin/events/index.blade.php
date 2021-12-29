
@extends('admin.layout.master')

@section('content')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <style>

        .form-control{
            border: 1px solid #ccc !important;
            margin-bottom: 5px !important;
        }
    </style>

    <div class="block-header">
        <h2>Event Landing Pages List</h2><br/>
        <button class="btn btn-success add-player-modal button">Add Event</button>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">
                    @if ($events->count())

                    <table class="table table-events table100 ver1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Event</th>
                                <th>Yacht</th>
                                <th>Event Host</th>
                                <th>Updated At</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $indexKey=0 ?>
                            @foreach ($events as $event)
                                <tr>
                                    <td class="col1">{{ $indexKey+1 }}</td>
                                    <td>
                                        <a target = '_blank' href="{{ url('/').'/events/'.$event->slug_str }}">{{ $event->name }}</a>
                                    </td>

                                    <td>
                                        {{  ($event->yacht) ? $event->yacht->product_name : 'No Yacht assigned'  }}
                                    </td>
                                    <td>
                                        {{ ($event->host) ? $event->host->name : 'No Host assigned'   }}
                                    </td>

                                    <td>{{ $event->updated_at->diffForHumans() }}</td>


                                        <td>
                                            <button style="padding: 1px 4px !important;box-shadow: none !important;" class="edit-player-modal btn btn-info"
                                                    data-id="{{$event->id}}"
                                                    data-name="{{$event->name}}"
                                                    data-yacht_id="{{$event->yacht_id}}"
                                                    data-owner_id="{{$event->owner_id}}"
                                                    data-number_of_guests="{{$event->number_of_guests}}"
                                                    data-description="{{$event->description}}"
                                                    data-start_time="{{$event->start_time}}"
                                                    data-end_time="{{$event->end_time}}"
                                                    data-event_date="{{$event->event_date}}"
                                                    data-event_type="{{$event->event_type}}"
                                                    data-boarding_location="{{$event->boarding_location}}"
                                                    data-general_instructions="{{$event->general_instructions}}"

                                                    >
                                                <i style="top:0px !important;" class="fa fa-edit"></i>
                                            </button>
                                            </button>
                                            <button style="top:0px !important; padding: 1px 4px !important;box-shadow: none !important;" class="delete-player-modal btn btn-danger" data-id="{{$event->id}}" data-name="{{$event->name}}">
                                                <i style="top:0px !important;" class="fa fa-remove"></i></button>

                                            </button>
                                        </td>

                                </tr>


                            <?php $indexKey++;?>
                            @endforeach

                        </tbody>
                    </table>

                    @else

                            <div>
                                No Record Found
                            </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Table -->

    <div id="addPlayerModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-name"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}"/>

                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="content">Event Host:</label>
                            <div class="col-sm-9">
                                {{--<textarea class="form-control" id="team_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="owner_id_add" cols="40" rows="5">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Name of Event:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name_add" autofocus="true">
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorName text-center text-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Event Type:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="event_type_add">

                                        <option value="Corporate">Corporate</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Other">Other</option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Event Date:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control event_datepicker" readonly="readonly" id="event_date_add">
                                <p class="errorEventDate text-center text-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Event Start Time:</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="start_time_add">
                                <p class="errorStartTime text-center text-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Event End Time:</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="end_time_add">
                                <p class="errorEndTime text-center text-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Number of Guests:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="number_of_guests_add">
                                <p class="errorNumberOfGuests text-center text-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="content">Yacht:</label>
                            <div class="col-sm-9">
                                {{--<textarea class="form-control" id="team_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="yacht_id_add" cols="40" rows="5">
                                    @foreach($yachts as $yacht)
                                        <option value="{{ $yacht->id }}">{{ $yacht->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Boarding Location:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="boarding_location_add" cols="40" rows="5">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                            <label class="control-label col-sm-4" style="text-align: left; margin-left: 10px;" for="name">Event Description:</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                            <div class="col-sm-11">
                                <textarea type="text" style="height: 150px;" class="form-control" id="description_add"></textarea>
                                <p class="errorDescription text-center text-danger hidden"></p>
                            </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-7" style="text-align: left;" for="content">Include General Instructions in Event Page:</label>
                            <div class="col-sm-5">
                                <input style="opacity: 1 !important; position: absolute !important; left: 10px !important; margin-top: 12px;" type="checkbox"  id="general_instructions_add" checked>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label class="control-label col-sm-3" for="name">General Instructions:</label>--}}
                            {{--<div class="col-sm-9">--}}
                                {{--<textarea type="text" class="form-control" id="general_instructions_add"></textarea>--}}
                                {{--<p class="errorGeneralInstructions text-center text-danger hidden"></p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary add-player-button" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Add
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal form to edit a form -->
    <div id="editPlayerModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-name"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="id">ID:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_edit" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="content">Event Host:</label>
                            <div class="col-sm-9">
                                {{--<textarea class="form-control" id="team_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="owner_id_edit" cols="40" rows="5">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Name of Event:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name_edit" autofocus="true">
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorName text-center text-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Event Type:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="event_type_edit">

                                    <option value="Corporate">Corporate</option>
                                    <option value="Wedding">Wedding</option>
                                    <option value="Birthday">Birthday</option>
                                    <option value="Other">Other</option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Event Date:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control event_datepicker" readonly="readonly" id="event_date_edit">
                                <p class="errorEventDate text-center text-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Event Start Time:</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="start_time_edit">
                                <p class="errorStartTime text-center text-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Event End Time:</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="end_time_edit">
                                <p class="errorEndTime text-center text-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Number of Guests:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="number_of_guests_edit">
                                <p class="errorNumberOfGuests text-center text-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="content">Yacht:</label>
                            <div class="col-sm-9">
                                {{--<textarea class="form-control" id="team_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="yacht_id_edit" cols="40" rows="5">
                                    @foreach($yachts as $yacht)
                                        <option value="{{ $yacht->id }}">{{ $yacht->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Boarding Location:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="boarding_location_edit" cols="40" rows="5">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-sm-4" for="name">Event Description:</label>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-11">
                                    <textarea type="text" style="height: 150px;" class="form-control" id="description_edit"></textarea>
                                    <p class="errorDescription text-center text-danger hidden"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-7" style="text-align: left;" for="content">Include General Instructions in Event Page:</label>
                            <div class="col-sm-5">
                                <input style="opacity: 1 !important; position: absolute !important; left: 10px !important; margin-top: 12px;" type="checkbox"  id="general_instructions_edit" >
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label class="control-label col-sm-3" for="name">General Instructions:</label>--}}
                            {{--<div class="col-sm-9">--}}
                                {{--<textarea type="text" class="form-control" id="general_instructions_edit"></textarea>--}}
                                {{--<p class="errorGeneralInstructions text-center text-danger hidden"></p>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit-player-button" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal form to delete a form -->
    <div id="deletePlayerModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-name"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete the following Event?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="id">ID:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_delete" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="name">Name:</label>
                            <div class="col-sm-9">
                                <input type="name" class="form-control" id="name_delete" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete-team-button" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Delete
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
