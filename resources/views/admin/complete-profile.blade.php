@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">

@endsection

@section('content')

<div class="row">
  <div class="col-lg-6 col-xl-4  d-lg-flex justify-content-center position-relative offset-xl-2 offset-md-0" style="">
    <div class="flex-grow-1 p-5">
      <!-- Step -->
      <ul class="step">
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-success"><i class="bi bi-check-lg"></i></span>
            <div class="step-content">
              <h4>Sign up</h4>
              <p class="step-text">Achieve virtually any design and layout from within the one template.</p>
            </div>
          </div>
        </li>

        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary">2</span>
            <div class="step-content">
              <h4>Complete profile</h4>
              <p class="step-text">We strive to figure out ways to help your business grow through all platforms.</p>
            </div>
          </div>
        </li>
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary">3</span>
            <div class="step-content">
              <h4>Profile review</h4>
              <p class="step-text">We strive to figure out ways to help your business grow through all platforms.</p>
            </div>
          </div>
        </li>
        
      </ul>
      <!-- End Step -->    
    </div>
  </div>

  <div class="col-lg-6 col-xl-4 justify-content-center align-items-center min-vh-lg-100 ">
    
    <div class="flex-grow-1 margin-auto-sm" style="max-width: 28rem;">  
    
      <div class="type-label-holder-wrap-outer">

        <div class="row">
          <div class="col-lg-4 col-xl-4">
           <div class="type-label-holder-wrap text-center ">
            <div class="type-label-holder"><img class="avatar avatar-xss" src="./assets/svg/brands/google.svg" alt="Image Description"></div>
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


      <form id="form" method="post" action="{{ baseUrl('/save-profile') }}" class="js-validate needs-validation" novalidate>
      @csrf
       <h4 class="mb-3" style="color:#377DFF"><span class="title-step-icon step-icon-success">1</span>Personal Information</h4>
       <h5 class="mb-3">Personal details</h5> <!-- Form -->
       <!-- Date -->
       <div class="mb-3">
        <label for="DateLabel" class="form-label">Date of Birth</label>
        <input type="text" class="js-input-mask form-control" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth }}" placeholder="xx/xx/xxxx"
        data-hs-mask-options='{
        "mask": "00/00/0000"
      }'>
      </div>

              <!-- Form -->
        <div class="mb-3">
          <label class="form-label" for="signupModalFormSignupEmail">Gender</label>
          <!-- Select -->
          <div class="tom-select-custom">
            <select name="gender" id="gender" class="js-select form-select" autocomplete="off"
            data-hs-tom-select-options='{
            "placeholder": "Select a gender...",
            "hideSearch": true
          }'>
              <option value="">Select a gender...</option>
              <option {{($user->gender == 'male')?'selected':''}} value="male">Male
              </option>
              <option {{($user->gender == 'female')?'selected':''}} value="female">Female
              </option>
              <option {{($user->gender == 'other')?'selected':''}} value="other">Other
              </option>
            </select> 
          </div>
        <!-- End Select -->
        </div>
        <!-- End Form -->

        <!--  Form -->
        <div class="mb-3">  
        <label for="addressShopCheckout" class="form-label">Languages known</label>
          <!-- Select -->
          <div class="tom-select-custom tom-select-custom-with-tags">

            <select name="languages_known[]" multiple id="languages_known" class="js-select form-select" autocomplete="off" multiple
                data-hs-tom-select-options='{
                "placeholder": "Select languages you know..."
              }'>
              <option value="">Select language...</option>
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
        <!--END  Form -->
        <!--  Form -->

        <div class="row g-3">
          <h5 class="mb-3 mt-3">Personal address</h5>
          <div class="col-12">
            <label for="addressShopCheckout" class="form-label">Address</label>
            <input type="text" value="{{ $user->address }}" name="address" id="address" class="form-control form-control-lg" placeholder="1234 Main St" required>
            <div class="invalid-feedback">
              Please enter your address.
            </div>
          </div>
          <!-- End Col -->

          <!-- Col -->
          <div class="col-md-6">
              <label for="countryShopCheckout" class="form-label">Country</label>


            <div class="tom-select-custom">
              <select name="country_id" id="country_id"           onchange="stateList(this.value,'state_id')" class="form-control">
                
                <option value="">Choose...</option>
                @foreach($countries as $country)
                <option {{$user->country_id == $country->id?"selected":""}}
                    value="{{$country->id}}">{{$country->name}}
                </option>
                @endforeach

              </select> 
            </div>

              <div class="invalid-feedback">
                Please select a valid country.
              </div>
          </div>
          <!-- End Col -->

          <!-- Col -->
          <div class="col-md-6">
            <label for="stateShopCheckout" class="form-label">State</label>
            <!-- Select -->
            <div class="tom-select-custom">
              <select name="state_id" id="state_id"           onchange="cityList(this.value,'city_id')" class="form-control">
                
                <option value="">Choose...</option>
                @foreach($states as $state)
                <option {{$user->state_id == $state->id?"selected":""}}
                    value="{{$state->id}}">{{$state->name}}
                </option>
                @endforeach

              </select> 
            </div>

            <div class="invalid-feedback">
              Please provide a valid state.
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

            <div class="invalid-feedback">
              Please provide a valid city.
            </div>  
            </div>
          </div>

          <div class="col-md-6">
            <div class="mt-3">
            <label for="zipShopCheckout" class="form-label">Postal/ Zip code</label>
            <input type="text" class="form-control form-control-lg" name="zip_code" value="{{ $user->zip_code }}" id="zip_code" placeholder="Postal/Zip code" required>
              <div class="invalid-feedback">
              Postal/Zip code required.
              </div> 
            </div>
          </div>
          <!-- End Col -->
        </div>
        <!-- Row g3 end -->


        <hr class="my-4">
        <h4 class="mb-3" style="color:#377DFF"><span class="title-step-icon step-icon-success">2</span>Company Information</h4>
        <h5 class="mb-3">Company details</h5>

        <!-- Form -->
        <div class="mb-3"> 
         <label class="form-label" for="fullNameSrEmail">Company Name</label>
         <!-- Form Group -->
         <div class="form-row">
          <div class="col-sm-12 col-xs-12">
            <div class="js-form-message form-group">
              <input type="text" class="form-control form-control-lg" name="company_name" id="company_name"  placeholder="Company's name" aria-label="company name" required data-msg="Please enter company's name." value="{{$company_details->company_name}}">
            </div>
          </div>

        </div>
        <!-- End Form Group -->
        </div> 

        <!-- Date -->
        <div class="mb-3">
          <label for="DateLabel" class="form-label">Date of formation</label>
          <input type="text" name="date_of_register" id="date_of_register" class="js-input-mask form-control" id="DateLabel"  value="{{ $company_details->date_of_register }}" placeholder="xx/xx/xxxx"
          data-hs-mask-options='{
          "mask": "00/00/0000"
        }'>
        </div>
        <!-- End Date -->

        <!-- Form -->
        <div class="mb-3">
          <label class="form-label" for="signupModalFormSignupEmail">Company's email</label>
          <input type="email" class="form-control form-control-lg" name="cp_email" id="cp_email" placeholder="email@site.com" aria-label="email@site.com"  value="{{$company_details->email}}" required>
          <span class="invalid-feedback">Please enter a valid email address.</span>
        </div>
        <!-- End Form -->

        <!-- Form -->
        <div class="mb-3"> 
             <label class="form-label" for="fullNameSrEmail">Company's phone number</label>
             <!-- Form Group -->
             <div class="form-row">
                        <!-- Select -->
                   <div class="col-sm-5 col-xs-6">
                       <div class="tom-select-custom2a">
                       <select name="cp_country_code" id="cp_country_code" class="form-control">
                            <option>Select</option>
                            @foreach($countries as $country)
                            <option {{$company_details->country_code == $country->phonecode?"selected":""}}
                                value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
                            @endforeach
                        </select>
                        </div>
                          <!-- End Select -->
                    </div>
                    
                    <div class="col-sm-7 col-xs-6">
                          <div class="js-form-message form-group">
                            <input type="text" name="cp_phone_no" id="cp_phone_no" class="form-control form-control-lg" placeholder="Please enter your number" aria-label="Phone number" required data-msg="Please enter your number." value="{{$company_details->phone_no}}">
                          </div>
                    </div>
              </div>
        <!-- End Form Group -->
        </div>

        <!-- Form Group -->
        <div class="mb-3">  
          <label for="basic-url" class="form-label">Company's website</label>
          <div class="input-group ">
            <span class="input-group-text" id="basic-addon3">https://</span>
            <input type="text" name="website_url" id="website_url" class="form-control" value="{{$company_details->website_url}}" aria-describedby="basic-addon3">
          </div>
        </div>
        <!-- End Form Group -->

        <h5 class="mb-3 mt-3">Company Address</h5>  <!-- Form -->
        <div class="row g-3">  
        
          <div class="col-12">
            <label for="addressShopCheckout" class="form-label">Address</label>
            <input type="text"  name="cp_address" id="cp_address"  class="form-control form-control-lg" placeholder="1234 Main St" value="{{ $company_details->address }}" required>
            <div class="invalid-feedback">
              Please enter your shipping address.
            </div>
          </div>
          <!-- End Col -->

          <div class="col-md-6">
            <label for="countryShopCheckout" class="form-label">Country</label>

            <div class="tom-select-custom">
              <select name="cp_country_id" id="cp_country_id" onchange="stateList(this.value,'cp_state_id'),licenceBodies(this.value)" class="form-control">
                <option value="">Choose...</option>
                @foreach($countries as $country)
                <option {{$user->country_id == $country->id?"selected":""}} value="{{$country->id}}">{{$country->name}}
                </option>
                @endforeach
              </select> 
            </div>


            <div class="invalid-feedback">
              Please select a valid country.
            </div>
          </div>


          <div class="col-md-6">
          <label for="stateShopCheckout" class="form-label">State</label>

            <div class="tom-select-custom">
              <select name="cp_state_id" id="cp_state_id" onchange="cityList(this.value,'cp_city_id')"  class="form-control">
            <option value="">Choose...</option>
              @foreach($states as $state)
                <option {{$company_details->state_id == $state->id?"selected":""}} value="{{$state->id}}">
                      {{$state->name}}</option>
                @endforeach
              </select> 
            </div>

            <div class="invalid-feedback">
              Please provide a valid state.
            </div>
          </div>

          <div class="col-md-6">
            <div class="mt-3">
            <label for="stateShopCheckout" class="form-label">City</label>
            <!-- Select -->
            
            <div class="tom-select-custom">
              <select name="cp_city_id" id="cp_city_id" class="form-control">
            <option value="">Choose...</option>
              @foreach($cities as $city)
              <option {{$company_details->city_id == $city->id?"selected":""}} value="{{$city->id}}">
                  {{$city->name}}</option>
              @endforeach
              </select> 
            </div>

            <div class="invalid-feedback">
              Please provide a valid city.
            </div>  
            </div>
          </div>

          <div class="col-md-6"><div class="mt-3">
            <label for="zipShopCheckout" class="form-label">Postal/Zip code</label>
            <input type="text" name="cp_zip_code" id="cp_zip_code" class="form-control form-control-lg"  placeholder="Postal/Zip code" value="{{ $company_details->zip_code }}" required>
            <div class="invalid-feedback">
              Postal/Zip code required.
            </div> </div>
          </div>

        </div><!-- row g3 -->
        

        <hr class="my-4">
        <span class="attachment-label"><i class="bi bi-paperclip"></i> Attachments </span>
        <div class="mb-3"> 
          <div class="d-grid gap-2">
           <label for="basicFormFile" class="js-file-attach form-label"
           data-hs-file-attach-options='{
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


        <div class="mb-3"> 
          <div class="d-grid gap-2">
           <label for="basicFormFile" class="js-file-attach form-label"
           data-hs-file-attach-options='{
           "textTarget": "[for=\"customFile\"]"
          }'>Proof of address</label>
          <input class="form-control" type="file" name="company_address_proof" id="company_address_proof" >
          </div>  
          @if($company_details->company_address_proof != '' &&
          file_exists(professionalDir().'/documents/'.$company_details->company_address_proof))
          <span class="attachment-label"><i class="bi bi-paperclip"></i> <a class="link" download
              href="{{ professionalDirUrl().'/documents/'.$company_details->company_address_proof }}"><i
                  class="fa fa-download"></i>{{$company_details->owner_id_proof}}</a> </span>

          
          @endif
        </div>

        <hr class="my-4"> 
        <h4 class="mb-3" style="color:#377DFF"><span class="title-step-icon step-icon-success">3</span>Licencing Information</h4> 
        <h5 class="mb-3">Licencing Information</h5>  
        
        <div class="mb-3">  
        <label for="addressShopCheckout" class="form-label">Licencing Number</label>
          
            <input type="text" class="form-control form-control-lg" name="licence_number" id="licence_number" placeholder="Licence Number" aria-label="Licence Number" required>
          
            <span class="invalid-feedback">Please enter a valid Licence Number.</span>
          
        <!-- End Select -->
        </div>

        <div class="mb-3">  
        <label for="addressShopCheckout" class="form-label">Licencing Body</label>

          <div class="tom-select-custom">
            <select class="js-select form-select" autocomplete="off"
            data-hs-tom-select-options='{
            "placeholder": "Choose...",
            "hideSearch": true
          }'>
              <?php
              if($company_details->license_body != ''){
                $license_body = json_decode($company_details->license_body,true);
              }else{
                $license_body = array();
              }
              ?>
              <option value="">Choose...</option>
              @foreach($licence_bodies as $bodies)
              <option {{in_array($bodies->id,$license_body)?"selected":""}} value="{{$bodies->id}}">{{$bodies->name}}
              </option>
              @endforeach
            </select>
        </div>
      <!-- End Select -->
      </div>

      <div class="mb-3"> 
       <label for="addressShopCheckout" class="form-label">Are you member in good standing?</label>

       <div class="my-3">
          <!-- Check -->
          <div class="form-check">
            <input name="member_of_good_standing" type="radio" class="form-check-input" checked required>
            <label class="form-check-label" for="creditShopCheckout">Yes</label>
          </div>
          <!-- End Check -->

          <!-- Check -->
          <div class="form-check">
            <input  name="member_of_good_standing" type="radio" class="form-check-input" required>
            <label class="form-check-label" for="debitShopCheckout">No</label>
          </div>
          <!-- End Check -->

        </div>
      </div>
      
      <div class="mb-3">  
        <label for="addressShopCheckout" class="form-label">Years of experience</label>
          <!-- Select -->
          <div class="tom-select-custom tom-select-custom-with-tags">
            <select name="years_of_expirences" id="years_of_expirences" class="js-select form-select" autocomplete="off" 
            data-hs-tom-select-options='{
            "placeholder": "Choose..."
            }'>
              <option value="">Choose...</option>

            <option {{($company_details->years_of_expirences == 'less then 2 years')?'selected':''}}
                value="less then 2 years">Less then 2 years</option>
            <option {{($company_details->years_of_expirences == '2 to 5 years')?'selected':''}}
                value="2 to 5 years">2 to 5 years</option>
            <option {{($company_details->years_of_expirences == '5 to 10 years')?'selected':''}}
                value="5 to 10 years">5 to 10 years</option>
            <option {{($company_details->years_of_expirences == '10+ years')?'selected':''}} value="10+ years">10+
                years</option>
            </select>
          </div>
      </div>  
      <hr class="my-4">
      <span class="attachment-label"><i class="bi bi-paperclip"></i> Attachments </span>
      <div class="mb-3"> 
        <div class="d-grid gap-2">
         <label for="basicFormFile" class="js-file-attach form-label"
         data-hs-file-attach-options='{
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
      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="signupHeroFormPrivacyCheck" name="signupFormPrivacyCheck" required>
        <label class="form-check-label small" for="signupHeroFormPrivacyCheck"> By submitting this form I have read and acknowledged the <a href=./page-privacy.html>Privacy Policy</a></label>
        <span class="invalid-feedback">Please accept our Privacy Policy.</span>
      </div>

      </div>

      <div class="d-grid mb-3">
        <button type="submit" id="validationFormFinishBtn" class="btn btn-primary btn-lg">Submit</button>
      </div>

      </form>


    </div>

  </div>

@endsection


@section('javascript')

<script src="assets/vendor/imask/dist/imask.min.js"></script>

<script>
    (function () {
      
      // INITIALIZATION OF SELECT
      // =======================================================
      HSCore.components.HSTomSelect.init('.js-select')
      HSCore.components.HSMask.init('.js-input-mask')
    })()

</script>

<script type="text/javascript">
  

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
               $("#validationFormFinishBtn").attr("disabled","disabled");
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
              } 
              else {
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

</script>

@endsection

