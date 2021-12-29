	<footer class="row" style="display: inherit !important;">
		<div class="footer-links row text-center">
			<div class="wrapper">
				<ul>
					<li <?php echo Request::segment(1) == 'corp-events'  ? 'class="active"' : '' ?>><a href="{{ url('/plan-your-event/corporate') }}">CORPORATE EVENTS</a></li>
					<li <?php echo Request::segment(1) == 'weddings'  ? 'class="active"' : '' ?>><a href="{{ url('/plan-your-event/wedding') }}">YACHT WEDDINGS</a></li>
					<li <?php echo Request::segment(1) == 'birthday-parties'  ? 'class="active"' : '' ?>><a href="{{ url('plan-your-event/birthdays') }}">BIRTHDAY PARTIES</a></li>
					<!-- <li <?php echo Request::segment(1) == 'download-brochure'  ? 'class="active"' : '' ?>><a href="{{ url('/download-brochure') }}">DOWNLOAD OUR BROCHURE</a></li>
					<li <?php echo Request::segment(1) == 'contact-us'  ? 'class="active"' : '' ?>><a href="{{ url('/contact-us') }}">CONTACT</a></li>-->
					<li <?php echo Request::segment(1) == 'leave-a-review'  ? 'class="active"' : '' ?>><a href="{{ url('/leave-a-review') }}">LEAVE A REVIEW</a></li>
					<li <?php echo Request::segment(1) == 'terms-of-service' ? 'class="active"' : '' ?>><a href="{{ url('/terms-of-service') }}">TERMS OF SERVICE</a></li>
					<li <?php echo Request::segment(1) == 'privacy-policy'  ? 'class="active"' : '' ?>><a href="{{ url('/privacy-policy') }}">PRIVACY POLICY</a></li>
				</ul>
			</div>
		</div>
		<div class="copyright row" style="display: inherit !important;">
			<div class="wrapper text-center">
				{{ config('legacy.site_copyright') }}
			</div>
		</div>
	</footer>

	<div id="myModal-register" class="modal register-popup">
		<div class="modal-content">
			<button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        	</button>
        	<div class="popup-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
			<form class="form-horizontal" id="registeration-form" role="form" method="POST" action="{{ url('/register-user') }}">
				{{ csrf_field() }}
				<label class="popup-heading">Create Account</label>
				<a href="javascript:void(0);" style="margin-bottom: 10px; display: block;" onclick="popUp('{{ url('/auth/facebook') }}');">
					<img src="{{ asset('images/fb.jpg') }}" alt="Log in with Facebook">
				</a>
				<a href="javascript:void(0);" onclick="popUp('{{ url('/auth/google') }}');">
					<img src="{{ asset('images/google.jpg') }}" alt="Sign in with Google">
				</a>
				<font>OR</font>
				<hr>
				<input id="cname" type="hidden" name="name" value="">
				<input id="cphone" type="hidden" name="phone" value="">
				<input id="email1" type="email" name="email" class="" value=""  placeholder="EMAIL ADDRESS" required>

				<input id="password1" type="password" class="" name="password" placeholder="PASSWORD" required>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="CONFIRM PASSWORD" required>
                <label id="signin-error" class="error"></label>
				<input type="submit"  class="signin"  value="CREATE ACCOUNT">
				<p>By Clicking on the "Create Account" button, you are agreeing to our <a href="/terms-of-service" target="_blank">Terms & Conditions</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.<p>
			</form>
		</div>
	</div>
	<div id="myModal-login" class="modal register-popup">
		<div class="modal-content">
			<button type="button" class="closebtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        	</button>
        	<div class="popup-loader">
                <i class="fa fa-spinner fa-spin spin-big"></i>
            </div>
			<form class="form-horizontal" id="loginForm" role="form" method="POST" action="{{ url('/legacy-login') }}">
				{{ csrf_field() }}
				<label class="popup-heading">Sign In</label>
				<p class="info">Please sign in if you already have a customer account with us or if you prefer to create one now. Or feel free to skip this now, and create your account later.</p>
				<a href="javascript:void(0);" style="margin-bottom: 10px; display: block;" onclick="popUp('{{ url('/auth/facebook') }}');">
					<img src="{{ asset('images/fb.jpg') }}" alt="Log in with Facebook">
				</a>
				<a href="javascript:void(0);" onclick="popUp('{{ url('/auth/google') }}');">
					<img src="{{ asset('images/google.jpg') }}" alt="Sign in with Google">
				</a>
				<font>OR</font>
				<hr>
				<input id="email2" type="email" class="lemail" name="email" placeholder="EMAIL ADDRESS" required>
				<input id="password2" type="password" name="password" placeholder="PASSWORD" required>
				<label id="login-error" class="error"></label>
				<input type="submit" class="signin" value="SIGN IN">
				<a class="btn btn-link" href="{{ route('password.request') }}">
	                Forgot Your Password?
	            </a>
	            <p class="footinfo">Don’t have an account? <a href="javascript:void(0)" class="btn-register">Click Here</a></p>

	        </form>
		</div>
	</div>

	{{--this is the part which is not allowing to redirect to right place --}}

	<script
			src="https://code.jquery.com/jquery-2.2.4.js"
			integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
			crossorigin="anonymous"></script>



	<script src="{{ URL::asset('admin-assets/plugins/jquery-datatable/jquery.dataTables.min.js') }}"></script>



	<script src="{{ URL::asset('admin-assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

	<script type="text/javascript">


		home_url = '{{ url('/') }}';

		$(document).on('click', '.btn-edit-title', function() {

			event_id = $(this).data("event_id");

			$("#editTitleModal").modal('show');

		});

//		$(document).on('click', '.email-guest-button', function() {
//
//			$.ajax({
//				type: 'POST',
//				url: home_url + '/send_email',
//				data: {},
//				success: function (data) {
//
//
//
//				}
//			});
//
//
//
//
//		});
		$(document).on('click', '.btn-title-updated', function() {

			title = $('#title_input').val();
			event_id = $('#event_id').val();
			editor_id = $('#editor_id').val();
			console.log(title);

				$.ajax({
					type: 'POST',
					url: home_url + '/update_event_title/' + event_id,
					data: {
						'_token': $('#_token').val(),
						title: title,
						type: 'title',
						editor_id: editor_id
					},
					success: function (data) {

						$('.errorEmptyTitle').addClass('hidden');
						$('#editTitleModal').modal('hide');

						$.jnoty("Your request to Change Title of your event is Saved. Our staff will review that and update that, Shortly.", {
							sticky: true,
							header: 'Information',
							theme: 'jnoty-success',
							icon: 'fa fa-info-circle'
						});


						console.log(data);

//					location.reload();
//                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

					}
				});

		});

		$(document).on('click', '.update-guest-button', function() {

			id = $('#id_edit_guest').val();
			name = $('#name_edit_guest').val();
			email = $('#email_edit_guest').val();
			console.log(title);



			$.ajax({
				type: 'POST',
				url: home_url+'/update_guest/' + id,
				data: {
					'_token': $('#_token').val(),
					name: name,
					email: email
				},
				success: function(data) {

//					console.log(data);



					location.reload();
//                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

				}
			});


		})

		    $(document).on('click', '.btn-remove-guest', function() {

		        var x = confirm("Are you sure you want to delete?");

		        if(x) {
		            $.ajax({
		                type: 'POST',
		                url: home_url + '/remove_guest',
		                data: {
		                    '_token': $('#_token').val(),
		                    id: $(this).data("id")

		                },
		                success: function (data) {

		                    console.log(data);

		                    location.reload();
		        //                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

		                }
		            });
		        }

		    })


		$(document).on('click', '.btn-description-updated', function() {

			description = $('#description_updated').val();
			console.log(description);

			event_id = $('#event_id').val();
			editor_id = $('#editor_id').val();
			console.log(title);



			$.ajax({
				type: 'POST',
				url: home_url+'/update_event_title/' + event_id,
				data: {
					'_token': $('#_token').val(),
					title: description,
					type: 'description',
					editor_id: editor_id
				},
				success: function(data) {

//					console.log(data);

					$.jnoty("Thanks for updating your event information. Our event specialists will review and make the updates to your event landing page shortly.", {
						sticky: true,
						header: 'Information',
						theme: 'jnoty-success',
						icon: 'fa fa-info-circle'
					});

//					location.reload();
//                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});

				}
			});

		});




		function countAndUpdate(e){

			console.log($(e).val().length);

			if($(e).val().length > 32 || $(e).val().length <= 2){

				$('.errorEmptyTitle').removeClass('hidden');
				$('.btn-title-updated').prop('disabled', true);

			}
			else if($(e).val().length < 32 || $(e).val().length > 2){

				$('.errorEmptyTitle').addClass('hidden');
				$('.btn-title-updated').prop('disabled', false);


			}

		}


		$(document).on('click', '.edit-guest-modal', function() {


			$('#editGuestModal').modal('show');
			$('#id_edit_guest').val($(this).data('id'));
			$('#name_edit_guest').val($(this).data('name'));
			$('#email_edit_guest').val($(this).data('email'));

		});


		$(document).on('click', '.add-guest-button', function() {

			$.ajax({
				type: 'POST',
				url: home_url+'/add_guest',
				data: {
					'_token': $('#_token').val(),
					'name': $('#name_add').val(),
					'email': $('#email_add').val(),
					'event_id': $('#event_id').val()
				},
				success: function(data) {

					if (data.errors) {

						setTimeout(function () {
							$('#addGuestModal').modal('show');
						}, 500);

						if (data.errors.name) {
							$('.errorName').removeClass('hidden');
							$('.errorName').text(data.errors.name);
						}


						if (data.errors.email) {
							$('.errorEmail').removeClass('hidden');
							$('.errorEmail').text(data.errors.email);
						}


					}else{

						$('#sendInvitationOnCreation').modal('show');

						console.log(data);



						$('#with_invitation_event_id').val(data.event_id);
						$('#with_invitation_guest_id').val(data.id);
						$('#with_invitation_name_of_guest').val(data.name);
						$('#with_invitation_email_of_guest').val(data.email);


//						location.reload();
					}



				}

				})


		});


		$(document).on('click', '#send_email_to_guest_on_creation', function() {


			$('#email_send_form').val($('#with_invitation_email_of_guest').val());
			$('#name_send_form').val($('#with_invitation_name_of_guest').val());
			$('#guest_send_form').val($('#with_invitation_guest_id').val());


			$("#emailGuestModal").modal('show');



		});
		$(document).on('click', '#send_email_later_refresh', function() {

									location.reload();


		});
		$(document).on('click', '.btn-edit-description', function() {

			event_id = $(this).data("event_id");

			$("#editDescriptionModal").modal('show');



		});

		$(document).on('click', '.btn-add-guest', function() {


			$("#addGuestModal").modal('show');



//			$(".email-guest-button").data('guest_name', name);


		});

		$(document).on('click', '#attend_event', function() {

			var $_GET = {};

			document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
				function decode(s) {
					return decodeURIComponent(s.split("+").join(" "));
				}

				$_GET[decode(arguments[1])] = decode(arguments[2]);
			});

			console.log($_GET["guestno"]);


			var result = confirm("You want to Attend this event?");
			if(result) {


				$.ajax({
					type: 'POST',
					url: home_url + '/attending_event',
					data: {
						'_token': $('#_token').val(),

						'guest_id': $_GET["guestno"]

					},
					success: function (data) {

						$.jnoty("Your Feedback Recorded.", {
							sticky: true,
							header: 'Information',
							theme: 'jnoty-success',
							icon: 'fa fa-info-circle'
						});

						location.reload();


					}
				});
			}
		});

		$(document).on('click', '#not_attend_event', function() {

			var $_GET = {};

			document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
				function decode(s) {
					return decodeURIComponent(s.split("+").join(" "));
				}

				$_GET[decode(arguments[1])] = decode(arguments[2]);
			});

			console.log($_GET["guestno"]);

			var result = confirm("You dont want to Attend this event?");

			if(result) {


				$.ajax({
					type: 'POST',
					url: home_url + '/not_attending_event',
					data: {
						'_token': $('#_token').val(),

						'guest_id': $_GET["guestno"]

					},
					success: function (data) {

						$.jnoty("Your Feedback Recorded.", {
							sticky: true,
							header: 'Information',
							theme: 'jnoty-success',
							icon: 'fa fa-info-circle'
						});

						location.reload();



					}
				});
			}
		});


		$(document).on('click', '#send_email_to_guests', function() {

			event_id = $(this).data("event");
			guest_email = $('#email_send_form').val();
			geust_name = $('#name_send_form').val();
			geust_id = $('#guest_send_form').val();




			$.ajax({
				type: 'POST',
				url: home_url+'/send_email',
				data: {
					'_token': $('#_token').val(),
					'guest_name': geust_name,
					'guest_email': guest_email,
					'event_id': event_id,
					'guest_id': geust_id,
					'email_text': CKEDITOR.instances['editor3'].getData()

				},
				success: function(data) {

					if(data) {

						$.jnoty("Email is sent to Guest.", {
							sticky: true,
							header: 'Information',
							theme: 'jnoty-success',
							icon: 'fa fa-info-circle'
						});

						location.reload();
					}


				}
			});






		});
		$(document).on('click', '#send_email_to_all_guests', function() {

			var guestIDs = $("input:checkbox:checked").map(function(){
				return $(this).val();
			}).get();
			console.log(guestIDs);

			event_id = $(this).data("event");


			if(guestIDs.length > 0) {

				$.ajax({
					type: 'POST',
					url: home_url + '/send_email_to_all',
					data: {
						'_token': $('#_token').val(),
						'guestIDs' : guestIDs,
						'event_id' : event_id,
						'email_text': CKEDITOR.instances['editor4'].getData()

					},
					success: function (data) {

						if (data) {

							$.jnoty("Email is sent to Selected Guests.", {
								sticky: true,
								header: 'Information',
								theme: 'jnoty-success',
								icon: 'fa fa-info-circle'
							});

//							location.reload();
						}


					}
				});
			}else{

				$.jnoty("Please Select Guests first.", {
					sticky: true,
					header: 'Information',
					theme: 'jnoty-danger',
					icon: 'fa fa-info-circle'
				});
			}




		})
		$(document).on('click', '.btn-email-all', function() {

			$("#emailGuestModal_all").modal('show');



		})
		$(document).on('click', '.email-guest-model', function() {

			name = $(this).data("name");
			email = $(this).data("email");
			guest_id = $(this).data("id");


//			$(".email-guest-button").data('email', email);

//			$(".email-guest-button").attr({'data-email':email});


			console.log(email);
			$('#email_send_form').val(email);
			$('#name_send_form').val(name);
			$('#guest_send_form').val(guest_id);


			$("#emailGuestModal").modal('show');





		});


			$('.table-events').DataTable( {
				"order": []
			} );

		$('.table-guests').DataTable( {
				"order": []
			} );


		$("#checkAll_guests").click(function () {
			$('input:checkbox').not(this).prop('checked', this.checked);
		});


		var $_GET = {};

		document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
			function decode(s) {
				return decodeURIComponent(s.split("+").join(" "));
			}

			$_GET[decode(arguments[1])] = decode(arguments[2]);
		});

		console.log($_GET["guestno"]);


		$.ajax({
			type: 'POST',
			url: home_url + '/check_guest_rsvp',
			data: {
				'_token': $('#_token').val(),

				'guest_id': $_GET["guestno"]

			},
			success: function (data) {

				if(data == 'Attending'){
					console.log(data);

					$("#not_attending").css("display", "none");
					$("#not_responded").css("display", "none");




				}
				else if(data == 'Not Attending'){

					console.log(data);

					$("#attending").css("display", "none");
					$("#not_responded").css("display", "none");
				}
				else{
					console.log(data);

					$("#attending").css("display", "none");
					$("#not_attending").css("display", "none");


				}


			}
		});




	</script>


	@if(!Request::is('/'))
		{{--<link href="{{ URL::asset('css/calendar.min.css') }}" rel="stylesheet" type="text/css">--}}
		<script src='https://www.google.com/recaptcha/api.js'></script>
		@endif


				<!-- Google Search Structured Data -->
		<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "https://www.legacycruisessd.com",
    "logo": "https://www.legacycruisessd.com/images/logo-legacy-cruises-blue.png",
    "name": "Legacy Cruises & Events",
	"sameAs": [
    "https://www.facebook.com/LegacyCruisesSD/",
    "https://www.instagram.com/legacycruisessd/",
    "https://twitter.com/legacycruisessd"
    ],
    "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+1-844-534-2732",
    "contactType": "reservations",
    "contactOption": "TollFree",
    "areaServed": [
      "US",
      "CA"
    ]
  },{
    "@type": "ContactPoint",
    "telephone": "+1-619-550-3800",
    "contactType": "customer service"
  },{
    "@type": "ContactPoint",
    "telephone": "+1-844-534-2732",
    "contactType": "sales",
    "contactOption": "TollFree",
    "areaServed": [
      "US",
      "CA"
    ]
  }]
}
</script>

	<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/jquery.autotab.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/scripts.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/jquery.validate.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/jnoty.js') }}"></script>




	<script type="text/javascript">
    function popUp(URL) {
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=500,left = 200,top = 200');");
    }

    function callback_top(){
    	$(".popup-loader").show();
    		$(".noauth").hide();
    		$(".complete-log").hide();
    		$(".to-complete").hide();
        	$(".authcheck").show();
        	$("#pay-purchase").show();
        setTimeout(function(){
        	$(".popup-loader").hide();
         	$('#myModal-register').hide();
            $('#myModal-login').hide();
        }, 2000);
    }
	</script>

