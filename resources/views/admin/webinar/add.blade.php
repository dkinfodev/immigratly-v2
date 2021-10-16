@extends('layouts.master')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div> 
<!-- End Content -->
@endsection
@section('content')
<style type="text/css">
.tplist .tp_field {
    margin-top: 10px;
    padding-bottom: 12px;
}
.topic_list_area > .tp_field > .js-tp-delete-field{
  display: none;
}
</style>
<!-- Content -->
<div class="webinar">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/webinar') }}">Webinar</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ baseUrl('webinar') }}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('webinar/save') }}" method="post">
        @csrf
        <input type="hidden" name="timestamp" value="{{$timestamp}}" />
        
        <div class="form-group js-form-message">
          <label>Title</label>
          <input type="text" class="form-control" data-msg="Please enter a article title." name="title" id="title">
        </div>
        <div class="row">
          <div class="col-md-4">
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
          <div class="col-md-4">
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
          <div class="col-md-4">
           <div class="form-group js-form-message">
              <label>Language</label>
              <select name="language_id" class="form-control"  id="language_id"
              data-hs-select2-options='{
                "placeholder": "Select Language",
                "searchInputPlaceholder": "Select language"
              }'>
                <option value="">Select Language</option>
                @foreach($languages as $language)
                <option value="{{$language->id}}">{{$language->name}}</option>
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
        <div class="row">
          <div class="col-md-6">
            <div class="form-group js-form-message">
              <label>Level</label>
              <select name="level" class="form-control" id="level"
              data-hs-select2-options='{
                "placeholder": "Select Level",
                "searchInputPlaceholder": "Select Level"
              }'>
                <option value="">Select Level</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advance">Advance</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group js-form-message">
              <label>Total Seats</label>
              <input type="text" name="total_seats" class="js-masked-input form-control" id="total_seats" placeholder="No of Seats">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group js-form-message">
              <label>Webinar Date</label>
              <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                 <div class="input-group-prepend" data-toggle>
                    <div class="input-group-text">
                       <i class="tio-date-range"></i>
                    </div>
                 </div>
                 <input data-msg="Please select start date" type="text" name="webinar_date" class="flatpickr-custom-form-control form-control" id="webinar_date" placeholder="Select Webinar Date" data-input value="">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group js-form-message">
              <label>Start Time</label>
              <input type="text" class="form-control" name="start_time" id="start_time">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group js-form-message">
              <label>End Time</label>
              <input type="text" class="form-control" name="end_time" id="end_time">
            </div>
          </div>
        </div>
        <div class="form-group js-form-message">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" id="paid_event" name="paid_event" value="1" class="custom-control-input">
            <label class="custom-control-label" for="paid_event">Paid Event</label>
          </div>
        </div>
        <div class="row paid_event_section" style="display:none">
          <div class="col-md-6">
            <div class="form-group js-form-message">
              <label>Event Cost</label>
              <input type="text" disabled class="form-control" name="event_cost" placeholder="Event Cost" id="event_cost">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group js-form-message">
              <label>Price Group</label>
              <select name="price_group" disabled class="form-control" id="price_group"
              data-hs-select2-options='{
                "placeholder": "Select Price Group",
                "searchInputPlaceholder": "Select Price Group"
              }'>
                <option value="">Select Price Group</option>
                <option value="Per Person">Per Person</option>
                <option value="Per Group">Per Group</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group js-form-message">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" id="offline_event" name="offline_event" value="1" class="custom-control-input">
            <label class="custom-control-label" for="offline_event">Offline Event</label>
          </div>
        </div>
        <div class="row online_event_section">
          <div class="col-md-12">
            <div class="form-group js-form-message">
              <label>Online Event Link</label>
              <input type="text" class="form-control" name="online_event_link" placeholder="Add the online link of event to attend" id="online_event_link">
            </div>
          </div>
        </div>
        <div class="row offline_event_section" style="display:none">
          <div class="col-md-12">
            <div class="form-group js-form-message">
              <label>Address</label>
              <textarea type="text" disabled class="form-control" name="address" placeholder="Address of event" id="address"></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group js-form-message">
              <label>Country</label>
              <select name="country_id" disabled onchange="stateList(this.value,'state_id')" class="form-control" id="country_id"
              data-hs-select2-options='{
                "placeholder": "Select Country",
                "searchInputPlaceholder": "Select Country"
              }'>
                <option value="">Select Country</option>
                @foreach($countries as $country)
                <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group js-form-message">
              <label>State</label>
              <select name="state_id" disabled onchange="cityList(this.value,'city_id')" class="form-control" id="state_id"
              data-hs-select2-options='{
                "placeholder": "Select State",
                "searchInputPlaceholder": "Select State"
              }'>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group js-form-message">
              <label>City</label>
              <select name="city_id" disabled class="form-control" id="city_id"
              data-hs-select2-options='{
                "placeholder": "Select City",
                "searchInputPlaceholder": "Select City"
              }'>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group js-form-message">
          <label>Topics</label>
        </div>
        <div class="js-add-field"
             data-hs-add-field-options='{
                "template": "#addTopicItemTemplate",
                "container": "#addTopicContainer",
                "defaultCreated": 1
              }'>
            <!-- Title -->
            <div class="bg-light border-bottom p-2 mb-3">
              <div class="row">
                <div class="col-sm-6">
                  <h6 class="card-title text-cap">Topic Name</h6>
                </div>
                <div class="col-sm-6 d-none d-sm-inline-block">
                  <h6 class="card-title text-cap">Topic List</h6>
                </div>
              </div>
            </div>

            <!-- Container For Input Field -->
            <div id="addTopicContainer"></div>

            <a href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
              <i class="tio-add"></i> Add Topic Group
            </a>

            <!-- Add Phone Input Field -->
            <div id="addTopicItemTemplate" class="item-row" style="display: none;">
              <!-- Content -->
              <div class="input-group-add-field">
                <div class="row">
                  <div class="col-md-6 js-form-message">
                    <input type="text" class="form-control mb-3 topic_name" placeholder="Topic Name" aria-label="Topic Name">
                  </div>
                  <div class="col-md-6 js-form-message topic_list_area">
                    <div class="tp_field">
                      <input type="text" class="form-control mb-3 topic_list" placeholder="Topic List">
                      <a onclick="removeTopicList(this)" class="text-danger float-right js-tp-delete-field" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Remove Topic List">
                        Remove Sub Topic
                      </a>
                      <div class="clearfix"></div>
                    </div>
                    <div class="tplist"></div>
                    <a href="javascript:;" class="add-topic-list badge badge-pill badge-secondary">
                      <i class="tio-add"></i> Add Sub Topic
                    </a>
                  </div>
                </div>
                <a class="js-delete-field input-group-add-field-delete" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Remove item">
                  <i class="tio-clear"></i>
                </a>
              </div>
            </div>
            <!-- End Add Phone Input Field -->
        </div>
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
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script>
var is_error = false;
var fc=0;
var dropzone;
$(document).on('ready', function () {
    $('.js-masked-input').each(function () {
      $.HSCore.components.HSMask.init($(this));
    });

    $('.js-add-field').each(function () {
    new HSAddField($(this), {
      addedField: function() {
        var index = randomNumber();
        $("#addTopicContainer > .item-row:last").find(".topic_name").attr("name","topics["+index+"][topic_name]");
        $("#addTopicContainer > .item-row:last").find(".topic_name").attr("required","true");
        $("#addTopicContainer > .item-row:last").find(".topic_list").attr("name","topics["+index+"][topic_list][]");
        $("#addTopicContainer > .item-row:last").find(".topic_list").attr("required","true");

        $('[data-toggle="tooltip"]').tooltip();
        $(".add-topic-list").click(function(){
          var field = $(this).parents(".topic_list_area").find(".tp_field:last").clone();
          $(this).parents(".topic_list_area").find(".tplist").append(field);
          $(this).parents(".topic_list_area").find(".tplist .tp_field:last .topic_list").val('');  
        });
      },
      deletedField: function() {
        $('.tooltip').hide();
      }
    }).init();
  });
  $("#offline_event").change(function(){
    if($(this).is(":checked")){
      $(".offline_event_section").show();
      $(".offline_event_section .form-control").removeAttr("disabled");
      $(".online_event_section").hide();
      $(".online_event_section .form-control").attr("disabled","disabled");

    }else{
      $(".offline_event_section").hide();
      $(".offline_event_section .form-control").attr("disabled","disabled");
      $(".online_event_section .form-control").removeAttr("disabled");
      $(".online_event_section").show();
    }
  });
  $("#paid_event").change(function(){
    if($(this).is(":checked")){
      $(".paid_event_section").show();
      $(".paid_event_section .form-control").removeAttr("disabled");
    }else{
      $(".paid_event_section").hide();
      $(".paid_event_section .form-control").attr("disabled","disabled");
    }
  });
  $('#start_time').datetimepicker({
       icons:
       {
           up: 'fa fa-angle-up',
           down: 'fa fa-angle-down'
       },
       format: 'LT',
   });

   $('#end_time').datetimepicker({
       icons:
       {
           up: 'fa fa-angle-up',
           down: 'fa fa-angle-down'
       },
       format: 'LT',
   });
    var date = new Date();
    date.setDate(date.getDate()); 
    var attr = $("#webinar_date").attr('date-format');
    var format ="dd-mm-yyyy";
    if (typeof attr !== typeof undefined && attr !== false) {
      format = $("#webinar_date").attr("date-format");
    }
    $('#webinar_date').datepicker({
      format:format,
      startDate:date
      // orientation: 'bottom auto',
    });
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
function removeTopicList(e){
  var len = $(e).parents(".topic_list_area").find(".tp_field").length;
  if(len > 1){
    $(e).parents(".tp_field").remove();
  }

}

function saveForm(){
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
          $('html, body').animate({
              scrollTop: $(".invalid-feedback").offset().top - 150
          }, 500);
        }
      },
      error:function(){
          internalError();
      }
    });
}
function stateList(country_id,id){
    $.ajax({
        url:"{{ url('states') }}",
        data:{
          country_id:country_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
        },
        success:function(response){
          if(response.status == true){
            $("#"+id).html(response.options);
          } 
        },
        error:function(){
           
        }
    });
}
function cityList(state_id,id){
    $.ajax({
        url:"{{ url('cities') }}",
        data:{
          state_id:state_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
        },
        success:function(response){
          if(response.status == true){
            $("#"+id).html(response.options);
          } 
        },
        error:function(){
           
        }
    });
}
</script>

@endsection