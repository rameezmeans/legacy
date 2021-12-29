<?php

namespace App\Http\Controllers\Admin;
use App\Dbooking; 
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DbookingController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Dbooking::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.dbooking.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dbooking.create');
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
            'start_date' => 'required',
            'dbooking_time_from' => 'required',
            'dbooking_time_to' => 'required' 
        ]);
        $start_date = $input['start_date'];
        $end_date = $input['end_date'];
        $createDbookings = array();
        while (strtotime($start_date) <= strtotime($end_date)) {   
            $createDbookings[] = array(
                'dbooking_date' => $start_date,
                'dbooking_time_from' => $input['dbooking_time_from'],
                'dbooking_time_to' => $input['dbooking_time_to'] 
            );
            $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
        }  
        foreach ($createDbookings as $createDbooking) { 
            Dbooking::create($createDbooking); 
        } 

        //redirect after creating new food
        return redirect()->route('admin::dbookings.index')
            ->with('flash_notice', 'Added successfully.');
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Dbooking::findOrFail($id);
        $food->delete();
        return redirect()->route('admin::dbookings.index')->with('flash_notice', 'Successfully deleted!');
    }
}
