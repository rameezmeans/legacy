<?php

namespace App\Http\Controllers\Admin; 
use DB;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Contact::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.contact.index', compact('entries'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get contact detail
        $entry = Contact::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::contacts.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.contact.view', compact('entry'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Contact::findOrFail($id);
        $coupon->delete();
        return redirect()->route('admin::contacts.index')->with('flash_notice', 'Successfully deleted!');
    }     
}
