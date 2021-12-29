
<!-- Flash Messages -->

@if (Session::get('flash_success'))       
    <div class="alert alert-success m-top-10">
        <b>Well done!</b> {{ Session::get('flash_success') }}
    </div>
@endif

@if (Session::get('flash_notice'))
    <div class="alert alert-info m-top-10">
        <b>Heads up!</b> {{ Session::get('flash_notice') }}
    </div>
@endif

@if (Session::get('flash_error'))
    <div class="alert alert-danger m-top-10">
        <b>Oh snap!</b> {{ Session::get('flash_error') }}
    </div>
@endif

<!-- End of Flash Messages -->