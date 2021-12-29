<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Response;

use App\GeneralInstructions;




use App\Http\Controllers\Controller;

class GeneralInstructionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gi = GeneralInstructions::findOrFail(1);

        return view('admin.general_instructions.index', ['general_instructions' => $gi]);

    }

    public function update(Request $request, $id)
    {

//        dd($request->all());


        $gi = GeneralInstructions::findOrFail($id);

        $gi->text = $request->text;
        $gi->subject = $request->subject;

        $gi->save();





    }


}
