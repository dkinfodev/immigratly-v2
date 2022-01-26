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
<a class="btn btn-primary" href="{{baseUrl('/cases')}}">
   <i class="tio mr-1"></i> Back 
</a>
@endsection

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

                <div class="col-auto">
                  <a class="btn btn-primary" href="{{baseUrl('/cases')}}">
                    <i class="tio mr-1"></i> Back 
                  </a>
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
<!-- Content -->
<div class="cases">
  

  <!-- Card -->
  <div class="card">

    <div class="card-body">
     <!-- Step Form -->
      <form id="form" action="{{ baseUrl('cases/update/'.base64_encode($record->id)) }}" class="js-validate js-step-form"
         data-hs-step-form-options='{
         "progressSelector": "#createProjectStepFormProgress",
         "stepsSelector": "#createProjectStepFormContent",
         "endSelector": "#createProjectFinishBtn",
         "isValidate": true
         }'>
         @csrf
         <!-- Step -->
         <ul id="createProjectStepFormProgress" class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createProjectStepDetails"
                  }'>
                  <span class="step-icon step-icon-soft-dark">1</span>
                  <div class="step-content">
                     <span class="step-title">Case Detail</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createProjectStepTerms"
                  }'>
                  <span class="step-icon step-icon-soft-dark">2</span>
                  <div class="step-content">
                     <span class="step-title">Assigned Staff</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createProjectStepMembers"
                  }'>
                  <span class="step-icon step-icon-soft-dark">3</span>
                  <div class="step-content">
                     <span class="step-title">Confirmation
                     </span>
                  </div>
               </a>
            </li>
         </ul>
         <!-- End Step -->
         <!-- Content Step Form -->
         <div id="createProjectStepFormContent">
            <div id="createProjectStepDetails" class="active">
              
               <!-- Form Group -->
               <div class="form-group">
                  <label for="clientNewProjectLabel" class="input-label">Client</label>
                  <div class="form-row align-items-center">
                     <div class="col-12 col-md-7 mb-3">
                        <div class="form-group js-form-message mb-0">
                            <!-- Select -->
                            <div class="select2-custom">
                               <select class="js-select2-custom" required name="client_id" id="client_id"
                                data-hs-select2-options='{
                                  "placeholder": "Select Client"
                                }'
                               >
                                  <option value="">Select Client</option>
                                  @foreach($clients as $client)
                                  <option {{ ($record->client_id == $client->unique_id)?'selected':'' }} value="{{$client->unique_id}}">
                                    {{$client->first_name." ".$client->last_name}}
                                  </option>
                                  @endforeach
                               </select>
                            </div>
                            <!-- End Select -->
                         </div>
                     </div>
                     <span class="col-auto">or</span>
                     <div class="col-md mb-md-3">
                        <a class="btn btn-white" onclick="showPopup('<?php echo baseUrl('cases/create-client') ?>')" href="javascript:;">
                        <i class="tio-add mr-1"></i>New client
                        </a>
                     </div>
                  </div>
               </div>
               <!-- End Form Group -->
               <!-- Form Group -->
               <div class="form-group js-form-message">
                  <label class="input-label">Case Title</label>
                  <div class="input-group input-group-merge">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-briefcase-outlined"></i>
                        </div>
                     </div>
                     <input type="text" value="{{ $record->case_title }}" required data-msg="Please enter case title" class="form-control" name="case_title" id="case_title" placeholder="Enter case title here" aria-label="Enter case title here">
                  </div>
               </div>
               <!-- End Form Group -->
               <div class="row">
                  <div class="col-sm-4">
                     <!-- Form Group -->
                     <div class="form-group js-form-message">
                        <label class="input-label">Start date</label>
                        <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                           <div class="input-group-prepend" data-toggle>
                              <div class="input-group-text">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                           <input required data-msg="Please select start date" type="text" value="{{ $record->start_date }}" name="start_date" class="flatpickr-custom-form-control form-control" id="start_date" placeholder="Select Start Date" data-input value="">
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-4">
                     <!-- Form Group -->
                     <div class="form-group js-form-message">
                        <label class="input-label">End date</label>
                        <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                           <div class="input-group-prepend" data-toggle>
                              <div class="input-group-text">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                           <input type="text" value="{{ $record->end_date }}" data-msg="Please select end date" name="end_date" class="flatpickr-custom-form-control form-control" id="end_date" placeholder="Select End Date" data-input value="">
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-4">
                     <div class="js-form-message form-group">
                        <label class="input-label font-weight-bold">Visa Service</label>
                        <select name="visa_service_id" required data-msg="Please select visa service" id="visa_service_id" class="custom-select"
                          data-hs-select2-options='{
                            "placeholder": "Select Visa Service"
                          }'
                        >
                          <option value="">Select Service</option>
                          @foreach($visa_services as $service)
                            @if(!empty($service->Service($service->service_id)))
                              <option {{ ($record->visa_service_id == $service->unique_id)?'selected':'' }} value="{{$service->unique_id}}">{{$service->Service($service->service_id)->name}} </option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                  </div>
               </div>
               <div class="form-group js-form-message">
                  <label class="input-label">Description <span class="input-label-secondary">(Optional)</span></label>
                  <textarea class="form-control" id="description" name="description"><?php echo $record->description ?></textarea>
               </div>
               
              
               <!-- Footer -->
               <div class="d-flex align-items-center">
                  <div class="ml-auto">
                     <button type="button" class="btn btn-primary"
                        data-hs-step-form-next-options='{
                        "targetSelector": "#createProjectStepTerms"
                        }'>
                     Next <i class="tio-chevron-right"></i>
                     </button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
            <div id="createProjectStepTerms" style="display: none;">
               <!-- Form Row -->
               <div class="row">
                  <div class="col-sm-6">
                      <!-- Form Group -->
                      <?php 
                            $ids = array();
                            if(!empty($assignedMember)){
                              foreach($assignedMember as $team){
                                $ids[] = $team->user_id;
                              }
                            }
                          ?>
                      <div class="js-form-message form-group">
                        <label class="input-label font-weight-bold">Assign Staffs</label>
                        <select name="assign_teams[]" id="assign_teams" multiple class="custom-select"
                          data-hs-select2-options='{
                            "minimumResultsForSearch": "Infinity",
                            "singleMultiple": true,
                            "placeholder": "Select Team members"
                          }'
                        >
                          
                          <option value="" disabled>Select Team</option>
                          @foreach($staffs as $staff)
                            <option {{ in_array($staff->unique_id,$ids)?'selected':'' }} data-name="{{$staff->first_name.' '.$staff->last_name}}" data-role="{{ $staff->role }}" value="{{$staff->unique_id}}">{{$staff->first_name.' '.$staff->last_name}} ({{$staff->role}})</option>
                          @endforeach
                        </select>
                      </div>
                     <!-- End Form Group -->
                  </div>
               </div>
               <!-- End Form Row -->
               <!-- Form Row -->
               
               <!-- End Form Row -->
               
               <!-- Footer -->
               <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createProjectStepDetails"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="ml-auto">
                     <button type="button" class="btn btn-primary"
                        data-hs-step-form-next-options='{
                        "targetSelector": "#createProjectStepMembers"
                        }'>
                     Next <i class="tio-chevron-right"></i>
                     </button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
            <div id="createProjectStepMembers" style="display: none;">
              
               <div class="row">
                  <div class="col-lg-12 text-center">
                     <h2>Confirm Details</h2>
                     <div class="confirm-details row">
                        <div class="col-md-6 text-left">
                          <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                            <li class="py-0">
                              <small class="card-subtitle">Case Details</small>
                            </li>
                            <li>
                              <i class="tio-user-outlined nav-icon"></i>
                              Client: <span id="client_name_text">
                                  @if(!empty($record->Client($record->client_id)))
                                  <?php
                                  $client = $record->Client($record->client_id);
                                  ?>
                                  {{$client->first_name." ".$client->last_name}}
                                  @else
                                  Client not found
                                  @endif
                              </span> 
                            </li>
                            <li>
                              <i class="tio-briefcase-outlined nav-icon"></i>
                              Case Title: <span id="case_title_text">{{$record->case_title}}</span>
                            </li>
                            <li>
                              <i class="tio-date-range nav-icon"></i>
                              Start Date: <span id="start_date_text">{{$record->start_date}}</span>
                            </li>
                            <li>
                              <i class="tio-date-range nav-icon"></i>
                              End Date: <span id="end_date_text">{{$record->end_date}}</span>
                            </li>
                            <li>
                              <i class="tio-layers-outlined  nav-icon"></i> 
                              Visa Service: <span id="visa_service_text">
                              @if(!empty($record->Service($record->VisaService->service_id)))
                              {{$record->Service($record->VisaService->service_id)->name}}
                              @else
                              Service Removed
                              @endif
                              </span>
                            </li>
                          </ul>
                        </div>
                        <div class="col-md-6 text-left" id="assign_staff_list" style="display:{{ !empty($assignedMember)?'block':'none' }}">
                          <ul class="nav card-nav card-nav-vertical nav-pills">
                              <li class="py-0 text-left">
                                <small class="card-subtitle">Team Members</small>
                              </li>
                              @if(!empty($assignedMember))
                              @foreach($assignedMember as $member)
                              <li class="text-left staff">
                                <a class="nav-link media" href="#">
                                  <i class="tio-group-senior nav-icon text-dark"></i>
                                  <span class="media-body">
                                    <span class="d-block text-dark">{{$member->Member->first_name." ".$member->Member->last_name}}</span>
                                    <small class="d-block text-muted">{{$member->Member->role}}</small>
                                  </span>
                                </a>
                              </li>
                              @endforeach
                              @endif
                          </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End Toggle Switch -->
               <!-- Footer -->
               <div class="d-sm-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createProjectStepTerms"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="d-flex justify-content-end ml-auto">
                     <a href="{{ baseUrl('cases') }}" class="btn btn-white mr-2">Cancel</a>
                     <button id="createProjectFinishBtn" type="button" class="btn btn-primary">Update Case</button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
         </div>
         <!-- End Content Step Form -->
         <!-- Message Body -->
         
         <!-- End Message Body -->
      </form>
      <!-- End Step Form -->
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
<script type="text/javascript">
initEditor("description"); 
$(document).on('ready', function () {
  $("#client_id").change(function(){
    if($(this).val() != ''){
      var text = $("#client_id").find("option:selected").text();
      $("#client_name_text").html(text.trim());
    }else{
      $("#client_name_text").html('');
    }
  });
  $("[name=case_title]").change(function(){
    if($(this).val() != ''){
      $("#case_title_text").html($(this).val());
    }else{
      $("#case_title_text").html('');
    }
  });
  $("[name=start_date]").change(function(){
    if($(this).val() != ''){
      $("#start_date_text").html($(this).val());
    }else{
      $("#start_date_text").html('');
    }
  });
  $("[name=end_date]").change(function(){
    if($(this).val() != ''){
      $("#end_date_text").html($(this).val());
    }else{
      $("#end_date_text").html('');
    }
  });
  $("#visa_service_id").change(function(){
    if($(this).val() != ''){
      var text = $("#visa_service_id").find("option:selected").text();
      $("#visa_service_text").html(text.trim());
    }else{
      $("#visa_service_text").html('');
    }
  });
  $("#assign_teams").change(function(){
    if($("#assign_teams").val() != ''){
      var html = '';
      $("#assign_staff_list").show();
      $(".staff").remove();
      $("#assign_teams").find("option:selected").each(function(){
          var text = $(this).attr('data-name');
          var role = $(this).attr('data-role');

          html +='<li class="text-left staff">';
          html +='<a class="nav-link media" href="javascript:;">';
          html +='<i class="tio-group-senior nav-icon text-dark"></i>';
          html +='<span class="media-body">';
          html +='<span class="d-block text-dark">'+text.trim()+'</span>';
          html +='<small class="d-block text-muted">'+role+'</small>';
          html +='</span></a></li>';
      });
      $("#assign_staff_list ul").append(html);
    }else{
      $("#assign_staff_list").hide();
      $("#assign_staff_list .staff").remove();
    }
  });
  $('#start_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('#end_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });
  $('.js-step-form').each(function () {
     var stepForm = new HSStepForm($(this), {
       validate: function(){
       },
       finish: function() {
         // $("#createProjectStepFormProgress").hide();
         // $("#createProjectStepFormContent").hide();
         // $("#createProjectStepSuccessMessage").show();
        var formData = $("#form").serialize();
        var url  = $("#form").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
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
                // errorMessage(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
       }
     }).init();
   });
  $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
          url:url,
          type:"post",
          data:formData,
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
              // errorMessage(response.message);
            }
          },
          error:function(){
            internalError();
          }
      });
  });
});
function stateList(country_id,id){
    $.ajax({
        url:"{{ url('states') }}",
        data:{
          country_id:country_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
           $("#city").html('');
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