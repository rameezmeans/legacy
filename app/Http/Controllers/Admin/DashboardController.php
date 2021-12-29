<?php

namespace App\Http\Controllers\Admin;

use App\Notification;
use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\GeneralInstructions;
use App\User;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    /*
     * Display Admin DashBoard
    */
    public function index() {

        $totalBookings = Order::get()->where('status', '=', 'Y')->where('paystatus', '=', 'Y')->where('parent_id', '=', 0)->count();
        $newBookings = Order::where('orders.created_at', date('Y-m-d'))->where('paystatus', '=', 'Y')->where('status', '=', 'Y')->where('parent_id', '=', 0)->get()->count();
        //$cBookings = Order::where('orders.status', 'c')->where('paystatus', '=', 'Y')->where('status', '=', 'Y')->where('parent_id', '=', 0)->get()->count();
        $totalUsers = User::get()->where('role', '=', 'S')->count();
        $entries = Order::orderBy('booking_date', 'desc')->where('paystatus', '=', 'Y')->where('status', '=', 'Y')->where('parent_id', '=', 0)->paginate(10);
        //render view

        $notifications = Notification::all();

        return view('admin.dashboard', compact('notifications','totalBookings','newBookings','totalUsers','entries'));
    }



    public function emailTemplates(){

        $gi = GeneralInstructions::findOrFail(2);
        $et2 = GeneralInstructions::findOrFail(3);
        $et3 = GeneralInstructions::findOrFail(4);
        $et4 = GeneralInstructions::findOrFail(5);
        $et5 = GeneralInstructions::findOrFail(6);

        return view('admin.email_templates.index', [
            'email_template_1' => $gi,
            'email_template_2' => $et2,
            'email_template_3' => $et3,
            'email_template_4' => $et4,
            'email_template_5' => $et5
        ]);


    }
    public function notifications(){

        $notifications = Notification::orderBy('updated_at', 'desc')->get();



        return view('admin.notifications.index', ['notifications' => $notifications]);

    }

}
