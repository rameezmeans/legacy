@extends('admin.layout.master')

@section('content')
<div class="block-header">
    <h2>Edit Yacht/h2>
</div>
<!-- Error messages -->
<!-- Validation Error messages -->
@if (count($errors) > 0)

    <div class="alert alert-danger">
        <ul>

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>
    </div>

@endif
<!-- End of Validation Error messages -->
<!-- End of Error messages -->
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                 {!! Form::model($product, array('method' => 'PATCH', 'action' => array('App\Http\Controllers\Admin\ProductController@update', $product, $product->id))) !!}
                  {!! Form::hidden('p_id', 1, array('class' => 'form-control', 'required' => 'required')) !!}
                     <label for="Yacht">Yacht Name*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('product_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                   <!--  <label for="Description">Description*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::textarea('description', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Image">Image*</label>
                    <div class="form-group">
                        <div class="form-line">
                            <?php
                            //get config values
                            $maxUploadSize = Config::get("legacy.max_upload_size");
    						$minImgWidth = Config::get("legacy.legacy_image.min_width");
                            $minImgHeight = Config::get("legacy.legacy_image.min_height");
                            $imgPreferedSize = Config::get("legacy.legacy_image.prefered_size");
                            ?>

                            {!! Form::file('image', array('class' => 'imgUpload', 'max_upload_size' => $maxUploadSize)) !!}

                            <small>(Leave empty this field if don't want to update image)</small>

                            @if ($maxUploadSize || $imgPreferedSize || $minImgWidth || $minImgHeight)
    							<br>
    							<small>
    								(
    									@if ($maxUploadSize) Max upload size is {{ $maxUploadSize }}MB. @endif
    									@if ($imgPreferedSize) Preferred image size is {{ $imgPreferedSize }}. @endif
    									@if ($minImgWidth) Minimum width of the image should be {{ $minImgWidth }}px. @endif
    									@if ($minImgHeight) Minimum height of the image should be {{ $minImgHeight }}px. @endif
    								)
    							</small>
    						@endif
                        </div>
                    </div> -->
                    <label for="Price">Default Price*</label>
                    <div class="form-group">
                        <div class="form-line">
                            {!! Form::text('default_price', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        </div>
                    </div>
                    <label for="Service">Status*</label>
                    {!! Form::select('status', ['Y' => 'Enable', 'N' => 'Disable'], null, array('class' => 'fform-control show-tick')) !!}
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" value="Update">Update</button>
                    <a class="btn btn-primary m-t-15 waves-effect" href="{{ route('admin::products.index') }}">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
