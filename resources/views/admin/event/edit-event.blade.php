@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/event') }}">Event</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('header-right')
    <a class="btn btn-primary" href="{{baseUrl('/event')}}">
            <i class="tio mr-1"></i> Back 
    </a>
@endsection

@section('content')
<?php $hours = 24; ?>
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
<style type="text/css">
.page-header-tabs {
    margin-bottom: 0px !important;
}

.hidden{
  display: none;
}

</style>
<!-- Content -->


<!-- Content -->
<div class="case-list">

  <!-- Card -->
  <div class="card">

    <div class="card-body">
        
    <form id="form" class="js-validate" action="{{ baseUrl('event/update/'.base64_encode($record->id)) }}" method="post">    
    @csrf
   
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group js-form-message">
                      <label>Event Name</label>
                      <input type="text" class="form-control" name="event_name" value="{{$record->name}}" id="event_name">
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group js-form-message">
                      <label>Event Date</label>
                      <input type="text" class="form-control @error('event_date') is-invalid @enderror" name="event_date" id="event_date" placeholder="Enter event date" aria-label="Enter Date" value="{{dateFormat($record->event_date,'d-m-Y')}}">
                      @error('event_date')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                  </div>
              </div>

            
              <div class="col-md-6">
                  <div class="form-group js-form-message">
                      <label>From time</label>
                      <input type="time" class="form-control" name="event_from_time" value="{{$record->from_time}}" id="event_from_time">
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group js-form-message">
                      <label>To time</label>
                      <input type="time" class="form-control" name="event_to_time" value="{{$record->to_time}}" id="event_to_time">
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                 <div class="form-group js-form-message">
                 <label>Description/Instruction</label>
                 <textarea name="description" id="description" class="form-control">{{$record->description}}</textarea>
                 </div>
              </div>
          </div>

        <!-- <div class="row">
            <div class="col-md-12">
               <div class="form-group js-form-message">
               <label for="is_online">Is the event online?</label>
               <input type="checkbox" value="1" name="is_online" id="is_online">
               </div>
            </div>
        </div> -->

        <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="">Location</label>
            <div class="">
            
            <select class="form-control @error('type') is-invalid @enderror" name="location" id="location" placeholder="Select location" aria-label="Enter location">
              <option value="">Select</option>
              @if(!empty($locations))
                @foreach($locations as $key=>$rec)
                <option <?php if($rec->unique_id == $record->location_id){ echo "selected"; } ?> data-type="{{$rec->type}}" value="{{$rec->unique_id}}">{{$rec->address}} ({{$rec->type}})</option>
                @endforeach
              @endif
            </select>
              @error('location')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->
          <?php $type = $record->location->type; ?>
          
          <div class="row <?php if(!empty($type) && ($type=="onsite")){ echo 'hidden'; }?> event-link">
              <div class="col-md-12">
                 <div class="form-group js-form-message">
                 <label>Event Link</label>
                 <input type="text" class="form-control" name="event_link" id="event_link">
                 </div>
              </div>
          </div>
          

          <div class="row text-center mt-4 align-items-center justify-content-center">
              <div class="col-md-3">    
                <div class="form-group">
                  <button type="submit" class="btn add-btn btn-primary">Save</button>
                </div>
              </div>
          </div>

    </form>    

    </div>

  </div>
  <!-- End Card -->

</div>
<!-- End Content -->

@endsection


@section('javascript')

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->

<script src="assets/vendor/quill/dist/quill.min.js"></script>

<script>

  
    
initEditor("description"); 

$(document).on('ready', function () {

    $('#event_date').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      startDate: "dateToday",
      todayHighlight: true,
      orientation: "bottom auto"
    });

    // $('#is_online').change(function() {
    //   if ($(this).is(':checked')) {
    //     $(".event-link").removeClass('hidden');
    //   } else {
    //     $(".event-link").addClass('hidden');
    //   }
    // });

    $("#location").change(function(){
        var tx = $(this).find(':selected').data('type');
        if(tx == "online"){
          $(".event-link").removeClass('hidden');
        }
        else{
          $(".event-link").addClass('hidden');  
        }
    });

    $("#form").submit(function(e){
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var url  = $("#form").attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
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
            if(response.error_type == 'validation')
              validation(response.message);
            else
              errorMessage(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
      
    });
  });
  
</script>
@endsection