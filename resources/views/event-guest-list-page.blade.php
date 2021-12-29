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

        .email-guest-model:hover{
            background-color: #5bc0de;

        }

        .edit-guest-modal:hover{
            background-color: #5cb85c;

        }

        .btn-remove-guest:hover{
            background-color: #d9534f;

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
            color:black;
            border-bottom: 1px solid black;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 0 !important;
        }

        th{

                             text-align: left;

        }

        button{
            cursor:pointer;

        }

        .btn-guests-model{

            padding: 10px 20px;
            background-color: #aea070;
            color: white;
        }

        .modal-content{

            width: 500px;
            height: 500px;
        }

        .modal{

            padding-top: 40px;
        }

        .btn-guests-model{
            margin-top: 10px;
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
            margin: 9px 0 0 !important;
        }

        input[type='checkbox']{
            -webkit-appearance: checkbox !important;
            appearance: checkbox !important;
        }

        .back-button{

            display: inline-block;
            color: black;
            height: 44px;
            line-height: 44px;
            border: none !important;
            padding: 0 15px;
            margin-right: 7px;
        }


    </style>


<div class="home-banner innerpage row contact-banner" style="background-image: url({{ asset('images/contact-banner.jpg') }});">
    <div class="top-padding" style="text-align: -webkit-center;">
        <div class="wrapper">
            <div class="banner-description" style="float: none;">
                <div>
                    <h2 style="font-size: 50px !important;" id="title">{{ $event->name }}</h2>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="wrapper">

    <div class="top-details">





    </div>
    <a style="font-size: 12px;
    color: white;
    letter-spacing: 1px;" href="{{ url('') }}/events/{{$event->slug_str}}"><button class="back-button" style="font-size: 18px; margin-bottom: 10px; margin-top: 10px; margin-left: -17px;" ><i style="margin-left: 5px;" class="fa fa-angle-left"></i><span style="margin-left: 10px;">Back to Event Page</span></button></a>

    <div class="bi-content" style="width: 95%; padding: 4px !important;">


        <button class="pull-left btn-add-guest btn-guests-model" style="margin-bottom: 10px; margin-top: 10px;" >Add New Guest</button>


        <div class="row" style="display: inline; margin-top: 20px;">
            <input style="display: inline; top: 38px;" class="form-check-input-all" type="checkbox" id="checkAll_guests"> <span style="margin-left: 12px; font-size: 15px;">Select All</span>
            <button class="btn-guests-model btn-email-all" style="border-radius: 30px; padding: 5px !important; margin-bottom: 10px; margin-top: 10px; margin-left: 5px;" >Send Invitation Email to Selected Guests</button>
        </div>

        @if ($guest_list->count())

            <table class="table table-guests" style="width: 100%;">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Guest Name</th>
                    <th width="25%">Email</th>
                    <th width="20%">RSVP Status</th>
                    <th width="20%">Added</th>
                    <th width="30%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $indexKey=0 ?>
                @foreach ($guest_list as $g)
                    <tr style="background-color: @if($g->status == 'Not Sent') #fbe9d0 @elseif($g->status == 'Sent') #eaf7fb @elseif($g->status == 'Attending') #dcefdc @elseif($g->status == 'Not Attending') #faebea @endif;">
                        <td width="5%">
                            <i class="material-icons" data-notify="icon">
                                <input class="form-check-input" type="checkbox" value="{{ $g->id }}">
                            </i>
                        </td>
                        <td width="20%">
                            {{ $g->name }}
                        </td>

                        <td width="25%">
                            {{ $g->email }}
                        </td>
                        <td width="20%">@if($g->status == 'Sent')Invitation @elseif($g->status == 'Not Sent') Invitation @endif {{ $g->status }}</td>
                        <td width="20%">{{ $g->created_at->diffForHumans() }}</td>
                        <td width="30%">
                            <button style="top:0px !important; padding: 1px 4px !important;box-shadow: none !important;" class="email-guest-model"
                                    data-id="{{$g->id}}"
                                    data-name="{{$g->name}}"
                                    data-email="{{$g->email}}"
                                    data-toggle="tooltip" title="Send Email"

                                    >

                                <i style="top:0px !important;" class="fa fa-envelope"></i></button>

                            </button>
                            <button style="padding: 1px 4px !important;box-shadow: none !important; " class="edit-guest-modal "
                                    data-id="{{$g->id}}"
                                    data-name="{{$g->name}}"
                                    data-email="{{$g->email}}"
                                    data-toggle="tooltip" title="Edit Guest"

                                    >
                                <i style="top:0px !important;" class="fa fa-edit"></i>
                            </button>
                            </button>
                            <button style="top:0px !important; padding: 1px 4px !important;box-shadow: none !important;" class="btn-remove-guest" data-id="{{$g->id}}"
                                    data-toggle="tooltip" title="Delete Guest"

                                    >
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

{{--<div class="about-content row">--}}
    {{--<div class="wrapper">--}}
        {{--<div class="blue-content">--}}
            {{--<p>General Instructions for Guests (what to wear, what to bring, where to park, etc.)</p>--}}
            {{--<p>Link to company terms and policies <a href="https://www.legacycruisessd.com/terms-of-service">(https://www.legacycruisessd.com/terms-of-service)</a></p>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}








    <div class="modal fade" id="guestsListModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style=" width: 80%; height: 100%; padding: 15px 15px 25px;">

                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #aea070; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Guest List for Event</h4></div>
                    </div>
                </div>


                <div class="modal-body">





                </div>
            </div>
        </div>
    </div>


    <div id="addGuestModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="height: auto !important;">
                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #aea070; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Add Guests</h4></div>
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 60px;">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="event_id" value="{{ $event->id }}"/>



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
                        <button type="button" class="btn-guests-model add-guest-button" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Add
                        </button>
                        <button type="button" class="btn-guests-model" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="editGuestModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="height: auto !important;">
                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #aea070; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Edit Guests</h4></div>
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 60px;">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" id="id_edit_guest"/>



                        <div class="form-group">
                            <label class="control-label col-sm-3" style="text-align: left;" for="name">Name of Guest:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name_edit_guest" autofocus="true">
                                <small>Min: 2, Max: 32, only text</small>
                                <p class="errorName text-center text-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:20px;">
                            <label class="control-label col-sm-3" style="text-align: left; " for="name">Email:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email_edit_guest" autofocus="true">
                                <small>Please Enter Valid Email</small>
                                <p class="errorEmail text-center text-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer" style="margin-top: 20px;">
                        <button type="button" class="btn-guests-model update-guest-button" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Submit
                        </button>
                        <button type="button" class="btn-guests-model" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="emailGuestModal_all" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #aea070; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Email Guest</h4></div>
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 60px;">
                    <form class="form-horizontal" role="form">
                        <label class="control-label col-sm-3" style="text-align: left; " for="name">Email Text:</label>

                        <div class="form-group row" style="margin-top:20px;">
                            <div class="col-sm-12">
                                <textarea id="editor4" rows="4" cols="50">{{ $guest_email_text->text }}</textarea>
                                <p class="errorEmail text-center text-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer" style="margin-top: 20px;">
                        <button id="send_email_to_all_guests" type="button" data-event="{{ $event->id }}" class="btn-guests-model" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Send
                        </button>
                        <button type="button" class="btn-guests-model" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="emailGuestModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #aea070; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Email Guest</h4></div>
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 60px;">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="email_send_form">
                        <input type="hidden" id="name_send_form">
                        <input type="hidden" id="guest_send_form">
                        <label class="control-label col-sm-3" style="text-align: left; " for="name">Email Text:</label>

                        <div class="form-group row" style="margin-top:20px;">
                            <div class="col-sm-12">
                                <textarea id="editor3" rows="4" cols="50">{{ $guest_email_text->text }}</textarea>
                                <p class="errorEmail text-center text-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer" style="margin-top: 20px;">
                        <button id="send_email_to_guests" type="button" data-event="{{ $event->id }}" class="btn-guests-model" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Send
                        </button>
                        <button type="button" class="btn-guests-model" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sendInvitationOnCreation" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="height: auto !important;">
                <div class="modal-header" style="width: 100%;">
                    <div class="row" style="background-color: #aea070; height: 40px; ">
                        <div class="col-md-2" style="color: white;"><i class="fa fa-close pull-right" data-dismiss="modal" style="margin-right: 3px;
    margin-top: 2px;"></i></div>

                        <div class="col-md-10"><h4 style="margin-top: 7px; color: white;"><span class="glyphicon glyphicon-lock"></span>Send Inivation On Guest Creation</h4></div>
                    </div>
                </div>
                <div class="modal-body" style="padding-top: 60px;">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="with_invitation_event_id">
                        <input type="hidden" id="with_invitation_guest_id">
                        <input type="hidden" id="with_invitation_name_of_guest">
                        <input type="hidden" id="with_invitation_email_of_guest">

                        <h3>Would you like to send an invitation email to this guest right now? </h3>
                       <p> NOTE: You can send the invitation email now or at a later time. </p>

                    </form>
                    <div class="modal-footer" style="margin-top: 20px;">
                        <button id="send_email_to_guest_on_creation" type="button" class="btn-guests-model" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Send
                        </button>
                        <button id="send_email_later_refresh" type="button" class="btn-guests-model" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Later
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        CKEDITOR.replace( 'editor3' );
        CKEDITOR.replace( 'editor4' );


    </script>


@endsection
