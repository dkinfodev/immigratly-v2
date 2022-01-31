@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/professionals') }}">Professionals</a></li>
  <li class="breadcrumb-item active" aria-current="page">Overview</li>

</ol>
<!-- End Content -->
@endsection


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
  <div class="professional" style="height: 25rem;">
    <!-- Page Header -->
    <div class="page-header-light">
      <div class="row align-items-center">
        <div class="col-6">
          <h1 class="page-header-title">{{$pageTitle}}</h1>
        </div>
        <div class="col-6" style="">

          <div class="form-inline float-right ml-2">

            <lable><span class="text-white" style="font-size:16px;">Profile Status </span></lable>
            <?php
            $check_profile = checkProfileStatus($record->subdomain);
            $profile_checked = '';
            if($check_profile['status'] == 'success'){
              $professional_profile = $check_profile['professional'];
              if($professional_profile->profile_status == 0){

              }else if($professional_profile->profile_status == 1){

              }else if($professional_profile->profile_status == 2){
                $profile_checked = 'checked';
              }
              else{
              }

            }else{ ?>

            <?php } ?>
            <label class="toggle-switch mx-2" for="profileStatus-1">
              <input type="checkbox" data-id="{{ $record->id }}" onchange="profileStatus(this)" class="js-toggle-switch toggle-switch-input" id="profileStatus-1" {{ $profile_checked }} >
              <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
              </span>
            </label>
            @if($profile_checked == 'checked')
            <!-- <span>Active</span> -->
            @else
            <!-- <span>Inactive</span> -->
            @endif
          </div>          
          
          <div class="form-inline float-right">
            <lable><span class="text-white" style="font-size:16px;">Panel Status </span></lable>
            <label class="toggle-switch mx-2" for="customSwitch-1">
              <input type="checkbox" data-id="{{ $record->id }}" onchange="changeStatus(this)" class="js-toggle-switch toggle-switch-input" id="customSwitch-1" {{($record->panel_status == 1)?'checked':''}} >
              <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
              </span>
            </label>
            @if($record->panel_status == 1)
            <!-- <span>Active</span> -->
            @else
            <!-- <span>Inactive</span> -->
            @endif
          </div>
          
        </div>
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

      <!-- Nav 
      <ul class="nav nav-tabs nav-tabs-light page-header-tabs" id="pageHeaderTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="javascript:;">Details</a>
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
<div class="content container-fluid" style="margin-top:-22rem">
  <!-- Card -->
  
  <div class="card mb-3 mb-lg-5" style="padding:30px;">
    <!-- Header -->
    <div class="text-right mb-3">
      <a onclick="fetchChats()" class="btn btn-primary js-hs-unfold-invoker" href="javascript:;"
                data-hs-unfold-options='{
                "target": "#activitySidebar",
                "type": "css-animation",
                "animationIn": "fadeInRight",
                "animationOut": "fadeOutRight",
                "hasOverlay": true,
                "smartPositionOff": true
                }'>
      <i class="tio-chat mr-1"></i> Chat with Professional
      @if($unread_chats > 0)
            <span class="badge badge-danger">{{$unread_chats}}</span>
      @endif
    </a>
      <!-- <a class="btn btn-warning mb-3 width-auto" onclick="showPopup('<?php echo baseUrl('professionals/add-notes/'.base64_encode($record->id)) ?>')" href="javascript:;">
        <i class="tio-edit mr-1"></i> Add Notes
      </a> -->
    </div>
    <div class="clearfix"></div>
    <!-- Step Form -->
    <form id="profile_form" class="js-step-form js-validate"
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
      "targetSelector": "#validationPersonalInfo"
    }'>
    <span class="step-icon step-icon-soft-dark">1</span>
    <div class="step-content">
      <span class="step-title">Personal Info</span>
    </div>
  </a>
</li>

<li class="step-item">
  <a class="step-content-wrapper" href="javascript:;"
  data-hs-step-form-next-options='{
  "targetSelector": "#validationFormAboutMe"
}'>
<span class="step-icon step-icon-soft-dark">2</span>
<div class="step-content">
  <span class="step-title">About</span>
</div>
</a>
</li>

<li class="step-item">
  <a class="step-content-wrapper" href="javascript:;"
  data-hs-step-form-next-options='{
  "targetSelector": "#validationFormCompanyInfo"
}'>
<span class="step-icon step-icon-soft-dark">3</span>
<div class="step-content">
  <span class="step-title">Company Info</span>
</div>
</a>
</li>
</ul>
<!-- End Step -->

<!-- Content Step Form -->
<div id="validationFormContent">
  <div id="validationPersonalInfo" class="active">

    <div class="row justify-content-md-between">
      <div class="col-md-4">
        <!-- Logo -->
        <label class="custom-file-boxed custom-file-boxed-sm" for="logoUploader">
        <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2" src="{{ professionalProfile($user->unique_id,'m',$subdomain) }}" alt="Profile Image">

          <!-- <span class="d-block">Upload your Image here</span> -->

          <!-- <input type="file" class="js-file-attach custom-file-boxed-input" name="profile_image" id="logoUploader"
          data-hs-file-attach-options='{
          "textTarget": "#logoImg",
          "mode": "image",
          "targetAttr": "src"
        }'> -->
      </label>
      <!-- End Logo -->
    </div>

    <div class="col-md-7 justify-content-md-end">

      <div class="row form-group">
        <div class="col-12">
          <label for="validationFormUsernameLabel" class="col-form-label input-label">First name</label>
          <div class="js-form-message">
            <input type="text" class="form-control" name="first_name" id="validationFormFirstnameLabel" placeholder="Firstname" aria-label="Firstname" required data-msg="Please enter your first name." value="{{ $user->first_name }}" disabled="true">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <div class="row form-group">
        <div class="col-12">
           <label for="validationFormUsernameLabel" class="col-form-label input-label">Last name</label>
          <div class="js-form-message">
            <input type="text" class="form-control" name="last_name" id="validationFormLastnameLabel" placeholder="Lastname" aria-label="Lastname" required data-msg="Please enter your last name." value="{{ $user->last_name }}" disabled="true">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

    </div>
  </div>
  <!-- End Row -->

  <hr class="my-5">

  <div class="row justify-content-md-between">
    <div class="col-md-6">
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Email</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="email" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{ $user->email }}" disabled="true">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Phone Number</label>

        <div class="col-sm-3">
          <div class="js-form-message">

            <input type="email" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{ $user->country_code }}" disabled="true">

            
          </div>
        </div>
        <div class="col-sm-4">
          <div class="js-form-message">
            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{$user->phone_no}}" disabled="true">
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Gender</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{$user->gender}}" disabled="true">
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Date of Birth</label>
        <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="date_of_birth" id="date_of_birth" value="{{ $user->date_of_birth }}" class="form-control" placeholder="Date of Birth" aria-label="Date of birth" required data-msg="Enter date of birth" disabled="true">
            <div class="input-group-addon p-2">
              <i class="tio-date-range"></i>
            </div>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Languages Known</label>

        <div class="col-sm-7">
          <div class="js-form-message">
           <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{$languages}}" disabled="true">
         </div>
       </div>
     </div>
     <!-- End Form Group -->


   </div> <!-- div end -->


   <div class="col-md-6">

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Country</label>
      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{(!empty($countries))?$countries->name:''}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->
    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">State</label>
      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{!empty($states)?$states->name:''}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">City</label>
      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{!empty($cities)?$cities->name:''}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Address</label>
      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="address" id="address" placeholder="Address" aria-label="Address" required data-msg="Please enter your address" value="{{ $user->address }}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Zip Code</label>
      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ $user->zip_code }}" disabled="true">
        </div>
      </div>
    </div>
  </div>
  <!-- End Form Group -->
</div>

<!-- Footer -->
<div class="d-flex align-items-center">
  <div class="ml-auto">
    <button type="button" class="btn btn-primary"
    data-hs-step-form-next-options='{
    "targetSelector": "#validationFormAboutMe"
  }'>
  Next <i class="tio-chevron-right"></i>
</button>
</div>
</div>
<!-- End Footer -->
</div>

<div id="validationFormAboutMe" style="display: none;">

  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Country</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ !empty($comp_countries)?$comp_countries->name:'' }}" disabled="true">
      </div>
    </div>
  </div>
  <!-- End Form Group -->
  
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">License Body</label>

    <div class="col-sm-7">
      <div class="js-form-message">

        {!! $licenceBodies !!}
      </div>
    </div>
  </div>
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Member in good standing</label>
    <div class="col-sm-7">
      <div class="js-form-message">

        <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{$company_details->member_of_good_standing}}" disabled="true">

      </div>
    </div>
  </div>
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Licence Number</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="licence_number" id="licence_number" placeholder="Licence Number" aria-label="Licence Number" required data-msg="Please enter your licence number" value="{{ $company_details->licence_number }}" disabled="true">
      </div>
    </div>
  </div>
  <!-- End Form Group -->
  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">License certificate</label>
    <div class="col-sm-7">
      <div class="js-form-message">
       @if($company_details->licence_certificate != '')
       <a class="h4 text-success" href="{{professionalDirUrl($subdomain).'/documents/'.$company_details->licence_certificate}}" download="true">
        <i class="tio-download"></i> {{$company_details->licence_certificate}}
      </a>
       @else
       <span class="legend-indicator bg-danger"></span> No document to preview
       @endif
     </div>
   </div>
 </div>
 <!-- End Form Group -->
 <div class="row form-group">
  <label class="col-sm-5 col-form-label input-label">Years of Expirence</label>
  <div class="col-sm-7">
    <div class="js-form-message">
      <input type="text" class="form-control" name="member_of_other_designated_body" id="member_of_other_designated_body" placeholder="Member of any other designated body" aria-label="Member of any other designated body" data-msg="Please enter your licence number" value="{{ $company_details->years_of_expirences}}" disabled="true">
    </div>
  </div>
</div>
<!-- Form Group -->
<div class="row form-group">
  <label class="col-sm-5 col-form-label input-label">Member of any other designated body</label>
  <div class="col-sm-7">
    <div class="js-form-message">
      <input type="text" class="form-control" name="member_of_other_designated_body" id="member_of_other_designated_body" placeholder="Member of any other designated body" aria-label="Member of any other designated body" data-msg="Please enter your licence number" value="{{ $company_details->member_of_other_designated_body }}" disabled="true">
    </div>
  </div>
</div>
<!-- End Form Group -->

<!-- End Quill -->


<!-- Footer -->
<div class="d-flex align-items-center">
  <button type="button" class="btn btn-ghost-secondary mr-2"
  data-hs-step-form-prev-options='{
  "targetSelector": "#validationPersonalInfo"
}'>
<i class="tio-chevron-left"></i> Previous step
</button>

<div class="ml-auto">
  <button type="button" class="btn btn-primary"
  data-hs-step-form-next-options='{
  "targetSelector": "#validationFormCompanyInfo"
}'>
Next <i class="tio-chevron-right"></i>
</button>
</div>
</div>
<!-- End Footer -->
</div>

<div id="validationFormCompanyInfo" style="display: none;">
 <div class="row justify-content-md-between">
  <div class="col-md-6">
    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Company Name</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="company_name" id="validationFormCompanyCompanyNameLabel" placeholder="Company" aria-label="Company Name" required data-msg="Please enter your company name." value="{{$company_details->company_name}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Website URL</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="website_url" id="website_url" placeholder="Website URL" aria-label="Website URL" required data-msg="Please enter your website." value="{{$company_details->website_url}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Email</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="email" class="form-control" name="cp_email" id="cp_email" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{$company_details->email}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Phone Number</label>
      <div class="col-sm-3">
        <div class="js-form-message">

          <input type="email" class="form-control" name="cp_email" id="cp_email" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{$company_details->country_code}}" disabled="true">

        </div>
      </div>
      <div class="col-sm-4">
        <div class="js-form-message">
          <input type="text" class="form-control" name="cp_phone_no" id="cp_phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{$company_details->phone_no}}" disabled="true">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Owner ID Proof</label>

      <div class="col-sm-7">
        <div class="js-form-message">
         @if($company_details->owner_id_proof != '')
         <a class="h4 text-success" href="{{professionalDirUrl($subdomain).'/documents/'.$company_details->owner_id_proof}}" download="true">
          <i class="tio-download"></i> {{$company_details->owner_id_proof}}
        </a>
         @else
         <span class="legend-indicator bg-danger"></span> No document to preview
         @endif
       </div>

     </div>
   </div>
   <!-- End Form Group -->

   <!-- Form Group -->
   <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Company Address Proof</label>

    <div class="col-sm-7">
      <div class="js-form-message">
       @if($company_details->company_address_proof != '')
       <a class="h4 text-success" href="{{professionalDirUrl($subdomain).'/documents/'.$company_details->company_address_proof}}" download="true">
        <i class="tio-download"></i> {{$company_details->company_address_proof}}
       </a>
       @else
       <span class="legend-indicator bg-danger"></span> No document to preview
       @endif
     </div>

   </div>
 </div>
 <!-- End Form Group -->

</div> <!-- div end -->


<div class="col-md-6">
  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">State</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="cp_zip_code" id="cp_zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ !empty($comp_states)?$comp_states->name:'' }}" disabled="true">
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">City</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="cp_zip_code" id="cp_zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ !empty($comp_cities)?$comp_cities->name:'' }}" disabled="true">
      </div>
    </div>
  </div>
  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Register Date</label>

    <div class="col-sm-7">
      <div class="input-group">
        <input type="text" name="date_of_register" id="date_of_register" class="form-control" placeholder="Date of Register" aria-label="Date of Register" required data-msg="Enter date of register" value="{{ $company_details->date_of_register }}" disabled="true">
        <div class="input-group-addon p-2">
          <i class="tio-date-range"></i>
        </div>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  

  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Address</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="cp_address" id="cp_address" placeholder="Address" aria-label="Address" required data-msg="Please enter your address" value="{{ $company_details->address }}" disabled="true">
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label for="validationFormZipLabel" class="col-sm-5 col-form-label input-label">Zip Code</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="cp_zip_code" id="cp_zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ $company_details->zip_code }}" disabled="true">
      </div>
    </div>
  </div>
</div>
</div>


<!-- Footer -->
<div id="err_response" class="text-danger"></div>
<div class="d-sm-flex align-items-center">
  <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
  data-hs-step-form-prev-options='{
  "targetSelector": "#validationFormAboutMe"
}'>

<i class="tio-chevron-left"></i> Previous step
</button>
<!--<div class="d-flex justify-content-end ml-auto">
  <button type="button" class="btn btn-white mr-2" data-dismiss="modal" aria-label="Close">Cancel</button>
  <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Save Changes</button>
</div>
</div>
End Footer -->
</div>
</div>
<!-- End Content Step Form -->
<!-- Message Body -->
<!-- End Message Body -->
</form>
<!-- End Step Form -->

</div>
</div>
<div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card sidebar-scrollbar">
      <div class="card-header">
          <h4 class="card-header-title">Support Chats</h4>
          <!-- Toggle Button -->
          <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
            data-hs-unfold-options='{
            "target": "#activitySidebar",
            "type": "css-animation",
            "animationIn": "fadeInRight",
            "animationOut": "fadeOutRight",
            "hasOverlay": true,
            "smartPositionOff": true
            }'>
          <i class="tio-clear tio-lg"></i>
          </a>
          <!-- End Toggle Button -->
      </div>
      <!-- Body -->
      <div class="card-body sidebar-body">
          <div class="chat_window">
            <ul class="messages">
                
            </ul>
            <div class="doc_chat_input bottom_wrapper clearfix">
                <div class="message_input_wrapper">
                  <input class="form-control msg_textbox" id="message_input" placeholder="Type your message here..." />
                  <input type="file" name="chat_file" id="chat-attachment" style="display:none" />
                </div>
                <div class="btn-group send-btn">
                  <button type="button" class="btn btn-primary btn-pill send-message">
                    <i class="tio-send"></i>
                  </button>
                  <button type="button" class="btn btn-info btn-pill send-attachment">
                    <i class="tio-attachment"></i>
                  </button>
                </div>
            </div>
          </div>
          <div class="message_template">
            <li class="message">
                <div class="avatar"></div>
                <div class="text_wrapper">
                  <div class="text"></div>
                </div>
            </li>
          </div>
      </div>
      <!-- End Body -->
    </div>
</div>

@endsection


@section('javascript')
<!-- JS Implementing Plugins -->
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->

<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>
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
    $(".send-message").click(function(){
       
       var message = $("#message_input").val();
       if(message != ''){
       $.ajax({
           type: "POST",
           url: "{{ baseUrl('professionals/send-message-to-support') }}",
           data:{
               _token:csrf_token,
               message:message,
               subdomain:"{{$subdomain}}",
               type:"text",
           },
           dataType:'json',
           beforeSend:function(){
               // var html = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
               // $("#activitySidebar .messages").html(html);
               $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
           },
           success: function (response) {
               if(response.status == true){
                   $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                   $("#message_input").val('');
                   $("#activitySidebar .messages").html(response.html);
                   $(".messages").mCustomScrollbar();
                   $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
                   $(".doc_chat_input").show();
                   fetchChats();
               }else{
                   errorMessage(response.message);
               }
           },
           error:function(){

           $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
           internalError();
           }
       });
       }
   });

  $(".send-attachment").click(function(){
     document.getElementById('chat-attachment').click();
  });
  $("#chat-attachment").change(function(){
     var formData = new FormData();
     formData.append("_token",csrf_token);
     formData.append("subdomain","{{$subdomain}}");
     formData.append('attachment', $('#chat-attachment')[0].files[0]);
     var url  = "{{ baseUrl('professionals/send-file-to-support') }}";
     $.ajax({
        url:url,
        type:"post",
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        beforeSend:function(){
           $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
        },
        success: function (response) {
           if(response.status == true){
              $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
              $("#chat-attachment").val('');
              $("#activitySidebar .messages").html(response.html);
              $(".messages").mCustomScrollbar();
              $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
              $(".doc_chat_input").show();
              fetchChats();
           }else{
              errorMessage(response.message);
           }
        },
        error:function(){
           $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
           internalError();
        }
     });
    });
    $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });

    // initialization of step form
    $('.js-step-form').each(function () {
      var stepForm = new HSStepForm($(this), {
        finish: function() {
          var formData = new FormData($("#profile_form")[0]);
          $.ajax({
            url:"{{ baseUrl('update-profile') }}",
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

function profileStatus(e){
  var id = $(e).attr("data-id");
  if($(e).is(":checked")){
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/profile-status/active',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        beforeSend:function(){
          showLoader();
        },
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                location.reload();
            }else{
                errorMessage(result.message);
            }
        },
    });
  }else{
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/profile-status/inactive',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        beforeSend:function(){
          showLoader();
        },
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                location.reload();
            }else{
                errorMessage(result.message);
            }
        },
        error: function(){
          internalError();
        }
    });
  }
}


function changeStatus(e){
  var id = $(e).attr("data-id");
  if($(e).is(":checked")){
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/status/active',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        beforeSend:function(){
          showLoader();
        },
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                location.reload();
            }else{
                errorMessage(result.message);
            }
        },
    });
  }else{
    $.ajax({
        type: "POST",
        url: BASEURL + '/professionals/status/inactive',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        beforeSend:function(){
          showLoader();
        },
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                location.reload();
            }else{
                errorMessage(result.message);
            }
        },
        error: function(){
          internalError();
        }
    });
  }
}

function fetchChats(){

  $.ajax({
    type: "POST",
    url: "{{ baseUrl('professionals/fetch-chats') }}",
    data:{
        _token:csrf_token,
        subdomain:"{{$subdomain}}"
    },
    dataType:'json',
    beforeSend:function(){
        $("#message_input").val('');
        $("#message_input,.send-message,.send-attachment").attr('disabled','disabled');
    },
    success: function (response) {
        if(response.status == true){
            $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
            $("#activitySidebar .messages").html(response.html);
            setTimeout(function(){
                $("#activitySidebar .messages").mCustomScrollbar();
               // $("#activitySidebar .messages").animate({ scrollTop: $(".messages")[0].scrollHeight}, 1000);
            },800);
            
            $(".doc_chat_input").show();
        }else{
            errorMessage(response.message);
        }
    },
    error:function(){
        $("#activitySidebar .messages").html('');
        internalError();
    }
  });
}
</script>
@endsection