@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/staff') }}">Staff</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{baseUrl('staff')}}">
  <i class="tio mr-1"></i> Back 
</a>
@endsection


@section('content')
<!-- Content -->
<div class="staff">

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('staff/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        
        <div class="row">

          <div class="col-md-6">

            <div class="form-group">
              <label for="validationFormUsernameLabel" class="col-form-label input-label">First name</label>

              <div class="js-form-message">
                <input type="text" class="form-control" name="first_name" id="validationFormFirstnameLabel" placeholder="Firstname" aria-label="Firstname" required data-msg="Please enter your first name." value="{{ $record->first_name }}">
              </div>

            </div>
            <!-- End Form Group -->
          </div>

          <div class="col-6">
            <div class="form-group">
              <label for="validationFormUsernameLabel" class="col-form-label input-label">Last name</label>

              <div class="js-form-message">
                <input type="text" class="form-control" name="last_name" id="validationFormLastnameLabel" placeholder="Lastname" aria-label="Lastname" required data-msg="Please enter your last name." value="{{ $record->last_name }}">
              </div>

            </div>
            <!-- End Form Group -->
          </div>
        </div>

        <div class="row justify-content-md-between">
          <div class="col-md-6">
            <!-- Form Group -->
            <div class="row form-group">
              <label class="col-sm-12 col-form-label input-label">Email</label>

              <div class="col-sm-12">
                <div class="js-form-message">
                  <input type="email" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{ $record->email }}">
                </div>
              </div>
            </div>
            <!-- End Form Group --> 
          </div> <!-- div end -->

          <div class="col-md-6">

           <!-- Form Group -->
           <div class="row form-group">
            <label class="col-sm-12 col-form-label input-label">Phone Number</label>

            <div class="col-sm-5">
              <div class="js-form-message">
                <select name="country_code" id="country_code" class="form-control">
                  <option value="">Select Code</option>
                  @foreach($countries as $country)
                  <option {{$record->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="js-form-message">
                <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="phone no" required data-msg="Please enter your phone number." value="{{$record->phone_no}}">
              </div>
            </div>
          </div>
          <!-- End Form Group -->
          
        </div>


          <div class="col-md-6">
            <!-- Form Group -->
            <div class="row form-group">
              <label class="col-sm-12 col-form-label input-label">Status</label>

              <div class="col-sm-12">
                <div class="js-form-message">
                  <select name="status" class="form-control">
                  <option {{($record->is_active == '1')?'selected':''}} value="1">Active</option>
                  <option {{($record->is_active == '0')?'selected':''}} value="0">Inactive</option>
                  <option {{($record->is_active == '2')?'selected':''}} value="2">Suspended</option>
                </select>
                </div>
              </div>
            </div>
            <!-- End Form Group --> 
          </div>

        <!-- End Form Group -->    
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
<script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>

<script src="assets/vendor/quill/dist/quill.min.js"></script>

<script>
    
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
            }
          },
          error:function(){
            internalError();
          }
        });    
    });
  
</script>

@endsection