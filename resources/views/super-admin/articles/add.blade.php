@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/article') }}">Article</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('articles') }}">
    <i class="tio mr-1"></i> Back 
</a>
@endsection


@section('content')
<!-- Content -->
<div class="articles">
  

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('articles/save') }}" method="post">
        @csrf
        <input type="hidden" name="timestamp" value="{{$timestamp}}" />
        
        <div class="form-group js-form-message">
          <label>Title</label>
          <input type="text" class="form-control" data-msg="Please enter a article title." name="title" id="title">
        </div>
        <div class="row">
          <div class="col-md-6">
           <div class="form-group js-form-message">
              <label>Category</label>
              <select name="category_id" class="form-control"  id="category_id"
              data-hs-select2-options='{
                "placeholder": "Select Category",
                "searchInputPlaceholder": "Select category"
              }'>
                <option value="">Select Category</option>
                @foreach($services as $service)
                <option value="{{$service->id}}">{{$service->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group js-form-message">
              <label>Tags</label>
              <select name="tags[]" multiple class="form-control" id="tags"
              data-hs-select2-options='{
                "placeholder": "Select Tags",
                "searchInputPlaceholder": "Select Tags"
              }'>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>


        <div class="form-group js-form-message">
          <label>Short Description</label>
          <textarea type="text" class="form-control" data-msg="Please enter short description." name="short_description" id="short_description"></textarea>
        </div>
     

        <div class="form-group js-form-message">
          <label>Content</label>
          <textarea name="description" data-msg="Please enter description." id="article_content" class="form-control editor"></textarea>
        </div>

        <div class="form-group js-form-message">
          <label>Share with</label>
          <select name="share_with" class="form-control" id="share_with"
          data-hs-select2-options='{
            "placeholder": "Select share with",
            "searchInputPlaceholder": "Select share with"
          }'>
            <option value="">Select Option</option>
            <option value="Public">Public</option>
            <option value="Private">Private</option>
          </select>
        </div>

        <!-- <div class="form-group js-form-message">
          <label>Content Block</label>
          <select name="content_block" class="form-control" id="content_block"
          data-hs-select2-options='{
            "placeholder": "Select content block",
            "searchInputPlaceholder": "Select content block"
          }'>
            <option value="">Select Content</option>
          </select>
        </div> -->
        

        <!-- <div class="form-group">
            <div class="btn-group" role="group">
               <a class="btn btn-primary"  href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i>Image</a>
            </div>
         </div> -->

        <div id="collapseOne" class="collapse show image-area" aria-labelledby="headingOne">
          
            <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
               data-hs-dropzone-options='{
                  "url": "<?php echo url('/upload-files?_token='.csrf_token()) ?>",
                  "autoProcessQueue":false,
                  "thumbnailWidth": 100,
                  "thumbnailHeight": 100,
                  "autoQueue":true,
                  "parallelUploads":20,
                  "acceptedFiles":"image/*"
               }'
            >
               <div class="dz-message custom-file-boxed-label">
                  <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                  <h5 class="mb-1">Drag and drop your file here</h5>
                  <p class="mb-2">or</p>
                  <span class="btn btn-sm btn-white">Browse files</span>
               </div>
            </div>
            <!-- End Dropzone -->
        </div>
        <div class="form-group js-form-message">
          <input type="hidden" id="no_of_images" name="images" value="" />
        </div>

        <div class="form-group">
          <button type="submit" id="submitbtn" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->
      </form>
    </div><!-- End Card body-->
  </div>
<!-- End Card -->
</div>
<!-- End Content -->

@endsection


@section('javascript')
<!-- JS Implementing Plugins -->

<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>

<script>
var is_error = false;
var fc=0;
var dropzone;
$(document).on('ready', function () {
    // $('.js-validate').each(function() {
    //   $.HSCore.components.HSValidation.init($(this));
    // });
    initEditor("article_content"); 

    dropzone = $.HSCore.components.HSDropzone.init('#attachFilesLabel');
    // dropzone.autoProcessQueue = false;
    dropzone.on("success", function(file,response) {
      if(response.status == false){
          is_error = true;
       }
    });
    dropzone.on("queuecomplete", function() {
       dropzone.options.autoProcessQueue = false; 
       saveForm();
    });
    dropzone.on("process", function () {
         dropzone.options.autoProcessQueue = true;
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
    $("#form").submit(function(e){
        e.preventDefault();
        var count= dropzone.files.length;
       
        if(count == 0){
          $("#no_of_images").val('');
        }else{
          $("#no_of_images").val(fc);
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
  

function saveForm(){
    // var formData = new FormData($("#form")[0]);
    var url  = $("#form").attr('action');
    var formData = $("#form").serialize();
    $.ajax({
      url:url,
      type:"post",
      data:formData,
      // cache: false,
      // contentType: false,
      // processData: false,
      dataType:"json",
      beforeSend:function(){
        showLoader();
      },
      success:function(response){
        hideLoader();
        if(response.status == true){
          successMessage(response.message);
          redirect(response.redirect_back);
        }else{
          validation(response.message);
        }
      },
      error:function(){
          internalError();
      }
    });
}
</script>

@endsection