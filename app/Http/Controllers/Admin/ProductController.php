<?php

namespace App\Http\Controllers\Admin;
use App\Product;
use App\Order;
use App\Pprice;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use File;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Product::orderBy('id', 'asc')->paginate(3000);
        //Show listing view
        return view('admin.product.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
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
            'product_name' => 'required',
            'default_price' => 'required|numeric',
           // 'description' => 'required',
            //'image' => 'required',
            'status' => 'required'
        ]);
        //Check image was uploaded
    //     if ($request->hasFile('image')) {

    //         //get the uploaded file
    //         $uploadImg = $request->file('image');

    //         if ($uploadImg->isValid()) {

    //             //get config values for different carousels
    //             $maxUploadSize = config("legacy.max_upload_size");
				// $minImgWidth = config("legacy.legacy_image.min_width");
    //             $minImgHeight = config("legacy.legacy_image.min_height");
    //             $imgPreferedSize = config("legacy.legacy_image.prefered_size");

    //             //Define allowed file extensions
    //             $allowedExtensions = array('png', 'jpg' ,'jpeg', 'gif', 'bmp');

    //             //get uploaded image data
    //             $imgExtenstion = $uploadImg->getClientOriginalExtension();
    //             $orginalImgName = $uploadImg->getClientOriginalName();
    //             $imgSize = $uploadImg->getClientSize() / (1024 * 1024); //in MB

    //             //check uploaded file is image
    //             if( !(in_array(strtolower($imgExtenstion), $allowedExtensions)) ) {
    //                 //redirect user back with input & error messages
				// 	return redirect()->route('admin::products.create')
    //                     ->withInput()
    //                     ->with('flash_error', 'Please upload an image.');
    //             }

    //             //check image size is not more than max upload size (if max upload size define in config)
    //             if( ($maxUploadSize) && ($imgSize > (int)$maxUploadSize) ) {
    //                 //redirect user back with input & error messages
    //                 return redirect()->route('admin::products.create')
    //                     ->withInput()
    //                     ->with('flash_error', "Maximum upload size is {$maxUploadSize}MB.");
    //             }

    //             //GET image Width & height
    //             list($imgWidth, $imgHeight) = getimagesize($uploadImg);

				// //check uploaded image width/height is not less than min. width/height (if min width/height define in config)
    //             if ( (($minImgWidth) && ($imgWidth < (int)$minImgWidth)) || (($minImgHeight) && ($imgHeight < (int)$minImgHeight)) ) {
    //                 //redirect user back with input & error messages
    //                 return redirect()->route('admin::products.create')
    //                     ->withInput()
				// 		->with('flash_error', "Minimum width and height of the image should be {$minImgWidth}px and {$minImgHeight}px respectively.");
    //             }

    //             //Change the uploaded image name and Store file
    //             $uniqueHash = '_' . uniqid();
				// $updatedImgName = str_replace('.' . $imgExtenstion, $uniqueHash, $orginalImgName) . '.' . $imgExtenstion;
    //             Storage::disk('legacy')->put($updatedImgName,  File::get($uploadImg));

				// //Create product thumbs as per config
				// $this->_create_thumbs($uploadImg, $uniqueHash);

    //         }

    //     }
       //Create data to save
        $createProduct = array(
            'product_name' => $input['product_name'],
            'default_price' => $input['default_price'],
            'description' => 'N/A',//$input['description'],
            'status' => $input['status'],
            'image' => 'N/A'//isset($updatedImgName) ? $updatedImgName : ''
        );
        
        //Create products
        Product::create($createProduct);

        //redirect after creating new products
        return redirect()->route('admin::products.index')
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
        //get products detail
        $entry = Product::find($id);

        //check entry exist or not
        if (!$entry) {
            return redirect()->route('admin::products.index')
                ->with('flash_error', 'No record found.');
        }

        //render view
        return view('admin.product.view', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        //Check product exist
        if (!$product) {
            return redirect()->route('admin::products.index')
                ->with('flash_error', 'No record found.');
        }

        //render edit form view
        return view('admin.product.edit', compact('product'));
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
        //Get The products
        $product = Product::find($id);

        //check products exist
        if (!$product) {
            return redirect()->route('admin::products.index')
                ->with('flash_error', 'No record found.');
        }

        //Get posted form data
        $input = $request->input();

        // create the validation rules
        $this->validate($request, [
            'product_name' => 'required',
            'default_price' => 'required|numeric',
            //'description' => 'required',
            'status' => 'required'//,
            //'image' => 'required'
        ]);


        // //Check image was uploaded
        // if ($request->hasFile('image')) {

        //     //get the uploaded file
        //     $uploadImg = $request->file('image');

        //     if ($uploadImg->isValid()) {

        //         //get config values for different carousels
        //         $maxUploadSize = config("legacy.max_upload_size");
        //         $minImgWidth = config("legacy.legacy_image.min_width");
        //         $minImgHeight = config("legacy.legacy_image.min_height");
        //         $imgPreferedSize = config("legacy.legacy_image.prefered_size");

        //         //Define allowed file extensions
        //         $allowedExtensions = array('png', 'jpg' ,'jpeg', 'gif', 'bmp');

        //         //get uploaded image data
        //         $imgExtenstion = $uploadImg->getClientOriginalExtension();
        //         $orginalImgName = $uploadImg->getClientOriginalName();
        //         $imgSize = $uploadImg->getClientSize() / (1024 * 1024); //in MB

        //         //check uploaded file is image
        //         if( !(in_array(strtolower($imgExtenstion), $allowedExtensions)) ) {
        //             //redirect user back with input & error messages
        //             return redirect()->route('admin::products.edit', $id)
        //                 ->withInput()
        //                 ->with('flash_error', 'Please upload an image.');
        //         }

        //         //check uploaded image size is not more than max upload size (if max upload size define in config)
        //         if( ($maxUploadSize) && ($imgSize > (int)$maxUploadSize) ) {
        //             //redirect user back with input & error messages
        //             return redirect()->route('admin::products.edit', $id)
        //                 ->withInput()
        //                 ->with('flash_error', "Maximum upload size is {$maxUploadSize}MB.");
        //         }

        //         //GET image Width & height
        //         list($imgWidth, $imgHeight) = getimagesize($uploadImg);

        //         //check uploaded image width/height is not less than min. width/height (if min width/height define in config)
        //         if ( (($minImgWidth) && ($imgWidth < (int)$minImgWidth)) || (($minImgHeight) && ($imgHeight < (int)$minImgHeight)) ) {
        //             //redirect user back with input & error messages
        //             return redirect()->route('admin::products.edit', $id)
        //                 ->withInput()
        //                 ->with('flash_error', "Minimum width and height of the image should be {$minImgWidth}px and {$minImgHeight}px respectively.");
        //         }

        //         //Change the uploaded image name and Store file
        //         $uniqueHash = '_' . uniqid();
        //         $updatedImgName = str_replace('.'.$imgExtenstion, $uniqueHash, $orginalImgName). '.' . $imgExtenstion;
        //         Storage::disk('legacy')->put($updatedImgName, File::get($uploadImg));

        //         //delete the old image
        //         if (!empty($product->image) && Storage::disk('legacy')->exists($product->image)) {
        //             Storage::disk('legacy')->delete($product->image);
        //         }

        //         //Create thumbs and delete old thumbs as per config
        //         $this->_create_thumbs($uploadImg, $uniqueHash);
        //         $this->_delete_thumbs($product->image);

        //     }

        // }

       //updated data to save
        $updatedProduct = array(
            'product_name' => $input['product_name'],
            'default_price' => $input['default_price'],
            'description' => 'N/A',//$input['description'],
            'status' => $input['status'],
            'image' => 'N/A'//(isset($updatedImgName) && $updatedImgName) ? $updatedImgName : $product->image,
        );

        //Update the products
        Product::where('id', $id)->update($updatedProduct);

        //redirect after creating new products
        return redirect()->route('admin::products.index')
            ->with('flash_notice', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);
    //     //delete the product image
    //     if (!empty($product->image) && Storage::disk('legacy')->exists($product->image)) {
    //         Storage::disk('legacy')->delete($product->image);
    //     }

    //     //Delete old thumbs as per config
    //     $this->_delete_thumbs($product->image);
    //     $product->delete();
    //     return redirect()->route('admin::products.index')->with('flash_notice', 'Successfully deleted!');
    // }

    /**
     * Create Producy thumb
     *
     * @param  int  $id
     * @return Response
    */
    private function _create_thumbs($uploadImg, $uniqueHash) {

        if (!$uploadImg || !$uniqueHash) {
            return false;
        }

        //get product thumbs from  config
        $thumbs = config("legacy.legacy_image.thumbs");

        //Check need to create thumbs
        if (count($thumbs) > 0) {

            //get uploaded image data
            $imgExtenstion = $uploadImg->getClientOriginalExtension();
            $orginalImgName = $uploadImg->getClientOriginalName();

            foreach ($thumbs as $key=>$thumb) {
                //get thumb width/height
                $width = config('legacy.legacy_image.thumbs.' . $key . '.width');
                $height = config('legacy.legacy_image.thumbs.' . $key . '.height');

                if ($width && $height) {
                    $productThumb = Image::make(File::get($uploadImg))->fit($width,$height)->stream();
                    $updatedThumbName = str_replace('.' . $imgExtenstion, $uniqueHash, $orginalImgName) . '_' . $thumb['name'] . '.' . $imgExtenstion;
                    Storage::disk('legacy')->put($updatedThumbName,  $productThumb->__toString());
                }
            }

        }

    }

    /**
     * delete product thumb
     *
     * @param  int  $id
     * @return Response
    */
    // private function _delete_thumbs($image) {

    //     //Check image exist
    //     if (!$image) {
    //         return false;
    //     }

    //     //get thumbs from config
    //     $thumbs = config("legacy.legacy_image.thumbs");

    //     //Check need to create thumbs
    //     if (count($thumbs) > 0) {

    //         //get image extention
    //         $imgExt = explode('.', $image);
    //         $imgExt = end($imgExt);

    //         foreach ($thumbs as $thumb) {
    //             //get existing thumb
    //             $oldThumb = str_replace('.' . $imgExt, '', $image) . '_' . $thumb['name'] . '.' . $imgExt;

    //             //Check and delete image
    //             if (Storage::disk('legacy')->exists($oldThumb)) {
    //                 Storage::disk('legacy')->delete($oldThumb);
    //             }
    //         }
    //     }

    // }
}
