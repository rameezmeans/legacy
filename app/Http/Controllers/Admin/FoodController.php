<?php

namespace App\Http\Controllers\Admin;
use App\Food;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Food::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.food.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.food.create');
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
            'food_name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'p_id' => 'required' 
        ]);

       //Create data to save
        $createFood = array(
            'food_name' => $input['food_name'],
            'price' => $input['price'],
            'type' => $input['type'],
            'p_id' => $input['p_id']
        );

        //Update the food
        Food::create($createFood);

        //redirect after creating new food
        return redirect()->route('admin::foods.index')
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
        //get food detail
        $entry = Food::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::foods.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.food.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $food = Food::findOrFail($id);

        //Check card exist
        if (!$food) {
            return redirect()->route('admin::foods.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.food.edit', compact('food'));
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
        //Get The food
        $food = Food::find($id);

        //check food exist
        if (!$food) {
            return redirect()->route('admin::foods.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'food_name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'p_id' => 'required' 
        ]);

       //updated data to save
        $updatedFood = array(
            'food_name' => $input['food_name'],
            'price' => $input['price'],
            'type' => $input['type'],
            'p_id' => $input['p_id']
        );

        //Update the food
        Food::where('id', $id)->update($updatedFood);

        //redirect after creating new food
        return redirect()->route('admin::foods.index')
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
        $food = Food::findOrFail($id);
        $food->delete();
        return redirect()->route('admin::foods.index')->with('flash_notice', 'Successfully deleted!');
    }
}
