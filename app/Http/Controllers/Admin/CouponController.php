<?php

namespace App\Http\Controllers\Admin;
use App\Coupon;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Coupon::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.coupon.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'coupon_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount' => 'required|numeric',
            'p_id' => 'required' 
        ]);

       //Create data to save
        $createCoupon = array(
            'coupon_name' => $input['coupon_name'],
            'start_date' => $input['start_date'],
            'end_date' => $input['end_date'],
            'discount' => $input['discount'],
            'p_id' => $input['p_id']
        );
        //Create Coupon
        Coupon::create($createCoupon);

        //redirect after creating new addon
        return redirect()->route('admin::coupons.index')
            ->with('flash_notice', 'Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get addon detail
        $entry = Coupon::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::coupons.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.coupon.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        //Check coupons exist
        if (!$coupon) {
            return redirect()->route('admin::coupons.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.coupon.edit', compact('coupon'));
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
        //Get The Coupon
        $coupon = Coupon::find($id);

        //check Coupon exist
        if (!$coupon) {
            return redirect()->route('admin::coupons.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'coupon_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount' => 'required|numeric',
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedCoupon = array(
             'coupon_name' => $input['coupon_name'],
            'start_date' => $input['start_date'],
            'end_date' => $input['end_date'],
            'discount' => $input['discount'],
            'p_id' => $input['p_id']
        );

        //Update the coupons
        Coupon::where('id', $id)->update($updatedCoupon);

        //redirect after creating new coupons
        return redirect()->route('admin::coupons.index')
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
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('admin::coupons.index')->with('flash_notice', 'Successfully deleted!');
    }
}
