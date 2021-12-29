<?php

namespace App\Http\Controllers\Admin;
use App\Pprice;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PpriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Pprice::orderBy('id', 'asc')->paginate(3000);        
        //Show listing view
        return view('admin.pprice.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //product dropdown
        $products = Product::pluck('product_name', 'id');
        return view('admin.pprice.create', compact('products'));
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
            'day' => 'required',
            'price' => 'required|numeric', 
            'p_id' => 'required' 
        ]);

       //Create data to save
        $createPprice = array(
            'day' => $input['day'],
            'price' => $input['price'],
            'date' => $input['date'],
            'p_id' => $input['p_id']
        );

        //Update the pprices
        Pprice::create($createPprice);

        //redirect after creating new pprices
        return redirect()->route('admin::pprices.index')
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
        //get pprice detail
        $entry = Pprice::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::pprices.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.pprice.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pprice = Pprice::findOrFail($id);

        //Check card exist
        if (!$pprice) {
            return redirect()->route('admin::pprices.index')
                ->with('flash_error', 'No record found.');
        }
        
        //product dropdown
        $products = Product::pluck('product_name', 'id');

        //render edit form view
        return view('admin.pprice.edit', compact('pprice','products'));
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
        //Get The pprice
        $pprice = Pprice::find($id);

        //check pprice exist
        if (!$pprice) {
            return redirect()->route('admin::pprices.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'day' => 'required',
            'price' => 'required|numeric',  
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedPprice = array(
            'day' => $input['day'],
            'price' => $input['price'],
            'date' => $input['date'],
            'p_id' => $input['p_id']
        );

        //Update the beverages
        Pprice::where('id', $id)->update($updatedPprice);

        //redirect after creating new beverages
        return redirect()->route('admin::pprices.index')
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
        $pprice = Pprice::findOrFail($id);
        $pprice->delete();
        return redirect()->route('admin::pprices.index')->with('flash_notice', 'Successfully deleted!');
    }
}
