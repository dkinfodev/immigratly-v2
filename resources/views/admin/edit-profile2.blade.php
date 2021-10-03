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
                        <a class="nav-link active" href="javascript:;">Edit Profile</a>
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

        <!-- Step Form -->
        <form id="profile_form" class="js-step-form js-validate" data-hs-step-form-options='{
    "progressSelector": "#validationFormProgress",
    "stepsSelector": "#validationFormContent",
    "endSelector": "#validationFormFinishBtn",
    "isValidate": true
  }'>
            @csrf
            <!-- Step -->
            <ul id="validationFormProgress"
                class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                        "targetSelector": "#validationPersonalInfo"
                        }'>
                        <span class="step-icon step-icon-soft-dark">1</span>
                        <div class="step-content">
                            <span class="step-title">Personal Info</span>
                        </div>
                    </a>
                </li>

                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
  "targetSelector": "#validationFormAboutMe"
}'>
                        <span class="step-icon step-icon-soft-dark">2</span>
                        <div class="step-content">
                            <span class="step-title">About</span>
                        </div>
                    </a>
                </li>

                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
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
                                <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2"
                                    src="{{ professionalProfile() }}" alt="Profile Image">

                                <span class="d-block">Upload your Image here</span>

                                <input type="file" class="js-file-attach custom-file-boxed-input" name="profile_image"
                                    id="logoUploader" data-hs-file-attach-options='{
                                        "textTarget": "#logoImg",
                                        "mode": "image",
                                        "targetAttr": "src"
                                        }'>
                            </label>
                            <!-- End Logo -->
                        </div>

                        <div class="col-md-7 justify-content-md-end">

                            <div class="row form-group">
                                <div class="col-12">
                                    <label for="validationFormUsernameLabel" class="col-form-label input-label">First
                                        name</label>
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="first_name"
                                            id="validationFormFirstnameLabel" placeholder="Firstname"
                                            aria-label="Firstname" required data-msg="Please enter your first name."
                                            value="{{ $user->first_name }}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="row form-group">
                                <div class="col-12">
                                    <label for="validationFormUsernameLabel" class="col-form-label input-label">Last
                                        name</label>
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="last_name"
                                            id="validationFormLastnameLabel" placeholder="Lastname"
                                            aria-label="Lastname" required data-msg="Please enter your last name."
                                            value="{{ $user->last_name }}">
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
                                        <input type="email" class="form-control" name="email"
                                            id="validationFormEmailLabel" placeholder="Email" aria-label="Email"
                                            required data-msg="Please enter your email." value="{{ $user->email }}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Phone Number</label>

                                <div class="col-sm-3">
                                    <div class="js-form-message">
                                        <select name="country_code" id="country_code" class="form-control">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option {{$user->country_code == $country->phonecode?"selected":""}}
                                                value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="phone_no" id="phone_no"
                                            placeholder="Phone number" aria-label="Email" required
                                            data-msg="Please enter your phone number." value="{{$user->phone_no}}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Gender</label>

                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <select name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option {{($user->gender == 'male')?'selected':''}} value="male">Male
                                            </option>
                                            <option {{($user->gender == 'female')?'selected':''}} value="female">Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Date of Birth</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="date_of_birth" id="date_of_birth"
                                            value="{{ $user->date_of_birth }}" class="form-control"
                                            placeholder="Date of Birth" aria-label="Date of birth" required
                                            data-msg="Enter date of birth">
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
                                        <select name="languages_known[]" multiple id="languages_known"
                                            class="form-control">
                                            <?php
                                            if($user->languages_known != ''){
                                                $language_known = json_decode($user->languages_known,true);
                                            }else{
                                                $language_known = array();
                                            }
                                            ?>
                                            @foreach($languages as $language)
                                            <option {{in_array($language->id,$language_known)?"selected":""}}
                                                value="{{$language->id}}">{{$language->name}}</option>
                                            @endforeach
                                        </select>
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
                                        <select name="country_id" id="country_id"
                                            onchange="stateList(this.value,'state_id')" class="form-control">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option {{$user->country_id == $country->id?"selected":""}}
                                                value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">State</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <select name="state_id" id="state_id" aria-label="State" required
                                            data-msg="Please select your state"
                                            onchange="cityList(this.value,'city_id')" class="form-control">
                                            <option value="">Select State</option>
                                            @foreach($states as $state)
                                            <option {{$user->state_id == $state->id?"selected":""}}
                                                value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">City</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <select name="city_id" id="city_id" aria-label="City" required
                                            data-msg="Please select your city" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                            <option {{$user->city_id == $city->id?"selected":""}} value="{{$city->id}}">
                                                {{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Address</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="address" id="address"
                                            placeholder="Address" aria-label="Address" required
                                            data-msg="Please enter your address" value="{{ $user->address }}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Zip Code</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="zip_code" id="zip_code"
                                            placeholder="Zipcode" aria-label="Zipcode" required
                                            data-msg="Please enter your zip code" value="{{ $user->zip_code }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->
                    </div>

                    <!-- Footer -->
                    <div class="d-flex align-items-center">
                        <div class="ml-auto">
                            <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
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
                                <select name="cp_country_id" aria-label="Country" required
                                    data-msg="Please select your country" id="cp_country_id"
                                    onchange="stateList(this.value,'cp_state_id'),licenceBodies(this.value)"
                                    class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option {{$user->country_id == $country->id?"selected":""}}
                                        value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->

                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label input-label">License Body</label>

                        <div class="col-sm-7">
                            <div class="js-form-message">
                                <select name="license_body[]" multiple id="license_body" class="form-control">
                                    <option value="">Select Licence Body</option>
                                    <?php
                                        $license_body = json_decode($company_details->license_body,true);
                                    ?>
                                    @foreach($licence_bodies as $bodies)
                                    <option {{in_array($bodies->id,$license_body)?"selected":""}}
                                        value="{{$bodies->id}}">{{$bodies->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label input-label">Are you member in good standing</label>
                        <div class="col-sm-7">
                            <div class="js-form-message">
                                <select name="member_of_good_standing" required data-msg="Please select your option"
                                    class="form-control">
                                    <option value="">Select Option</option>
                                    <option {{($company_details->member_of_good_standing == 'yes')?'selected':''}}
                                        value="yes">Yes</option>
                                    <option {{($company_details->member_of_good_standing == 'no')?'selected':''}}
                                        value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label input-label">Licence Number</label>
                        <div class="col-sm-7">
                            <div class="js-form-message">
                                <input type="text" class="form-control" name="licence_number" id="licence_number"
                                    placeholder="Licence Number" aria-label="Licence Number" required
                                    data-msg="Please enter your licence number"
                                    value="{{ $company_details->licence_number }}">
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->
                    <!-- Form Group -->
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label input-label">Upload your license certificate</label>
                        <div class="col-sm-7">
                            <div class="js-form-message">
                                <div class="custom-file">
                                    <input type="file" class="js-file-attach custom-file-input"
                                        name="licence_certificate" id="licence_certificate" data-hs-file-attach-options='{
                                            "textTarget": "[for=\"licence_certificate\"]"
                                            }'>
                                    <label class="custom-file-label" for="licence_certificate">Choose file</label>
                                </div>
                            </div>
                            @if($company_details->licence_certificate != '' &&
                            file_exists(professionalDir().'/documents/'.$company_details->licence_certificate))
                            <a class="badge badge-primary" download
                                href="{{ professionalDirUrl().'/documents/'.$company_details->licence_certificate }}"><i
                                    class="fa fa-download"></i>{{$company_details->licence_certificate}}</a>
                            @endif
                        </div>
                    </div>
                    <!-- End Form Group -->
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label input-label">Years of Expirence</label>
                        <div class="col-sm-7">
                            <div class="js-form-message">
                                <select name="years_of_expirences" aria-label="Years of Expirence" required
                                    data-msg="Please select your expirence" class="form-control">
                                    <option>Select</option>
                                    <option
                                        {{($company_details->years_of_expirences == 'less then 2 years')?'selected':''}}
                                        value="less then 2 years">Less then 2 years</option>
                                    <option {{($company_details->years_of_expirences == '2 to 5 years')?'selected':''}}
                                        value="2 to 5 years">2 to 5 years</option>
                                    <option {{($company_details->years_of_expirences == '5 to 10 years')?'selected':''}}
                                        value="5 to 10 years">5 to 10 years</option>
                                    <option {{($company_details->years_of_expirences == '10+ years')?'selected':''}}
                                        value="10+ years">10+ years</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Form Group -->
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label input-label">Member of any other designated body</label>
                        <div class="col-sm-7">
                            <div class="js-form-message">
                                <input type="text" class="form-control" name="member_of_other_designated_body"
                                    id="member_of_other_designated_body"
                                    placeholder="Member of any other designated body"
                                    aria-label="Member of any other designated body"
                                    data-msg="Please enter your licence number"
                                    value="{{ $company_details->member_of_other_designated_body }}">
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->

                    <!-- End Quill -->


                    <!-- Footer -->
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-ghost-secondary mr-2" data-hs-step-form-prev-options='{
                            "targetSelector": "#validationPersonalInfo"
                            }'>
                            <i class="tio-chevron-left"></i> Previous step
                        </button>

                        <div class="ml-auto">
                            <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
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
                            <!-- Logo -->
                            <label class="custom-file-boxed custom-file-boxed-sm" for="company_logo">
                                <img id="companylogoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2"
                                    src="{{ professionalLogo() }}" alt="Company Logo">

                                <span class="d-block">Upload your company logo</span>

                                <input type="file" class="js-file-attach custom-file-boxed-input" name="company_logo"
                                    id="company_logo" data-hs-file-attach-options='{
                                        "textTarget": "#companylogoImg",
                                        "mode": "image",
                                        "targetAttr": "src"
                                        }'>
                            </label>
                            <!-- End Logo -->
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Company Name</label>

                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="company_name"
                                            id="validationFormCompanyCompanyNameLabel" placeholder="Company"
                                            aria-label="Company Name" required
                                            data-msg="Please enter your company name."
                                            value="{{$company_details->company_name}}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Website URL</label>

                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="website_url" id="website_url"
                                            placeholder="Website URL" aria-label="Website URL" required
                                            data-msg="Please enter your website."
                                            value="{{$company_details->website_url}}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Email</label>

                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <input type="email" class="form-control" name="cp_email" id="cp_email"
                                            placeholder="Email" aria-label="Email" required
                                            data-msg="Please enter your email." value="{{$company_details->email}}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Phone Number</label>
                                <div class="col-sm-3">
                                    <div class="js-form-message">
                                        <select name="cp_country_code" id="cp_country_code" class="form-control">
                                            <option>Select</option>
                                            @foreach($countries as $country)
                                            <option
                                                {{$company_details->country_code == $country->phonecode?"selected":""}}
                                                value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="cp_phone_no" id="cp_phone_no"
                                            placeholder="Phone number" aria-label="Email" required
                                            data-msg="Please enter your phone number."
                                            value="{{$company_details->phone_no}}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->

                            <!-- End Form Group -->

                        </div> <!-- div end -->


                        <div class="col-md-6">
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Owner ID Proof</label>

                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <div class="custom-file">
                                            <input type="file" class="js-file-attach custom-file-input"
                                                name="owner_id_proof" id="owner_id_proof" data-hs-file-attach-options='{
                                                    "textTarget": "[for=\"owner_id_proof\"]"
                                                    }'>
                                            <label class="custom-file-label" for="owner_id_proof">Choose file</label>
                                        </div>
                                    </div>
                                    @if($company_details->owner_id_proof != '' &&
                                    file_exists(professionalDir().'/documents/'.$company_details->owner_id_proof))
                                    <a class="badge badge-primary" download
                                        href="{{ professionalDirUrl().'/documents/'.$company_details->owner_id_proof }}"><i
                                            class="fa fa-download"></i>{{$company_details->owner_id_proof}}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Company Address Proof</label>

                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <div class="custom-file">
                                            <input type="file" class="js-file-attach custom-file-input"
                                                name="company_address_proof" id="company_address_proof"
                                                data-hs-file-attach-options='{
                                                    "textTarget": "[for=\"company_address_proof\"]"
                                                    }'>
                                            <label class="custom-file-label" for="company_address_proof">Choose
                                                file</label>
                                        </div>
                                    </div>
                                    @if($company_details->company_address_proof != '' &&
                                    file_exists(professionalDir().'/documents/'.$company_details->company_address_proof))
                                    <a class="badge badge-primary" download
                                        href="{{ professionalDirUrl().'/documents/'.$company_details->company_address_proof }}"><i
                                            class="fa fa-download"></i>{{$company_details->owner_id_proof}}</a>
                                    @endif
                                </div>
                            </div>
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">State</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <select name="cp_state_id" id="cp_state_id"
                                            onchange="cityList(this.value,'cp_city_id')" class="form-control">
                                            <option value="">Select State</option>
                                            @foreach($states as $state)
                                            <option {{$company_details->state_id == $state->id?"selected":""}}
                                                value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">City</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <select name="cp_city_id" id="cp_city_id" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                            <option {{$company_details->city_id == $city->id?"selected":""}}
                                                value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label input-label">Register Date</label>

                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="date_of_register" id="date_of_register"
                                            class="form-control" placeholder="Date of Register"
                                            aria-label="Date of Register" required data-msg="Enter date of register"
                                            value="{{ $company_details->date_of_register }}">
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
                                        <input type="text" class="form-control" name="cp_address" id="cp_address"
                                            placeholder="Address" aria-label="Address" required
                                            data-msg="Please enter your address"
                                            value="{{ $company_details->address }}">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label for="validationFormZipLabel" class="col-sm-5 col-form-label input-label">Zip
                                    Code</label>
                                <div class="col-sm-7">
                                    <div class="js-form-message">
                                        <input type="text" class="form-control" name="cp_zip_code" id="cp_zip_code"
                                            placeholder="Zipcode" aria-label="Zipcode" required
                                            data-msg="Please enter your zip code"
                                            value="{{ $company_details->zip_code }}">
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
                        <div class="d-flex justify-content-end ml-auto">
                            <button type="button" class="btn btn-white mr-2" data-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Save
                                Changes</button>
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
$(document).on('ready', function() {
    $('#date_of_birth,#date_of_register').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate: (new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });

    $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this));
    });

    // initialization of step form
    $('.js-step-form').each(function() {
        var stepForm = new HSStepForm($(this), {
            finish: function() {
                var formData = new FormData($("#profile_form")[0]);
                $.ajax({
                    url: "{{ baseUrl('update-profile') }}",
                    type: "post",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $("#validationFormFinishBtn").html("Processing...");
                        $("#validationFormFinishBtn").attr("disabled",
                            "disabled");
                    },
                    success: function(response) {
                        $("#validationFormFinishBtn").html("Save Data");
                        $("#validationFormFinishBtn").removeAttr("disabled");
                        if (response.status == true) {
                            successMessage(response.message);
                            setTimeout(function() {
                                window.location.href = window.location
                                    .href;
                            }, 2000);

                        } else {
                            $("#err_response").html(
                                '<h4><b>*Field required</b></h4>');
                            $.each(response.message, function(index, value) {
                                $("#err_response").append("<p>" +
                                    value + "</p>");
                                $("input[name=" + index + "]").parents(
                                    ".js-form-message").find("#" +
                                    index + "-error").remove();
                                $("input[name=" + index + "]").parents(
                                    ".js-form-message").find(
                                    ".form-control").removeClass(
                                    'is-invalid');

                                var html = '<div id="' + index +
                                    '-error" class="invalid-feedback">' +
                                    value + '</div>';
                                $(html).insertAfter("*[name=" + index +
                                    "]");
                                $("input[name=" + index + "]").parents(
                                    ".js-form-message").find(
                                    ".form-control").addClass(
                                    'is-invalid');
                            });
                        }
                    },
                    error: function() {
                        $("#validationFormFinishBtn").html("Save Data");
                        $("#validationFormFinishBtn").removeAttr("disabled");
                        internalError();
                    }
                });
            }
        }).init();
    });

    // initialization of quilljs editor
    $('.js-flatpickr').each(function() {
        $.HSCore.components.HSFlatpickr.init($(this));
    });
    // initEditor("about_professional");
});

function licenceBodies(country_id) {
    $.ajax({
        url: "{{ url('licence-bodies') }}",
        data: {
            country_id: country_id
        },
        dataType: "json",
        beforeSend: function() {
            $("#license_body").html('');
        },
        success: function(response) {
            if (response.status == true) {
                $("#license_body").html(response.options);
            }
        },
        error: function() {

        }
    });
}

function stateList(country_id, id) {
    $.ajax({
        url: "{{ url('states') }}",
        data: {
            country_id: country_id
        },
        dataType: "json",
        beforeSend: function() {
            $("#" + id).html('');
        },
        success: function(response) {
            if (response.status == true) {
                $("#" + id).html(response.options);
            }
        },
        error: function() {

        }
    });
}

function cityList(state_id, id) {
    $.ajax({
        url: "{{ url('cities') }}",
        data: {
            state_id: state_id
        },
        dataType: "json",
        beforeSend: function() {
            $("#" + id).html('');
        },
        success: function(response) {
            if (response.status == true) {
                $("#" + id).html(response.options);
            }
        },
        error: function() {

        }
    });
}
</script>
@endsection