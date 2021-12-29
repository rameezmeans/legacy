<?php

namespace App\Http\Controllers;

use App\Event;
use App\GeneralInstructions;
use App\GuestList;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use PHPMailer\PHPMailer\PHPMailer;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


    }
    protected $rules =
        [
            'name' => 'required|min:2|max:32',
            'email' => 'required|email',


        ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        dd($this->auth->user());


        return view('home');
    }

    public function remove_guest(Request $request){

        $guest = GuestList::findOrFail($request->id);

        $guest->delete();





    }
    public function update_guest($id, Request $request){
        $validator = \Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $guest = GuestList::findOrFail($id);

            $guest->name = $request->name;
            $guest->email = $request->email;

            $guest->save();

            return response()->json($guest);
        }


    }
    public function check_guest_rsvp(Request $request){


        $guest_id = $request->guest_id;

        $guest_rsvp = GuestList::findOrFail($guest_id)->status;

        echo $guest_rsvp;exit;


    }
    public function add_guest(Request $request){


        $validator = \Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $guest = new GuestList();

            $guest->name = $request->name;
            $guest->email = $request->email;
            $guest->event_id = $request->event_id;
            $guest->status = "Not Sent";

            $guest->save();

            return response()->json($guest);
        }


    }


//    public function show_event($name_date){
//
//
//        $date = substr($name_date, -10);
//
////        dd($date);
//
//        $slug = substr($name_date,0,-11);
//
////        dd($name);
//
//
//
//
//        $event = Event::where('slug_str', '=', $slug)->where('event_date', '=', $date)->first();
//
//        $general_instructions = GeneralInstructions::FindOrFail(1);
//
////dd(Auth::user());
//
//
////        dd($event);
//
//        if(Auth::user()->role == 'A' ) {
//
//            return view('event-landing-page', ['general_instructions' => $general_instructions->general_instructions, 'event' => $event]);
//
//        }else if (Auth::user()->role == 'S'){
//
//
//            if(Auth::user()->id == $event->owner_id) {
//                return view('event-landing-page', ['general_instructions' => $general_instructions->general_instructions, 'event' => $event]);
//            }
//            else{
////                dd($event->owner_id);
//
//                return redirect('/');
//            }
//
//        }


//    }

    public function approveAllUpdateEvent(Request $request){

//        dd($request->all());


        $all_notifications_checked = $request->notificationIDs;


//        dd($all_notifications_checked);

        if(!is_null($all_notifications_checked)) {


            foreach ($all_notifications_checked as $n) {


                if (is_numeric($n)) {

                    $notification = Notification::findOrFail($n);


                    if (!$notification->approved) {
                        $notification->approved = 1;
                        $notification->save();

                        $event = Event::findOrFail($notification->event_id);

//                        dd($notification);

                        if ($notification->type == 'title') {
                            $event->name = $notification->value;
                        }
                        if ($notification->type == 'description') {

                            $event->description = $notification->value;
                        }


                        $event->save();




                    }

                }
            }
        }



    }

    public function send_email(){

        $mail = new PHPMailer(true);

        try {
            $mail->Host = 'mail.inthezonenj.com';

            $mail->AddReplyTo('name@yourdomain.com', 'First Last');
            $mail->AddAddress("xrkalix@gmail.com", "Rameeez");
            $mail->SetFrom('feedback@inthezonenj.com', 'ITZ Admin');
            $mail->AddReplyTo('noreply@inthezonenj.com', 'No Replay');
            $mail->Subject = "Test Email";
            $mail->MsgHTML('

                        
                        <div>
                        This is my Email
                        </div>

                        ');

            return $mail->Send();
            //  echo "Message Sent OK\n";
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }


    }



    public function removeUpdateEvent(Request $request){

        $all_notifications_checked = $request->notificationIDs;

        foreach($all_notifications_checked as $n) {

            if (is_numeric($n)) {

                $notification = Notification::findOrFail($n);
                $notification->approved = -1;
                $notification->save();


            }


        }

    }
    public function approveUpdateEvent(Request $request){

//        dd($request->all());

        $notification = Notification::findOrFail($request->id);

        if($request->btn == 'approve'){
            $notification->approved = 1;
        }
        if($request->btn == 'undo'){
            $notification->approved = 0;
        }

        $notification->save();

        $event = Event::findOrFail($request->event_id);

        if($request->type == 'title'){
            $event->name = $request->value;
        }
        if($request->type == 'description'){
            $event->description = $request->value;
        }



        $event->save();

        if($request->btn == 'approve'){




            $host = User::findOrFail($event->owner_id);
            $admin = User::findOrFail(Auth::user()->id);

            $original_text = GeneralInstructions::findOrFail(4)->text;
            $subject = GeneralInstructions::findOrFail(4)->subject;

            $name = $admin->name;
            $hostname = $host->name;

            $original_text = str_replace("#eventname",$event->name,$original_text);
            $original_text = str_replace("#guestname",$hostname,$original_text);



//        dd($original_text);

            $userData['email_text'] =  $original_text;
            $userData['name'] = $hostname;
            $userData['subject'] = $subject;
            $fromMail = $admin->email;
            $toMail = $host->email;

//            dd($toMail);



            Mail::send('emails.invitation', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
                $m->from($fromMail, 'Legacy Cruises & Events');

                $m->to($toMail, $userData['name'])->subject($userData['subject']);
            });
            // check for failures
            if (Mail::failures()) {
                echo 0;exit;
            }
            else{
                echo 1;exit;
            }
        }



    }

    public function rejectUpdateEvent(Request $request){

//        dd($request->all());

        $notification = Notification::findOrFail($request->id);


            $notification->approved = -1;


        $notification->save();



    }
    public function updateEventTitle($id, Request $request){


        $event_id = $id;

        $event = Event::findOrFail($event_id);

        $host = User::findOrFail($event->owner_id);
        $guest = User::findOrFail(Auth::user()->id);

//        dd($guest);


        $editor_id = $request->editor_id;
        $type = $request->type;

//        echo $type;exit;

        if($type == 'title'){

            $original_value = $event->name;

        }
        else if($type == 'description'){

            $original_value = $event->description;

        }

//
//        echo $original_value;exit;

        $original_text = GeneralInstructions::findOrFail(3)->text;
        $userData['subject'] = GeneralInstructions::findOrFail(3)->subject;


        $original_text = str_replace("#eventhonor",$guest->name,$original_text);

//        dd($original_text);



        $userData['email_text'] =  $original_text;
        $userData['name'] = $guest->name;
        $fromMail = $host->email;
        $toMail = $guest->email;





        $title = $request->title;

        $notification = Notification::create(['event_id' => $event_id, 'editor_id' => $editor_id,'original_value' => $original_value, 'type' => $type, 'value' => $title]);

//        var_dump($notification);

        Mail::send('emails.invitation', ['userData' => $userData], function ($m) use ($userData,$fromMail,$toMail) {
            $m->from($fromMail, 'Legacy Cruises & Events');

            $m->to($toMail, $userData['name'])->subject($userData['subject']);
        });
        // check for failures
        if (Mail::failures()) {
            echo 0;exit;
        }
        else{
            echo 1;exit;
        }


    }


}
