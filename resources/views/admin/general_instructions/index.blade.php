@extends('admin.layout.master')

@section('content')



    <style>

        .form-control{

            border: 1px solid #ccc !important;
            margin-bottom: 5px !important;


        }
    </style>

    <div class="block-header">
        <h2>General Instructions</h2><br/>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">

                    <textarea name="editor1" id="editor1">
                        <?php echo $general_instructions->text; ?>
                    </textarea>

                    <button style="margin-top: 10px;" class="btn btn-success save_instructions" >Save Edits</button>

                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Table -->

    <script type="text/javascript">

        CKEDITOR.replace( 'editor1' );


    </script>



@stop
