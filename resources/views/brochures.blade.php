@extends('layouts.basic')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'download_brochure'))
@stop

@section('body-class', 'download-brochure')

@section('content')
<div class="yacht-content">
    <div class="wrapper" style="text-align: left;">
        <h1>DOWNLOAD OUR PRIVATE YACHT CHARTER BROCHURES </h1> 
        <p>Thank you for your interest in downloading our brochures. 
        </p> 
        <p>We are actively working on putting together comprehensive brochures, visually detailing our products and services, including pricing and rates.
        </p> 
        <p>Please check back here soon, or leave us with your email address below, and we will get back to you as soon as the brochures are ready for download.
        </p> 
        <!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="https://legacycruisessd.us17.list-manage.com/subscribe/post?u=8a32ca3ea8e84e0e33fcd9f3e&amp;id=909942e158&SOURCE=Brochures" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	
	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8a32ca3ea8e84e0e33fcd9f3e_909942e158" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>

<!--End mc_embed_signup-->
<br>
    </div>
</div> 
@endsection
