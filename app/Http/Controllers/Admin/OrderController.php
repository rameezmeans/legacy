<?php

namespace App\Http\Controllers\Admin;
use App\Notification;
use App\Order;
use App\Product;
use DB;
use App\Addon;
use App\Food;
use App\Beverage;
use App\Bottle;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notifications = Notification::all();

        $entries = Order::orderBy('booking_date', 'desc')->where('parent_id', '=', 0)->where('status', '=', 'Y')->where('paystatus', '=', 'Y')->paginate(30000);
        //Show listing view
        return view('admin.order.index', compact('entries', 'notifications'));
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
        $entry = Order::where('parent_id', '=', 0)->find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::orders.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.order.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::where('parent_id', '=', 0)->findOrFail($id);
        $settings = Setting::orderBy('id', 'asc')->first();

        //Check Order exist
        if (!$order) {
            return redirect()->route('admin::orders.index')
                ->with('flash_error', 'No record found.');
        }
        $foods = Food::orderBy('id', 'asc')->get();
        $beverages = Beverage::orderBy('id', 'asc')->get();
        $bottles = Bottle::orderBy('id', 'asc')->get();
        $addons = Addon::orderBy('id', 'asc')->get();

        //render edit form view
        return view('admin.order.edit', compact('order', 'foods', 'beverages', 'bottles', 'addons', 'settings'));
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
        //Get The Order
        $order = Order::find($id);

        //check order exist
        if (!$order) {
            return redirect()->route('admin::orders.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();
        $buffetsArr = array();

        foreach ($input['buffets'] as $key => $value) {
            // $key would contain the key value (1 or 2)
            if($value['buffet_guest']){
                $buffetsArr[] = array( 'buffet_id' => $value['buffet'], 'buffet_name' => $value['buffet_name'], 'buffet_price' => $value['buffet_price'], 'buffet_qty' => $value['buffet_guest'], 'buffet_base_price' => $value['buffet_base_price']);
            }
        }

        $traysArr = array();
        foreach ($input['trays'] as $key => $value) {
            // $key would contain the key value (1 or 2)
            if($value['tray_guest']){
                $traysArr[] = array( 'tray_id' => $value['tray'], 'tray_name' => $value['tray_name'], 'tray_price' => $value['tray_price'], 'tray_qty' => $value['tray_guest'], 'tray_base_price' => $value['tray_base_price']);
            }
        }

        $bottlesArr = array();
        foreach ($input['bottles'] as $key => $value) {
           // $key would contain the key value (1 or 2)
           if($value['bottle_guest']){
               $bottlesArr[] = array( 'bottle_id' => $value['bottle'], 'bottle_name' => $value['bottle_name'], 'bottle_price' => $value['bottle_price'], 'bottle_qty' => $value['bottle_guest'], 'bottle_base_price' => $value['bottle_base_price']);
           }
        }

        $barsArr = array();
        foreach ($input['bars'] as $key => $value) {
            // $key would contain the key value (1 or 2)
            if($value['bar_guest']){
                $barsArr[] = array( 'bar_id' => $value['bar'], 'bar_name' => $value['bar_name'], 'bar_price' => $value['bar_price'], 'bar_qty' => $value['bar_guest'], 'bar_base_price' => $value['bar_base_price'], 'bar_half' => $value['bar_half'], 'bar_full' => $value['bar_full'], 'time_duration' => $value['time_duration'] );
            }
        }

        $addonsArr = array();
        foreach ($input['addons'] as $key => $value) {
            // $key would contain the key value (1 or 2)
            if($value['addon_guest']){
                $addonsArr[] =array( 'addon_id' => $value['addon_name'], 'addon_name' => $value['addon_name'], 'addon_price' => $value['addon_price'], 'addon_qty' => $value['addon_guest'], 'addon_half' => $value['addon_half'], 'addon_full' => $value['addon_full'], 'time_duration' => $value['time_duration'] );
            }
        }

        if ($input['bartenderFee'] > 0){
           $bartenders= serialize(array('bartenderFee'=>$input['bartenderFee'],'bartenderQty'=>$input['bartenderQty'],'bartenderTime'=>$input['bartenderTime']));
       } else{
            $bartenders= serialize(array('bartenderFee'=> '','bartenderQty'=>'','bartenderTime'=>''));
       }



        if ( count($buffetsArr)>0 ) {
            $buffets= serialize($buffetsArr);
        } else {
            $buffets= serialize('Skip');
        }

        if ( count($traysArr)>0 ) {
            $trays= serialize($traysArr);
        } else {
            $trays= serialize('Skip');
        }

        if ( count($bottlesArr)>0 ) {
            $bottles= serialize($bottlesArr);
        } else {
            $bottles= serialize('Skip');
        }

        if ( count($addonsArr)>0 ) {
            $addons= serialize($addonsArr);
        } else {
            $addons= serialize('Skip');
        }

        if ( count($barsArr)>0 ) {
            $bars= serialize($barsArr);
        } else {
            $bars= serialize('Skip');
        }

       //updated data to save
        $updatedOrder = array(
            'tax' => $input['ordertax'],
            'stotal' => $input['stotal'],
            'total' => $input['total'],
            'due' => $input['due'],
            'buffet_details' => $buffets,
            'tray_details' => $trays,
            'bottle_details' => $bottles,
            'addon_details' => $addons,
            'bar_details' => $bars,
            'bartender_details' => $bartenders
        );

        //Update the coupons
        Order::where('id', $id)->update($updatedOrder);

        //redirect after creating new order
        return redirect()->route('admin::orders.index')
            ->with('flash_notice', 'Updated successfully.');
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
        $order = Order::find($id);

        //check location exist
        if (!$order) {
            return redirect()->route('admin::orders.index')
                ->with('flash_error', 'No record found.');
        }

       //updated data to save
        $updatedOrder = array(
            'status' => 'N'
        );
        if($order->parent_id !=0){
            $orderp = Order::where('parent_id', '=', $id)->find($id);
            Order::where('id', $orderp->id)->update($updatedOrder);
        }

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
        return redirect()->route('admin::orders.index')
            ->with('flash_notice', 'Successfully Canceled!');
    }
}
