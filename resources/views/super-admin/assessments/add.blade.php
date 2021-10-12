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
<!-- Content -->
<div class="assessments">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/assessments') }}">Assessments</a></li>
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
  <div class="card">

    <div class="card-body">
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
            <a class="step-content-wrapper" href="javascript:;">
              <span class="step-icon step-icon-soft-dark">2</span>
              <div class="step-content">
                <span class="step-title">Payment</span>
              </div>
            </a>
          </li>

          <li class="step-item">
            <a class="step-content-wrapper" href="javascript:;">
              <span class="step-icon step-icon-soft-dark">3</span>
              <div class="step-content">
                <span class="step-title">Visa Documents</span>
              </div>
            </a>
          </li>

           <li class="step-item">
            <a class="step-content-wrapper" href="javascript:;">
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
            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormCaseNameLabel" class="col-sm-3 col-form-label input-label">Case Name</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <input type="text" class="form-control" name="case_name" id="validationFormCaseNameLabel" placeholder="Case Name" aria-label="Case Name" required data-msg="Please enter case name.">
                </div>
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormVisaServiceLabel" class="col-sm-3 col-form-label input-label">Visa Service</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <select name="visa_service_id" id="validationFormVisaServiceLabel" required data-msg="Please select visa service." class="form-control">
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
              <label for="validationFormCaseTypeLabel" class="col-sm-3 col-form-label input-label">Case Type</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <select name="case_type" id="validationFormCaseTypeLabel" required data-msg="Please select case type." class="form-control">
                    <option value="">Select Case Type</option>
                    <option value="new">New</option>
                    <option value="previous">Previous</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- End Form Group -->

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
          {{--
          <div id="validationFormPayment" style="display: none;">
            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormFirstNameLabel" class="col-sm-3 col-form-label input-label">First name</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <input type="password" class="form-control" name="firstName" id="validationFormFirstNameLabel" placeholder="First name" aria-label="First name" required data-msg="Please enter your first name.">
                </div>
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormLastNameLabel" class="col-sm-3 col-form-label input-label">Last name</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <input type="password" class="form-control" name="lastName" id="validationFormLastNameLabel" placeholder="Last name" aria-label="Last name" required data-msg="Please enter your last name.">
                </div>
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormEmailLabel" class="col-sm-3 col-form-label input-label">Email</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <input type="password" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email address" aria-label="Email address" required data-msg="Please enter a valid email address.">
                </div>
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Footer -->
            <div class="d-flex align-items-center">
              <button type="button" class="btn btn-ghost-secondary mr-2"
                 data-hs-step-form-prev-options='{
                   "targetSelector": "#validationFormCaseInfo"
                 }'>
                <i class="tio-chevron-left"></i> Previous step
              </button>

              <div class="ml-auto">
                <button type="button" class="btn btn-primary"
                        data-hs-step-form-next-options='{
                          "targetSelector": "#validationFormVisaDocument"
                        }'>
                  Next <i class="tio-chevron-right"></i>
                </button>
              </div>
            </div>
            <!-- End Footer -->
          </div>

          <div id="validationFormVisaDocument" style="display: none;">
            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormVisaDocument1Label" class="col-sm-3 col-form-label input-label">Address 1</label>

              <div class="col-sm-9">
                <div class="js-form-message">
                  <input type="password" class="form-control" name="address1" id="validationFormVisaDocument1Label" placeholder="Address 1" aria-label="Address 1" required data-msg="Please enter your address.">
                </div>
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div class="row form-group">
              <label for="validationFormVisaDocument2Label" class="col-sm-3 col-form-label input-label">Address 2 <span class="input-label-secondary">(Optional)</span></label>

              <div class="col-sm-9">
                <input type="password" class="form-control" name="address2" id="validationFormVisaDocument2Label" placeholder="Address 2" aria-label="Address 2">
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Footer -->
            <div class="d-sm-flex align-items-center">
              <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
                 data-hs-step-form-prev-options='{
                   "targetSelector": "#validationFormPayment"
                 }'>
                <i class="tio-chevron-left"></i> Previous step
              </button>

              <div class="d-flex justify-content-end ml-auto">
                <button type="button" class="btn btn-white mr-2" data-dismiss="modal" aria-label="Close">Cancel</button>
                <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Save Changes</button>
              </div>
            </div>
            <!-- End Footer -->
          </div> --}}
        </div>
        <!-- End Content Step Form -->

      </form>
      <!-- End Step Form -->
      </div><!-- End Card body-->
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

  <script type="text/javascript">
     $(document).on('ready', function () {
    // initialization of form validation
    $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });

    // initialization of step form
    $('.js-step-form').each(function () {
      var stepForm = new HSStepForm($(this), {
        finish: function() {
            var formData = new FormData($("#form")[0]);
            $.ajax({
              url:"{{ baseUrl('assessments/save') }}",
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
                $("#validationFormFinishBtn").html("Next");
                $("#validationFormFinishBtn").removeAttr("disabled");
                if(response.status == true){
                  successMessage(response.message);
                  setTimeout(function(){
                        redirect(response.redirect_back);
                  },2000);
                  
                }else{
                  validation(response.message);
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
  });
  </script>

  @endsection