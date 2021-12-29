<?php

namespace App\Http\Controllers;

use App\GuestList;
use App\User;
use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Contact;
use App\Event;

use Illuminate\Support\Facades\Auth;


use App\GeneralInstructions;



class ContactController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Send mail to Admin from Contact Us page.
     *
     * @return \Illuminate\Http\Response
     */
//    public function event_landing_page(Request $request){
//
//        return redirect('/event-landing-page');
//
//    }

//    public function showGuestList($slug){
//
//
//        $event = Event::where('slug_str', '=', $slug)->first();
//
//        $guest_list = GuestList::orderBy('created_at', 'desc')->where('event_id', '=', $event->id)->get();
//
////        dd($guest_list);
//
//        return view('event-guest-list-page',['event' => $event, 'guest_list' => $guest_list]);
//
//
//
//
//    }
//    public function show_event($slug){
//
////dd(Auth::user());
//
//
//        $event = Event::where('slug_str', '=', $slug)->first();
//
//
//        $guest_list = GuestList::where('event_id', '=', $event->id)->get();
//
////                dd($guest_list);
//
//
//
//        $general_instructions = GeneralInstructions::FindOrFail(1);
//
//
//
////dd(Auth::user());
//
//
////        dd(Auth::user());
//
//        $editor = false;
//
//
//        if(!is_null(Auth::user()))
//            $editor_id = Auth::user()->id;
//        else
//            $editor_id = 0;
//
//        if(!is_null(Auth::user())) {
//
//            if (Auth::user()->role == 'A') {
//
//                return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id,'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);
//
//            } else if (Auth::user()->role == 'S') {
//
//
//                if (Auth::user()->id == $event->owner_id) {
//
//                    $editor = true;
//
//                    return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id,'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);
//                } else {
////                dd($event->owner_id);
//
//                    return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id, 'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);
//                }
//
//            }
//        }else{
//            return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id, 'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor]);
//
//        }
//
//
//    }

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

                return view('event-landing-page', ['guest_list' => $guest_list,'editor_id' => $editor_id,'general_instructions' => $general_instructions->general_instructions, 'event' => $event, 'editor' => $editor, 'admin' => true ]);

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



    public function send_email_to_all(Request $request){


        foreach($request->guestIDs as $guest_id){

            $event_id = $request->event_id;
            $email_text = $request->email_text;
            $guest = GuestList::findOrFail($guest_id);

            $event = Event::findOrFail($event_id);

            $host = User::findOrFail($event->owner_id);

            $original_text = $email_text;

            $name = $guest->name;
            $hostname = $host->name;

            $original_text = str_replace("#guestname",$name,$original_text);
            $original_text = str_replace("#hostname",$hostname,$original_text);
            $original_text = str_replace("#eventname",$event->name,$original_text);

            $event_link = "<a href='". url('') ."/events/".$event->slug_str."?guestno=".$guest_id."'>"."here"."</a>";

            $original_text = str_replace("#eventlink",$event_link,$original_text);

//        dd($original_text);

            $userData['email_text'] =  $original_text;
            $userData['name'] = $guest->name;
            $fromMail = $host->email;
            $toMail = $guest->email;

            Mail::send('emails.invitation', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
                $m->from($fromMail, 'Legacy Cruises & Events');

                $m->to($toMail, $userData['name'])->subject('Invitation For Event');
            });
            // check for failures
            if (Mail::failures()) {
                echo 0;exit;
            }else{

//                $guest = GuestList::findOrFail($request->guest_id);

                $guest->status = 'Sent';

                $guest->save();

                echo  1;
            }




        }


    }
    public function send_email(Request $request){

//        dd($request->all());

        $event = Event::findOrFail($request->event_id);

        $host = User::findOrFail($event->owner_id);

        $original_text = $request->email_text;

        $name = $request->guest_name;
        $hostname = $host->name;

        $userData['subject'] = GeneralInstructions::findOrFail(2)->subject;


        $original_text = str_replace("#guestname",$name,$original_text);
        $original_text = str_replace("#hostname",$hostname,$original_text);
        $original_text = str_replace("#eventname",$event->name,$original_text);

        $event_link = "<a href='". url('') ."/events/".$event->slug_str."?guestno=".$request->guest_id."'>"."here"."</a>";

        $original_text = str_replace("#eventlink",$event_link,$original_text);

//        dd($original_text);

        $userData['email_text'] =  $original_text;
        $userData['name'] = $request->guest_name;
        $fromMail = $host->email;
        $toMail = $request->guest_email;



        Mail::send('emails.invitation', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['name'])->subject($userData['subject']);
        });
        // check for failures
        if (Mail::failures()) {
            echo 0;exit;
        }else{

            $guest = GuestList::findOrFail($request->guest_id);

            $guest->status = 'Sent';

            $guest->save();

            echo  1;exit;
        }




    }
    public function not_attending_event(Request $request){

        $guest = GuestList::findOrFail($request->guest_id);

        $guest->status = 'Not Attending';

        $guest->save();


        $event = Event::findOrFail($guest->event_id);
        $host = User::findOrFail($event->owner_id);


        $userData['subject'] = GeneralInstructions::findOrFail(8)->subject;
        $original_text = GeneralInstructions::findOrFail(8)->text;


        $original_text = str_replace("#hostname",$host->name,$original_text);
        $original_text = str_replace("#eventname",$event->name,$original_text);
        $original_text = str_replace("#guestname",$guest->name,$original_text);



//        dd($original_text);

        $userData['email_text'] =  $original_text;
        $userData['name'] = $host->name;
        $fromMail = "team@legacycruisessd.com";
        $toMail = $host->email;

//            dd($userData);


//        dd($toMail);

        Mail::send('emails.invitation', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['name'])->subject($userData['subject']);
        });
        // check for failures
        if (Mail::failures()) {
            echo 0;exit;
        }
        else{
            echo  1;exit;

        }


    }
    public function attending_event(Request $request){

//        dd($request->guest_id);


        $guest = GuestList::findOrFail($request->guest_id);
//                        dd($guest);


        $guest->status = 'Attending';

        $guest->save();



        $event = Event::findOrFail($guest->event_id);
        $host = User::findOrFail($event->owner_id);


        $userData['subject'] = GeneralInstructions::findOrFail(7)->subject;
        $original_text = GeneralInstructions::findOrFail(7)->text;


        $original_text = str_replace("#hostname",$host->name,$original_text);
        $original_text = str_replace("#eventname",$event->name,$original_text);
        $original_text = str_replace("#guestname",$guest->name,$original_text);



//        dd($original_text);

        $userData['email_text'] =  $original_text;
        $userData['name'] = $host->name;
        $fromMail = "team@legacycruisessd.com";
        $toMail = $host->email;

//            dd($userData);


//        dd($toMail);

        Mail::send('emails.invitation', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['name'])->subject($userData['subject']);
        });
        // check for failures
        if (Mail::failures()) {
            echo 0;exit;
        }
        else{
            echo  1;exit;

        }



    }
    public function contactus(Request $request){
        $legacy_conf = \Config::get('legacy');
        $toMail = $legacy_conf['contectus_email_alert'];
//        $toMail = 'xrkalix@gmail.com';
//        $toMail = 'lfarasati@gmail.com';

//        dd($toMail);
        $fromMail = $legacy_conf['from_email_alert'];

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        //Create data to save
        $createContact = array(
             'name' => $request->firstname.' '.$request->lastname,
             'phone' => $request->phone,
             'email' => $request->email,
             'additional' => $request->message,
             'company' => ' ',
             'dayofevent' => ' ',
             'category' => 'Contact Us'
        );
        //Create contact
        Contact::create($createContact);

        $userData['firstname'] = $request->firstname;
        $userData['lastname'] = $request->lastname;
        $userData['email'] = $request->email;
        $userData['phone'] = $request->phone;
        $userData['message'] = $request->message;

        Mail::send('emails.contactus', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['firstname'])->subject('Contact Us');
        });
         // check for failures
        if (Mail::failures()) {
            $request->session()->flash('mailstatus', 'Please try again.');
        }else{
            $request->session()->flash('mailstatus', 'Thank you! Your message has been successfully sent. We will contact you very soon!.');
        }


        return redirect('/contact-us#success');
    }

    //book now enquiry
    public function booknow(Request $request){
        $legacy_conf = \Config::get('legacy');
        $toMail = $legacy_conf['contectus_email_alert'];
        $fromMail = $legacy_conf['from_email_alert'];

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        //Create data to save
        $createContact = array(
             'name' => $request->firstname.' '.$request->lastname,
             'phone' => $request->phone,
             'email' => $request->email,
             'additional' => $request->message,
             'company' => ' ',
             'dayofevent' => ' ',
             'category' => 'Book Now'
        );
        //Create contact
        Contact::create($createContact);

        $userData['firstname'] = $request->firstname;
        $userData['lastname'] = $request->lastname;
        $userData['email'] = $request->email;
        $userData['phone'] = $request->phone;
        $userData['message'] = $request->message;

        Mail::send('emails.contactus', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['firstname'])->subject('Booking Enquiry');
        });
         // check for failures
        if (Mail::failures()) {
            $request->session()->flash('mailstatus', 'Please try again.');
        }else{
            $request->session()->flash('mailstatus', 'Thank you! Your message has been successfully sent. We will contact you very soon!.');
        }


        return redirect('/thanks');
    }


    /**
     * Send mail to Admin from About Us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutus(Request $request){
        $legacy_conf = \Config::get('legacy');
        $toMail = $legacy_conf['contectus_email_alert'];
        $fromMail = $legacy_conf['from_email_alert'];

        $this->validate($request, [
            'yname' => 'required',
            'cname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        //Create data to save
        $createContact = array(
             'name' => $request->yname,
             'phone' => $request->phone,
             'email' => $request->email,
             'additional' => $request->message,
             'company' => $request->cname,
             'dayofevent' => '-',
             'category' => 'About Us'
        );
        //Create contact
        Contact::create($createContact);

        $userData['yname'] = $request->yname;
        $userData['cname'] = $request->cname;
        $userData['email'] = $request->email;
        $userData['phone'] = $request->phone;
        $userData['message'] = $request->message;

        Mail::send('emails.aboutus', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['yname'])->subject('Legacy Partner');
        });
         // check for failures
        if (Mail::failures()) {
            $request->session()->flash('mailstatus', 'Please try again.');
        }else{
            $request->session()->flash('mailstatus', 'Thank you! Your message has been successfully sent. We will contact you very soon!.');
        }


        return redirect('/about-us#success');
    }


    /**
     * Send mail to Admin from home plan event.
     *
     * @return \Illuminate\Http\Response
     */
    public function planevent(Request $request){
        $legacy_conf = \Config::get('legacy');
        $toMail = $legacy_conf['contectus_email_alert'];
        $fromMail = $legacy_conf['from_email_alert'];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'datetime' => 'required',
        ]);

        //Create data to save
        $createContact = array(
             'name' => $request->name,
             'phone' => $request->phone,
             'email' => $request->email,
             'additional' => ' ',
             'company' => ' ',
             'dayofevent' => $request->datetime,
             'category' => 'Home'
        );
        //Create contact
        Contact::create($createContact);

        $userData['name'] = $request->name;
        $userData['email'] = $request->email;
        $userData['phone'] = $request->phone;
        $userData['datetime'] = $request->datetime;

        Mail::send('emails.planevent', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['name'])->subject('Plan Custom Event');
        });
         // check for failures
        if (Mail::failures()) {
            $request->session()->flash('mailstatus', 'Please try again.');
        }else{
            $request->session()->flash('mailstatus', 'Thank you! Your message has been successfully sent. We will contact you very soon!.');
        }


        return redirect('/#success');
    }

    /**
     * Send mail to Admin from Book Now page.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookingnow(Request $request){
        $legacy_conf = \Config::get('legacy');
        $toMail = $legacy_conf['contectus_email_alert'];
        $fromMail = $legacy_conf['from_email_alert'];
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'dayofevent' => 'required',
        ]);

        //Create data to save
        $createContact = array(
             'name' => $request->firstname.' '.$request->lastname,
             'phone' => $request->phone,
             'email' => $request->email,
             'additional' => $request->message,
             'company' => ' ',
             'dayofevent' => $request->dayofevent,
             'category' => 'Events'
        );
        //Create contact
        Contact::create($createContact);


        $userData['firstname'] = $request->firstname;
        $userData['lastname'] = $request->lastname;
        $userData['email'] = $request->email;
        $userData['phone'] = $request->phone;
        $userData['dayofevent'] = $request->dayofevent;
        $userData['message'] = $request->message;
        Mail::send('emails.contactbooknow', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['firstname'])->subject('Book an Event');
        });
         // check for failures
        if (Mail::failures()) {
           $request->session()->flash('mailstatus', 'Please try again.');
        }else{
            $request->session()->flash('mailstatus', 'Thank you! Your message has been successfully sent. We will contact you very soon!.');
        }

		if($request->redirecturl){

			return redirect($request->redirecturl.'#success');
		}

        return redirect('/');
    }
}
