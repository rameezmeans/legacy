<?php

use Illuminate\Http\Request;

//Forntend Routes
Route::get('/', function () {
    return view('home');
});

Route::get('/plan-your-event', function () {
    return view('events',['redirectur'=>'/plan-your-event']);
});

Route::get('/plan-your-event/corporate', function () {
    return view('corporate',['redirectur'=>'/plan-your-event/corporate']);
});

Route::get('/plan-your-event/wedding', function () {
    return view('wedding',['redirectur'=>'/plan-your-event/wedding']);
});

Route::get('/plan-your-event/birthdays', function () {
    return view('birthdays',['redirectur'=>'/plan-your-event/birthdays']);
});

Route::get('/plan-your-event/others', function () {
    return view('others',['redirectur'=>'/plan-your-event/others']);
});

Route::get('/your-yachts', function () {
    return view('yachts');
});

Route::get('/contact-us', function () {
    return view('contact');
});

Route::get('/download-brochure', function () {
    return view('brochures');
});

Route::get('/about-us', function () {
    return view('about');
});

Route::get('/leave-a-review', function () {
    return view('feedback');
});

Route::get('/terms-of-service', function () {
    return view('terms');
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

Route::get('/thanks-for-signup', function () {
    return view('thanksforsignup');
});

//booking process routes
Route::get('/book-now', function () {
    return view('booknow');
});

Route::namespace('App\Http\Controllers')->group(function () {

Route::get('/events/{unique_id}', 'ContactController@show_event');
Route::get('/events/{unique_id}/guest_list', 'ProfileController@showGuestList');

//booking process routes
Route::get('book-now-live', [
    'as' => 'book-now-live',
    'uses' => 'OrderController@index'
]);

Route::post('fetch-date', [
    'as' => 'fatchDate',
    'uses' => 'OrderController@fatchDate'
]);

Route::post('avail-times', [
    'as' => 'fetchtime',
    'uses' => 'OrderController@fetchtime'
]);

Route::post('fetch-bartender', [
    'as' => 'bartenderFee',
    'uses' => 'OrderController@bartenderFee'
]);

Route::post('book-step1', [
    'as' => 'bookingProcessStep1',
    'uses' => 'OrderController@bookingProcessStep1'
]);

Route::post('book-step2', [
    'as' => 'bookingProcessStep2',
    'uses' => 'OrderController@bookingProcessStep2'
]);

Route::post('book-step3', [
    'as' => 'bookingProcessStep3',
    'uses' => 'OrderController@bookingProcessStep3'
]);

Route::post('book-step4', [
    'as' => 'bookingProcessStep4',
    'uses' => 'OrderController@bookingProcessStep4'
]);

Route::post('book-step5', [
    'as' => 'bookingProcessStep5',
    'uses' => 'OrderController@bookingProcessStep5'
]);

Route::post('book-step6', [
    'as' => 'bookingProcessStep6',
    'uses' => 'OrderController@bookingProcessStep6'
]);

Route::post('book-step7', [
    'as' => 'bookingProcessStep7',
    'uses' => 'OrderController@bookingProcessStep7'
]);

Route::post('fatch-addons', [
    'as' => 'addonesDDval',
    'uses' => 'OrderController@addonesDDval'
]);

Route::post('store-booking', [
    'as' => 'store',
    'uses' => 'OrderController@store'
]);

Route::post('coupon-redeem', [
    'as' => 'redeemCoupon',
    'uses' => 'OrderController@redeemCoupon'
]);

Route::post('skip-booking', [
    'as' => 'skipBookingStep',
    'uses' => 'OrderController@skipBookingStep'
]);

Route::get('/thanks', function () {
    return view('thanks');
});

Route::get('/404', function () {
    return view('errors.404');
});

Route::get('/authcallback', function () {
    return view('authcallback');
});

//Payment
Route::get('checkout', [
    'as' => 'checkout.process',
    'uses' => 'OrderController@checkoutProcess'
]);

Route::post('usercheckout', [
    'uses' => 'OrderController@userCheckoutProcess'
]);

Route::post('fatch-method', [
    'as' => 'checkout.method',
    'uses' => 'PayProcessController@checkoutMethod'
]);

Route::post('checkout', [
    'as' => 'payment.stripe',
    'uses' => 'PayProcessController@postPaymentStripe'
]);

Route::post('checkouts', [
    'as' => 'payment.paylater',
    'uses' => 'PayProcessController@postPaymentLater'
]);

Route::post('paypal', [
    'as' => 'payment.paypal',
    'uses' => 'PayProcessController@postPaymentPaypal'
]);

Route::get('paypal', [
    'as' => 'payment.status',
    'uses' => 'PayProcessController@getPaymentPaypal'
]);

//Authentication route
Route::auth();
//Admin Routes
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin', 'as' => 'admin::'],
        function () {
            Route::get('/', 'DashboardController@index');
            Route::get('/notifications', 'DashboardController@notifications');
            Route::get('/email_templates', 'DashboardController@emailTemplates');
            Route::get('events/google_sheets', 'EventController@googleSheet');
            Route::get('events/google_sheets/rev', 'EventController@googleSheetRev');

            Route::get('/dashboard', [
                'as'   => 'dashboard',
                'uses' => 'DashboardController@index'
            ]);

            Route::resource('foods', 'FoodController');
            Route::resource('beverages', 'BeverageController');
            Route::resource('bottles', 'BottleController');
            Route::resource('locations', 'LocationController');
            Route::resource('products', 'ProductController');
            Route::resource('orders', 'OrderController');
            Route::resource('addons', 'AddonController');
            Route::resource('users', 'UserController');
            Route::resource('pprices', 'PpriceController');
            Route::resource('coupons', 'CouponController');
            Route::resource('settings', 'SettingController');
            Route::resource('contacts', 'ContactController');
            Route::resource('profile', 'ProfileController');
            Route::resource('events', 'EventController');
            Route::resource('general_instructions', 'GeneralInstructionsController');
            Route::resource('dbookings', 'DbookingController');
        });

    Route::group(['prefix' => 'user', 'middleware' => 'auth', 'as' => 'user::'], function () {
        Route::get('/my-account', 'ProfileController@index');
        Route::resource('profile', 'ProfileController');
    });
});


Route::get('legacy-logout', function (){
    return view('logout');
});

Route::get('logout', function (){
    Auth::logout();
    return redirect('/');
});

Route::get('/send_email','HomeController@send_email');

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/legacy-admin', 'Auth\LoginController@adminform');
    Route::post('/legacy-login', 'Auth\LoginController@login');
});
Route::post('/register-user','Auth\RegisterController@create');

Route::post('/add_guest','HomeController@add_guest');
Route::post('/check_guest_rsvp','HomeController@check_guest_rsvp');
Route::post('/update_guest/{id}','HomeController@update_guest');
Route::post('/remove_guest','HomeController@remove_guest');
Route::post('/send_email','ContactController@send_email');
Route::post('/send_email_to_all','ContactController@send_email_to_all');

Route::post('/attending_event','ContactController@attending_event');
Route::post('/not_attending_event','ContactController@not_attending_event');

Route::post('/update_event_title/{id}','HomeController@updateEventTitle');
Route::post('/approve_update_event','HomeController@approveUpdateEvent');
Route::post('/reject_update_event','HomeController@rejectUpdateEvent');
Route::post('/remove_update_event','HomeController@removeUpdateEvent');
Route::post('/approve_all_update_event','HomeController@approveAllUpdateEvent');

Route::namespace('App\Http\Controllers')->group(function () {

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('/contact-us','ContactController@contactus');
Route::post('/bookevent','ContactController@bookingnow');
Route::post('/planevent','ContactController@planevent');
Route::post('/about-us','ContactController@aboutus');
//Route::post('/event-landing-page','ContactController@event_landing_page');
Route::post('/book-now','ContactController@booknow');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
