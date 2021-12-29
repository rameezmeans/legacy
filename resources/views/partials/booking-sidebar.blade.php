 <div class="booking-right book-process">
    <h2>Booking Summary</h2>
    <ul>
        <li>Date Booked : <input type="text" class="date" value="<?php echo date('m-d-Y');?>" disabled></li>
        <li>Time Booked : <input type="text" class="time" value="0"  disabled></li>
        <li>Yacht Booked : <input type="text" class="yatch" value='{{ $product->product_name }}' disabled></li>
        <hr>
        <div id="event-main"></div>
        <div id="location-main"></div>
	    <div id="buffet-main"></div>
	    <div id="tray-main"></div>
        <div id="bar-main"></div>
	    <div id="bartender-main"></div>
	    <div id="bottle-main"></div>
	    <div id="addon-main"></div>
    </ul>
    <div class="total">
        Total: <strong>$0</strong>
    </div>
</div>
