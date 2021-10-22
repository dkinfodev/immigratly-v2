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
<style>
.service-btn {
    padding: 2px !important;
    height: auto;
    width: auto;
}
</style>
<!-- Content -->
<div class="assessments">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/assessments') }}">Assessments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{baseUrl('assessments')}}">
                    <i class="tio mr-1"></i> Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <form id="form" action="{{ baseUrl('assessments/save') }}" class="js-validate" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
               <h2> Assessment Details</h2>
            </div>
            <div class="card-body">
                <!-- Step Form -->
                <div class="form-group js-form-message">
                    <label class="input-label" for="assessment_title">Assessment Title</label>
                    <input type="text" id="assessment_title" name="assessment_title" class="form-control"
                        placeholder="Assessment Title">
                </div>

                <div class="form-group js-form-message">
                    <label class="input-label pull-left" for="visa_service">Visa Service</label>
                    <button onclick="showPopup('<?php echo baseUrl('assessments/visa-services') ?>')" type="button" class="pull-left ml-3 btn btn-soft-primary mb-1 btn-icon service-btn">
                        <i class="tio-add"></i>
                    </button>
                    <div class="clearfix"></div>
                    <input type="hidden" name="visa_service_id" id="visa_service_id" />
                    <span id="visa_service" class="font-weight-bold"></span>
                    
                    <!-- <select name="visa_service_id" id="visa_service" onchange="findProfessional()" data-msg="Please select visa service."
                        class="form-control">
                        <option value="">Select Visa Service</option>
                        @foreach($visa_services as $visa_service)
                        <option value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
                        @endforeach
                    </select> -->
                </div>

                <div class="form-group js-form-message">
                    <label class="input-label">Case Type</label>
                    <select name="case_type" id="validationFormCaseTypeLabel" data-msg="Please select case type." class="form-control">
                        <option value="">Select Case Type</option>
                        <option value="new">New</option>
                        <option value="previous">Previous</option>
                    </select>
                </div>
                <div class="form-group js-form-message">
                    <label class="input-label" for="additional_comment">Additional Comment</label>
                    <textarea id="additional_comment" name="additional_comment" class="form-control"
                        placeholder="Additional Comment" rows="4"></textarea>
                </div>
                
            </div>
            <!-- End Card -->
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h2>Professional</h2>
            </div>
            <div class="card-body">               
                <div class="form-group">
                    <label class="input-label">Choose Professional</label>
                    <div class="js-form-message">
                        <select name="choose_professional" id="choose_professional" onchange="findProfessional()"
                            id="choose_professional" class="form-control">
                            <option value="">Select Option</option>
                            <option value="manual">Manual</option>
                            <option value="auto_assigned">Auto Assigned</option>
                        </select>
                    </div>
                </div>
                <div id="professional-list">
                </div>
            </div>
            <!-- End Card -->
        </div>

        <div class="card mt-3" id="documents" style="display:none">
            <div class="card-header">
                <h2>Documents</h2>
            </div>
            <div class="card-body">
            </div>
        </div>

        <div class="text-center mt-3">
          <button type="submit" id="validationFormFinishBtn" class="btn add-btn btn-primary">Save</button>
        </div>
    </form>
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

    <script type="text/javascript">
    $(document).on('ready', function() {

        $("#form").submit(function(e){
          e.preventDefault();
          var formData = $("#form").serialize();
          $.ajax({
              url: "{{ baseUrl('assessments/save') }}",
              type: "post",
              data: formData,
              beforeSend: function() {
                  $("#validationFormFinishBtn").html("Processing...");
                  $("#validationFormFinishBtn").attr("disabled",
                      "disabled");
              },
              success: function(response) {
                  $("#validationFormFinishBtn").html("Next");
                  $("#validationFormFinishBtn").removeAttr(
                  "disabled");
                  if (response.status == true) {
                      successMessage(response.message);
                      setTimeout(function() {
                          redirect(response.redirect_back);
                      }, 2000);

                  } else {
                      validation(response.message);
                  }
              },
              error: function() {
                  $("#validationFormFinishBtn").html("Save Data");
                  $("#validationFormFinishBtn").removeAttr(
                  "disabled");
                  internalError();
              }
          });
        });
    });
    function findProfessional() {
      var value = $("#choose_professional").val();
      var visa_service = $("#visa_service_id").val();
        if (value == 'manual' && visa_service != '') {
            // if ($("#visa_service").val() == '') {
            //     errorMessage("Please select visa service");
            //     return false;
            // }
            $.ajax({
                url: "{{ baseUrl('assessments/find-professional') }}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    visa_service_id: visa_service
                },
                beforeSend: function() {
                    $("#professional-list").html("<center><i class='fa fa-spin fa-spinner'></i></center>");
                },
                success: function(response) {
                    if (response.status == true) {
                        $("#professional-list").html(response.contents);
                    } else {
                        validation(response.message);
                    }
                },
                error: function() {
                    internalError();
                }
            });
        } else {
            $("#professional-list").html('');
        }
    }
    function fetchDocuments(assessment_id,folder_id){
      var url = '<?php echo baseUrl("assessments/documents") ?>/'+assessment_id+'/'+folder_id;
    //   var id = $(e).attr("data-folder");
      $.ajax({
        url:url,
        type:"post",
        data:{
            _token:"{{ csrf_token() }}",
            action:"add"
        },
        beforeSend:function(){
          $("#collapse-"+folder_id).html('');  
        },
        success:function(response){
          $("#collapse-"+folder_id).html(response.contents);
        },
        error:function(){
          errorMessage("Internal error try again");
        }
    });
  }
  </script>

@endsection