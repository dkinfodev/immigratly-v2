@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
<style type="text/css">
.page-header-tabs {
    margin-bottom: 0px !important;
}
</style>
@endsection

@section('content')

<!-- Content -->
<div class="bg-dark">
  <div class="content container-fluid" style="height: 25rem;">
    <!-- Page Header -->
    <div class="page-header page-header-light">
      <div class="row align-items-center">
        <div class="col">
          <h1 class="page-header-title">{{$pageTitle}}</h1>
        </div>
      </div>
      <!-- End Row -->

      <!-- Nav Scroller -->
      <div class="js-nav-scroller hs-nav-scroller-horizontal">
        <span class="hs-nav-scroller-arrow-prev hs-nav-scroller-arrow-dark-prev" style="display: none;">
          <a class="hs-nav-scroller-arrow-link" href="javascript:;">
            <i class="tio-chevron-left"></i>
          </a>
        </span>

        <span class="hs-nav-scroller-arrow-next hs-nav-scroller-arrow-dark-next" style="display: none;">
          <a class="hs-nav-scroller-arrow-link" href="javascript:;">
            <i class="tio-chevron-right"></i>
          </a>
        </span>

        <!-- Nav -->
        <ul class="nav nav-tabs nav-tabs-light page-header-tabs" id="pageHeaderTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="javascript:;">Assessment</a>
          </li>
        </ul>
        <!-- End Nav -->
      </div>
      <!-- End Nav Scroller -->
    </div>
    <!-- End Page Header -->
  </div>
</div>
<!-- End Content -->


<!-- Content -->
<div class="content container-fluid" style="margin-top: -17rem;">
  <!-- Card -->
  <div class="card mb-3 mb-lg-5" style="padding:30px;">
    <!-- Header -->
{{--
    <!-- Step Form -->
    <form id="form" class="js-step-form js-validate"
    data-hs-step-form-options='{
    "progressSelector": "#validationFormProgress",
    "stepsSelector": "#validationFormContent",
    "endSelector": "#validationFormFinishBtn",
    "isValidate": true
  }'>
  @csrf
  <!-- Step -->
  <ul id="validationFormProgress" class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
    <li class="step-item">
      <a class="step-content-wrapper" href="javascript:;"
        data-hs-step-form-next-options='{
        "targetSelector": "#validationFormCaseInfo"
      }'>
      <span class="step-icon step-icon-soft-dark">1</span>
      <div class="step-content">
        <span class="step-title">Case Information</span>
      </div>
    </a>
  </li>

  <li class="step-item">
    <a class="step-content-wrapper" href="javascript:;"
    data-hs-step-form-next-options='{
    "targetSelector": "#validationFormPayment"
  }'>
  <span class="step-icon step-icon-soft-dark">2</span>
  <div class="step-content">
    <span class="step-title">Payment</span>
  </div>
  </a>
  </li>

  <li class="step-item">
    <a class="step-content-wrapper" href="javascript:;"
    data-hs-step-form-next-options='{
    "targetSelector": "#validationFormVisaDocument"
  }'>
  <span class="step-icon step-icon-soft-dark">3</span>
  <div class="step-content">
    <span class="step-title">Visa Documents</span>
  </div>
  </a>
  </li>

  <li class="step-item">
    <a class="step-content-wrapper" href="javascript:;"
    data-hs-step-form-next-options='{
    "targetSelector": "#validationFormAdditional"
  }'>
  <span class="step-icon step-icon-soft-dark">4</span>
  <div class="step-content">
    <span class="step-title">Additional Comments</span>
  </div>
  </a>
  </li>

</ul>
<!-- End Step -->

<!-- Content Step Form -->
<div id="validationFormContent">
  <div id="validationFormCaseInfo" class="active">


  <div class="row justify-content-md-between">
    <div class="col-md-6">
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Case Name</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="text" class="form-control" name="case_name" id="case_name" placeholder="Ente Case Name" aria-label="Case Name" required data-msg="Please enter case name" value="">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Visa Service</label>
        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="visa_service_id" id="visa_service_id" required class="form-control">
              <option value="">Select Visa Service</option>
              @foreach($visa_services as $visa_service)
              <option value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Case Type</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="case_type" class="form-control" required>
              <option value="">Select Case Type</option>
              <option value="new">New</option>
              <option value="previous">Previous</option>
            </select>
          </div>
        </div>
      </div>

    </div> <!-- div end -->
 
  </div>

  <!-- Footer -->
  <div class="d-flex align-items-center">
    <div class="ml-auto">
      <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Next</button>
      <!-- <button type="button" class="btn btn-primary"
      data-hs-step-form-next-options='{
      "targetSelector": "#validationFormPayment"
      }'>
      Next <i class="tio-chevron-right"></i>
      </button> -->
    </div>
  </div>
<!-- End Footer -->
</div>
</div>
<!-- End Message Body -->
</form>
<!-- End Step Form -->
--}}
</div>
</div>


@endsection


@section('javascript')
<!-- JS Implementing Plugins -->

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
  $(document).on('ready', function () {
    $('#date_of_birth,#date_of_register').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate:(new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
    
    $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });

    // initialization of step form
    $('.js-step-form').each(function () {
      var stepForm = new HSStepForm($(this), {
        finish: function() {
          var formData = new FormData($("#form")[0]);
          $.ajax({
            url:"{{ baseUrl('save-profile') }}",
            type:"post",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $("#validationFormFinishBtn").html("Processing...");
                $("#validationFormFinishBtn").attr("disabled","disabled");
            },
            success:function(response){
              $("#validationFormFinishBtn").html("Save Data");
              $("#validationFormFinishBtn").removeAttr("disabled");
              if(response.status == true){
                successMessage(response.message);
                setTimeout(function(){
                      window.location.href=window.location.href;
                },2000);
                
              }else{
                $("#err_response").html('<h4><b>*Field required</b></h4>');
                $.each(response.message, function (index, value) {
                    $("#err_response").append("<p>"+value+"</p>");
                    $("input[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                    $("input[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
                    
                    var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                    $(html).insertAfter("*[name="+index+"]");
                    $("input[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
                });
              }
            },
            error:function(){
                $("#validationFormFinishBtn").html("Save Data");
                $("#validationFormFinishBtn").removeAttr("disabled");
                internalError();
            }
        });
        }
      }).init();
    });

    // initialization of quilljs editor
    $('.js-flatpickr').each(function () {
      $.HSCore.components.HSFlatpickr.init($(this));
    });
    // initEditor("about_professional");
  });
  function licenceBodies(country_id){
      $.ajax({
          url:"{{ url('licence-bodies') }}",
          data:{
            country_id:country_id
          },
          dataType:"json",
          beforeSend:function(){
             $("#license_body").html('');
          },
          success:function(response){
            if(response.status == true){
              $("#license_body").html(response.options);
            } 
          },
          error:function(){
             
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