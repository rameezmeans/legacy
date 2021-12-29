<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Location;
use App\Notification;
use App\Product;
use App\GeneralInstructions;
use App\User;

use Carbon\Carbon;
use Google\Client;
use Revolution\Google\Sheets\Sheets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

use Illuminate\Support\Facades\Input;
use Response;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class EventController extends Controller
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

    protected $rules =
        [
            'name'             => 'required|min:2|max:32',
            'description'      => 'required|min:2',
            'number_of_guests' => 'required',
            'event_date'       => 'required',
            'start_time'       => 'required',
            'end_time'         => 'required',

        ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events        = Event::orderBy('id', 'asc')->get();
        $yachts        = Product::orderBy('id', 'asc')->get();
        $users         = User::orderBy('id', 'asc')->get();
        $locations     = Location::orderBy('id', 'asc')->get();
        $notifications = Notification::all();

        $this->addGoogleSheetRecords();

        return view('admin.events.index', [
            'notifications' => $notifications,
            'locations'     => $locations,
            'events'        => $events,
            'yachts'        => $yachts,
            'users'         => $users
        ]);
    }

    public function addGoogleSheetRecords()
    {
        $records = $this->googleSheet();

        array_shift($records);
        foreach ($records as $record) {
            if ( ! Event::where('crm_id', $record[0])->first() ) {
                if ($record[20] == 'Yes') {
                    $event             = new Event();
                    $event->crm_id     = $record[0];

                    for ($i = 0; ; $i++) {
                        $url = mt_rand(1000000000, 9999999999);

                        if (Event::where('slug_str', '=', $url)->exists()) {
                            continue;
                        } else {
                            break;
                        }
                    }

                    $event->slug_str             = $url;
                    $event->event_type     = $record[6];
                    $event->event_date = Carbon::createFromFormat('m/d/Y', $record[1])->format('Y-m-d');
                    $event->start_time = date("G:i", strtotime($record[2]));
                    $event->save();
                }
            }
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $event = Event::findOrFail($id);

            $event->name = $request->name;
//            $event->slug_str = str_slug( $request->name );
            $event->boarding_location    = $request->boarding_location;
            $event->event_date           = date('Y-m-d', strtotime($request->event_date));
            $event->yacht_id             = $request->yacht_id;
            $event->owner_id             = $request->owner_id;
            $event->start_time           = $request->start_time;
            $event->end_time             = $request->end_time;
            $event->description          = $request->description;
            $event->event_type           = $request->event_type;
            $event->number_of_guests     = $request->number_of_guests;
            $event->general_instructions = $request->general_instructions;

            $event->save();


            return response()->json($event);
        }
    }

    public function googleSheet()
    {
        $client = $this->getClient();
        $client->setScopes([\Google_Service_Sheets::DRIVE, \Google_Service_Sheets::SPREADSHEETS]);

        $service = new \Google_Service_Sheets($client);

        $spreadsheetId = '13cLR8nwbyGSNSa-zb0XEx6uU4bJgFuLytw7hPU0gKM0';
        $range         = 'Schedule!A:U';
        $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values        = $response->getValues();

        return $values;
    }

    public function getClient()
    {
        $client = new \Google_Client();
        $client->setApplicationName('sheetapi');
        $client->setScopes(\Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig(public_path('credentials_token/cr1.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = public_path('credentials_token/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = "4/0AX4XfWgypQz4hXnTWuVSt8g6-Qv61UWDxocaD6O7-dqarSCWES80s7O3bcJiYhJV3h4zcA";

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if ( ! file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }


    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $event = new Event();

            $event->name = $request->name;

            for ($i = 0; ; $i++) {
                $url = mt_rand(1000000000, 9999999999);

                if (Event::where('slug_str', '=', $url)->exists()) {
                    continue;
                } else {
                    break;
                }
            }

            $event->slug_str             = $url;
            $event->boarding_location    = $request->boarding_location;
            $event->event_date           = date('Y-m-d', strtotime($request->event_date));
            $event->yacht_id             = $request->yacht_id;
            $event->owner_id             = $request->owner_id;
            $event->start_time           = $request->start_time;
            $event->event_type           = $request->event_type;
            $event->end_time             = $request->end_time;
            $event->number_of_guests     = $request->number_of_guests;
            $event->description          = $request->description;
            $event->general_instructions = $request->general_instructions;

            $event->save();

            $host  = User::findOrFail($request->owner_id);
            $admin = User::findOrFail(Auth::user()->id);

            $hostname = $host->name;

            $userData['subject'] = GeneralInstructions::findOrFail(5)->subject;
            $original_text       = GeneralInstructions::findOrFail(5)->text;


            $original_text = str_replace("#hostname", $hostname, $original_text);
            $original_text = str_replace("#eventname", $request->name, $original_text);

//        dd($original_text);
            $userData['email_text'] = $original_text;
            $userData['name']       = $host->name;
            $fromMail               = $admin->email;
            $toMail                 = $host->email;

//            dd($userData);

            Mail::send('emails.invitation', ['userData' => $userData],
                function ($m) use ($userData, $fromMail, $toMail) {
                    $m->from($fromMail, 'Legacy Cruises & Events');

                    $m->to($toMail, $userData['name'])->subject($userData['subject']);
                });
            // check for failures
            if (Mail::failures()) {
                echo 0;
                exit;
            } else {
                echo 1;
                exit;
            }

            return response()->json($event);
        }
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json($event);
    }
}
