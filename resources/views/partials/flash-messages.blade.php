@if (Session::get('flash_success'))
    <div class="snackbar-container hide">
		<span class='snackbar--success'>{{ Session::get('flash_success') }}</span>
    </div>
@endif

@if (Session::get('flash_notice'))
	<div class="snackbar-container hide">
		<span class='snackbar--notice'>{{ Session::get('flash_notice') }}</span>
    </div>
@endif

@if (Session::get('flash_error'))
    <div class="snackbar-container hide">
		<span class='snackbar--error'>{{ Session::get('flash_error') }}</span>
    </div>
@endif
