<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\Order;
use App\Temporder;
use App\Setting;
/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Mail;
use DB;

class PayProcessController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('payments');
        $settings = Setting::orderBy('id', 'asc')->first();
        $paypal_client_id = $settings['paypal_client_id'];
        $paypal_secret = $settings['paypal_secret'];
        $payment_mode = $settings['payment_mode'];
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_client_id, $paypal_secret));
        $paypal_settings = array( 'mode' => $payment_mode, 'http.ConnectionTimeOut' => 1000, 'log.LogEnabled' => true, 'log.FileName' => storage_path() . '/logs/paypal.log', 'log.LogLevel' => 'FINE');
        $this->_api_context->setConfig($paypal_settings);
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentPaypal(Request $request)
    {
        $legacyOrders = Session::get('legacyOrders');
        if (Session::has('legacyOrders.orderid') && Auth::check()) {
            if(Session::has('legacyOrders.payMethod')){
                $payMethod = Session::get('legacyOrders.payMethod');
                if($payMethod == 'P'){
                    $percentage = 25;
                    $totalAmount = $legacyOrders['gtotal'];
                    $gtotal = ($percentage / 100) * $totalAmount;
                    $gtotal = round($gtotal, 2);
                } else{
                    $gtotal = $legacyOrders['gtotal'];
                }

            } else{
                Session::put('legacyOrders.payMethod','F');
                $gtotal = $legacyOrders['gtotal'];
            }
            Session::put('legacyOrders.paidAmount',$gtotal);
            $oId = $legacyOrders['orderid'];
            if ( Session::get('legacyOrders.orderAdded') == '') {
                Session::put('legacyOrders.orderBooked', 'no');
                $this->_beforePayProcess($oId);
                if ( Session::get('legacyOrders.orderBooked') == 'yes') {
                   Session::flash ( 'errorbooked', "Sorry! Someone else had booked the date slot you are looking for. Please try again with other time slot." );
                    return redirect('/checkout');
                }

            }
            $oId = Session::get('legacyOrders.neworderid');
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Legacy Yacht LEGACY#'.$oId ) /** item name **/
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($gtotal); /** unit price **/
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($gtotal);
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Payment of Yacht Booking on Legacy Cruises & Events for Order no. LEGACY#'.$oId);
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('payment.paypal')) /** Specify return URL **/
                ->setCancelUrl(URL::route('payment.status'));
            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; **/
            try {
                $payment->create($this->_api_context);
            }
            catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error','Connection timeout');
                    return Redirect::route('checkout.process');
                    /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                    /** $err_data = json_decode($ex->getData(), true); **/
                    /** exit; **/
                } else {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return Redirect::route('checkout.process');
                    /** die('Some error occur, sorry for inconvenient'); **/
                }
            }

            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());
            if(isset($redirect_url)) {
                /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }
            \Session::put('error','Unknown error occurred');
            return Redirect::route('checkout.process');

        } elseif (Session::has('legacyOrders.bookingId') && Auth::check()) {

            $gtotal = $legacyOrders['bookingDue'];
            $oId = $legacyOrders['bookingId'];
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Legacy Yacht LEGACY#'.$oId ) /** item name **/
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($gtotal); /** unit price **/
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($gtotal);
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Paying Due Amount of Yacht Booking on Legacy Cruises & Events for Order no. LEGACY#'.$oId);
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('payment.paypal')) /** Specify return URL **/
                ->setCancelUrl(URL::route('payment.status'));
            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; **/
            try {
                $payment->create($this->_api_context);
            }
            catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error','Connection timeout');
                    return Redirect::route('checkout.process');
                    /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                    /** $err_data = json_decode($ex->getData(), true); **/
                    /** exit; **/
                } else {
                    \Session::put('error','Some error occur, sorry for inconvenient');
                    return Redirect::route('checkout.process');
                    /** die('Some error occur, sorry for inconvenient'); **/
                }
            }

            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());
            if(isset($redirect_url)) {
                /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }
            \Session::put('error','Unknown error occurred');
            return Redirect::route('checkout.process');

        } else{
            Session::flash ( 'errorbooknow', "Error! Something went wrong. Please Try Again." );
            return redirect('/book-now');
        }
    }


    public function getPaymentPaypal()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error','Payment failed');
            return Redirect::route('checkout.process');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        $legacyOrders = Session::get('legacyOrders');

        if ($result->getState() == 'approved') {

            if (Session::has('legacyOrders.bookingId') && Auth::check()) {

                $bookingId = Session::get('legacyOrders.bookingId');
                $Order = Order::where('id', '=', $bookingId)->first();
                if (!$Order) {
                    Session::flash ( 'errorbooked', "Error! Something went wrong. Please Try Again." );
                    return redirect('/checkout');
                }

                $bookingAdvance = $Order->payadvance + Session::get('legacyOrders.bookingDue');
                $bookingPaywith = $Order->paywith.', Paypal';
                $bookingPayment_id = $Order->payid.', '.$payment_id;
                $bookingToken = $Order->token.', '.Input::get('token');
                $bookingPayerid = $Order->payerid.', '.Input::get('PayerID');

                Order::where('id', $bookingId)->update( array('paymethod'=> 'F', 'payadvance'=> $bookingAdvance, 'due'=> 0,'paystatus'=> 'Y', 'paywith'=> $bookingPaywith, 'payid'=> $bookingPayment_id, 'token' => $bookingToken, 'payerid' => $bookingPayerid ));

                $legacy_conf = \Config::get('legacy');
                $toMail = $legacy_conf['order_email_alert'];
                $fromMail = $legacy_conf['from_email_alert'];

                $orderData['name'] = $Order->name;
                $orderData['phone'] = $Order->phone;
                $orderData['paywith'] = 'Paypal';
                $orderData['updated_at'] = $Order->updated_at;
                $orderData['payid'] = $payment_id;
                $orderData['total'] = $Order->total;
                $orderData['orderid'] = 'LEGACY#'.$bookingId;
                $orderData['email'] = $Order->email;
                $orderData['booking_date'] = $Order->booking_date;
                $orderData['booking_time'] = $Order->time_html;

                Mail::send('emails.orderbookadmin', ['orderData' => $orderData], function ($m) use ($orderData,$toMail,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to($toMail, $orderData['name'])->subject('Booking Due Amount Paid Notifications');
                });
                Mail::send('emails.orderbook', ['orderData' => $orderData], function ($m) use ($orderData,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to(Auth::user()->email, $orderData['name'])->subject('Paid Booking Due Amount');
                });

                Session::put('legacyOrders', []);

                /** it's all right **/
                /** Here Write your database logic like that insert record or value in database if you want **/
                \Session::put('success','');
                return redirect('/thanks');

            } else {
                $lastInsertedId = Session::get('legacyOrders.neworderid');
                $lastInsertedCId = Session::get('legacyOrders.neworderChildId');
                Order::where('id', $lastInsertedId)->update( array('paymethod'=> Session::get('legacyOrders.payMethod'), 'payadvance'=> Session::get('legacyOrders.paidAmount'), 'due'=> Session::get('legacyOrders.gtotal')-Session::get('legacyOrders.paidAmount'),'paystatus'=> 'Y', 'paywith'=> 'Paypal', 'payid'=> $payment_id, 'token'=>Input::get('token'), 'payerid'=>Input::get('PayerID') ));
                //Email
                $nextday = Session::get('legacyOrders.nextDay');
                if ($nextday =='Yes') {
                    Order::where('id', $lastInsertedCId)->update( array('paymethod'=> Session::get('legacyOrders.payMethod'), 'payadvance'=> Session::get('legacyOrders.paidAmount'), 'due'=> Session::get('legacyOrders.gtotal')-Session::get('legacyOrders.paidAmount'),'paystatus'=> 'Y', 'paywith'=> 'Paypal', 'payid'=> $payment_id, 'token'=>Input::get('token'), 'payerid'=>Input::get('PayerID') ));
                }
                $Order = Order::where('id', '=', $lastInsertedId)->first();
                if (!$Order) {
                    Session::flash ( 'errorbooked', "Error! Something went wrong. Please Try Again." );
                    return redirect('/checkout');
                }
                $legacy_conf = \Config::get('legacy');
                $toMail = $legacy_conf['order_email_alert'];
                $fromMail = $legacy_conf['from_email_alert'];

                $orderData['name'] = $Order->name;
                $orderData['phone'] = $Order->phone;
                $orderData['paywith'] = $Order->paywith;
                $orderData['updated_at'] = $Order->updated_at;
                $orderData['payid'] = $Order->payid;
                $orderData['total'] = $Order->total;
                $orderData['orderid'] = 'LEGACY#'.$Order->id;
                $orderData['email'] = $Order->email;
                $orderData['booking_date'] = $Order->booking_date;
                $orderData['booking_time'] = $Order->time_html;

                Mail::send('emails.orderbookadmin', ['orderData' => $orderData], function ($m) use ($orderData,$toMail,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to($toMail, $orderData['name'])->subject('New Booking Notifications');
                });
                Mail::send('emails.orderbook', ['orderData' => $orderData], function ($m) use ($orderData,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to(Auth::user()->email, $orderData['name'])->subject('Booking Confirmation on Legacy Cruises & Events');
                });

                Session::put('legacyOrders', []);

                /** it's all right **/
                /** Here Write your database logic like that insert record or value in database if you want **/
                \Session::put('success','');
                return redirect('/thanks');
            }
        }
        \Session::put('error','Payment failed');
        return Redirect::route('checkout.process');
    }

    /**
     * Store a details of payment with Stripe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentStripe(Request $request){

        $legacyOrders = Session::get('legacyOrders');
        if (Session::has('legacyOrders.bookingId') && Auth::check()) {

            $settings = Setting::orderBy('id', 'asc')->first();
            $stripe_secret_key = $settings['stripe_secret_key'];

            $gtotal = $legacyOrders['bookingDue'];
            $bookingId = $legacyOrders['bookingId'];

            \Stripe\Stripe::setApiKey ( $stripe_secret_key );
            try {
                \Stripe\Charge::create ( array (
                        "amount" => $gtotal*100,
                        "currency" => "usd",
                        "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                        "description" => "Payment of Yacht Booking on Legacy Cruises & Events"
                ) );

                $cardno = substr($request->input ( 'card-number' ), -4 );

                $Order = Order::where('id', '=', $bookingId)->first();
                if (!$Order) {
                    Session::flash ( 'errorbooked', "Error! Something went wrong. Please Try Again." );
                    return redirect('/checkout');
                }

                $bookingAdvance = $Order->payadvance + $gtotal;
                $bookingPaywith = $Order->paywith.', Stripe';
                $bookingPayment_id = $Order->payid.', '.$cardno;
                $bookingToken = $Order->token.', '.$request->input ( 'stripeToken' );
                $bookingPayerid = $Order->payerid.', '.$cardno;

                Order::where('id', $bookingId)->update( array('paymethod'=> 'F', 'payadvance'=> $bookingAdvance, 'due'=> 0,'paystatus'=> 'Y', 'paywith'=> $bookingPaywith, 'payid'=> $bookingPayment_id, 'token' => $bookingToken, 'payerid' => $bookingPayerid ));

                $legacy_conf = \Config::get('legacy');
                $toMail = $legacy_conf['order_email_alert'];
                $fromMail = $legacy_conf['from_email_alert'];

                $orderData['name'] = $Order->name;
                $orderData['phone'] = $Order->phone;
                $orderData['paywith'] = 'Stripe';
                $orderData['updated_at'] = $Order->updated_at;
                $orderData['payid'] = $cardno;
                $orderData['total'] = $Order->total;
                $orderData['orderid'] = 'LEGACY#'.$bookingId;
                $orderData['email'] = $Order->email;
                $orderData['booking_date'] = $Order->booking_date;
                $orderData['booking_time'] = $Order->time_html;

                Mail::send('emails.orderbookadmin', ['orderData' => $orderData], function ($m) use ($orderData,$toMail,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to($toMail, $orderData['name'])->subject('Booking Due Amount Paid Notifications');
                });
                Mail::send('emails.orderbook', ['orderData' => $orderData], function ($m) use ($orderData,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to(Auth::user()->email, $orderData['name'])->subject('Paid Booking Due Amount');
                });

                Session::put('legacyOrders', []);
                //Session::flash ( 'success-message', 'Payment done successfully !' );
                return redirect('/thanks');

            } catch ( \Exception $e ) {
                Session::flash ( 'fail-message', "Error! Please Try again." );
                return redirect('/checkout');
            }

        } elseif (Session::has('legacyOrders.orderid') && Auth::check()) {
            $settings = Setting::orderBy('id', 'asc')->first();
            $stripe_secret_key = $settings['stripe_secret_key'];

            if(Session::has('legacyOrders.payMethod')){
                $payMethod = Session::get('legacyOrders.payMethod');
                if($payMethod == 'P'){
                    $percentage = 25;
                    $totalAmount = $legacyOrders['gtotal'];
                    $gtotal = ($percentage / 100) * $totalAmount;
                    $gtotal = round($gtotal, 2);
                } else{
                    $gtotal = $legacyOrders['gtotal'];
                }

            } else{
                Session::put('legacyOrders.payMethod','F');
                $gtotal = $legacyOrders['gtotal'];
            }
            Session::put('legacyOrders.paidAmount',$gtotal);
            $oId = $legacyOrders['orderid'];
            if ( Session::get('legacyOrders.orderAdded') == '') {
                Session::put('legacyOrders.orderBooked', 'no');
                $this->_beforePayProcess($oId);
                if ( Session::get('legacyOrders.orderBooked') == 'yes') {
                   Session::flash ( 'errorbooked', "Sorry! Someone else had booked the date slot you are looking for. Please try again with other time slot." );
                    return redirect('/checkout');
                }

            }
            \Stripe\Stripe::setApiKey ( $stripe_secret_key );
            try {
                \Stripe\Charge::create ( array (
                        "amount" => $gtotal*100,
                        "currency" => "usd",
                        "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                        "description" => "Payment of Yacht Booking on Legacy Cruises & Events"
                ) );

                $cardno = substr($request->input ( 'card-number' ), -4 );
                $lastInsertedId = Session::get('legacyOrders.neworderid');
                $lastInsertedCId = Session::get('legacyOrders.neworderChildId');
                Order::where('id', $lastInsertedId)->update( array('paymethod'=> Session::get('legacyOrders.payMethod'), 'payadvance'=> Session::get('legacyOrders.paidAmount'), 'due'=> (Session::get('legacyOrders.gtotal') - Session::get('legacyOrders.paidAmount')), 'paystatus'=> 'Y', 'paywith'=> 'Stripe', 'payid'=> $cardno, 'token'=>$request->input ( 'stripeToken' ), 'payerid'=>$cardno));
                //Email
                $nextday = Session::get('legacyOrders.nextDay');
                if ($nextday =='Yes') {
                    Order::where('id', $lastInsertedCId)->update( array('paymethod'=> Session::get('legacyOrders.payMethod'), 'payadvance'=> Session::get('legacyOrders.paidAmount'), 'due'=> Session::get('legacyOrders.gtotal')-Session::get('legacyOrders.paidAmount'),'paystatus'=> 'Y', 'paywith'=> 'Stripe', 'payid'=> $cardno, 'token'=>$request->input ( 'stripeToken' ), 'payerid'=>$cardno));
                }
                $Order = Order::where('id', '=', $lastInsertedId)->first();
                if (!$Order) {
                    Session::flash ( 'errorbooked', "Error! Something went wrong. Please Try Again." );
                    return redirect('/checkout');
                }
                $legacy_conf = \Config::get('legacy');
                $toMail = $legacy_conf['order_email_alert'];
                $fromMail = $legacy_conf['from_email_alert'];

                $orderData['name'] = $Order->name;
                $orderData['phone'] = $Order->phone;
                $orderData['paywith'] = $Order->paywith;
                $orderData['updated_at'] = $Order->updated_at;
                $orderData['payid'] = $Order->payid;
                $orderData['total'] = $Order->total;
                $orderData['orderid'] = 'LEGACY#'.$Order->id;
                $orderData['email'] = $Order->email;
                $orderData['booking_date'] = $Order->booking_date;
                $orderData['booking_time'] = $Order->time_html;
                Mail::send('emails.orderbookadmin', ['orderData' => $orderData], function ($m) use ($orderData,$toMail,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to($toMail, $orderData['name'])->subject('New Booking Notifications');
                });
                Mail::send('emails.orderbook', ['orderData' => $orderData], function ($m) use ($orderData,$fromMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');
                    $m->to(Auth::user()->email, $orderData['name'])->subject('Booking Confirmation on Legacy Cruises & Events');
                });

                Session::put('legacyOrders', []);
                //Session::flash ( 'success-message', 'Payment done successfully !' );
                return redirect('/thanks');

            } catch ( \Exception $e ) {
                Session::flash ( 'fail-message', "Error! Please Try again." );
                return redirect('/checkout');
            }
        }else{
            Session::flash ( 'errorbooknow', "Error! Something went wrong. Please Try Again." );
            return redirect('/book-now');
        }
    }

    /**
     * Store a details of payment later.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentLater(Request $request){

        $legacyOrders = Session::get('legacyOrders');
        if (Session::has('legacyOrders.orderid') && Auth::check() && Session::has('legacyOrders.payMethod')) {
            $payMethod = Session::get('legacyOrders.payMethod');
            $oId = $legacyOrders['orderid'];
            if ( Session::get('legacyOrders.orderAdded') == '') {
                Session::put('legacyOrders.orderBooked', 'no');
                $this->_beforePayProcess($oId);
                if ( Session::get('legacyOrders.orderBooked') == 'yes') {
                   Session::flash ( 'errorbooked', "Sorry! Someone else had booked the date slot you are looking for. Please try again with other time slot." );
                    return redirect('/checkout');
                }

            }

            $lastInsertedId = Session::get('legacyOrders.neworderid');
            $lastInsertedCId = Session::get('legacyOrders.neworderChildId');
            Order::where('id', $lastInsertedId)->update( array('paymethod'=> 'L', 'payadvance'=> '0', 'due'=> Session::get('legacyOrders.gtotal'), 'paystatus'=> 'Y', 'paywith'=> 'Pay Later', 'payid'=> 'Pay Later', 'token'=>'Pay Later', 'payerid'=>'Pay Later'));
            //Email
            $nextday = Session::get('legacyOrders.nextDay');
            if ($nextday =='Yes') {
                Order::where('id', $lastInsertedCId)->update( array('paymethod'=> 'L', 'payadvance'=> '0', 'due'=> Session::get('legacyOrders.gtotal'), 'paystatus'=> 'Y', 'paywith'=> 'Pay Later', 'payid'=> 'Pay Later', 'token'=>'Pay Later', 'payerid'=>'Pay Later'));
            }
            $Order = Order::where('id', '=', $lastInsertedId)->first();
            if (!$Order) {
                Session::flash ( 'errorbooked', "Error! Something went wrong. Please Try Again." );
                return redirect('/checkout');
            }
            $legacy_conf = \Config::get('legacy');
            $toMail = $legacy_conf['order_email_alert'];
            $fromMail = $legacy_conf['from_email_alert'];

            $orderData['name'] = $Order->name;
            $orderData['phone'] = $Order->phone;
            $orderData['paywith'] = $Order->paywith;
            $orderData['updated_at'] = $Order->updated_at;
            $orderData['payid'] = $Order->payid;
            $orderData['total'] = $Order->total;
            $orderData['orderid'] = 'LEGACY#'.$Order->id;
            $orderData['email'] = $Order->email;
            $orderData['booking_date'] = $Order->booking_date;
            $orderData['booking_time'] = $Order->time_html;
            Mail::send('emails.orderbookadmin', ['orderData' => $orderData], function ($m) use ($orderData,$toMail,$fromMail) {
                $m->from($fromMail, 'Legacy Cruises & Events');
                $m->to($toMail, $orderData['name'])->subject('New Booking Notifications');
            });
            Mail::send('emails.orderbook', ['orderData' => $orderData], function ($m) use ($orderData,$fromMail) {
                $m->from($fromMail, 'Legacy Cruises & Events');
                $m->to(Auth::user()->email, $orderData['name'])->subject('Booking Confirmation on Legacy Cruises & Events');
            });

            Session::put('legacyOrders', []);
            //Session::flash ( 'success-message', 'Payment done successfully !' );
            return redirect('/thanks');
        }else{
            Session::flash ( 'errorbooknow', "Error! Something went wrong. Please Try Again." );
            return redirect('/book-now');
        }
    }



    /**
     * Check before order save booking date time is available
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function _beforePayProcess($oId){
        $error=0;
        $legacyOrders = Session::get('legacyOrders');
        if (Session::has('legacyOrders.orderid') && Auth::check() ) {
            Session::put('legacyOrders.orderBooked', 'no');
			$oId = $legacyOrders['orderid'];
			$u_id= Auth::user()->id;
			$UpdatePayBefore = Temporder::where('id', $oId)->update( array('status'=> 'Y', 'u_id'=> $u_id));
			$nextday = Session::get('legacyOrders.nextDay');
			if ($nextday =='Yes') {
				Temporder::where('id',Session::get('legacyOrders.orderChildId'))->update( array('status'=> 'Y', 'u_id'=> $u_id));
			}
			 $Temporder = Temporder::where('id', $oId)->first();

			if($nextday=='Yes')
			{
				$TemporderChild = Temporder::where('parent_id', $oId)->first();
				$booking_date=$Temporder->booking_date;
				$booking_date_nextday=date('Y-m-d',strtotime($booking_date)+86400);
				#check main order table
				$error=0;
                ($Mainorder= DB::table('orders')
                    ->where('booking_date', $booking_date)
                    ->where(function ($query) use ($Temporder) {
                        $query->whereBetween('booking_time_from', [$Temporder->booking_time_from, 23])
                        ->orWhereBetween('booking_time_to', [$Temporder->booking_time_from, 23]);
                    })->first());

                if ( $Mainorder ) {
                    $error=1;
                    Session::put('legacyOrders.orderBooked', 'yes');
				}
				else
				{	#if all slot available after starttime, checking child for endtime
                    ($MainorderNextday= DB::table('orders')
                        ->where('booking_date', $booking_date_nextday)
                        ->where(function ($query) use ($Temporder) {
                            $query->whereBetween('booking_time_from', [0, $Temporder->booking_time_to])
                            ->orWhereBetween('booking_time_to', [0, $Temporder->booking_time_to]);
                        })->first());
					if ( $MainorderNextday ) {
                        $error=1;
                        Session::put('legacyOrders.orderBooked', 'yes');
                    }
				}
			}
			else#same day booking
			{
				$booking_date=$Temporder->booking_date; 
				$error=0;
				($Mainorder= DB::table('orders')
                    ->where('booking_date', $booking_date)
                    ->where(function ($query) use ($Temporder) {
                        $query->whereBetween('booking_time_from', [$Temporder->booking_time_from, $Temporder->booking_time_to])
                        ->orWhereBetween('booking_time_to', [$Temporder->booking_time_from, $Temporder->booking_time_to]);
                    })->first());
				if ( $Mainorder ) {
                    $error=1;
                    Session::put('legacyOrders.orderBooked', 'yes');
				} #all booked slots are in this array
			}
			if( $error == 0 ){#date availabnle so insert it in main table
                Session::put('legacyOrders.orderAdded', 'added');
				$lastInsertedId = Order::create($Temporder->toArray())->id;
				Session::put('legacyOrders.neworderid', $lastInsertedId);
				$nextday = Session::get('legacyOrders.nextDay');
				if ($nextday =='Yes') {
					$Temporder2 = Temporder::where('id', Session::get('legacyOrders.orderChildId'))->first();
					$lastInsertedCId = Order::create($Temporder2->toArray())->id;
					Session::put('legacyOrders.neworderChildId', $lastInsertedCId);
					Order::where('id', $lastInsertedCId)->update(array('parent_id' => $lastInsertedId));
				}

			}
        }

    }

    public function checkoutMethod(Request $request){
        $method = $request->method();
        if ($request->isMethod('post')) {
            if (Session::has('legacyOrders.orderid') && Auth::check()) {
                if ($request->input('paymethod') == 'paylater'){
                    $methods= 'L';
                } elseif ($request->input('paymethod') == 'paypartial') {
                    $methods= 'P';
                } else {
                    $methods= 'F';
                }

                Session::put('legacyOrders.payMethod', $methods);
                return response()->json(['status' => 1], 200);
            }else{
                Session::put('legacyOrders.payMethod','');
                return response()->json(['status' => 2], 200);
            }
        }
    }
}
