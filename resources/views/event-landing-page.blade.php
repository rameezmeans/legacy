@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'event_page'))
@stop

@section('body-class', 'contact-us')

@section('content')
    <style>

        @media only screen and (min-width: 426px) {

            .top-details {

                display: none;

            }
        }

        small{
            font-size: 10px !important;
            float:left;
        }

        label{
            float: left;
        }

        .modal-content{

            padding: 15px 15px 25px;;
        }

        .hidden{
            display: none;
        }

        .close{

            border: none !important;
        }

        @media only screen and (max-width: 1025px) {

            .not-display {
                display: none !important;

            }

            .side-details {

                width: 40% !important;
            }
        }

        @media only screen and (max-width: 426px) {

            .top-details {

                width: 100% !important;
                padding: 20px;

            }

            .side-details {

                display: none;

            }

            .top-padding{
                padding: 20px!important;
            }


            .not-display {
                display: none !important;
            }

            .bi-content{
                padding: 20px 40px !important;
                width: 100% !important;
            }


        }

        .not-display {
            display: inline-flex;
        }

        .top-padding{
            padding: 120px 0 0;
        }

        .side-details {

            width: 20%;
        }

        .form-control {
            display: block;
            width: 94%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }

        .hidden{
            display: none;
        }

        .text-danger{
            color: red;
        }

        button:disabled,
        button[disabled]{
            border: 1px solid #999999;
            background-color: #cccccc;
            color: #666666;
        }

        td{
            text-align: left;
        }

        th{

                             text-align: left;

        }

        button{
            cursor:pointer;

        }

        .btn-events-model{

            padding: 10px 20px;
            background-color: #1a1b55;
            color: white;
        }


    </style>

    <input type="hidden" id="event_id" value="{{ $event->id }}">
    <input type="hidden" id="editor_id" value="{{ $editor_id }}">
<div class="home-banner innerpage row contact-banner" style="background-image: url({{ asset('images/contact-banner.jpg') }}); display: inherit !important;">
    <div class="top-padding" style="text-align: -webkit-center;">
        <div class="wrapper">
            <div class="banner-description" style="float: none;">
                <div>
                    <h2 style="font-size: 50px !important;" id="title">{{ $event->name }}</h2>
                    <div style="text-align: -webkit-center;">
                        @if( $editor )
                            <button data-event_id="{{ $event->id }}" class="btn btn-edit-title" style="height: 30px; width: 80px; line-height: 0px; background: white; color: black;">Edit Title</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="not-display" style="width: 100%;">
    <div style="text-align: left; margin-left: 30px; width: 75%;"><h3 style="color: white;  font-size: 20px; font-weight: 400;
            font-style: normal;">{{ date('D, M d,Y', strtotime($event->event_date)) }}</h3>
        <h3 style="color: white;  font-size: 20px; font-weight: 400;
            font-style: normal;">{{ date("h:i a", strtotime($event->start_time) ) }} To {{date("h:i a",  strtotime($event->end_time)  ) }}</h3></div>
        <div style="text-align: right;">
    <div style="text-align: right; margin-left: 30px;"><h3 style="color: white;  font-size: 20px; font-weight: 400;
    font-style: normal;">{{ ($event->yacht) ? $event->yacht->product_name : 'No Yacht assigned' }}</h3>
        <h3 style="color: white;  font-size: 20px; font-weight: 400;
    font-style: normal;">{{  ($event->location) ? $event->location_name: 'Location not assigned.' }}</h3></div></div>
        </div>
</div>

<div class="wrapper">

    <div class="top-details">



        <div style="display: inline-flex; margin-top: 40px;">
            <i class="fa fa-user" style="margin: 5px 15px;"></i>
            <div>
                <h3 style="color: black;  font-size: 16px; font-weight: 400;
    font-style: normal;">{{ ($event->host) ? $event->host->name: 'No Host assigned' }}</h3>
                <a href="#"><span style="color: #3f51b5;">Send a message</span></a>
            </div>
        </div>

        <div style="display: inline-flex;  margin-top: 15px;">
            <i class="fa fa-calendar" style="margin: 5px 15px;"></i>
            <div>
                <h3 style="color: black;  font-size: 16px; font-weight: 400;
            font-style: normal;">{{ date('D, M d,Y', strtotime($event->event_date)) }}</h3>
                <h3 style="color: black;  font-size: 16px; font-weight: 400;
            font-style: normal;">{{ date("h:i a", strtotime($event->start_time) ) }} To {{date("h:i a",  strtotime($event->end_time)  ) }}</h3>
                <a href="#"><span style="color: #3f51b5;">Add To Calender</span></a>
            </div>
        </div>
        <div style="display: inline-flex;  margin-top: 15px;">
            <i class="fa fa-map-marker" style="margin: 5px 15px;"></i>
            <div>

                <h3 style="color: black;  font-size: 16px; font-weight: 400;
    font-style: normal;">{{ ($event->yacht) ? $event->yacht->product_name: 'No yacht assigned' }}</h3>
                <h3 style="color: black;  font-size: 16px; font-weight: 400;
    font-style: normal;">{{ ( $event->location) ? $event->location->name: 'No Location assigned' }}</h3>
                <a href="#"><span style="color: #3f51b5;">View on Map</span></a>
            </div>
        </div>
    </div>
    <div class="bi-content" style="width: 60%;">
        <div style="display: inline-flex;"><h3 style="color: black; font-weight: 300;">Event Description</h3>@if( $editor )
                <button class="btn btn-edit-description" data-event_id="{{ $event->id }}" style="height: 30px; width: 130px; line-height: 0px; background: black; color: white; margin-top: 10px;
    margin-left: 10px;">Edit Description</button>
            @endif</div>
        <p style="color: #000000;">{{ $event->description }}</p>

        @if($event->general_instructions )
            <h3 style="color: black;font-weight: 300;">General Instructions for Guests</h3>
            {!! $general_instructions !!}
        @endif

    </div>
    <div class="bi-content-event-details side-details">




        <div style="display: inline-flex;">
            <i class="fa fa-user" style="margin: 5px 15px;"></i>
            <div>
            <h3 style="color: black;  font-size: 16px; font-weight: 400;
    font-style: normal;">{{ ($event->host) ? $event->host->name : 'No Host assigned.' }}</h3>
                <a href="#"><span style="color: #3f51b5;">Send a message</span></a>
            </div>
        </div>
        <div style="display: inline-flex;  margin-top: 15px;">
            <i class="fa fa-calendar" style="margin: 5px 15px;"></i>
            <div>
                <h3 style="color: black;  font-size: 16px; font-weight: 400;
            font-style: normal;">{{ date('D, M d,Y', strtotime($event->event_date)) }}</h3>
                <h3 style="color: black;  font-size: 16px; font-weight: 400;
            font-style: normal;">{{ date("h:i a", strtotime($event->start_time) ) }} To {{ date("h:i a", strtotime($event->end_time) ) }}</h3>
                <a href="#"><span style="color: #3f51b5;">Add To Calender</span></a>
            </div>
        </div>
        <div style="display: inline-flex;  margin-top: 15px;">
        <i class="fa fa-map-marker" style="margin: 5px 15px;"></i>
            <div>

            <h3 style="color: black;  font-size: 16px; font-weight: 400;
    font-style: normal;">{{ ($event->yacht) ? $event->yacht->product_name : 'No Yacht assigned.' }}</h3>
        <h3 style="color: black;  font-size: 16px; font-weight: 400;
    font-style: normal;">{{  ($event->location)? $event->yacht->location_name: "No Location assigned." }}</h3>
                <a href="#"><span style="color: #3f51b5;">View on Map</span></a>
                </div>
            </div>



    </div>
</div>
</div>

{{--<div class="about-content row">--}}
    {{--<div class="wrapper">--}}
        {{--<div class="blue-content">--}}
            {{--<p>General Instructions for Guests (what to wear, what to bring, where to park, etc.)</p>--}}
            {{--<p>Link to company terms and policies <a href="https://www.legacycruisessd.com/terms-of-service">(https://www.legacycruisessd.com/terms-of-service)</a></p>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


    @if( !$editor && isset($admin) && !$admin )

<div class="" style="text-align: -webkit-center;">
    <div class="yacht-content" id="not_responded">
            <a href="javascript:void(0)" id="attend_event" style="font-size: 15px; text-decoration: none; width: 190px;">Will Attend</a>
            <a href="javascript:void(0)" id="not_attend_event" style="font-size: 15px; text-decoration: none; width: 190px;">Will Not Attend</a>
            {{--<a href="#" style="font-size: 16px;">Ask a Question</a>--}}
    </div>

    <div class="yacht-content" id="attending" style="display: none;">
            <h3>I Will Attend</h3>
            <a href="javascript:void(0)" id="not_attend_event" style="font-size: 15px; text-decoration: none; width: 190px;">Change RSVP</a>
            {{--<a href="#" style="font-size: 16px;">Ask a Question</a>--}}
    </div>

    <div class="yacht-content" id="not_attending" style="display: none;">
        <h3>I Will Not Attend</h3>
        <a href="javascript:void(0)" id="attend_event" style="font-size: 15px; text-decoration: none; width: 190px;">Change RSVP</a>
        {{--<a href="#" style="font-size: 16px;">Ask a Question</a>--}}
    </div>
</div>
@elseif(isset($admin) && !$admin)

        <div class="" style="text-align: -webkit-center;">
            <div class="yacht-content">
                <a href="/events/{{ $event->slug_str }}/guest_list" style="font-size: 15px; text-decoration: none; width: 160px;">MANAGE GUEST LIST AND RSVP'S</a>
                {{--<a href="javascript:void(0)" class="showEmailSettings" style="font-size: 15px; text-decoration: none; width: 160px;">Email Settings</a>--}}
            </div>
        </div>
@endif

    <div class="modal fade" id="editTitleModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline-flex;">
                    <h4 style="margin-top: 7px;"><span class="glyphicon glyphicon-lock"></span>Edit Event Title</h4>
                </div>
                <div class="modal-body">
                    <form role="form" style="margin-top: 30px;">
                        <div class="form-group">
                            <label for="usrname" style="float: left; "><span class="glyphicon glyphicon-user"></span> Title:</label>


                            <input onchange="countAndUpdate(this);"
                                   onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" type="text" class="form-control" id="title_input" value='{{ $event->name }}'><br>
                            <p class="errorEmptyTitle text-danger hidden">Please enter an event title between 5 and 32 characters.</p>

                        </div>
                    </form>
                </div>
                <div style="display: inline-flex; margin-top: 20px;" class="modal-footer">
                    <button style="width: 50px; height: 30px; line-height: 0px; margin-right: 5px;" type="button" class="btn btn-default btn-success btn-block btn-title-updated"><span class="glyphicon glyphicon-off"></span>Save</button>
                    <button style="width: 50px; height: 30px; line-height: 0px;" type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editDescriptionModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="width: 500px; height: 300px;">
                <div class="modal-header" style="display: inline-flex;">
                    <h4 style="margin-top: 7px;"><span class="glyphicon glyphicon-lock"></span>Edit Event Description</h4>
                </div>
                <div class="modal-body">
                    <form role="form" style="margin-top: 30px;">
                        <div class="form-group">
                            <label for="usrname" style="float: left; "><span class="glyphicon glyphicon-user"></span> Description:</label>
                            <textarea style="height: 150px;" type="text" class="form-control" id="description_updated">{{ $event->description }}</textarea>
                        </div>
                    </form>
                </div>
                <div style="display: inline-flex; margin-top: 20px;" class="modal-footer">
                    <button style="width: 50px; height: 30px; line-height: 0px; margin-right: 5px;" type="button" class="btn btn-default btn-success btn-block btn-description-updated" data-dismiss="modal"><span class="glyphicon glyphicon-off"></span>Save</button>
                    <button style="width: 50px; height: 30px; line-height: 0px;" type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="guestsListModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style=" width: 80%; height: 100%; padding: 15px 15px 25px;">

                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #1a1b55; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Guest List for Event</h4></div>
                    </div>
                </div>


                <div class="modal-body">


                    <button class="pull-left btn-add-guest btn-events-model" style="margin-bottom: 10px; margin-top: 10px;" >Add Guest</button>




                    @if ($guest_list->count())

                        <table class="table table-events" style="width: 100%;">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Name</th>
                                <th width="35%">Email</th>
                                <th width="40%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $indexKey=0 ?>
                            @foreach ($guest_list as $g)
                                <tr>
                                    <td width="5%">{{ $indexKey+1 }}</td>
                                    <td width="20%">
                                        {{ $g->name }}
                                    </td>

                                    <td width="35%">
                                        {{ $g->email }}
                                    </td>
                                    <td width="40%">
                                        <button style="padding: 1px 4px !important;box-shadow: none !important;" class="edit-player-modal"
                                                data-id="{{$g->id}}"
                                                data-name="{{$g->name}}"
                                                data-yacht_id="{{$g->yacht_id}}"
                                                data-owner_id="{{$g->owner_id}}"
                                                data-number_of_guests="{{$g->number_of_guests}}"
                                                data-description="{{$g->description}}"


                                                >
                                            <i style="top:0px !important;" class="fa fa-edit"></i>
                                        </button>
                                        </button>
                                        <button style="top:0px !important; padding: 1px 4px !important;box-shadow: none !important;" class="delete-player-modal" data-id="{{$event->id}}" data-name="{{$event->name}}">
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


    <div id="addGuestModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #1a1b55; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Add Guests</h4></div>
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 60px;">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}"/>
                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Name of Guest:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name_add" autofocus="true">
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorName text-center text-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:20px;">
                            <label class="control-label col-sm-3" style="text-align: left; " for="name">Email:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email_add" autofocus="true">
                                <small>Please Enter Valid Email</small>
                                <p class="errorEmail text-center text-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer" style="margin-top: 20px;">
                        <button type="button" class="btn-events-model add-guest-button" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Add
                        </button>
                        <button type="button" class="btn-events-model" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
