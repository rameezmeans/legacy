<?php

namespace App\Http\Controllers\Admin;
use App\Notification;
use App\User;
use App\Order;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    /*
     * Display Admin DashBoard
    */
    public function index() {
//        $user = User::whereNull('id')->get();
//        dd($user);
        $entries = User::orderBy('id', 'asc')->where('role','S')->get();
//        dd($entries);
        $notifications = Notification::all();

        //Show listing view
        return view('admin.user.index', compact('entries', 'notifications'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get products detail
        $entry = User::find($id);

        $notifications = Notification::all();


        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::users.index')
                ->with('flash_error', 'No record found.');
        }

        $entries = Order::orderBy('booking_date', 'desc')->where('orders.u_id', $id)->where('parent_id', '=', 0)->get();

        //render view
        return view('admin.user.view', compact('entry','entries', 'notifications'));
    }

}
