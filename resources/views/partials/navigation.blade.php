<div class="mainmenu">
	<ul> 
		<li <?php echo Request::segment(1) == 'plan-your-event'  ? 'class="active dropdown"' : '' ?>>
			<a href="{{ url('/plan-your-event') }}">
				Plan Your Event
				<i class="fa fa-caret-down" aria-hidden="true"></i>
			</a> 
			<ul>
				<li><a href="{{ url('/plan-your-event/corporate') }}">Corporate Events</a></li>
				<li><a href="{{ url('/plan-your-event/wedding') }}">YACHT WEDDINGS</a></li>
				<li><a href="{{ url('/plan-your-event/birthdays') }}">BIRTHDAY PARTIES</a></li>
				<li><a href="{{ url('/plan-your-event/others') }}">OTHER EVENTS</a></li>
			</ul>
		</li>  
		<li <?php echo Request::segment(1) == 'your-yachts'  ? 'class="active"' : '' ?>>
			<a href="{{ url('/your-yachts') }}">
				Your Yacht
			</a>			
		</li>
		<li <?php echo Request::segment(1) == 'book-now'  ? 'class="active"' : '' ?>>
			<a href="{{ url('/book-now') }}">
				BOOK NOW
			</a>
		</li>
		<li <?php echo Request::segment(1) == 'about-us'  ? 'class="active"' : '' ?>>
			<a href="{{ url('/about-us') }}">
				ABOUT US
			</a>
		</li>
		<li>
			<a href="/blog">
				Blog
			</a>
		</li>
		<li <?php echo Request::segment(1) == 'contact-us'  ? 'class="active"' : '' ?>>
			<a href="{{ url('/contact-us') }}">
				CONTACT
			</a>
		</li>
	</ul> 
</div> 