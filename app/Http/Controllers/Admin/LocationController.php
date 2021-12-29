<?php

namespace App\Http\Controllers\Admin;
use App\Location;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Location::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.location.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.location.create');
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
            'location_name' => 'required',
            'price' => 'required|numeric',
            'p_id' => 'required'
        ]);

       //Create data to save
        $createLocation = array(
            'location_name' => $input['location_name'],
            'price' => $input['price'],
            'p_id' => $input['p_id']
        );

        //Create location
        Location::create($createLocation);

        //redirect after creating new locations
        return redirect()->route('admin::locations.index')
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
        //get locations detail
        $entry = Location::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::locations.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.location.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);

        //Check card exist
        if (!$location) {
            return redirect()->route('admin::locations.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.location.edit', compact('location'));
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
        //Get The location
        $location = Location::find($id);

        //check location exist
        if (!$location) {
            return redirect()->route('admin::locations.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
           'location_name' => 'required',
            'price' => 'required|numeric',
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedLocation = array(
            'location_name' => $input['location_name'],
            'price' => $input['price'],
            'p_id' => $input['p_id']
        );

        //Update the locations
        Location::where('id', $id)->update($updatedLocation);

        //redirect after creating new locations
        return redirect()->route('admin::locations.index')
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
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()->route('admin::locations.index')->with('flash_notice', 'Successfully deleted!');
    }
}
