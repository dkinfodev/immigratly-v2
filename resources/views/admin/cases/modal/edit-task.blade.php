<style>
.invalid-feedback {
    position: absolute;
    bottom: -20px;
}
</style>

<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <div class="imm-modal-slanted-div angled lower-start">
          <div class="row">
            <div class="col-10">
              <h3 class="modal-title" id="exampleModalLongTitle">{{$pageTitle}}</h3>
            </div>
           <div class="col-2" style="text-align:right"> 
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal-body imm-education-modal-body">
      <form method="post" id="popup-form" class="js-validate"
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

                <!-- <div class="row form-group js-form-message">
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
                </div> -->
                <div class="form-group js-form-message">
                    <input type="hidden" id="no_of_files" name="no_of_files" value="" />
                </div>
                <!-- End Form Group -->

            </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" type="submit" class="btn btn-primary">Save</button>
    </div>

  </div>
</div>


<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
initEditor("description");
var dropzone;
$(document).ready(function() {
    // dropzone = $.HSCore.components.HSDropzone.init('#attachFilesLabel');
    // // dropzone.autoProcessQueue = false;
    // dropzone.on("success", function(file,response) {
    //   if(response.status == false){
    //       is_error = true;
    //    }
    // });
    // dropzone.on("queuecomplete", function() {
    //    dropzone.options.autoProcessQueue = false; 
    //    saveForm();
    // });
    // dropzone.on("process", function () {
    //      dropzone.options.autoProcessQueue = true;
    // });
    // dropzone.on('success', function( file, resp ){
    //      fc++;
    // });
    // // dropzone.on("queuecomplete", function (file) {
        
    // //     // saveForm();
    // // });
    // dropzone.on("sending", function(file, xhr, formData) { 
    //     formData.append("timestamp","{{$timestamp}}");
    // });
    $("#popup-form").submit(function(e){
        e.preventDefault();
        saveForm();
        // var count= dropzone.files.length;
       
        // if(count == 0){
        //   $("#no_of_files").val('');
        // }else{
        //   $("#no_of_files").val(fc);
        // }
        // if(fc >= count){
        //    saveForm();
        // }else{
        //   if(count > 0){
        //       dropzone.processQueue();
        //   }else{
        //     errorMessage("Please select some images");
        //   } 
        // }
    });
});

function saveForm(){
    var formData = $("#popup-form").serialize();
    var url = $("#popup-form").attr('action');
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
                closeModal();
                location.reload();
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