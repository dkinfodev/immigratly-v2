@extends('layouts.master-old')

@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/user') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('user')}}">
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
      <form id="form" class="js-validate" action="{{ baseUrl('user/save') }}" method="post">

        @csrf
        
        <div class="row">

        <div class="col-md-6">

          <div class="form-group">
            <label for="validationFormUsernameLabel" class="col-form-label input-label">First name</label>

            
              <div class="js-form-message">
                <input type="text" class="form-control" name="first_name" id="validationFormFirstnameLabel" placeholder="Firstname" aria-label="Firstname" required data-msg=" " >
              </div>
            
          </div>
          <!-- End Form Group -->
        </div>

        <div class="col-md-6">

          <div class="form-group">
            <label for="validationFormUsernameLabel" class="col-form-label input-label">Last name</label>

            
              <div class="js-form-message">
                <input type="text" class="form-control" name="last_name" id="validationFormLastnameLabel" placeholder="Lastname" aria-label="Lastname" required data-msg="">
              </div>
            
          </div>
          <!-- End Form Group -->
          </div>
        </div>



      <div class="row justify-content-md-between">
        <div class="col-md-6">
          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-md-12 col-form-label input-label">Email</label>

            <div class="col-md-12">
              <div class="js-form-message">
                <input type="email" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email" aria-label="Email" required data-msg="" value="">
              </div>
            </div>
          </div>
          <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-md-12 col-form-label input-label">Phone Number</label>

        <div class="col-md-5">
          <div class="js-form-message">
            <select name="country_code" id="country_code" class="form-control">
              <option value="">Select Code</option>
              @foreach($countries as $country)
              <option value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-7">
          <div class="js-form-message">
            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="" value="">
          </div>
        </div>
      </div>
      <!-- End Form Group -->
       <!-- Form Group -->
          <div class="row form-group">
            <label class="col-md-12 col-form-label input-label">Status</label>

            <div class="col-md-12">
              <div class="js-form-message">
                <select name="status" class="form-control">
                  <option value="">Select Status</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                  <option value="2">Suspended</option>
                </select>
              </div>
            </div>
          </div>
          <!-- End Form Group -->

    </div>
      <div class="col-md-6">

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-md-12 col-form-label input-label">Password</label>

            <div class="col-md-10">
              <div class="js-form-message input-group-merge">
                <!--<input type="password" class="form-control" name="password" id="password" placeholder="password" aria-label="Email" required data-msg="Please enter password." value="">-->
                <input type="password" class="js-toggle-password form-control" name="password" id="password" placeholder="8+ characters required" aria-label="8+ characters required" required
                data-msg="Your password is invalid. Please try again."
                data-hs-toggle-password-options='{
                "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                "defaultClass": "tio-hidden-outlined",
                "showClass": "tio-visible-outlined",
                "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
              }'>
            </div> <!-- Js Form Message -->
          </div> <!--col sm end -->

          <div class="col-sm-1 js-toggle-password-target-1 input-group-append">
            <a class="input-group-text" href="javascript:;">
              <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
            </a>  
          </div>
        </div>
        <!-- End Form Group -->


        <!-- Form Group -->
        <div class="row form-group">
          <label class="col-md-12 col-form-label input-label">Confirm Password</label>

          <div class="col-md-10">
            <div class="js-form-message">
              <!--<input type="password" class="form-control" name="password" id="password" placeholder="password" aria-label="Confirm password" required data-msg="Please enter password." value="">-->

              <input type="password" class="js-toggle-password form-control" name="password_confirmation" id="password_confirmation" placeholder="8+ characters required" aria-label="8+ characters required" required
              data-msg="Password does not match the confirm password."
              data-hs-toggle-password-options='{
              "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
              "defaultClass": "tio-hidden-outlined",
              "showClass": "tio-visible-outlined",
              "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
            }'>
          </div>
        </div>

        <div class="col-md-1 js-toggle-password-target-2 input-group-append">
          <a class="input-group-text" href="javascript:;">
            <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
          </a>
        </div>

      </div><!-- Form grp end -->
        
      </div>
    </div> <!-- div end -->

  <div class="form-group">
    <button type="submit" class="btn add-btn btn-primary">Add</button>
  </div>
  <!-- End Input Group -->

</div><!-- End Card body-->
</div>
<!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')

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

<script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>

<script src="assets/vendor/quill/dist/quill.min.js"></script>


<script>
  $(document).on('ready', function () {
    $('#date_of_birth').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
    });

    // initialization of Show Password
    $('.js-toggle-password').each(function () {
        new HSTogglePassword(this).init()
    });


    // initialization of quilljs editor
    $('.js-flatpickr').each(function () {
      $.HSCore.components.HSFlatpickr.init($(this));
    });
    // initEditor("about_professional");
    
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
            validation(response.message);
            // $.each(response.message, function (index, value) {
            //   $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
            //   $("[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
              
            //   var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
            //   $("[name="+index+"]").parents(".js-form-message").append(html);
            //   $("[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
            // });
              // errorMessage(response.message);
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