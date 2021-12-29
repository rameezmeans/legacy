<?php

namespace App\Http\Controllers\Admin;
use App\Addon;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Addon::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.addon.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addon.create');
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
            'addons_name' => 'required',
            'hprice' => 'required|numeric',
            'fprice' => 'required|numeric',
            'p_id' => 'required' 
        ]);

       //Create data to save
        $createAddon = array(
            'addons_name' => $input['addons_name'],
            'hprice' => $input['hprice'],
            'fprice' => $input['fprice'],
            'p_id' => $input['p_id']
        );
        //Create addons
        Addon::create($createAddon);

        //redirect after creating new addon
        return redirect()->route('admin::addons.index')
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
        $entry = Addon::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::addons.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.addon.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addon = Addon::findOrFail($id);

        //Check card exist
        if (!$addon) {
            return redirect()->route('admin::addons.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.addon.edit', compact('addon'));
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
        //Get The addons
        $addon = Addon::find($id);

        //check addons exist
        if (!$addon) {
            return redirect()->route('admin::addons.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'addons_name' => 'required',
            'hprice' => 'required|numeric',
            'fprice' => 'required|numeric',
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedAddon = array(
            'addons_name' => $input['addons_name'],
            'hprice' => $input['hprice'],
            'fprice' => $input['fprice'],
            'p_id' => $input['p_id']
        );

        //Update the addon
        Addon::where('id', $id)->update($updatedAddon);

        //redirect after creating new addon
        return redirect()->route('admin::addons.index')
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
        $addon = Addon::findOrFail($id);
        $addon->delete();
        return redirect()->route('admin::addons.index')->with('flash_notice', 'Successfully deleted!');
    }
}
