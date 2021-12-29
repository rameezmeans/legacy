<?php

namespace App\Http\Controllers\Admin;
use App\Beverage;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BeverageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Beverage::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.beverage.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.beverage.create');
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
            'beverage_name' => 'required',
            'hprice' => 'required|numeric', 
            'fprice' => 'required|numeric', 
            'p_id' => 'required' 
        ]);

       //Create data to save
        $createBeverage = array(
            'beverage_name' => $input['beverage_name'],
            'hrice' => $input['hprice'],
            'fprice' => $input['fprice'], 
            'p_id' => $input['p_id']
        );

        //Update the beverages
        Beverage::create($createBeverage);

        //redirect after creating new beverages
        return redirect()->route('admin::beverages.index')
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
        //get beverages detail
        $entry = Beverage::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::beverages.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.beverage.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beverage = Beverage::findOrFail($id);

        //Check card exist
        if (!$beverage) {
            return redirect()->route('admin::beverages.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.beverage.edit', compact('beverage'));
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
        //Get The beverages
        $beverage = Beverage::find($id);

        //check beverages exist
        if (!$beverage) {
            return redirect()->route('admin::beverages.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'beverage_name' => 'required',
            'hprice' => 'required|numeric', 
            'fprice' => 'required|numeric', 
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedBeverage = array(
            'beverage_name' => $input['beverage_name'],
            'hprice' => $input['hprice'],
            'fprice' => $input['fprice'], 
            'p_id' => $input['p_id']
        );

        //Update the beverages
        Beverage::where('id', $id)->update($updatedBeverage);

        //redirect after creating new beverages
        return redirect()->route('admin::beverages.index')
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
        $beverage = Beverage::findOrFail($id);
        $beverage->delete();
        return redirect()->route('admin::beverages.index')->with('flash_notice', 'Successfully deleted!');
    }
}
