@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/my-cases') }}">My Case</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
    <a class="btn btn-primary" href="{{baseUrl('/my-cases')}}">
            <i class="tio mr-1"></i> Back 
    </a>
@endsection


@section('content')
<!-- Content -->
<div class="add-case">


  <!-- Card -->
  <div class="card">

    <div class="card-body">
     <!-- Step Form -->
      <form id="form" class="js-validate js-step-form"
         data-hs-step-form-options='{
         "progressSelector": "#createProjectStepFormProgress",
         "stepsSelector": "#createProjectStepFormContent",
         "endSelector": "#createProjectFinishBtn",
         "isValidate": true
         }' action="{{baseUrl('my-cases/save')}}">
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
                     <span class="step-title">Visa Services</span>
                  </div>
               </a>
            </li>
           
         </ul>
         <!-- End Step -->
         <!-- Content Step Form -->
         <div id="createProjectStepFormContent">
            <div id="createProjectStepDetails" class="active">
             
               <!-- Form Group -->
               <div class="form-group js-form-message">
                  <label class="input-label">Case Title</label>
                  <div class="input-group input-group-merge">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-briefcase-outlined"></i>
                        </div>
                     </div>
                     <input type="text" required data-msg="Please enter case title" class="form-control" name="case_title" id="case_title" placeholder="Enter case title here" aria-label="Enter case title here" >
                  </div>
               </div>
               <!-- End Form Group -->
          
               <div class="form-group js-form-message">
                  <label class="input-label">Description <span class="input-label-secondary">(Optional)</span></label>
                  <textarea class="form-control" id="description" name="description"></textarea>
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
                     <div class="js-form-message form-group">
                        <div class="row">
                            <div class="col-md-4">
                               <label class="input-label font-weight-bold mt-2">Visa Service</label>
                            </div>
                            <div class="col-md-8">
                              <select name="visa_service_id" required data-msg="Please select visa service" id="visa_service_id" class="custom-select"
                                  data-hs-select2-options='{
                                    "placeholder": "Select Visa Service"
                                  }'
                                >
                                <option value="">Select Service</option>
                                @foreach($visa_services as $service)
                                  @if(!empty($service->name))
                                    <option  data-price="{{$service->price}}" value="{{$service->unique_id}}">{{$service->name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                        </div>
                      </div>
                  </div>
               </div>
               <!-- End Form Row -->
               <!-- Form Row -->
               
               <!-- End Form Row -->
               
               <!-- Footer -->
               <div class="d-sm-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createProjectStepDetails"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="d-flex justify-content-end ml-auto">
                     <a href="{{ baseUrl('my-cases') }}" class="btn btn-white mr-2">Cancel</a>
                     <button id="createProjectFinishBtn" type="button" class="btn btn-primary">Create Case</button>
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
      var price = $("#visa_service_id").find("option:selected").attr("data-price")
      $("#visa_service_text").html(text.trim());
      if(price == 0){
        $("#service_charge").html("Free");
      }else{
        $("#service_charge").html("{{ currencyFormat()}}"+price);
      }
     
    }else{
      $("#visa_service_text").html('');
    }
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