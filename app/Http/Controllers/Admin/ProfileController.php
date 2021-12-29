<?php
namespace App\Http\Controllers\Admin; 
use App\Notification;
use DB;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    
	
	public function index()
    { 
        $currentuserid = Auth::user()->id;   
        $entry = User::where('id', $currentuserid)->where('role', 'A')->first();
        $notifications = Notification::all();
        return view('admin.profile.index',compact('entry', 'notifications'));
    }
	 
	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = User::where('role', 'A')->findOrFail($id);

        //Check setting exist
        if (!$profile) {
            return redirect()->route('admin::profile.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.profile.edit', compact('profile'));
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

    	//Get The User
        $profile = User::where('role', 'A')->find($id);

        //check User exist
        if (!$profile) {
            return redirect()->route('admin::profile.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [ 
            'password' => 'min:6',
			'confirm_password' => 'min:6|same:password'  
        ]);

       //updated data to save
        $updatedprofile = array( 
            'password' => bcrypt($input['password']) 
        );

        //Update the User
        User::where('id', $id)->where('role', 'A')->update($updatedprofile);

         
		return redirect()->route('admin::profile.index')
            ->with('flash_notice', 'Updated successfully.');
    } 
}
