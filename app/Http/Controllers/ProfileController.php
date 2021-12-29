<?php

namespace App\Http\Controllers;

use App\Event;
use App\GuestList;
use App\GeneralInstructions;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Auth;
use App\Order;
use Mail;
class ProfileController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
     * Create a new controller instance.
     *
     * @return void
     */


    public function showGuestList($slug){


        $event = Event::where('slug_str', '=', $slug)->first();
        $guest_email_text = GeneralInstructions::findOrFail(2);

        $guest_list = GuestList::orderBy('created_at', 'desc')->where('event_id', '=', $event->id)->get();

//        dd($guest_list);

        return view('event-guest-list-page',['event' => $event, 'guest_list' => $guest_list, 'guest_email_text' => $guest_email_text]);




    }
    public function show_event($slug){

//dd(Auth::user());


        $event = Event::where('slug_str', '=', $slug)->first();


        $guest_list = GuestList::where('event_id', '=', $event->id)->get();

//                dd($guest_list);



        $general_instructions = GeneralInstructions::FindOrFail(1);



//dd(Auth::user());


//        dd(Auth::user());

        $editor = false;


        if(!is_null(Auth::user()))
            $editor_id = Auth::user()->id;
        else
            $editor_id = 0;

        if(!is_null(Auth::user())) {

            if (Auth::user()->role == 'A') {

                return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id,'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);

            } else if (Auth::user()->role == 'S') {


                if (Auth::user()->id == $event->owner_id) {

                    $editor = true;

                    return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id,'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);
                } else {
//                dd($event->owner_id);

                    return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id, 'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);
                }

            }
        }else{
            return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id, 'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);

        }


    }

	public function index()
    {
        $currentuserid = Auth::user()->id;
        $entries = Order::orderBy('booking_date', 'desc')->where('status', '=', 'Y')->where('paystatus', '=', 'Y')->where('u_id', '=', $currentuserid)->where('parent_id', '=', '0')->paginate(3000);
        $entry = User::where('id', $currentuserid)->where('role', 'S')->first();
        return view('profile.index',compact('entry','entries'));
    }

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = User::where('role', 'S')->findOrFail($id);

        //Check setting exist
        if (!$profile) {
            return redirect()->route('user::profile.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    	//Get The User
        $profile = User::where('role', 'S')->find($id);

        //check User exist
        if (!$profile) {
            return redirect()->route('user::profile.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
        	'name' => 'required',
            'password' => 'min:6',
			'confirm_password' => 'min:6|same:password'
        ]);

       //updated data to save
        $updatedprofile = array(
        	'name' => $input['name'],
        	'phone' => $input['phone'],
            'password' => bcrypt($input['password'])
        );

        //Update the User
        User::where('id', $id)->where('role', 'S')->update($updatedprofile);


		return redirect()->route('user::profile.index')
            ->with('flash_notice', 'Updated successfully.');
    }

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get Order detail
        $currentuserid = Auth::user()->id;
        $entry = Order::where('u_id', '=', $currentuserid)->where('parent_id', '=', 0)->where('status', '=', 'Y')->where('paystatus', '=', 'Y')->where('id', '=', $id)->first();
        //check entry exist or not
        if (!$entry) {
            return redirect()->route('user::profile.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('profile.view', compact('entry'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Get The order
        $currentuserid = Auth::user()->id;
        $order = Order::where('u_id', '=', $currentuserid)->where('id', '=', $id)->where('parent_id', '=', 0)->where('status', '=', 'Y')->where('paystatus', '=', 'Y')->first();

        //check location exist
        if (!$order) {
            return redirect()->route('user::profile.index')
                ->with('flash_error', 'No record found.');
        }

        if($order->next_day === 'Y'){
            $cOrder = Order::where('u_id', '=', $currentuserid)->where('parent_id', '=', $id)->first();
            $cupdatedOrder = array(
                'status' => 'N'
            );

            //Update the Order
            Order::where('id', $id)->update($cupdatedOrder);
        }

       //updated data to save
        $updatedOrder = array(
            'status' => 'N'
        );

        //Update the Order
        Order::where('id', $id)->update($updatedOrder);
        $Order = Order::where('id', '=', $id)->first();
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
        Mail::send('emails.ordercanceladmin', ['orderData' => $orderData], function ($m) use ($orderData,$toMail,$fromMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');
            $m->to($toMail, $orderData['name'])->subject('Booking Cancellation Notifications');
        });
        Mail::send('emails.ordercancel', ['orderData' => $orderData], function ($m) use ($orderData,$fromMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');
            $m->to(Auth::user()->email, $orderData['name'])->subject('Booking Cancelled on Legacy Cruises & Events');
        });
        //redirect after creating new locations
        return redirect()->route('user::profile.index')
            ->with('flash_notice', 'Successfully Canceled!');
    }
}
