<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entry = Setting::orderBy('id', 'asc')->first();
        //Show listing view
        return view('admin.setting.index', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        //Check setting exist
        if (!$setting) {
            return redirect()->route('admin::setting.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.setting.edit', compact('setting'));
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
        //Get The Setting
        $setting = Setting::find($id);

        //check Setting exist
        if (!$setting) {
            return redirect()->route('admin::settings.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'hprice' => 'required',
            'fprice' => 'required|numeric',
            'tax' => 'required|numeric',
            'payment_mode' => 'required',
            'paypal_client_id' => 'required',
            'paypal_secret' => 'required',
            'stripe_publishable_key' => 'required',
            'stripe_secret_key' => 'required'
        ]);

       //updated data to save
        $updatedSetting = array(
            'hprice' => $input['hprice'],
            'fprice' => $input['fprice'],
            'tax' => $input['tax'],
            'payment_mode' => $input['payment_mode'],
            'paypal_client_id' => $input['paypal_client_id'],
            'paypal_secret' => $input['paypal_secret'],
            'stripe_publishable_key' => $input['stripe_publishable_key'],
            'stripe_secret_key' => $input['stripe_secret_key']
        );

        //Update the Setting
        Setting::where('id', $id)->update($updatedSetting);

        //redirect after creating new Setting
        return redirect()->route('admin::settings.index')
            ->with('flash_notice', 'Updated successfully.');
    }


}
