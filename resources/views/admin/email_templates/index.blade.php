@extends('admin.layout.master')

@section('content')



    <style>

        .form-control{

            border: 1px solid #ccc !important;
            margin-bottom: 5px !important;


        }
    </style>

    <div class="block-header">
        <h2>All Email Template</h2><br/>
    </div>
    <!-- Basic Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body table-responsive">

                    <h4>Guest Email Template</h4><br/>

                    <label>Guest Email Subject</label><br/>
                    <input type="text" id="temp1_subject" class="form-control" value="{{ $email_template_1->subject }}"><br/>


                    <textarea name="editor2" id="editor2">
                        <?php echo $email_template_1->text; ?>
                    </textarea>

                    <button style="margin-top: 10px;" class="btn btn-success save_email_template_1" >Save Guest Email Text</button>

                </div>
            </div>

            <div class="card">
                <div class="body table-responsive">

                    <h4>Changes Submission to Staff Email</h4><br/>

                    <label>Guest Staff Subject</label><br/>
                    <input type="text" id="temp2_subject" class="form-control" value="{{ $email_template_2->subject }}"><br/>



                    <textarea name="editor3" id="editor3">
                        <?php echo $email_template_2->text; ?>
                    </textarea>

                    <button style="margin-top: 10px;" class="btn btn-success save_email_template_2" >Save Staff Email Text</button>

                </div>
            </div>

            <div class="card">
                <div class="body table-responsive">

                    <h4>Changes Approved Email</h4><br/>

                    <label>Changes Approval Email Subject</label><br/>
                    <input type="text" id="temp3_subject" class="form-control" value="{{ $email_template_3->subject }}"><br/>



                    <textarea name="editor4" id="editor4">
                        <?php echo $email_template_3->text; ?>
                    </textarea>

                    <button style="margin-top: 10px;" class="btn btn-success save_email_template_3" >Save Approval Email Text</button>

                </div>
            </div>

            <div class="card">
                <div class="body table-responsive">

                    <h4>Event Email</h4><br/>

                    <label>Event Email Subject</label><br/>
                    <input type="text" id="temp4_subject" class="form-control" value="{{ $email_template_4->subject }}"><br/>



                    <textarea name="editor5" id="editor5">
                        <?php echo $email_template_4->text; ?>
                    </textarea>

                    <button style="margin-top: 10px;" class="btn btn-success save_email_template_4" >Save Event Email Text</button>

                </div>
            </div>

            <div class="card">
                <div class="body table-responsive">

                    <h4>Event Changes Email</h4><br/>

                    <label>Event Changes Email Subject</label><br/>
                    <input type="text" id="temp5_subject" class="form-control" value="{{ $email_template_5->subject }}"><br/>



                    <textarea name="editor6" id="editor6">
                        <?php echo $email_template_5->text; ?>
                    </textarea>

                    <button style="margin-top: 10px;" class="btn btn-success save_email_template_5" >Save Event Changes Email Text</button>

                </div>
            </div>

        </div>
    </div>
    <!-- #END# Basic Table -->

    <script type="text/javascript">

        CKEDITOR.replace( 'editor2' );
        CKEDITOR.replace( 'editor3' );
        CKEDITOR.replace( 'editor4' );
        CKEDITOR.replace( 'editor5' );
        CKEDITOR.replace( 'editor6' );


    </script>



@stop
