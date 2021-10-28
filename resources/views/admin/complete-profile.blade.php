@extends('frontend.layouts.master')


<!-- <link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
 -->


@section('content')
<style>
span.select2-selection.select2-selection--single {
    height: 51px;
}
li.select2-selection__choice {
    padding: 9px !important;
}
</style>
<div class="row">
    <div class="col-lg-6 col-xl-4  d-lg-flex justify-content-center position-relative offset-xl-2 offset-md-0" style="">
        <div class="flex-grow-1 p-5">
            <!-- Step -->
            <ul class="step">
                <li class="step-item">
                    <div class="step-content-wrapper">
                        @if($profile_status == 0)
                        <span class="step-icon step-icon-success"><i class="bi bi-check-lg"></i></span>
                        @else
                        <span class="step-icon step-icon-soft-primary">1</span>
                        @endif
                        <div class="step-content">
                            <h4>Sign up</h4>
                            <p class="step-text">Achieve virtually any design and layout from within the one template.
                            </p>
                        </div>
                    </div>
                </li>

                <li class="step-item">
                    <div class="step-content-wrapper">
                        @if($profile_status == 1)
                        <span class="step-icon step-icon-success"><i class="bi bi-check-lg"></i></span>
                        @else
                        <span class="step-icon step-icon-soft-primary">2</span>
                        @endif
                        <div class="step-content">
                            <h4>Complete profile</h4>
                            <p class="step-text">We strive to figure out ways to help your business grow through all
                                platforms.</p>
                        </div>
                    </div>
                </li>
                <li class="step-item">
                    <div class="step-content-wrapper">
                        @if($profile_status == 2)
                        <span class="step-icon step-icon-success"><i class="bi bi-check-lg"></i></span>
                        @else
                        <span class="step-icon step-icon-soft-primary">3</span>
                        @endif
                        <div class="step-content">
                            <h4>Profile review</h4>
                            <p class="step-text">We strive to figure out ways to help your business grow through all
                                platforms.</p>
                        </div>
                    </div>
                </li>

            </ul>
            <!-- End Step -->
        </div>
    </div>

    <div class="col-lg-6 col-xl-4 justify-content-center align-items-center min-vh-lg-100 ">
        @if($profile_status == 2)
        <!-- <div class="col-sm-auto text-right">
        <a onclick="fetchChats()" class="btn btn-primary js-hs-unfold-invoker" href="javascript:;"
                    data-hs-unfold-options='{
                    "target": "#activitySidebar",
                    "type": "css-animation",
                    "animationIn": "fadeInRight",
                    "animationOut": "fadeOutRight",
                    "hasOverlay": true,
                    "smartPositionOff": true
                    }'>
          <i class="tio-chat mr-1"></i> Chat with Support
          @if($unread_chats > 0)
                <span class="badge badge-danger">{{$unread_chats}}</span>
          @endif
        </a>
    </div> -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">

                <div id="validationFormSuccessMessage" style="display:block;">
                    <div class="text-center">
                        <img class="img-fluid mb-3" src="assets/svg/illustrations/create.svg" alt="Image Description"
                            style="max-width: 15rem;">

                        <div class="mb-4">
                            <h2>Successful!</h2>
                            <p>Your profile have been verified successfully!!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($profile_status == 1)
        <!-- <div class="col-sm-auto text-right">
        <a onclick="fetchChats()" class="btn btn-primary js-hs-unfold-invoker" href="javascript:;"
                    data-hs-unfold-options='{
                    "target": "#activitySidebar",
                    "type": "css-animation",
                    "animationIn": "fadeInRight",
                    "animationOut": "fadeOutRight",
                    "hasOverlay": true,
                    "smartPositionOff": true
                    }'>
          <i class="tio-chat mr-1"></i> Chat with Support
          @if($unread_chats > 0)
                <span class="badge badge-danger">{{$unread_chats}}</span>
          @endif
        </a>
    </div> -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div id="validationFormSuccessMessage" style="display:block;">

                    <div class="text-center">
                        <img class="img-fluid mb-3" src="assets/svg/illustrations/create.svg" alt="Image Description"
                            style="max-width: 15rem;">

                        @if(!empty($admin_notes))
                        <div class="mb-4" style="background:#fcf36a;padding: 30px;">
                            <h2>Admin notes</h2>
                            <p style="">{{$admin_notes}}</p>
                            <span class="float-right"><small>Notes Added On {{$notes_updated_on}}</small></span>
                        </div>
                        @else
                        <div class="mb-4">
                            <h2>Awaiting Verification!</h2>
                            <p>Your profile have been successfully saved. Waiting for admin approval!!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="flex-grow-1 margin-auto-sm" style="max-width: 28rem;">

            <div class="type-label-holder-wrap-outer">

                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="type-label-holder-wrap text-center ">
                            <div class="type-label-holder"><img class="avatar avatar-xss"
                                    src="./assets/svg/brands/google.svg" alt="Image Description"></div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-8 text-center-xs">
                        <!-- Heading -->
                        <div class="mb-5 mb-md-7">
                            <h1 class="h2">Hey {{ $user->first_name }} {{ $user->last_name }} </h1>
                            <p>We need some more information</p>
                        </div>
                        <!-- End Heading -->
                    </div>
                </div><!-- row end -->
                <span class="type-label professional-label">Professional</span>
            </div> <!-- type holder class end -->


            <form id="form" method="post" action="{{ baseUrl('/save-profile') }}" class="js-validate needs-validation"
                novalidate>
                @csrf
                <h4 class="mb-3" style="color:#377DFF"><span class="title-step-icon step-icon-success">1</span>Personal
                    Information</h4>
                <h5 class="mb-3">Personal details</h5> <!-- Form -->
                <!-- Date -->
                <div class="mb-3">
                    <label for="DateLabel" class="form-label">Date of Birth</label>
                    <input type="text" class="js-input-mask form-control" id="date_of_birth" name="date_of_birth"
                        value="{{ $user->date_of_birth }}" placeholder="xx/xx/xxxx" data-hs-mask-options='{
        "mask": "00/00/0000"
      }'>
                </div>

                <!-- Form -->
                <div class="mb-3">
                    <label class="form-label" for="signupModalFormSignupEmail">Gender</label>
                    <!-- Select -->
                    <select name="gender" id="gender" class="js-select2-custom form-select" autocomplete="off">
                        <option value="">Select a gender...</option>
                        <option {{($user->gender == 'male')?'selected':''}} value="male">Male
                        </option>
                        <option {{($user->gender == 'female')?'selected':''}} value="female">Female
                        </option>
                        <option {{($user->gender == 'other')?'selected':''}} value="other">Other
                        </option>
                    </select>
                    <!-- End Select -->
                </div>
                <!-- End Form -->

                <!--  Form -->
                <div class="mb-3">
                    <label for="addressShopCheckout" class="form-label">Languages known</label>
                    <!-- Select -->

                    <select name="languages_known[]" multiple id="languages_known" class="js-select2-custom form-select"
                        autocomplete="off" multiple>
                        <option value="">Select language...</option>
                        <?php
                  if($user->languages_known != ''){
                    $language_known = json_decode($user->languages_known,true);
                  }else{
                    $language_known = array();
                  }
                ?>
                        @foreach($languages as $language)
                        <option {{in_array($language->id,$language_known)?"selected":""}} value="{{$language->id}}">
                            {{$language->name}}</option>
                        @endforeach
                    </select>

                </div>
        </div>
        <!--END  Form -->
        <!--  Form -->

        <div class="row g-3">
            <h5 class="mb-3 mt-3">Personal address</h5>
            <div class="col-12">
                <label for="addressShopCheckout" class="form-label">Address</label>
                <input type="text" value="{{ $user->address }}" name="address" id="address"
                    class="form-control form-control-lg" placeholder="1234 Main St" required>

            </div>
            <!-- End Col -->

            <!-- Col -->
            <div class="col-md-6">
                <label for="countryShopCheckout" class="form-label">Country</label>

                <select name="country_id" id="country_id" onchange="stateList(this.value,'state_id')"
                    class="form-control">

                    <option value="">Choose...</option>
                    @foreach($countries as $country)
                    <option {{$user->country_id == $country->id?"selected":""}} value="{{$country->id}}">
                        {{$country->name}}
                    </option>
                    @endforeach

                </select>
            </div>
            <!-- End Col -->

            <!-- Col -->
            <div class="col-md-6">
                <label for="stateShopCheckout" class="form-label">State</label>
                <!-- Select -->
                <div class="tom-select-custom">
                    <select name="state_id" id="state_id" onchange="cityList(this.value,'city_id')"
                        class="form-control">

                        <option value="">Choose...</option>
                        @foreach($states as $state)
                        <option {{$user->state_id == $state->id?"selected":""}} value="{{$state->id}}">{{$state->name}}
                        </option>
                        @endforeach

                    </select>
                </div>

            </div>
            <!-- End Col -->
        </div> <!-- Row g3 end -->

        <!-- Row g3 -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mt-3">
                    <label for="stateShopCheckout" class="form-label">City</label>
                    <!-- Select -->

                    <div class="tom-select-custom">
                        <select name="city_id" id="city_id" class="form-control">

                            <option value="">Choose...</option>
                            @foreach($cities as $city)
                            <option {{$user->city_id == $city->id?"selected":""}} value="{{$city->id}}">
                                {{$city->name}}</option>
                            @endforeach

                        </select>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="mt-3">
                    <label for="zipShopCheckout" class="form-label">Postal/ Zip code</label>
                    <input type="text" class="form-control form-control-lg" name="zip_code"
                        value="{{ $user->zip_code }}" id="zip_code" placeholder="Postal/Zip code" required>

                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- Row g3 end -->


        <hr class="my-4">
        <h4 class="mb-3" style="color:#377DFF"><span class="title-step-icon step-icon-success">2</span>Company
            Information</h4>
        <h5 class="mb-3">Company details</h5>

        <!-- Form -->
        <div class="mb-3">
            <label class="form-label" for="fullNameSrEmail">Company Name</label>
            <!-- Form Group -->
            <div class="form-row">
                <div class="col-sm-12 col-xs-12">
                    <div class="js-form-message form-group">
                        <input type="text" class="form-control form-control-lg" name="company_name" id="company_name"
                            placeholder="Company's name" aria-label="company name" required
                            data-msg="Please enter company's name." value="{{$company_details->company_name}}">
                    </div>
                </div>

            </div>
            <!-- End Form Group -->
        </div>

        <!-- Date -->
        <div class="mb-3 js-form-message">
            <label for="DateLabel" class="form-label">Date of formation</label>
            <input type="text" name="date_of_register" id="date_of_register" class="js-input-mask form-control"
                id="DateLabel" value="{{ $company_details->date_of_register }}" placeholder="xx/xx/xxxx"
                data-hs-mask-options='{
          "mask": "00/00/0000"
        }'>
        </div>
        <!-- End Date -->

        <!-- Form -->
        <div class="mb-3 js-form-message">
            <label class="form-label" for="signupModalFormSignupEmail">Company's email</label>
            <input type="email" class="form-control form-control-lg" name="cp_email" id="cp_email"
                placeholder="email@site.com" aria-label="email@site.com" value="{{$company_details->email}}" required>

        </div>
        <!-- End Form -->

        <!-- Form -->
        <div class="mb-3 js-form-message">
            <label class="form-label" for="fullNameSrEmail">Company's phone number</label>
            <!-- Form Group -->
            <div class="form-row">
                <!-- Select -->
                <div class="col-sm-5 col-xs-6">
                    <select name="cp_country_code" id="cp_country_code" class="form-control js-select">
                        <option>Select</option>
                        @foreach($countries as $country)
                        <option {{$company_details->country_code == $country->phonecode?"selected":""}}
                            value="+{{$country->phonecode}}">+{{$country->phonecode}} ({{$country->sortname}})</option>
                        @endforeach
                    </select>
                    <!-- End Select -->
                </div>

                <div class="col-sm-7 col-xs-6">
                    <div class="js-form-message form-group">
                        <input type="text" name="cp_phone_no" id="cp_phone_no" class="form-control form-control-lg"
                            placeholder="Please enter your number" aria-label="Phone number" required
                            data-msg="Please enter your number." value="{{$company_details->phone_no}}">
                    </div>
                </div>
            </div>
            <!-- End Form Group -->
        </div>

        <!-- Form Group -->
        <div class="mb-3 js-form-message">
            <label for="basic-url" class="form-label">Company's website</label>
            <div class="input-group ">
                <span class="input-group-text" id="basic-addon3">https://</span>
                <input type="text" name="website_url" id="website_url" class="form-control"
                    value="{{$company_details->website_url}}" aria-describedby="basic-addon3">
            </div>
        </div>
        <!-- End Form Group -->

        <h5 class="mb-3 mt-3 js-form-message">Company Address</h5> <!-- Form -->
        <div class="row g-3">

            <div class="col-12">
                <label for="addressShopCheckout" class="form-label">Address</label>
                <input type="text" name="cp_address" id="cp_address" class="form-control form-control-lg"
                    placeholder="1234 Main St" value="{{ $company_details->address }}" required>

            </div>
            <!-- End Col -->

            <div class="col-md-6 js-form-message">
                <label for="countryShopCheckout" class="form-label">Country</label>
                <select name="cp_country_id" id="cp_country_id"
                    onchange="stateList(this.value,'cp_state_id'),licenceBodies(this.value)" class="form-control">
                    <option value="">Choose...</option>
                    @foreach($countries as $country)
                    <option {{$user->country_id == $country->id?"selected":""}} value="{{$country->id}}">
                        {{$country->name}}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-6 js-form-message">
                <label for="stateShopCheckout" class="form-label">State</label>
                <select name="cp_state_id" id="cp_state_id" onchange="cityList(this.value,'cp_city_id')"
                    class="form-control">
                    <option value="">Choose...</option>
                    @foreach($states as $state)
                    <option {{$company_details->state_id == $state->id?"selected":""}} value="{{$state->id}}">
                        {{$state->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 js-form-message">
                <div class="mt-3">
                    <label for="stateShopCheckout" class="form-label">City</label>
                    <!-- Select -->
                    <select name="cp_city_id" id="cp_city_id" class="form-control">
                        <option value="">Choose...</option>
                        @foreach($cities as $city)
                        <option {{$company_details->city_id == $city->id?"selected":""}} value="{{$city->id}}">
                            {{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 js-form-message">
                <div class="mt-3">
                    <label for="zipShopCheckout" class="form-label">Postal/Zip code</label>
                    <input type="text" name="cp_zip_code" id="cp_zip_code" class="form-control form-control-lg"
                        placeholder="Postal/Zip code" value="{{ $company_details->zip_code }}" required>

                </div>
            </div>

        </div><!-- row g3 -->


        <hr class="my-4">
        <span class="attachment-label"><i class="bi bi-paperclip"></i> Attachments </span>
        <div class="mb-3 js-form-message">
            <div class="d-grid gap-2">
                <label for="basicFormFile" class="js-file-attach form-label" data-hs-file-attach-options='{
           "textTarget": "[for=\"customFile\"]"
         }'>Ownership proof</label>
                <input class="form-control" type="file" name="owner_id_proof" id="owner_id_proof">
            </div>

            @if($company_details->owner_id_proof != '' &&
            file_exists(professionalDir().'/documents/'.$company_details->owner_id_proof))
            <span class="attachment-label"><i class="bi bi-paperclip"></i> <a class="link" download
                    href="{{ professionalDirUrl().'/documents/'.$company_details->owner_id_proof }}"><i
                        class="fa fa-download"></i>{{$company_details->owner_id_proof}}</a> </span>

            @endif
        </div>


        <div class="mb-3 js-form-message">
            <div class="d-grid gap-2">
                <label for="basicFormFile" class="js-file-attach form-label" data-hs-file-attach-options='{
           "textTarget": "[for=\"customFile\"]"
          }'>Proof of address</label>
                <input class="form-control" type="file" name="company_address_proof" id="company_address_proof">
            </div>
            @if($company_details->company_address_proof != '' &&
            file_exists(professionalDir().'/documents/'.$company_details->company_address_proof))
            <span class="attachment-label"><i class="bi bi-paperclip"></i> <a class="link" download
                    href="{{ professionalDirUrl().'/documents/'.$company_details->company_address_proof }}"><i
                        class="fa fa-download"></i>{{$company_details->owner_id_proof}}</a> </span>


            @endif
        </div>

        <hr class="my-4">
        <h4 class="mb-3" style="color:#377DFF"><span class="title-step-icon step-icon-success">3</span>Licencing
            Information</h4>
        <h5 class="mb-3">Licencing Information</h5>

        <div class="mb-3 js-form-message">
            <label for="addressShopCheckout" class="form-label">Licencing Number</label>

            <input type="text" class="form-control form-control-lg" name="licence_number"
                value="{{ $company_details->licence_number }}" id="licence_number" placeholder="Licence Number"
                aria-label="Licence Number" required>


            <!-- End Select -->
        </div>

        <div class="mb-3 js-form-message">
            <label for="addressShopCheckout" class="form-label">Licencing Body</label>

            <select class="js-select2-custom form-select" autocomplete="off">
                <?php
              if($company_details->license_body != ''){
                $license_body = json_decode($company_details->license_body,true);
              }else{
                $license_body = array();
              }
              ?>
                <option value="">Choose...</option>
                @foreach($licence_bodies as $bodies)
                <option {{in_array($bodies->id,$license_body)?"selected":""}} value="{{$bodies->id}}">
                    {{$bodies->name}}
                </option>
                @endforeach
            </select>
            <!-- End Select -->
        </div>

        <div class="mb-3 js-form-message">
            <label for="addressShopCheckout" class="form-label">Are you member in good standing?</label>

            <div class="my-3 js-form-message">
                <!-- Check -->
                <div class="form-check">
                    <input name="member_of_good_standing" type="radio" class="form-check-input" checked required>
                    <label class="form-check-label" for="creditShopCheckout">Yes</label>
                </div>
                <!-- End Check -->

                <!-- Check -->
                <div class="form-check">
                    <input name="member_of_good_standing" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="debitShopCheckout">No</label>
                </div>
                <!-- End Check -->

            </div>
        </div>

        <div class="mb-3 js-form-message">
            <label for="addressShopCheckout" class="form-label">Years of experience</label>

            <select name="years_of_expirences" id="years_of_expirences" class="js-select2-custom form-select"
                autocomplete="off">
                <option value="">Choose...</option>

                <option {{($company_details->years_of_expirences == 'less then 2 years')?'selected':''}}
                    value="less then 2 years">Less then 2 years</option>
                <option {{($company_details->years_of_expirences == '2 to 5 years')?'selected':''}}
                    value="2 to 5 years">2 to 5 years</option>
                <option {{($company_details->years_of_expirences == '5 to 10 years')?'selected':''}}
                    value="5 to 10 years">5 to 10 years</option>
                <option {{($company_details->years_of_expirences == '10+ years')?'selected':''}} value="10+ years">
                    10+
                    years</option>
            </select>

        </div>
        <hr class="my-4">
        <span class="attachment-label"><i class="bi bi-paperclip"></i> Attachments </span>
        <div class="mb-3">
            <div class="d-grid gap-2">
                <label for="basicFormFile" class="js-file-attach form-label" data-hs-file-attach-options='{
         "textTarget": "[for=\"customFile\"]"
       }'>Upload your license certificate</label>
                <input class="form-control" type="file" name="licence_certificate" id="licence_certificate">

            </div>

            @if($company_details->licence_certificate != '' &&
            file_exists(professionalDir().'/documents/'.$company_details->licence_certificate))

            <span class="attachment-label"><i class="bi bi-paperclip"></i> <a class="link" download
                    href="{{ professionalDirUrl().'/documents/'.$company_details->licence_certificate }}"><i
                        class="fa fa-download"></i>{{$company_details->licence_certificate}} aaa</a> </span>

            @endif

        </div>


        <hr class="my-4">
        <!-- Check -->
        <div class="form-check mb-3 js-form-message">
            <input type="checkbox" class="form-check-input" id="termsAndConditions" name="termsAndConditions" required>
            <label class="form-check-label small" for="termsAndConditions"> By submitting this form I have read and
                acknowledged the <a href="javascript:;">Term and Conditions</a></label>

        </div>
        <div class="d-grid mb-3">
        <button type="submit" id="validationFormFinishBtn" class="btn btn-primary btn-lg">Submit</button>
       </div>
    </div>

    

    </form>


</div>
@endif
</div>
<!-- Sidebar -->
{{--<div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
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
</div> --}}
<!-- End Sidebar -->
@endsection


@section('javascript')
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<!-- <script src="assets/vendor/imask/dist/imask.min.js"></script> -->
<link rel="stylesheet" href="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css" />
<script src="assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.js"></script>


<script type="text/javascript">
// initSelect();
$(document).ready(function() {
    $("select").select2();
    $('#date_of_birth').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate: (new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
    $('#date_of_register').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom auto"
    });

    $(".send-message").click(function() {

        var message = $("#message_input").val();
        if (message != '') {
            $.ajax({
                type: "POST",
                url: "{{ baseUrl('send-message-to-support') }}",
                data: {
                    _token: csrf_token,
                    message: message,
                    type: "text",
                },
                dataType: 'json',
                beforeSend: function() {
                    // var html = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
                    // $("#activitySidebar .messages").html(html);
                    $("#message_input,.send-message,.send-attachment").attr('disabled',
                        'disabled');
                },
                success: function(response) {
                    if (response.status == true) {
                        $("#message_input,.send-message,.send-attachment").removeAttr(
                            'disabled');
                        $("#message_input").val('');
                        $("#activitySidebar .messages").html(response.html);
                        $(".messages").mCustomScrollbar();
                        $(".messages").animate({
                            scrollTop: $(".messages")[0].scrollHeight
                        }, 1000);
                        $(".doc_chat_input").show();
                        fetchChats();
                    } else {
                        errorMessage(response.message);
                    }
                },
                error: function() {

                    $("#message_input,.send-message,.send-attachment").removeAttr(
                        'disabled');
                    internalError();
                }
            });
        }
    });

    $(".send-attachment").click(function() {
        document.getElementById('chat-attachment').click();
    });
    $("#chat-attachment").change(function() {
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append('attachment', $('#chat-attachment')[0].files[0]);
        var url = "{{ baseUrl('send-file-to-support') }}";
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $("#message_input,.send-message,.send-attachment").attr('disabled',
                    'disabled');
            },
            success: function(response) {
                if (response.status == true) {
                    $("#message_input,.send-message,.send-attachment").removeAttr(
                        'disabled');
                    $("#chat-attachment").val('');
                    $("#activitySidebar .messages").html(response.html);
                    $(".messages").mCustomScrollbar();
                    $(".messages").animate({
                        scrollTop: $(".messages")[0].scrollHeight
                    }, 1000);
                    $(".doc_chat_input").show();
                    fetchChats();
                } else {
                    errorMessage(response.message);
                }
            },
            error: function() {
                $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                internalError();
            }
        });
    });
});
$("#form").submit(function(e) {
    e.preventDefault();

    var formData = new FormData($(this)[0]);
    var url = $("#form").attr('action');
    $.ajax({
        url: url,
        type: "post",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",

        beforeSend: function() {
            $("#validationFormFinishBtn").html("Processing...");
            $("#validationFormFinishBtn").attr("disabled", "disabled");
            showLoader();
        },
        success: function(response) {

            hideLoader();
            $("#validationFormFinishBtn").html("Save Data");
            $("#validationFormFinishBtn").removeAttr("disabled");
            if (response.status == true) {
                successMessage(response.message);
                setTimeout(function() {
                    redirect('{{ baseUrl("complete-profile") }}');
                }, 2000);
            } else {
                validation(response.message);
            }
        },
        error: function() {
            hideLoader();
            $("#validationFormFinishBtn").html("Save Data");
            $("#validationFormFinishBtn").removeAttr("disabled");
            internalError();
        }
    });
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

function fetchChats() {
    alert("Tet");
    $.ajax({
        type: "POST",
        url: "{{ baseUrl('fetch-chats') }}",
        data: {
            _token: csrf_token
        },
        dataType: 'json',
        beforeSend: function() {
            $("#message_input").val('');
            $("#message_input,.send-message,.send-attachment").attr('disabled', 'disabled');
        },
        success: function(response) {
            if (response.status == true) {
                $("#message_input,.send-message,.send-attachment").removeAttr('disabled');
                $("#activitySidebar .messages").html(response.html);
                setTimeout(function() {
                    $("#activitySidebar .messages").mCustomScrollbar();
                    $("#activitySidebar .messages").animate({
                        scrollTop: $(".messages")[0].scrollHeight
                    }, 1000);
                }, 800);

                $(".doc_chat_input").show();
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            $("#activitySidebar .messages").html('');
            internalError();
        }
    });
}
</script>
@endsection