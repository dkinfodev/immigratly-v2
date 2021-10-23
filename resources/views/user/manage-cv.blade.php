@extends('layouts.master')
@section('style')
<link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">
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
<div class="manage_cv">
  <div id="main-content"  class="has-navbar-vertical-aside navbar-vertical-aside-show-xl   footer-offset"
        data-offset="80"
        data-hs-scrollspy-options='{
          "target": "#navbarSettings"
        }'>
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-end">
         <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-no-gutter">
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
               </ol>
            </nav>
            <h1 class="page-title">{{$pageTitle}}</h1>
         </div>
         <!-- <div class="col-sm-auto">
            <a class="btn btn-primary" href="{{ baseUrl('/') }}">
            <i class="tio mr-1"></i> Back 
            </a>
         </div> -->
      </div>
      <!-- End Row -->
   </div>
   <!-- End Page Header -->
   <div class="row">
      <div class="col-lg-3">
         <!-- Navbar -->
         <div class="navbar-vertical navbar-expand-lg mb-3 mb-lg-5">
            <!-- Navbar Toggle -->
            <button type="button" class="navbar-toggler btn btn-block btn-white mb-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu" data-toggle="collapse" data-target="#navbarVerticalNavMenu">
            <span class="d-flex justify-content-between align-items-center">
            <span class="h5 mb-0">Nav menu</span>
            <span class="navbar-toggle-default">
            <i class="tio-menu-hamburger"></i>
            </span>
            <span class="navbar-toggle-toggled">
            <i class="tio-clear"></i>
            </span>
            </span>
            </button>
            <!-- End Navbar Toggle -->
            <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
               <!-- Navbar Nav -->
               <ul id="navbarSettings" class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav">
                  <li class="nav-item">
                     <a class="nav-link active" href="javascript:;">
                     <i class="tio-user-outlined nav-icon"></i>
                     Personal information
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ (cv_progress('work_expirences') <= 0)?'text-danger':'' }}" href="javascript:;">
                     <i class="tio-online nav-icon"></i>
                     Work Expirences 
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ (cv_progress('educations') <= 0)?'text-danger':'' }}" href="javascript:;">
                     <i class="tio-education-outlined nav-icon"></i>
                      Qualifications
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ (cv_progress('language_proficiency') <= 0)?'text-danger':'' }}" href="javascript:;">
                     <i class="tio-settings-outlined nav-icon"></i>
                     Language Proficiency
                     </a>
                  </li>
                  
               </ul>
               <!-- End Navbar Nav -->
            </div>
         </div>
         <!-- End Navbar -->
      </div>
      <div class="col-lg-9">
         <!-- Legend Indicators -->
         <div class="row justify-content-start mb-2">
          <div class="col-md-3">
            <span class="legend-indicator bg-success"></span>
            Profile
          </div>
          <div class="col-md-3">
            @if(cv_progress('work_expirences') > 0)
            <span class="legend-indicator bg-success"></span>
            @else
            <span class="legend-indicator bg-danger"></span>
            @endif
            Experiences
          </div>
          <div class="col-md-3">
            @if(cv_progress('educations') > 0)
            <span class="legend-indicator bg-success"></span>
            @else
            <span class="legend-indicator bg-danger"></span>
            @endif
            Educations
          </div>
          <div class="col-md-3">
            @if(cv_progress('language_proficiency') > 0)
            <span class="legend-indicator bg-success"></span>
            @else
            <span class="legend-indicator bg-danger"></span>
            @endif
            Language Proficiency
          </div>
        </div>
        <!-- End Legend Indicators -->

        <!-- Progress -->
        <div class="progress rounded-pill mb-2" style="height:25px;">
          <!-- <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div> -->
          <div class="progress-bar bg-success" role="progressbar" style="width: {{cv_progress()}}%" aria-valuenow="{{cv_progress()}}" aria-valuemin="0" aria-valuemax="100">{{cv_progress()}}%</div>
        </div>
        <!-- End Progress -->
         
         <!-- Card -->
         <form id="personal_info_form" class="js-validate" action="{{ baseUrl('/update-profile') }}" method="post">
            @csrf
            <div class="card mb-3 mb-lg-5">
               <!-- Profile Cover -->
               <div class="profile-cover">
                  <div class="profile-cover-img-wrapper">
                     <img id="profileCoverImg" class="profile-cover-img" src="assets/img/1920x400/img2.jpg" alt="Image Description">
                     <!-- Custom File Cover -->
                     <!-- <div class="profile-cover-content profile-cover-btn">
                        <div class="custom-file-btn">
                           <input type="file" class="js-file-attach custom-file-btn-input" id="profileCoverUplaoder"
                              data-hs-file-attach-options='{
                              "textTarget": "#profileCoverImg",
                              "mode": "image",
                              "targetAttr": "src"
                              }'>
                           <label class="custom-file-btn-label btn btn-sm btn-white" for="profileCoverUplaoder">
                           <i class="tio-add-photo mr-sm-1"></i>
                           <span class="d-none d-sm-inline-block">Update your header</span>
                           </label>
                        </div>
                     </div> -->
                     <!-- End Custom File Cover -->
                  </div>
               </div>
               <!-- End Profile Cover -->
               <!-- Avatar -->
               <label class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader profile-cover-avatar" for="avatarUploader">
                  @if($user->profile_image != '' &&  file_exists(userDir().'/profile/'.$user->profile_image))
                     <img id="avatarImg" class="avatar-img" src="{{ userDirUrl().'/profile/'.$user->profile_image }}" alt="Image Description">
                  @else
                     <img id="avatarImg" class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
                  @endif
                  <input type="file" name="profile_image" class="js-file-attach avatar-uploader-input" id="avatarUploader"
                  data-hs-file-attach-options='{
                  "textTarget": "#avatarImg",
                  "mode": "image",
                  "targetAttr": "src"
                  }'>
               <span class="avatar-uploader-trigger">
               <i class="tio-edit avatar-uploader-icon shadow-soft"></i>
               </span>
               </label>
               <!-- End Avatar -->
               <!-- Body -->
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-5">
                        <!-- <span class="d-block font-size-sm mb-2">Who can see your profile photo? <i class="tio-help-outlined" data-toggle="tooltip" data-placement="top" title="Your visibility setting only applies to your profile photo. Your header image is always visible to anyone."></i></span> -->
                        <!-- Select -->
                        <!-- <div class="select2-custom">
                           <select class="js-select2-custom"
                              data-hs-select2-options='{
                              "minimumResultsForSearch": "Infinity"
                              }'>
                              <option value="privacy1" data-option-template='<span class="media"><i class="tio-earth-east tio-lg text-body mr-2" style="margin-top: .125rem;"></i><span class="media-body"><span class="d-block">Anyone</span><small class="select2-custom-hide">Visible to anyone who can view your content. Accessible by installed apps.</small></span></span>'>Anyone</option>
                              <option value="privacy2" data-option-template='<span class="media"><i class="tio-lock-outlined tio-lg text-body mr-2" style="margin-top: .125rem;"></i><span class="media-body"><span class="d-block">Only you</span><small class="select2-custom-hide">Only visible to you.</small></span></span>'>Only you</option>
                           </select>
                        </div> -->
                        <!-- End Select -->
                     </div>
                  </div>
                  <!-- End Row -->
               </div>
               <!-- End Body -->
            </div>
            <!-- End Card -->

            <!-- Card -->
            
            <!-- Card -->
            <div class="card mb-3 mb-lg-5">
               <div class="card-header">
                  <h2 class="card-title h4"><i class="tio-user-outlined nav-icon"></i> Personal information</h2>
               </div>
               <!-- Body -->
               <div class="card-body">
                  <!-- Form -->
                     <div class="row form-group">
                        <label class="col-sm-3 col-form-label input-label">CV Type</label>
                        <div class="col-sm-9">
                           <div class="js-form-message">
                              <select name="cv_type" id="cv_type" class="form-control">
                                 <option value="">Select CV Type</option>
                                 @foreach($cv_types as $type)
                                 <option {{$user_detail->cv_type == $type->id?"selected":""}} value="{{$type->id}}">{{$type->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">Full name <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Displayed on public forums, such as Front."></i></label>
                        <div class="col-sm-9">
                           <div class="input-group input-group-sm-down-break">
                              <input type="text" class="form-control" id="firstNameLabel" placeholder="Your first name" name="first_name" aria-label="Your first name" value="{{ $user->first_name }}">
                              <input type="text" class="form-control" id="lastNameLabel" placeholder="Your last name" name="last_name" aria-label="Your last name" value="{{ $user->last_name }}">
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label for="emailLabel" class="col-sm-3 col-form-label input-label">Email</label>
                        <div class="col-sm-9">
                           <input type="email" class="form-control" name="email" id="emailLabel" placeholder="Email" aria-label="Email" value="{{ $user->email }}">
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group">
                        <label class="col-sm-3 col-form-label input-label">Phone Number</label>
                        <div class="col-sm-3">
                           <div class="js-form-message">
                              <select name="country_code" id="country_code" class="form-control">
                                 <option value="">Select Country</option>
                                 @foreach($countries as $country)
                                 <option {{$user->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode."(".$country->sortname.")"}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="js-form-message">
                              <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="phone no" required data-msg="Please enter your phone number." value="{{$user->phone_no}}">
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label class="col-sm-3 col-form-label input-label">Country</label>
                        <div class="col-sm-9">
                           <div class="js-form-message">
                              <select name="country_id" id="country_id" onchange="stateList(this.value,'state_id')" class="form-control">
                                 <option value="">Select Country</option>
                                 @foreach($countries as $country)
                                 <option {{$user_detail->country_id == $country->id?"selected":""}} value="{{$country->id}}">{{$country->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label class="col-sm-3 col-form-label input-label">State</label>
                        <div class="col-sm-9">
                           <div class="js-form-message">
                              <select name="state_id" id="state_id" aria-label="State" required data-msg="Please select your state" onchange="cityList(this.value,'city_id')" class="form-control">
                                 <option value="">Select State</option>
                                 @foreach($states as $state)
                                 <option {{$user_detail->state_id == $state->id?"selected":""}} value="{{$state->id}}">{{$state->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label class="col-sm-3 col-form-label input-label">City</label>
                        <div class="col-sm-9">
                           <div class="js-form-message">
                              <select name="city_id" id="city_id"  aria-label="City" required data-msg="Please select your city" class="form-control">
                                 <option value="">Select City</option>
                                 @foreach($cities as $city)
                                 <option {{$user_detail->city_id == $city->id?"selected":""}} value="{{$city->id}}">{{$city->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label for="addressLine1Label" class="col-sm-3 col-form-label input-label">Address</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" name="address" id="addressLine1Label" placeholder="Your address" aria-label="Your address" value="{{ $user_detail->address }}">
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label for="zipCodeLabel" class="col-sm-3 col-form-label input-label">Zip code <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="You can find your code in a postal address."></i></label>
                        <div class="col-sm-9">
                           <input type="text" class="js-masked-input form-control" name="zip_code" id="zipCodeLabel" placeholder="Your zip code" aria-label="Your zip code" value="{{ $user_detail->zip_code }}"
                              data-hs-mask-options='{
                              "template": "AA0 0AA"
                              }'>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group js-form-message">
                        <label class="col-sm-3 col-form-label input-label">Date of Birth</label>
                        <div class="col-sm-9">
                           <div class="input-group">
                              <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $user_detail->date_of_birth }}" placeholder="Date of Birth" aria-label="Date of birth" required data-msg="Enter date of birth">
                              <div class="input-group-addon p-2">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group">
                        <label class="col-sm-3 col-form-label input-label">Gender</label>
                        <div class="col-sm-9">
                           <div class="js-form-message">
                              <select name="gender" class="form-control">
                                 <option value="">Select Gender</option>
                                 <option {{($user_detail->gender == 'male')?'selected':''}} value="male">Male</option>
                                 <option {{($user_detail->gender == 'female')?'selected':''}} value="female">Female</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <!-- Form Group -->
                     <div class="row form-group">
                        <label class="col-sm-3 col-form-label input-label">Language Known</label>
                        <div class="col-sm-9">
                           <div class="js-form-message">
                              <select name="languages_known[]" multiple id="languages_known" class="form-control">
                              <?php
                                 if($user_detail->languages_known != ''){
                                    $language_known = json_decode($user_detail->languages_known,true);
                                 }else{
                                    $language_known = array();
                                 }
                                 
                              ?> 
                              @foreach($languages as $language)
                              <option {{ (in_array($language->id,$language_known))?'selected':'' }} value="{{$language->id}}">{{$language->name}}</option>
                              @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                     <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                     </div>
               
                  <!-- End Form -->
               </div>
               <!-- End Body -->
            </div>
         </form>
         <!-- End Card -->
         <!-- Card -->
         <div id="workExpirences" class="card mb-3 mb-lg-5">
           <div class="card-header d-block">
            <div class="row">
             <div class="col-md-6">
                <h2 class="card-title h4 pt-2"><i class="tio-online nav-icon"></i> Work Expirences</h2>
             </div>
             <div class="col-md-6 text-right">
                <a href="javascript:;" onclick="showPopup('<?php echo baseUrl('work-experiences/add') ?>')" class="btn btn-primary"><i class="tio-add"></i> Add</a>
             </div>
            </div>
           </div>
           <div class="card-body">
              <!-- Table -->
              <div class="table-responsive datatable-custom">
                <table id="work_expirence_dt" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                         "order": [],
                         "isResponsive": false,
                         "isShowPaging": false,
                         "pagination": "datatableWithPaginationPagination"
                       }'>
                  <thead class="thead-light">
                    <tr>
                      <th class="no-sort">#</th>
                      <th>Employment Agency</th>
                      <th>Position</th>
                      <th>Duration</th>
                      <th>Job Type</th>
                      <!-- <th>NOC Code</th> -->
                      <th class="no-sort"></th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($work_expirences as $key => $expirence)
                        <tr>
                           <td>{{$key+1}}</td>
                           <td>{{$expirence->employment_agency}}</td>
                           <td>{{$expirence->position}}</td>
                           <td>{{$expirence->join_date}} <br> {{$expirence->leave_date}}</td>
                           <td>{{$expirence->job_type}}</td>
                           <!-- <td>{{$expirence->noc_code}}</td> -->
                           <td class="pr-3">
                              <div class="hs-unfold">
                                 <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                                    data-hs-unfold-options='{
                                      "target": "#we-action-{{$key}}",
                                      "type": "css-animation"
                                    }'>
                                    <i class="tio-chevron-down ml-1"></i>
                                 </a>
                                 <div id="we-action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('work-experiences/edit/'.base64_encode($expirence->id)) ?>')">
                                      <i class="tio-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('work-experiences/delete/'.base64_encode($expirence->id))}}">
                                      <i class="tio-delete"></i> Delete
                                    </a> 
                                 </div>
                               </div>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
                  
                </table>
              </div>
              <!-- End Table -->
            </div>
           <!-- Footer -->
           <div class="card-footer">
             <!-- Pagination -->
             <div class="d-flex justify-content-center justify-content-sm-end">
               <nav id="datatableWithPaginationPagination" aria-label="Activity pagination"></nav>
             </div>
             <!-- End Pagination -->
           </div>
              <!-- End Footer -->
         </div>
            <!-- End Card -->
         <!-- End Card -->
         <!-- Card -->
         <div id="educationQualifications" class="card mb-3 mb-lg-5">
            <div class="card-header d-block">
               <div class="row">
                <div class="col-md-6">
                   <h2 class="card-title h4 pt-2"><i class="tio-education nav-icon"></i> Education & Qualifications</h2>
                </div>
                <div class="col-md-6 text-right">
                   <a href="javascript:;" onclick="showPopup('<?php echo baseUrl('educations/add') ?>')" class="btn btn-primary"><i class="tio-add"></i> Add</a>
                </div>
               </div>
            </div>
            <!-- Body -->
            <div class="card-body">
               <!-- Table -->
                 <div class="table-responsive datatable-custom">
                   <table id="education_qualification_dt" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                          data-hs-datatables-options='{
                            "order": [],
                            "isResponsive": false,
                            "isShowPaging": false,
                            "pagination": "education_qualification_dt_pagination"
                          }'>
                     <thead class="thead-light">
                       <tr>
                         <th>#</th>
                         <th>Degree</th>
                         <th>Qualification</th>
                         <th>Percentage</th>
                         <th>Year Passed</th>
                         <th></th>
                       </tr>
                     </thead>
                     <tbody>
                        @foreach($educations as $key => $education)
                        <tr>
                           <td>{{$key+1}}</td>
                           <td>{{$education->Degree->name}}</td>
                           <td>{{$education->qualification}}</td>
                           <td>{{$education->percentage}}%</td>
                           <td>{{$education->year_passed}}</td>
                           <td class="pr-3">
                              <div class="hs-unfold">
                                 <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                                    data-hs-unfold-options='{
                                      "target": "#edu-action-{{$key}}",
                                      "type": "css-animation"
                                    }'>
                                    <i class="tio-chevron-down ml-1"></i>
                                 </a>
                                 <div id="edu-action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('educations/edit/'.base64_encode($education->id)) ?>')">
                                      <i class="tio-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('educations/delete/'.base64_encode($education->id))}}">
                                      <i class="tio-delete"></i> Delete
                                    </a> 
                                 </div>
                               </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     
                   </table>
               </div>
                 <!-- End Table -->
            </div>
            <!-- End Body -->
            <!-- Footer -->
              <div class="card-footer">
                <!-- Pagination -->
                <div class="d-flex justify-content-center justify-content-sm-end">
                  <nav id="education_qualification_dt_pagination" aria-label="Activity pagination"></nav>
                </div>
                <!-- End Pagination -->
              </div>
                 <!-- End Footer -->
         </div>
         <!-- End Card -->
         <!-- Card -->
         <div id="languageProficiency" class="card mb-3 mb-lg-5">
            <div class="card-header">
               <h4 class="card-title"><i class="tio-settings-outlined nav-icon"></i> Language Proficiency</h4>
            </div>
            <!-- Body -->
            <div class="card-body">
            <form id="language_proficiency_form" class="js-validate" action="{{ baseUrl('/save-language-proficiency') }}" method="post">
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <h3>First Official Language</h3>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group js-form-message">
                        <label>Language <span class="text-danger">*</span></label>
                        <select onchange="fetchOfficialLanguage(this.value),fetchProficiency(this.value,'first')" name="first_official[language]" required>
                           <option value="">Select Language</option>
                           @foreach($official_languages as $off_language)
                                 <option <?php echo (isset($first_official) && $first_official->language_id == $off_language->unique_id)?'selected':'' ?> value="{{ $off_language->unique_id}}">{{$off_language->name}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group js-form-message">
                        <label>Proficiency</label>
                        <select id="first_proficiency" name="first_official[proficiency]">
                           <option value="">Select Proficiency</option>
                           @foreach($first_proficencies as $proficiency)
                                 <option <?php echo (isset($first_official) && $first_official->proficiency == $proficiency->unique_id)?'selected':'' ?> value="{{ $proficiency->unique_id }}">{{$proficiency->name}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group js-form-message">
                        <label>Reading <span class="text-danger">*</span></label>
                        <input type="text" name="first_official[reading]" value="<?php echo (isset($first_official))?$first_official->reading:'' ?>" required class="form-control" placeholder="Reading" />
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group js-form-message">
                        <label>Writing <span class="text-danger">*</span></label>
                        <input type="text" name="first_official[writing]" value="<?php echo (isset($first_official))?$first_official->writing:'' ?>"  required class="form-control" placeholder="Writing" />
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group js-form-message">
                        <label>Listening <span class="text-danger">*</span></label>
                        <input type="text" name="first_official[listening]" value="<?php echo (isset($first_official))?$first_official->listening:'' ?>"  required class="form-control" placeholder="Listening" />
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group js-form-message">
                        <label>Speaking <span class="text-danger">*</span></label>
                        <input type="text" name="first_official[speaking]" value="<?php echo (isset($first_official))?$first_official->speaking:'' ?>"  required class="form-control" placeholder="Speaking" />
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <h3>Second Official Language</h3>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group js-form-message">
                        <label>Language</label>
                        <select onchange="fetchProficiency(this.value,'second')" id="second_official" name="second_official[language]">
                           <option value="">Select Language</option>
                           @foreach($second_off_languages as $off_language)
                                 <option <?php echo (isset($second_official) && $second_official->language_id == $off_language->unique_id)?'selected':'' ?> value="{{ $off_language->unique_id}}">{{$off_language->name}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group js-form-message">
                        <label>Proficiency</label>
                        <select id="second_proficiency" name="second_official[proficiency]">
                           <option value="">Select Proficiency</option>
                           @foreach($second_proficencies as $proficiency)
                                 <option <?php echo (isset($second_official) && $second_official->proficiency == $proficiency->unique_id)?'selected':'' ?> value="{{ $proficiency->unique_id}}">{{$proficiency->name}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Reading</label>
                        <input type="text" name="second_official[reading]" value="<?php echo (isset($second_official))?$second_official->reading:'' ?>" class="form-control" placeholder="Reading" />
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Writing</label>
                        <input type="text" name="second_official[writing]" value="<?php echo (isset($second_official))?$second_official->writing:'' ?>" class="form-control" placeholder="Writing" />
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Listening</label>
                        <input type="text" name="second_official[listening]" value="<?php echo (isset($second_official))?$second_official->listening:'' ?>" class="form-control" placeholder="Listening" />
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Speaking</label>
                        <input type="text" name="second_official[speaking]" value="<?php echo (isset($second_official))?$second_official->speaking:'' ?>" class="form-control" placeholder="Speaking" />
                     </div>
                  </div>
               </div>
               <div class="p-2 language_response text-danger"></div>
               <div class="form-group">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </form>
               <!-- Form -->
               {{--<form id="language_proficiency_form" class="js-validate" action="{{ baseUrl('/save-language-proficiency') }}" method="post">
               @csrf
                  <!-- Form Group -->
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label">PTE</label>
                     <div class="col-sm-9 js-form-message">
                        <input type="text" class="form-control" name="pte" id="pte" placeholder="Enter PTE Points" aria-label="PTE" value="{{ !empty($language_proficiency)?$language_proficiency->pte:'' }}">
                     </div>
                  </div>
                  <!-- End Form Group -->
                  <!-- Form Group -->
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label">TOFEL</label>
                     <div class="col-sm-9 js-form-message">
                        <input type="text" class="form-control" name="tofel" id="tofel" placeholder="Enter TOFEL Points" aria-label="TOFEL" value="{{ !empty($language_proficiency)?$language_proficiency->tofel:'' }}">
                     </div>
                  </div>
                  <!-- End Form Group -->

                  <!-- Form Group -->
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label">IELTS</label>
                     <div class="col-sm-9 js-form-message">
                        <input type="text" class="form-control" name="ielts" id="ielts" placeholder="Enter TOFEL Points" aria-label="TOFEL" value="{{ !empty($language_proficiency)?$language_proficiency->tofel:'' }}">
                     </div>
                  </div>
                  <!-- End Form Group -->

                  <!-- Form Group -->
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label">GRE</label>
                     <div class="col-sm-9 js-form-message">
                        <input type="text" class="form-control" name="gre" id="gre" placeholder="Enter GRE Points" aria-label="TOFEL" value="{{ !empty($language_proficiency)?$language_proficiency->gre:'' }}">
                     </div>
                  </div>
                  <!-- End Form Group -->

                  <!-- Form Group -->
                  <div class="row form-group">
                     <label class="col-sm-3 col-form-label input-label">Other</label>
                     <div class="col-sm-9 js-form-message">
                        <input type="text" class="form-control" name="other" id="other" placeholder="Enter Other Points" aria-label="Other" value="{{ !empty($language_proficiency)?$language_proficiency->other:'' }}">
                     </div>
                  </div>
                  <!-- End Form Group -->

                  <!-- End Toggle Switch -->
                  <div class="d-flex justify-content-end">
                     <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
               </form>--}}
               <!-- End Form -->
            </div>
            <!-- End Body -->
         </div>
         <!-- End Card -->
        
         <!-- Sticky Block End Point -->
         <div id="stickyBlockEndPoint"></div>
      </div>
   </div>
  </div>
</div>
<!-- End Content -->
@endsection
@section('javascript')
<!-- JS Implementing Plugins -->
<link href="assets/vendor/datatables/media/css/jquery.dataTables.min.css" />
<!-- <script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script> -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
<script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>
<script src="assets/vendor/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js"></script>
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
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
        $('.js-masked-input').each(function () {
          var mask = $.HSCore.components.HSMask.init($(this));
        });

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