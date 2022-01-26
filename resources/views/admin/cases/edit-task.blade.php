@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/cases/tasks/list/'.base64_encode($case->id)) }}"><i class="tio mr-1"></i> Back</a>

@endsection

@section('content')
<style>
.h-100 {
    height: auto !important;
}
</style>
<!-- Content -->
<div class="content container-fluid">
    
    <!-- Card -->
    <div class="card">

        <div class="card-body">
            <form method="post" id="form" class="js-validate"
                action="{{ baseUrl('/cases/tasks/edit/'.$record->unique_id) }}">
                @csrf
                <input type="hidden" name="timestamp" value="{{$timestamp}}" />
                <!-- Form Group -->
                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Task Title</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="task_title" id="task_title" placeholder="Enter Task title"
                                aria-label="Enter Task title" value="{{ $record->task_title }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Description</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <textarea type="text"
                                class="form-control ckeditor @error('description') is-invalid @enderror"
                                name="description" id="description" placeholder="Enter description"
                                aria-label="Enter description"><?php echo $record->description ?></textarea>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Files(Optionl)</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
                                data-hs-dropzone-options='{
                        "url": "<?php echo url('/upload-files?_token='.csrf_token()) ?>",
                        "autoProcessQueue":false,
                        "thumbnailWidth": 100,
                        "thumbnailHeight": 100,
                        "autoQueue":true,
                        "parallelUploads":20,
                        "acceptedFiles":"{{$ext_files}}"
                    }'>
                                <div class="dz-message custom-file-boxed-label">
                                    <img class="avatar avatar-xl avatar-4by3 mb-3"
                                        src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                                    <h5 class="mb-1">Drag and drop your file here</h5>
                                    <p class="mb-2">or</p>
                                    <span class="btn btn-sm btn-white">Browse files</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group js-form-message">
                    <input type="hidden" id="no_of_files" name="no_of_files" value="" />
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <table class="table table-bordered">
                        <?php
                        if(!empty($record->CaseTaskFiles)) {
                        $task_files = $record->CaseTaskFiles;
                        foreach($task_files as $file){
                            if(file_exists(professionalDir()."/cases/tasks/".$file->file_name)){
                    ?>
                        <tr>
                                <td>
                                    <a href='<?php echo professionalDirUrl()."/cases/tasks/".$file->file_name ?>' download>
                                        <span class="file_icon">
                                    <?php
                                        $file_icon = fileIcon(professionalDirUrl()."/cases/tasks/".$file->file_name);
                                        echo $file_icon;
                                    ?>
                                        </span>
                                        <span class="file_name">{{$file->file_name}}</span>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="javascript:;" onclick="confirmAction(this)"
                                        data-href="{{ baseUrl('cases/tasks/remove-file/'.base64_encode($file->id)) }}">
                                        <i class="tio-clear"></i>
                                    </a>
                                </td>
                        </tr>
                        <?php
                            }
                        }
                        }
                    ?>
                    </table>
                    </div>
                </div>
                <div class="row form-group js-form-message">
                    <label class="col-sm-3 col-form-label input-label">Response Type</label>
                    <div class="col-sm-9">
                        <select name="response_type">
                            <option value="">Select Option</option>
                            <option {{$record->response_type == 'textarea'?'selected':''}} value="textarea">Textarea
                            </option>
                            <option {{$record->response_type == 'file_upload'?'selected':''}} value="file_upload">File
                                Upload</option>
                        </select>
                    </div>
                </div>
               
                
                <!-- End Form Group -->
                <div class="form-group">
                    <button type="submit" class="btn add-btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('javascript')
<script src="{{asset('assets/vendor/dropzone/dist/min/dropzone.min.js')}}"></script>
<script type="text/javascript">
// initEditor("description");
var dropzone;
var fc = 0
$(document).ready(function() {
    dropzone = $.HSCore.components.HSDropzone.init('#attachFilesLabel');
    // dropzone.autoProcessQueue = false;
    dropzone.on("success", function(file,response) {
      if(response.status == false){
          is_error = true;
       }
    });
    dropzone.on("queuecomplete", function() {
       saveForm();
    });
    dropzone.on('success', function( file, resp ){
         fc++;
    });
    // dropzone.on("queuecomplete", function (file) {

    //     // saveForm();
    // });
    dropzone.on("sending", function(file, xhr, formData) { 
        formData.append("timestamp","{{$timestamp}}");
    });
    $("#form").submit(function(e) {
        e.preventDefault();
        dropzone.options.autoProcessQueue = true;
        // saveForm();

        var count= dropzone.files.length;

        if(count == 0){
          $("#no_of_files").val('');
        }else{
          $("#no_of_files").val(fc);
        }
        if(fc >= count){
           saveForm();
        }else{
          if(count > 0){
              dropzone.processQueue();
          }else{
            errorMessage("Please select some images");
          } 
        }
    });
});

function saveForm() {
    var formData = $("#form").serialize();
    var url = $("#form").attr('action');
    $.ajax({
        url: url,
        type: "post",
        data: formData,
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                successMessage(response.message);
                redirect(response.redirect);
            } else {
                validation(respoonse.message);
                // errorMessage(response.message);
            }
        },
        error: function() {
            internalError();
        }
    });
}
</script>
@endsection