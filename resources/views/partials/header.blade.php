<header class="row" style="display: inherit !important;">
	<div class="top-header">
		<div class="wrapper">
			<div class="logo">
				<a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Legacy Cruises SD Logo" /></a>
			</div>

			<div class="header-left">
	      		<div class="top-links">
	      		@if (Route::has('login'))
	      			@if (Auth::check())
						<script>
						window.intercomSettings = {
						app_id: "q66oai88",
						name: "{{Auth::user()->name}}", // Full name
						email: "{{Auth::user()->email}}", // Email address
						created_at: "{{date('Y-m-d H:i:s')}}" // Signup date as a Unix timestamp
						};
						</script>
						<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/APP_ID';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
	      				<a href="{{ url('/user/my-account') }}">My Account</a> /
		                <a href="{{ url('legacy-logout') }}">
							Logout
						</a>
						</form>
		            @else
						<script>
						window.intercomSettings = {
						app_id: "q66oai88"
						};
						</script>
						<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/APP_ID';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
		            	<div class="authcheck" style="display:none;">
		            		<a href="{{ url('/user/my-account') }}">My Account</a> /
			                <a href="{{ url('legacy-logout') }}">
								Logout
							</a>
						</div>
						<div class="noauth">
							<a href="javascript:void(0)" class="myBtn-login">LOGIN</a> / <a href="javascript:void(0)" class="myBtn-register">REGISTER</a>
						</div>
		            @endif
		        @endif

	      		</div>
	      		<div class="callto"><a href="tel:1-844-534-2732">1-844-LEGASEA</a></div>
	      	</div>

	      	<div class="header-right">
	      		<div class="talk-btn">
	      			<a href="{{ url('/contact-us') }}">TALK TO AN EXPERT</a>
	      		</div>
	      		<div class="social-links">
	      			<a href="https://www.facebook.com/LegacyCruisesSD" target="_blank" title="Follow us on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
	      			<a href="https://www.instagram.com/LegacyCruisesSD" target="_blank" title="Follow us on Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
	      			<a href="https://twitter.com/LegacyCruisesSD" target="_blank" title="Follow us on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
	      			<a href="https://yelp.com/biz/legacy-cruises-and-events-san-diego" target="_blank" title="Visit us on Yelp"><i class="fa fa-yelp" aria-hidden="true"></i></a>
	      		</div>
	      	</div>
	    </div>
	</div>
	<div class="header-bottom">
		<div class="wrapper">
			<div class="navigation-section">
				<div class="menu-icon">
					<label>Menu</label>
					<div>
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
				<!-- Include navigation -->
				@include('partials.navigation')
				<!-- End of navigation -->
			</div>
		</div>
	</div>
	<div class="header-fixed">
		<div class="wrapper">
			<div class="logo-fixed">
				<a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Legacy Cruises SD Logo" /></a>
			</div>
			<!-- Include navigation -->
			@include('partials.navigation')
			<!-- End of navigation -->
			<div class="header-left">
	      		<div class="top-links">
	      		@if (Route::has('login'))
	      			@if (Auth::check())
	      				<a href="{{ url('/user/my-account') }}">My Account</a> /
		                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							Logout
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
		            @else
		           		<div class="authcheck" style="display:none;">
		            		<a href="{{ url('/user/my-account') }}">My Account</a> /
			                <a href="{{ url('legacy-logout') }}">
								Logout
							</a>
						</div>
						<div class="noauth">
							<a href="javascript:void(0)" class="myBtn-login">LOGIN</a> / <a href="javascript:void(0)" class="myBtn-register">REGISTER</a>
						</div>
		            @endif
		        @endif

	      		</div>
	      		<div class="callto"><a href="tel:1-844-LEGASEA">1-844-LEGASEA</a></div>
	      	</div>
		</div>
	</div>
</header>
