<!-- Start of Scripts -->
<script src="{{ URL::asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ URL::asset('admin-assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>--}}
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script> 
<script src="{{ URL::asset('admin-assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('admin-assets/plugins/node-waves/waves.js') }}"></script>
<script src="{{ URL::asset('admin-assets/plugins/momentjs/moment.js') }}"></script>
<script src="{{ URL::asset('admin-assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/admin.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/pages/tables/jquery-datatable.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/pages/forms/basic-form-elements.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/demo.js') }}"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="{{ URL::asset('js/jnoty.js') }}"></script>



<script type="text/javascript"
        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript"
        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
</script>


{{--<scrip type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></scrip>--}}

<!-- AJAX CRUD operations -->
<script type="text/javascript">
    // add a new post
    $(document).on('click', '.add-player-modal', function() {
        $('.modal-name').text('Add Event');
        $('#addPlayerModal').modal('show');
    });

    home_url = '{{ url('/') }}';



    $('.modal-footer').on('click', '.add-player-button', function() {

        gi = 0;


        if ($('#general_instructions_add').is(":checked")){

            gi = 1;
        }



            $.ajax({
            type: 'POST',
            url: 'events',
            data: {
                '_token': $('#_token').val(),
                'name': $('#name_add').val(),
                'event_type': $('#event_type_add').val(),
                'boarding_location': $('#boarding_location_add').val(),
                'event_date': $('#event_date_add').val(),
                'start_time': $('#start_time_add').val(),
                'end_time': $('#end_time_add').val(),
                'yacht_id': $('#yacht_id_add').val(),
                'owner_id': $('#owner_id_add').val(),
                'number_of_guests': $('#number_of_guests_add').val(),
                'description': $('#description_add').val(),
                'general_instructions': gi

            },
            success: function(data) {
                $('.errorName').addClass('hidden');
                $('.errorContent').addClass('hidden');



                if ((data.errors)) {

                    setTimeout(function () {
                        $('#addPlayerModal').modal('show');
//                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }




                    if (data.errors.event_date) {
                        $('.errorEventDate').removeClass('hidden');
                        $('.errorEventDate').text(data.errors.event_date);
                    }

                    if (data.errors.start_time) {
                        $('.errorStartTime').removeClass('hidden');
                        $('.errorStartTime').text(data.errors.start_time);
                    }

                    if (data.errors.end_time) {
                        $('.errorEndTime').removeClass('hidden');
                        $('.errorEndTime').text(data.errors.end_time);
                    }

                    if (data.errors.description) {
                        $('.errorDescription').removeClass('hidden');
                        $('.errorDescription').text(data.errors.description);
                    }

                    if (data.errors.number_of_guests) {
                        $('.errorNumberOfGuests').removeClass('hidden');
                        $('.errorNumberOfGuests').text(data.errors.number_of_guests);
                    }

                    return false;

                } else {

                    location.reload();


//                    $('#teams_table').DataTable().ajax.reload();
//                    toastr.success('Successfully added Team!', 'Success Alert', {timeOut: 5000});
                }
            }
        });
    });

    $(document).ready(function() {
        $('#notification-table').DataTable( {
            "order": []
        } );
    } );

    // Edit a post



    $(document).on('click', '.edit-player-modal', function() {
        $('.modal-name').text('Edit');

        $('#id_edit').val($(this).data('id'));
        $('#name_edit').val($(this).data('name'));
        $('#event_type_edit').val($(this).data('event_type'));
        $('#boarding_location_edit').val($(this).data('boarding_location'));
        $('#event_date_edit').val($(this).data('event_date'));
        $('#start_time_edit').val($(this).data('start_time'));
        $('#end_time_edit').val($(this).data('end_time'));
        $('#yacht_id_edit').val($(this).data('yacht_id'));
        $('#owner_id_edit').val($(this).data('owner_id'));
        $('#number_of_guests_edit').val($(this).data('number_of_guests'));
        $('#description_edit').val($(this).data('description'));

        if($(this).data('general_instructions') == 1)
            $('#general_instructions_edit').prop('checked', true);
        else
            $('#general_instructions_edit').prop('checked', false);




        id = $('#id_edit').val();
        $('#editPlayerModal').modal('show');
    });


    $('.modal-footer').on('click', '.edit-player-button', function() {

        gi = 0;


        if ($('#general_instructions_edit').is(":checked")){

            gi = 1;
        }


        $.ajax({
            type: 'PUT',
            url: 'events/' + id,
            data: {
                '_token': $('#_token').val(),
                'id': $("#id_edit").val(),
                'name': $('#name_edit').val(),
                'event_type': $('#event_type_edit').val(),
                'boarding_location': $('#boarding_location_edit').val(),
                'event_date': $('#event_date_edit').val(),
                'start_time': $('#start_time_edit').val(),
                'end_time': $('#end_time_edit').val(),
                'yacht_id': $('#yacht_id_edit').val(),
                'owner_id': $('#owner_id_edit').val(),
                'number_of_guests': $('#number_of_guests_edit').val(),
                'description': $('#description_edit').val(),
                'general_instructions': gi
            },
            success: function(data) {
                $('.errorName').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editPlayerModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }


                    if (data.errors.boarding_location) {
                        $('.errorBoardingLocation').removeClass('hidden');
                        $('.errorBoardingLocation').text(data.errors.boarding_location);
                    }

                    if (data.errors.event_date) {
                        $('.errorEventDate').removeClass('hidden');
                        $('.errorEventDate').text(data.errors.event_date);
                    }

                    if (data.errors.start_time) {
                        $('.errorStartTime').removeClass('hidden');
                        $('.errorStartTime').text(data.errors.start_time);
                    }

                    if (data.errors.end_time) {
                        $('.errorEndTime').removeClass('hidden');
                        $('.errorEndTime').text(data.errors.end_time);
                    }

                    if (data.errors.description) {
                        $('.errorDescription').removeClass('hidden');
                        $('.errorDescription').text(data.errors.description);
                    }

                    if (data.errors.number_of_guests) {
                        $('.errorNumberOfGuests').removeClass('hidden');
                        $('.errorNumberOfGuests').text(data.errors.number_of_guests);
                    }



                } else {
                    location.reload();
//                    toastr.success('Successfully updated Team!', 'Success Alert', {timeOut: 5000});

                }
            }
        });
    });

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).on('click', '.remove-all-notifications', function() {

        var notificationIDs = $("input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        console.log(notificationIDs);

        if(notificationIDs.length > 0) {



        var x = confirm("Are you sure you want to Delete all Selected Notifications?");

        if(x) {
            $.ajax({
                type: 'POST',
                url: home_url + '/remove_update_event',
                data: {
                    '_token': $('#_token').val(),
                    notificationIDs: notificationIDs

                },
                success: function (data) {

                    console.log(data);

                    location.reload();
                    //                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

                }
            });
        }

    }else{

        $.jnoty("Please Select Notifications first.", {
            sticky: true,
            header: 'Information',
            theme: 'jnoty-danger',
            icon: 'fa fa-info-circle'
        });
    }


    });


    $(document).on('click', '.approve-all-notifications', function() {

        var notificationIDs = $("input:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
        console.log(notificationIDs);

        if(notificationIDs.leggth > 0) {

            var x = confirm("Are you sure you want to Approve all Selected Notifications?");

            if (x) {
                $.ajax({
                    type: 'POST',
                    url: home_url + '/approve_all_update_event',
                    data: {
                        '_token': $('#_token').val(),
                        notificationIDs: notificationIDs

                    },
                    success: function (data) {

                        console.log(data);

                        location.reload();
                        //                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

                    }
                });
            }
        }else{

            $.jnoty("Please Select Notifications first.", {
                sticky: true,
                header: 'Information',
                theme: 'jnoty-danger',
                icon: 'fa fa-info-circle'
            });
        }


    });


//    $(document).on('click', '.btn-remove-notification', function() {
//
//        var x = confirm("Are you sure you want to delete?");
//
//        if(x) {
//            $.ajax({
//                type: 'POST',
//                url: home_url + '/remove_update_event/',
//                data: {
//                    '_token': $('#_token').val(),
//                    id: $(this).data("id")
//
//                },
//                success: function (data) {
//
//                    console.log(data);
//
//                    location.reload();
//        //                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});
//
//                }
//            });
//        }
//
//    })


    $(document).on('click', '.btn-approve-notification', function() {

        var x = confirm("Are you sure you want to Approve/Undo?");

        if(x) {


            $.ajax({
                type: 'POST',
                url: home_url + '/approve_update_event',
                data: {
                    '_token': $('#_token').val(),
                    id: $(this).data("id"),
                    event_id: $(this).data("event_id"),
                    type: $(this).data("type"),
                    value: $(this).data("value"),
                    btn: $(this).data("btn")
                },
                success: function (data) {

                    console.log(data);

                    location.reload();
//                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

                }
            });
        }

    });

    $(document).on('click', '.btn-reject-notification', function() {

        var x = confirm("Are you sure you want to Reject/Undo?");

        if(x) {


            $.ajax({
                type: 'POST',
                url: home_url + '/reject_update_event',
                data: {
                    '_token': $('#_token').val(),
                    id: $(this).data("id"),
                    event_id: $(this).data("event_id"),
                    type: $(this).data("type"),
                    value: $(this).data("value"),
                    btn: $(this).data("btn")
                },
                success: function (data) {

                    console.log(data);

                    location.reload();
//                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

                }
            });
        }

    });


    // delete a post


    $(document).on('click', '.delete-player-modal', function() {
        $('.modal-name').text('Delete');
        $('#id_delete').val($(this).data('id'));
        $('#name_delete').val($(this).data('name'));
        $('#deletePlayerModal').modal('show');
        id = $('#id_delete').val();
    });
    $('.modal-footer').on('click', '.delete-team-button', function() {
        $.ajax({
            type: 'DELETE',
            url: 'events/' + id,
            data: {
                '_token': $('#_token').val()
            },
            success: function(data) {

                location.reload();
//                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

            }
        });
    });

</script>


<script type="text/javascript">

    $(document).ready(function() {
        $('.table-events').DataTable(

                {
                    "pageLength": 10
                }
        );

        $( function() {
            $( ".event_datepicker" ).datepicker(

                    {
                        minDate: 0

                }
            );

//            $('#start_time_add').timepicker();




        } );


    } );

    $(document).on('click', '.save_instructions', function() {


        $.ajax({
            type: 'PUT',
            url: 'general_instructions/' + 1,
            data: {
                '_token': $('#_token').val(),

                'text': CKEDITOR.instances['editor1'].getData()
            },
            success: function(data) {

                location.reload();

            }
        })
    });

    $(document).on('click', '.save_email_template_1', function() {


        $.ajax({
            type: 'PUT',
            url: 'general_instructions/' + 2,
            data: {
                '_token': $('#_token').val(),
                'subject': $('#temp1_subject').val(),

                'text': CKEDITOR.instances['editor2'].getData()
            },
            success: function(data) {

                location.reload();

            }
        })
    });

    $(document).on('click', '.save_email_template_2', function() {


        $.ajax({
            type: 'PUT',
            url: 'general_instructions/' + 3,
            data: {
                '_token': $('#_token').val(),
                'subject': $('#temp2_subject').val(),


                'text': CKEDITOR.instances['editor3'].getData()
            },
            success: function(data) {

                location.reload();

            }
        })
    });

    $(document).on('click', '.save_email_template_3', function() {


        $.ajax({
            type: 'PUT',
            url: 'general_instructions/' + 4,
            data: {
                '_token': $('#_token').val(),
                'subject': $('#temp3_subject').val(),


                'text': CKEDITOR.instances['editor4'].getData()
            },
            success: function(data) {

                location.reload();

            }
        })
    });

    $(document).on('click', '.save_email_template_5', function() {


        $.ajax({
            type: 'PUT',
            url: 'general_instructions/' + 6,
            data: {
                '_token': $('#_token').val(),
                'subject': $('#temp5_subject').val(),


                'text': CKEDITOR.instances['editor6'].getData()
            },
            success: function(data) {

                location.reload();

            }
        })
    });




</script>
<!-- End of Scripts --> 