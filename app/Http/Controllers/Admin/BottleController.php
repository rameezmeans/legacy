<?php

namespace App\Http\Controllers\Admin;
use App\Bottle;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BottleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Bottle::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.bottle.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bottle.create');
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
            'bottle_name' => 'required',
            'price' => 'required|numeric', 
            'p_id' => 'required' 
        ]);

       //Create data to save
        $createBottle = array(
            'bottle_name' => $input['bottle_name'],
            'price' => $input['price'], 
            'p_id' => $input['p_id']
        );

        //Update the bottles
        Bottle::create($createBottle);

        //redirect after creating new bottles
        return redirect()->route('admin::bottles.index')
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
        //get bottle detail
        $entry = Bottle::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::bottles.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.bottle.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bottle = Bottle::findOrFail($id);

        //Check card exist
        if (!$bottle) {
            return redirect()->route('admin::bottles.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.bottle.edit', compact('bottle'));
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
        //Get The bottles
        $bottle = Bottle::find($id);

        //check bottles exist
        if (!$bottle) {
            return redirect()->route('admin::bottles.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'bottle_name' => 'required',
            'price' => 'required|numeric', 
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedBottle = array(
            'bottle_name' => $input['bottle_name'],
            'price' => $input['price'], 
            'p_id' => $input['p_id']
        );

        //Update the bottles
        Bottle::where('id', $id)->update($updatedBottle);

        //redirect after creating new bottles
        return redirect()->route('admin::bottles.index')
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
        $bottle = Bottle::findOrFail($id);
        $bottle->delete();
        return redirect()->route('admin::bottles.index')->with('flash_notice', 'Successfully deleted!');
    }
}
