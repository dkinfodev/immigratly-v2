@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
  <a class="btn btn-primary" href="{{ baseUrl('/user') }}">
    <i class="tio mr-1"></i> Back 
  </a>
@endsection

@section('content')
<!-- Content -->
<div class="user">

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/user/update-password/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-3 col-form-label">Name</label>
          <div class="col-sm-9 pt-2 font-weight-bold">
           {{$record->first_name ." ".$record->last_name }}
         </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-9 pt-2 font-weight-bold">
           {{$record->email}}
         </div>
        </div>

        <div class="js-form-message form-group row">
          <label class="col-sm-3 col-form-label">Password</label>
          <div class="col-sm-8">
           <!-- <input type="text" name="name" placeholder="Enter price for your service" class="form-control"> -->
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
          </div>
            <div class="col-sm-1 js-toggle-password-target-1 input-group-append">
              <a class="input-group-text" href="javascript:;">
                <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
              </a>  
            </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-3 col-form-label">Confirm password</label>
          <div class="col-sm-8">
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

        <div class="col-sm-1 js-toggle-password-target-2 input-group-append">
          <a class="input-group-text" href="javascript:;">
            <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
          </a>
        </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->

      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

@section('javascript')
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>

<script type="text/javascript">
    
$(document).on('ready', function () {
  
  $('.js-toggle-password').each(function () {
    new HSTogglePassword(this).init()
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
              $.each(response.message, function (index, value) {
                  $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                  $("[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
                  
                  var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                  $(html).insertAfter("*[name="+index+"]");
                  $("[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
              });
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