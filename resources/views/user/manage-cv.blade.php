@extends('layouts.master')
@section("style")
<style>
.custom-select {
    height: 52px !important;
    background-color: #f8fafd;
}
span#select2-bchg-container {
    top: 6px;
    position: relative;
}
.select2-selection__rendered {
    position: relative;
    top: 6px;
}
.input-group-addon.p-2 {
    background-color: #f8fafd;
    padding: 14px 13px !important;
    border: 0.0625rem solid rgba(33, 50, 91, 0.1);
}
</style>
@endsection
@section('content')
<div class="sidebar-detached-content mt-3 mt-lg-0">
   <div class="imm-cv-user-block">
      <div class="page-header">
         <!-- Profile Cover -->
         <div class="profile-cover">
         <div class="profile-cover-img-wrapper">
            <img class="profile-cover-img" src="./assets/img/Rect Light.svg" alt="Image Description">
         </div>
         </div>
         <!-- End Profile Cover -->

         <!-- Media -->
         <div class="d-sm-flex align-items-lg-center pt-1 px-3 pb-4 mt-n4">
         <div class="flex-shrink-0 mb-2 mb-sm-0">

               <!-- Avatar -->
               <label class="avatar avatar-xl avatar-circle avatar-uploader me-4" for="avatarUploader">
               <img id="avatarImg" class="avatar-img" src="./assets/img/160x160/img1.jpg"
                  alt="Image Description">

               <input type="file" class="js-file-attach avatar-uploader-input" id="avatarUploader"
                  data-hs-file-attach-options='{
         "textTarget": "#avatarImg",
         "mode": "image",
         "targetAttr": "src",
         "resetTarget": ".js-file-attach-reset-img",
         "resetImg": "./assets/img/160x160/img1.jpg",
         "allowTypes": [".png", ".jpeg", ".jpg"]
      }'>

               <span class="avatar-uploader-trigger">
                  <i class="bi-plus-circle me-1 avatar-uploader-icon shadow-soft"></i>
               </span>
               </label>
               <!-- End Avatar -->

               <!-- <button type="button" class="js-file-attach-reset-img btn btn-white">Delete</button> -->

         </div>

         <div class="flex-grow-1  pt-3">
            <div class="row">
               <div class="col-md mb-3 mb-md-0">
                  <h1 class="h3 mt-4 mb-0">{{Auth::user()->first_name." ".Auth::user()->last_name}} 
                  <img class="avatar avatar-xs" src="./assets/svg/illustrations/top-vendor.svg" alt="Review rating" data-bs-toggle="tooltip" data-bs-placement="top" title="Claimed profile"></h1>
                  <p class="card-text small" style="margin: 0;">{{Auth::user()->role}} profile</p>
               <!-- Rating -->
                  <div class="d-flex gap-1">

                  </div>
               <!-- End Rating -->
               </div>
               <!-- End Col -->

               <div class="col-md-auto align-self-md-end">
               <div class="d-grid d-sm-flex gap-2 imm-change-profile-section"><span
                     style="font-size:12px;display:block;padding:1rem 0.5rem;font-weight:600;width: 190px;">Change
                     profile</span>
                     <select class="js-select2-custom custom-select" size="1" name="cv_type" style="opacity: 0;">
                        <option value="">Select CV Type</option>
                        @foreach($cv_types as $type)
                        <option {{$user_detail->cv_type == $type->id?"selected":""}} value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                     </select>
               </div>
               </div>
               <!-- End Col -->
            </div>
            <!-- End Row -->
         </div>
         </div>
         <!-- End Media -->

         <!-- Nav Scroller -->
         <div id="pageHeaderTabParent">
         <div class="hs-nav-scroller-horizontal bg-white zi-2">

            <!-- Nav -->
            <ul class="js-scroll-nav nav nav-tabs page-header-tabs bg-white" id="pageHeaderTab" role="tablist"
               data-hs-scroll-nav-options='{
   "customOffsetTop": 40
   }'>
               <li class="nav-item active">
               <a class="nav-link" href="#">Resume</a>
               </li>
               <li class="nav-item">
               <a class="nav-link" href="#jobs-section">Jobs <span
                     class="badge bg-info rounded-pill ms-1">+9</span></a>
               </li>
               <li class="nav-item">
               <a class="nav-link" href="#reviews-section">Reviews</a>
               </li>
               <li class="nav-item">
               <a class="nav-link" href="#interview-section">Interview</a>
               </li>
               <li class="nav-item">
               <a class="nav-link" href="#locations-section">Locations</a>
               </li>
            </ul>
            <!-- End Nav -->
         </div>
         </div>
         <!-- End Nav Scroller -->
      </div>

      <!-- End Page Header -->

      <!-- Step Form -->
         <div class="row">
         <div class="col-lg-3">
            <!-- Sticky Block -->
            <div id="navbarVerticalNavMenuEg2">
               <div class="">
               <!-- Navbar Collapse -->

               <ul id="navbarSettingsEg2"
                  class="js-sticky-block js-nav-scrollerjs-scrollspy nav js-step-progress step step-icon-xs step-border-last-0 mt-5"
                  data-hs-sticky-block-options='{
            "parentSelector": "#navbarVerticalNavMenuEg2",
            "breakpoint": "lg",
            "startPoint": "#navbarVerticalNavMenuEg2",
            "endPoint": "#stickyBlockEndPoint",
            "stickyOffsetTop": 10,
            "stickyOffsetBottom": 0
            }'>
                  <li class="step-item nav-item">
                     <a class="step-content-wrapper nav-link  active" href="#imm-personal-profile-section">
                     <span class="step-icon step-icon-soft-dark">1</span>
                     <div class="step-content">
                        <span class="step-title">Basics</span>

                     </div>
                     </a>
                  </li>

                  <li class="step-item  nav-item ">
                     <a class="step-content-wrapper  nav-link" href="#imm-education-section">
                     <span class="step-icon step-icon-soft-dark">2</span>
                     <div class="step-content">
                        <span class="step-title">Education</span>

                     </div>
                     </a>
                  </li>

                  <li class="step-item  nav-item ">
                     <a class="step-content-wrapper  nav-link" href="#imm-experience-section">
                     <span class="step-icon step-icon-soft-dark">3</span>
                     <div class="step-content">
                        <span class="step-title">Work experience</span>

                     </div>
                     </a>
                  </li>

                  <li class="step-item  nav-item ">
                     <a class="step-content-wrapper  nav-link" href="#imm-language-section">
                     <span class="step-icon step-icon-soft-dark">4</span>
                     <div class="step-content">
                        <span class="step-title">Language proficiency</span>

                     </div>
                     </a>
                  </li>

               </ul>

               <!-- End Navbar Collapse -->



               </div>
            </div>
            <!-- End Sticky Block -->
         </div>
         <!-- End Col -->

         <div class="col-lg-9">
            <!-- Content Step Form -->
            <div id="imm-resume-content">
               <!-- Page Header -->

               <!-- Card -->
               <div id="imm-personal-profile-section" class="card  imm-cv-section">
               <!-- Header -->
               <div class="card-header bg-img-start" style="background-image: url(./assets/img/bck1.svg);">
                  <div class="flex-grow-1">

                     <h3 class="card-header-title">Personal details</h3>
                  </div>
               </div>
               <!-- End Header -->
               <form id="personal_info_form" method="post" class="js-validate" action="{{ baseUrl('/update-profile') }}" method="post">
               @csrf
               <!-- Body -->
               <div class="card-body">

                  <div class="row mb-3">
                     <h4 class="mb-3">Basic information</h4>
                     <div class="col-12">
                     <div class="mb-4">
                        <div class="row">
                           <div class="col-sm-6 js-form-message">
                           <label for="firstNameShopCheckout" class="form-label">First name</label>
                           <input type="text" class="form-control form-control-lg" id="first_name" name="first_name"
                              placeholder="" value="{{ $user->first_name }}" >
                           </div>
                           <!-- End Col -->
                          
                           <div class="col-sm-6 js-form-message">
                           <label for="lastNameShopCheckout" class="form-label">Last name</label>
                           <input type="text" class="form-control form-control-lg" id="last_name" name="last_name"
                              placeholder="" value="{{ $user->last_name }}" >
                           </div>
                        </div>
                     </div>
                     </div>
                     <!-- End Col -->

                     <div class="col-12">
                     <div class="mb-4 js-form-message">
                        <label for="emailShopCheckout" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control form-control-lg" id="emailShopCheckout"
                           placeholder="you@example.com">

                     </div>
                     </div>
                     <!-- End Col -->
                     <!-- Form -->
                     <div class="col-12">
                     <div class="mb-4">

                        <label for="phoneLabel" class="form-label">Phone number</label>
                        <div class="form-group">
                           <div class="row">
                           <div class="col-4 js-form-message">
                              <!-- Select2 -->
                              <!-- Select2 -->
                              <select class="js-select2-custom custom-select" name="country_code" size="1" style="opacity: 0;">
                                 <option value="">Select Country</option>
                                 @foreach($countries as $country)
                                 <option {{$user->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode."(".$country->sortname.")"}}</option>
                                 @endforeach
                              </select>

                              <!-- End Select2 -->
                           </div>
                           <div class="col-8 js-form-message">
                              <div class="input-group">
                                 <input type="text" value="{{ $user->phone_no }}" class="js-input-mask form-control" name="phone_no"
                                 id="phoneLabel">
                              </div>
                           </div>
                           </div>
                        </div>


                     </div>
                     </div>
                     <!-- End Form -->
                     <div class="col-12">
                     <div class="mb-4 js-form-message">
                        <label for="addressShopCheckout" class="form-label">Address</label>
                        <input type="text" class="form-control form-control-lg" id="addressShopCheckout" value="{{ $user_detail->address }}" name="address" placeholder="1234 Main St" >

                     </div>
                     </div>
                     <!-- End Col -->

                     <div class="col-12">
                     <div class="mb-4 js-form-message">
                        <label for="address2ShopCheckout" class="form-label">Address 2 <span
                           class="form-label-secondary">(Optional)</span></label>
                        <input type="text" class="form-control form-control-lg" id="address2ShopCheckout" value="{{ $user->address_2 }}" name="address_2"
                           placeholder="Apartment or suite">
                     </div>
                     </div>
                     <!-- End Col -->
                     <div class="col-12">
                        <div class="mb-4">
                           <div class="row">
                              <div class="col-md-4 js-form-message">
                              <label for="countryShopCheckout" class="form-label">Country</label>

                              <!-- Select -->
                              <select class="form-select" name="country_id" id="country_id" onchange="stateList(this.value,'state_id')" >
                                 <option value="">Select Country</option>
                                 @foreach($countries as $country)
                                 <option {{$user_detail->country_id == $country->id?"selected":""}} value="{{$country->id}}">{{$country->name}}</option>
                                 @endforeach
                              </select>
                              <!-- End Select -->

                              </div>
                              <!-- End Col -->

                              <div class="col-md-4 js-form-message">
                              <label for="stateShopCheckout" class="form-label">State</label>

                              <!-- Select -->
                                 <select name="state_id" id="state_id" aria-label="State" data-msg="Please select your state" onchange="cityList(this.value,'city_id')" class="form-control">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                    <option {{$user_detail->state_id == $state->id?"selected":""}} value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                 </select>
                              <!-- End Select -->

                              </div>
                              <!-- End Col -->

                              <div class="col-md-4 js-form-message">
                                 <label for="cityLabel" class="form-label">City</label>
                                 <select name="city_id" id="city_id"  aria-label="City" data-msg="Please select your city" class="form-control">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                    <option {{$user_detail->city_id == $city->id?"selected":""}} value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                 </select>
                              
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Col -->
                     

                     <div class="col-12">
                        <div class="mb-4">
                           <div class="row">
                              <div class="col-md-4 js-form-message">
                              <label for="zipCodeLabel" class="form-label">Zip Code</label>

                              <input type="text" class="js-masked-input form-control" name="zip_code" id="zipCodeLabel" placeholder="Your zip code" aria-label="Your zip code" value="{{ $user_detail->zip_code }}"
                              data-hs-mask-options='{
                              "template": "AA0 0AA"
                              }'>

                              </div>
                              <!-- End Col -->

                              <div class="col-md-4 js-form-message">
                              <label for="stateShopCheckout" class="form-label">Date of Birth</label>

                              <div class="input-group">
                                 <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $user_detail->date_of_birth }}" placeholder="Date of Birth" aria-label="Date of birth" data-msg="Enter date of birth">
                                 <div class="input-group-addon p-2">
                                    <i class="tio-date-range"></i>
                                 </div>
                              </div>

                              </div>
                              <!-- End Col -->

                              <div class="col-md-4 js-form-message">
                                 <label for="cityLabel" class="form-label">Gender</label>
                                 <select name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option {{($user_detail->gender == 'male')?'selected':''}} value="male">Male</option>
                                    <option {{($user_detail->gender == 'female')?'selected':''}} value="female">Female</option>
                                 </select>
                              
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Col -->
                     <div class="col-12">
                        <label for="languagesKnownLabel" class="form-label">Language Known</label>
                        <select name="languages_known[]" multiple id="languages_known" class="form-control">
                              <?php
                                 if($user_detail->languages_known != ''){
                                    $language_known = json_decode($user_detail->languages_known,true);
                                 }else{
                                    $language_known = array();
                                 }
                                 

                              ?> 
                              @foreach($languages as $language)
                              <option {{ (is_array($language_known) && in_array($language->id,$language_known))?'selected':'' }} value="{{$language->id}}">{{$language->name}}</option>
                              @endforeach
                              </select>
                     </div>
                     
                  </div>
                  <hr class="my-4">
                  <div class="row mb-3">
                     <h4 class="mb-3">Basic information</h4>
                     <!-- Form -->
                     <div class="col-12">
                     <div class="mb-4">
                        <label class="form-label">Employment eligibility</label>

                        <div class="d-grid gap-2">
                           <!-- Radio Check -->
                           <label class="form-control" for="employmentRadio1">
                           <span class="form-check">
                              <input type="radio" class="form-check-input" name="employmentRadioName"
                                 id="employmentRadio1" checked>
                              <span class="form-check-label">Authorized to work in the UK for any
                                 employer</span>
                           </span>
                           </label>
                           <!-- End Radio Check -->

                           <!-- Radio Check -->
                           <label class="form-control" for="employmentRadio2">
                           <span class="form-check">
                              <input type="radio" class="form-check-input" name="employmentRadioName"
                                 id="employmentRadio2">
                              <span class="form-check-label">Sponsorship required to work in the UK</span>
                           </span>
                           </label>
                           <!-- End Radio Check -->

                           <!-- Radio Check -->
                           <label class="form-control" for="employmentRadio3">
                           <span class="form-check">
                              <input type="radio" class="form-check-input" name="employmentRadioName"
                                 id="employmentRadio3">
                              <span class="form-check-label">No specified</span>
                           </span>
                           </label>
                           <!-- End Radio Check -->
                        </div>
                     </div>
                     </div>
                     <!-- End Form -->

                     <!-- Form -->
                     <div class="col-12">
                     <div class="mb-4">
                        <label for="contactInformationLabel" class="form-label">Contact information</label>
                        <p class="small mt-n2">Only provided to employers you apply to respond to.</p>
                        <input type="email" class="form-control" name="contactInformationName"
                           id="contactInformationLabel" placeholder="email@site.com" aria-label="email@site.com">

                        <!-- Check -->
                        <div class="form-check mt-2">
                           <input type="checkbox" class="form-check-input" id="callPermissionCheckbox">
                           <label class="form-check-label" for="callPermissionCheckbox">Call and send me text
                           messages at this phone number</label>
                        </div>
                        <!-- End Check -->
                     </div>
                     </div>
                     <!-- End Form -->

                     <!-- Form -->
                     <div class="col-12">
                     <div class="mb-4">
                        <label for="CVPrivacySwitch" class="form-label">CV privacy settings <span
                           class="badge bg-primary text-uppercase ms-1">PRO</span></label>

                        <div class="row">
                           <div class="col">
                           <label for="CVPrivacySwitch" class=" text-body">Your CV is not visible.
                              Employers cannot find your CV, but you can attach it when you apply to a
                              job.</label>
                           </div>

                           <div class="col-auto">
                           <!-- Form Switch -->
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="CVPrivacySwitch">
                           </div>
                           <!-- End Form Switch -->
                           </div>
                        </div>
                        <!-- End Row -->
                     </div>
                     </div>
                     <!-- End Form -->
                  </div>

               </div>
               <!-- Footer -->
               <div class="card-footer pt-0">
                  <div class="d-flex justify-content-end align-items-center">
                     <button type="submit" class="btn btn-primary">
                     Save and continue <i class="bi-chevron-right small ms-1"></i>
                     </button>
                  </div>
               </div>
               <!-- End Footer -->
               </form>
               </div>
               <!-- End Body -->



               <div id="imm-education-section" class="card imm-cv-section">
               <!-- Header -->
               <div class="card-header bg-img-start" style="background-image: url(./assets/img/bck1.svg);">
                  <div class="flex-grow-1">
                  
                     <h3 class="card-header-title">Education</h3>
                  </div>
               </div>
               <!-- End Header -->
               <div class="card-sub-header">
                  <div class="row">
                     <div class="col-4"></div>
                     <div class="col-8">
                     <div class="imm-add-skillset-container"><a href="javascript:;" 
                           class="imm-add-skillset-education form-link" onclick="showPopup('<?php echo baseUrl('educations/add') ?>')">
                           <i class="bi-plus-circle me-1"></i> Add Education
                        </a></div>
                     </div>
                  </div>
               </div>
               <!-- Body -->
               <div class="card-body imm-add-skillset-body">
                  <div class="imm-add-skillset-body-list">
                     <div class="imm-add-skillset-body-list-component">
                     <div class="imm-add-skillset-body-list-component-header">


                     </div>



                     <div class="imm-add-skillset-body-list-component-body">


                        <div class="row">
                           <div class="col-10">
                           <h3>Masters of technology</h3>
                           <h5>University of Alberta</h5>

                           </div>
                           <div class="col-2" style="text-align:right">
                           <!-- Dropdown -->
                           <div class="btn-group">
                              <button type="button"
                                 class="btn btn-outline-secondary btn-icon btn-sm btn-eca-menu" type="button"
                                 id="dropdownMenuButtonHoverAnimation" data-bs-toggle="dropdown"
                                 aria-expanded="false" data-bs-open-on-hover data-bs-dropdown-animation>
                                 <i class="bi-three-dots"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonHoverAnimation">
                                 <a class="dropdown-item" href="#">Edit list</a>
                                 <a class="dropdown-item" href="#">Delete list</a>

                              </div>
                           </div>
                           <!-- End Dropdown -->

                           </div>

                        </div>
                        <div class="imm-add-skillset-body-list-component-footer">
                           <div class="row">
                           <div class="col-xs-12 col-sm-7">
                              <p> <i class="bi-geo-alt me-1"></i> Alberta, Canada</p>

                           </div>
                           <div class="col-xs-12 col-sm-5"> <span
                                 style="/* font-size:12px; */display:block;float:right;/* font-weight: 600; */">September,
                                 2020 - August, 2021</span></div>
                           </div>
                           <div class="imm-credential-eca-component">
                           <div class="row">
                              <div class="col-12">
                                 <div class="d-flex flex-row">
                                 <div class="imm-credential-eca-subcomponent1">
                                    <span style="font-size:12px;font-weight:600;">Masters</span>
                                    <span class="imm-eca-small-span">(Original credential)</span>
                                 </div>
                                 <div class="imm-credential-eca-subcomponent2"> <img
                                       src="./assets/img/badge-blank.svg" class="me-1"
                                       style="width:20px;margin-top: -2px;" alt="Logo"><span
                                       style="font-size:12px;font-weight:600;">Educational credential assessment
                                       (ECA) </span><span class="imm-eca-small-span">(not done)</span></div>
                                 </div>
                              </div>
                           </div>
                           </div>
                        </div>


                     </div>

                     </div>
                     <div class="imm-add-skillset-body-list-component">
                     <div class="imm-add-skillset-body-list-component-header">


                     </div>



                     <div class="imm-add-skillset-body-list-component-body">


                        <div class="row">
                           <div class="col-10">
                           <h3>Masters of technology</h3>
                           <h5>University of Alberta</h5>

                           </div>
                           <div class="col-2" style="text-align:right">
                           <!-- Dropdown -->
                           <div class="btn-group">
                              <button type="button"
                                 class="btn btn-outline-secondary btn-icon btn-sm btn-eca-menu" type="button"
                                 id="dropdownMenuButtonHoverAnimation" data-bs-toggle="dropdown"
                                 aria-expanded="false" data-bs-open-on-hover data-bs-dropdown-animation>
                                 <i class="bi-three-dots"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonHoverAnimation">
                                 <a class="dropdown-item" href="#">Edit list</a>
                                 <a class="dropdown-item" href="#">Delete list</a>

                              </div>
                           </div>
                           <!-- End Dropdown -->

                           </div>

                        </div>
                        <div class="imm-add-skillset-body-list-component-footer">
                           <div class="row">
                           <div class="col-xs-12 col-sm-7">
                              <p> <i class="bi-geo-alt me-1"></i> Alberta, Canada</p>

                           </div>
                           <div class="col-xs-12 col-sm-5"> 
                  <span
                                 style="/* font-size:12px; */display:block;float:right;/* font-weight: 600; */">September,
                                 2020 - August, 2021</span>
                  </div>
                           </div>
                           <div class="imm-credential-eca-component">
                           <div class="row">
                              <div class="col-12">
                                 <div class="d-flex flex-row">
                                 <div class="imm-credential-eca-subcomponent1">
                                    <span style="font-size:12px;font-weight:600;">Post Graduate Diploma (4
                                       Years)</span>
                                    <span class="imm-eca-small-span">(Original)</span>
                                 </div>
                                 <div class="imm-credential-eca-subcomponent2"> <img
                                       src="./assets/img/badge.svg" class="me-1"
                                       style="width:20px;margin-top: -2px;" alt="Logo"><span
                                       style="font-size:12px;font-weight:600;">Post Graduate Diploma (4 Years)
                                    </span><span class="imm-eca-small-span">(CA Equivalency)</span></div>
                                 </div>
                              </div>
                           </div>
                           </div>
                        </div>


                     </div>

                     </div>


                  </div>
                  <div class="imm-add-skillset-body-list-empty"><span>Education history not found</span>
                  </div>


               </div>
               <!-- End Body -->

               <!-- Footer -->
               <div class="card-footer pt-0">
                  <div class="d-flex align-items-center">

                  </div>
               </div>
               <!-- End Footer -->
               </div>

               <div id="imm-experience-section" class="card imm-cv-section">
               <!-- Header -->
               <div class="card-header bg-img-start" style="background-image: url(./assets/img/bck1.svg);">
                  <div class="flex-grow-1">
                  
                     <h3 class="card-header-title">Work experience</h3>
                     <p class="card-text">Tell job seekers the pay and receive up to two times more applications
                     </p>
                  </div>
               </div>
               <!-- End Header -->
               <div class="card-sub-header">
                  <div class="row">
                     <div class="col-4"></div>
                     <div class="col-8">
                     <div class="imm-add-workexp-container"><a href="javascript:;"
                           class="imm-add-workexp-education form-link" onclick="showPopup('<?php echo baseUrl('work-experiences/add') ?>')">
                           <i class="bi-plus-circle me-1"></i> Add Work experience
                        </a></div>
                     </div>
                  </div>
               </div>
               <!-- Body -->
               <div class="card-body imm-add-workexp-body">
                  @if(!empty($work_expirences))
                 
                  <div class="imm-add-workexp-body-list">
                     @foreach($work_expirences as $key => $expirence)
                        <div class="imm-add-workexp-body-list-component">
                           <div class="imm-add-workexp-body-list-component-header">
                              <div class="imm-credential-eca-component">
                                 <div class="row  align-items-center">
                                 <div class="col-xs-12 col-sm-7">
                                    <div class="d-flex flex-row">
                                       <div class="imm-credential-eca-subcomponent1">
                                       <ul class="list-inline" style="margin-bottom:0">
                                          <li class="list-inline-item d-inline-flex align-items-center">
                                             <span class="legend-indicator bg-primary"></span><span
                                             style="font-size:12px;font-weight:600;">Full-time</span>
                                          </li>
                                       </ul>
                                       </div>
                                       <div class="imm-credential-eca-subcomponent2"><span
                                          style="font-size:12px;font-weight:600;">NOC 1241</span></div>
                                    </div>
                                 </div>

                                 <div class="col-xs-12 col-sm-5"> <span
                                       style="/* font-size:12px; */display:block;margin-top:3px;float:right;/* font-weight: 600; */">September,
                                       2020 - August, 2021</span></div>

                                 </div>

                              </div>
                           </div>
                           <div class="imm-add-workexp-body-list-component-body">
                              <div class="row">
                                 <div class="col-10">
                                 <h4>Assisstant Manager</h4>
                                 <h6>HCL Technologies Limited, Alberta, Canada </h6>

                                 </div>
                                 <div class="col-2" style="text-align:right">

                                 <!-- Dropdown -->
                                 <div class="btn-group">
                                    <button type="button"
                                       class="btn btn-outline-secondary btn-icon btn-sm btn-eca-menu js-hs-action" type="button"
                                       data-hs-unfold-options='{
                                       "target": "#we-action-{{$key}}",
                                       "type": "css-animation"
                                       }'
                                       >
                                       <i class="bi-three-dots"></i>
                                    </button>
                                    <div id="we-action-{{$key}}" class="dropdown-menu" aria-labelledby="dropdownMenuButtonHoverAnimation">
                                          <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('work-experiences/edit/'.base64_encode($expirence->id)) ?>')">
                                          <i class="tio-edit"></i> Edit
                                          </a>
                                          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('work-experiences/delete/'.base64_encode($expirence->id))}}">
                                          <i class="tio-delete"></i> Delete
                                          </a> 

                                    </div>
                                 </div>
                                 <!-- End Dropdown -->
                                 </div>

                              </div>
                              <div class="imm-add-workexp-body-list-component-footer">
                                 <div class="row">
                                 <div class="col-12">
                                    <ul>
                                       <li>Tell job seekers the pay and receive up to two times more applications</li>
                                       <li>Do you have any of these top skills employers are looking for?</li>
                                       <li>This information will help us find the job that's right for you.</li>
                                       <li>Employers cannot find your CV, but you can attach it</li>
                                    </ul>

                                 </div>
                                 </div>

                              </div>
                        </div>
                     @endforeach
                  </div>
                  @else
                  <div class="imm-add-workexp-body-list-empty"><span>Work history not found</span>
                  </div>
                  @endif
                  <!-- End Body -->

                  <!-- Footer -->
                  <div class="card-footer pt-0">
                     <div class="d-flex align-items-center">

                     </div>
                  </div>
                  <!-- End Footer -->
               </div>

               <!-- Footer -->
               <div class="card-footer pt-0">
                  <div class="d-flex align-items-center">

                  </div>
               </div>
               <!-- End Footer -->
               </div>

               <div id="imm-language-section" class="card imm-cv-section">
               <!-- Header -->
               <div class="card-header bg-img-start" style="background-image: url(./assets/img/bck1.svg);">
                  <div class="flex-grow-1">
                  
                     <h3 class="card-header-title"> Language proficiency</h3>
                     <p class="card-text">Tell job seekers the pay and receive up to two times more applications
                     </p>
                  </div>
               </div>
               <!-- End Header -->

               <!-- Body -->
               <div class="card-body">
                  <div class="imm-cv-language">
                     <h4 class="mb-3">First Official Language</h4>

                     <div class="col-12">
                     

                        <div class="row"> 
                           <div class="col-sm-4"> 
                  <div class="mb-4">
                  <label for="addressShopCheckout"
                              class="form-label">Language</label>
                           <!-- Select2 -->
                           <!-- Select2 -->
                           <select class="js-select2-custom custom-select" size="1" style="opacity: 0;">
                              <option value="1">English</option>
                              <option value="2">French</option>

                           </select>

                           <!-- End Select2 -->

                           </div> </div>
                           <div class="col-sm-8">
<div class="mb-4">
                  <label for="addressShopCheckout" class="form-label">Language
                              Test</label>
                           <!-- Select2 -->
                           <!-- Select2 -->
                           <select class="js-select2-custom custom-select" size="1" style="opacity: 0;">
                              <option value="1">International English Language Testing System (IELTS) – General
                                 Training</option>
                              <option value="2">Canada (+1)</option>
                              <option value="3">Lester Howard</option>
                              <option value="4">George Marino</option>
                              <option value="5">Tyler Johnson</option>
                              <option value="6">Jennifer Craig</option>
                              <option value="7">Martha Barnwell</option>
                              <option value="8">Florencia Todd</option>
                              <option value="9">Henry Sloan</option>
                              <option value="10">Abigail Watson</option>
                           </select>

                           <!-- End Select2 -->

                           </div>

                        </div>

                     </div>
                     </div>
                     <!-- End Col -->
                     <!-- Form -->
                     <div class="col-12">
                     
                        <div class="row gx-2">
                           <div class="col-sm-3"><div class="mb-4">

                           <label for="addlisteningLabel" class="form-label">Listening</label>
                           <input type="text" class="form-control" name="addlistening" id="addlistening"
                              placeholder="Listening" aria-label="Listening">
                           </div></div>
                           <div class="col-sm-3"><div class="mb-4">

                           <label for="addreadingLabel" class="form-label">Reading</label>
                           <input type="text" class="form-control" name="addreading" id="addreading"
                              placeholder="Reading" aria-label="Reading">
                           </div></div>
                           <div class="col-sm-3"><div class="mb-4">

                           <label for="addwritingLabel" class="form-label">Writing</label>
                           <input type="text" class="form-control" name="addwriting" id="addwriting"
                              placeholder="Writing" aria-label="Writing">
                           </div></div>
                           <div class="col-sm-3"><div class="mb-4">

                           <label for="addspeakingLabel" class="form-label">Speaking</label>
                           <input type="text" class="form-control" name="addspeaking" id="addspeaking"
                              placeholder="Speaking" aria-label="Speaking">
                           </div>
                        </div>
                     </div>
                     </div>
                     <!-- End Form -->
                  </div>
                  <hr class="my-4">
                  <div class="imm-cv-language">
                     <h4 class="mb-3">Second Official Language</h4>
                     <div class="col-12">
                     <div class="mb-4">

                        <div class="row">
                           <div class="col-sm-4"><div class="mb-4">
                  <label for="addressShopCheckout"
                              class="form-label">Language</label>
                           <!-- Select2 -->
                           <!-- Select2 -->
                           <select class="js-select2-custom custom-select" size="1" style="opacity: 0;">
                              <option value="1">English</option>
                              <option value="2">French</option>

                           </select>

                           <!-- End Select2 -->

                           </div>  </div>
                           <div class="col-sm-8"><div class="mb-4">
                  <label for="addressShopCheckout" class="form-label">Language
                              Test</label>
                           <!-- Select2 -->
                           <!-- Select2 -->
                           <select class="js-select2-custom custom-select" size="1" style="opacity: 0;">
                              <option value="1">International English Language Testing System (IELTS) – General
                                 Training</option>
                              <option value="2">Canada (+1)</option>
                              <option value="3">Lester Howard</option>
                              <option value="4">George Marino</option>
                              <option value="5">Tyler Johnson</option>
                              <option value="6">Jennifer Craig</option>
                              <option value="7">Martha Barnwell</option>
                              <option value="8">Florencia Todd</option>
                              <option value="9">Henry Sloan</option>
                              <option value="10">Abigail Watson</option>
                           </select>

                           <!-- End Select2 -->

                           </div>

                        </div>

                     </div>
                     </div>
                     <!-- End Col -->
                     <!-- Form -->
                     <div class="col-12">
                     

                        <div class="row gx-2">
                           <div class="col-sm-3"> <div class="mb-4">
                           <label for="addlisteningLabel" class="form-label">Listening</label>
                           <input type="text" class="form-control" name="addlistening" id="addlistening"
                              placeholder="Listening" aria-label="Listening">
                           </div> </div>
                           <div class="col-sm-3"> <div class="mb-4">
                           <label for="addreadingLabel" class="form-label">Reading</label>
                           <input type="text" class="form-control" name="addreading" id="addreading"
                              placeholder="Reading" aria-label="Reading">
                           </div> </div>
                           <div class="col-sm-3"> <div class="mb-4">
                           <label for="addwritingLabel" class="form-label">Writing</label>
                           <input type="text" class="form-control" name="addwriting" id="addwriting"
                              placeholder="Writing" aria-label="Writing">
                           </div> </div>
                           <div class="col-sm-3"> <div class="mb-4">
                           <label for="addspeakingLabel" class="form-label">Speaking</label>
                           <input type="text" class="form-control" name="addspeaking" id="addspeaking"
                              placeholder="Speaking" aria-label="Speaking">
                           </div>
                        </div>
                     </div>
                     </div>
                     <!-- End Form -->
                  </div>
               </div>
               <!-- End Body -->

               <!-- Footer -->
               <div class="card-footer pt-0">
                  <div class="d-flex align-items-center">

                  </div>
               </div>
               <!-- End Footer -->
               </div>

            </div>



            <!-- Sticky Block End Point -->
            <div id="stickyBlockEndPoint"></div>
         </div>
         <!-- End Col -->
         </div>
         <!-- End Row -->
      <!-- End Step Form -->
   </div>

   </div>
@endsection
@section('javascript')

<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>

<script>
   var work_expirence_dt,education_qualification_dt;
   $('.js-select2-custom').each(function () {
      var select2 = $.HSCore.components.HSSelect2.init($(this));
      select2.init();   
   });

      $(document).on('ready', function () {

         $("#personal_info_form").submit(function(e){
            e.preventDefault(); 
            var formData = new FormData($(this)[0]);
            var url  = $("#personal_info_form").attr('action');
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
                    }else{
                      validation(response.message);
                     }
                  },
                  error:function(){
                      internalError();
                  }
            });
         });
         $("#language_proficiency_form").submit(function(e){
            e.preventDefault(); 
            var formData = $("#language_proficiency_form").serialize();
            var url  = $("#language_proficiency_form").attr('action');
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
                    $(".language_response").html('');
                    if(response.status == true){
                      successMessage(response.message);
                      location.reload();
                    }else{
                       if(response.error_type == 'validation'){
                          $(".language_response").html(response.message);
                       }
                     }
                  },
                  error:function(){
                      internalError();
                  }
            });
         });

         $('#work_expirence_dt,#education_qualification_dt').DataTable({
            "ordering": false
         });
         $('#date_of_birth').datepicker({
          format: 'dd/mm/yyyy',
          autoclose: true,
          maxDate:(new Date()).getDate(),
          todayHighlight: true,
          orientation: "bottom auto"
        });
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
          $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });
        // initialization of navbar vertical navigation
        var sidebar = $('.js-navbar-vertical-aside').hsSideNav();

        // initialization of tooltip in navbar vertical menu
        $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function(e) {
          if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
            return false;
          }
        });

        // initialization of unfold
        // $('.js-hs-unfold-invoker').each(function () {
        //   var unfold = new HSUnfold($(this)).init();
        // });

        // initialization of form search
        // $('.js-form-search').each(function () {
        //   new HSFormSearch($(this)).init()
        // });

        // initialization of file attach
        $('.js-file-attach').each(function () {
          var customFile = new HSFileAttach($(this)).init();
        });

        // initialization of masked input
      //   $('.js-masked-input').each(function () {
      //     var mask = $.HSCore.components.HSMask.init($(this));
      //   });

        // initialization of select2
        $('.js-select2-custom').each(function () {
          var select2 = $.HSCore.components.HSSelect2.init($(this));
        });

        // initialization of sticky blocks
      //   $('.js-sticky-block').each(function () {
      //     var stickyBlock = new HSStickyBlock($(this), {
      //       targetSelector: $('#header').hasClass('navbar-fixed') ? '#header' : null
      //     }).init();
      //   });

        // initialization of scroll nav
        var scrollspy = new HSScrollspy($('#main-content'), {
          // !SETTING "resolve" PARAMETER AND RETURNING "resolve('completed')" IS REQUIRED
          beforeScroll: function(resolve) {
            if (window.innerWidth < 992) {
              $('#navbarVerticalNavMenu').collapse('hide').on('hidden.bs.collapse', function () {
                return resolve('completed');
              });
            } else {
              return resolve('completed');
            }
          }
        }).init();

        // initialization of password strength module
        $('.js-pwstrength').each(function () {
          var pwstrength = $.HSCore.components.HSPWStrength.init($(this));
        });
        $('.js-hs-action').each(function () {
          var unfold = new HSUnfold($(this)).init();
        });
        // var work_expirence_dt = $.HSCore.components.HSDatatables.init($('#work_expirence_dt'));
        // var education_qualification_dt = $.HSCore.components.HSDatatables.init($('#education_qualification_dt'));

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
   function fetchOfficialLanguage(value){
      $.ajax({
         url:"{{ baseUrl('fetch-official-languages') }}",
         data:{
            language:value
         },
         dataType:"json",
         beforeSend:function(){
             $("#second_official").html('');
         },
         success:function(response){
            if(response.status == true){
               $("#second_official").html(response.options);
            } 
         },
         error:function(){
            
         }
      });
   }
   function fetchProficiency(value,type){
      $.ajax({
         url:"{{ baseUrl('fetch-proficiency') }}",
         data:{
            language:value,
            type:type
         },
         dataType:"json",
         beforeSend:function(){
            if(type == 'first'){
               $("#first_proficiency").html('');
            }
            if(type == 'second'){
               $("#second_proficiency").html('');
            }
         },
         success:function(response){
            if(response.status == true){
               if(type == 'first'){
                  $("#first_proficiency").html(response.options);
               }
               if(type == 'second'){
                  $("#second_proficiency").html(response.options);
               }
            } 
         },
         error:function(){
            
         }
      });
   }
</script>    

@endsection