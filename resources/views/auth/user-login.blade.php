@extends('frontend.layouts.master')

@section('content')

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main pt-0">
      <!-- Content -->
      <div class="container-fluid px-3">
        <div class="row mb-5 pb-2 pt-5">
          <!-- Cover -->
          <div class="col-lg-6 mb-5 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative  px-0">
            <!-- Logo & Language -->
            <!-- <div class="position-absolute top-0 left-0 right-0 mt-3 mx-3">
              <div class="d-none d-lg-flex justify-content-between">
                <a href="{{ url('/') }}">
                  <img class="w-100" src="assets/svg/logos/logo.svg" alt="Image Description" style="min-width: 7rem; max-width: 7rem;">
                </a>                
              </div>
            </div> -->
            <!-- End Logo & Language -->

            <div class="mt-5" style="max-width: 23rem;">
              <div class="text-center mb-5">
                <img class="img-fluid" src="assets/svg/illustrations/chat.svg" alt="Image Description" style="width: 12rem;">
              </div>

              <div class="mb-5">
                <h2 class="display-4">Build digital products with:</h2>
              </div>

              <!-- List Checked -->
              <ul class="list-checked list-checked-lg list-checked-primary list-unstyled-py-4">
                <li class="list-checked-item">
                  <span class="d-block font-weight-bold mb-1">All-in-one tool</span>
                  Build, run, and scale your apps - end to end
                </li>

                <li class="list-checked-item">
                  <span class="d-block font-weight-bold mb-1">Easily add &amp; manage your services</span>
                  It brings together your tasks, projects, timelines, files and more
                </li>
              </ul>
              <!-- End List Checked -->

              <div class="row justify-content-between mt-5 gx-2">
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/gitlab-gray.svg" alt="Image Description">
                </div>
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/fitbit-gray.svg" alt="Image Description">
                </div>
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/flow-xo-gray.svg" alt="Image Description">
                </div>
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/layar-gray.svg" alt="Image Description">
                </div>
              </div>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Cover -->

          <div class="col-lg-6 pt-5 mt-5 min-vh-lg-100">
          <!-- <a href="{{ url('/quick-eligibility') }}" class="btn btn-primary float-right mt-3">Click for Quick Eligibility</a> -->
          <div class="clearfix"></div>
            <div class="w-100 pt-10 pt-lg-7 pb-7">
              <!-- Form -->
              <form class="js-validate" action="{{ route('user.login') }}" method="post">
                @csrf
                <div class="text-center mb-5">
                  <h1 class="display-4">Sign in</h1>
                 
                  <p>Don't have an account yet? <br>
                   <a href="{{ url('signup/user') }}">Create your Account</a>
                  </p>
                
                </div>
                
                <div class="mb-4 text-center">
                  <a class="btn btn-lg btn-white btn-block" href="{{ url('login/google') }}">
                    <span class="text-center">
                      <!-- <img class="img-responsiv" src="assets/svg/brands/google.svg" alt="Image Description"> -->
                      Sign in with Google
                    </span>
                  </a>
                </div>
              
                <div class="text-center mb-4">
                  <span class="divider text-muted">OR</span>
                </div>
               
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label class="input-label" for="signupSrEmail">Your email</label>

                  <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" id="signupSrEmail" placeholder="youremail@abc.com" aria-label="Markwilliams@example.com" required data-msg="Please enter a valid email address.">
                   @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <!-- End Form Group -->

                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label class="input-label" for="signupSrPassword" tabindex="0">
                    <span class="d-flex justify-content-between align-items-center">
                      Password
                      </span>
                  </label>

                  <div class="input-group input-group-merge">
                    <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="Enter Password" aria-label="8+ characters required" required
                           data-msg="Your password is invalid. Please try again."
                           data-hs-toggle-password-options='{
                             "target": "#changePassTarget",
                             "defaultClass": "tio-hidden-outlined",
                             "showClass": "tio-visible-outlined",
                             "classChangeTarget": "#changePassIcon"
                           }'>
                    <div id="changePassTarget" class="input-group-append">
                      <a class="input-group-text" href="javascript:;">
                        <i id="changePassIcon" class="tio-visible-outlined"></i>
                      </a>
                    </div>
                  </div>
                  <a class="input-label-secondary float-right" href="{{ url('forgot-password') }}">Forgot Password?</a>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <!-- End Form Group -->

                <!-- Checkbox -->
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox">
                    <label class="custom-control-label font-size-sm text-muted" for="termsCheckbox"> Remember me</label>
                  </div>
                </div>
                <!-- End Checkbox -->
                @if(Session::has('error_message'))
                    <div class="alert alert-warning"><i class="fa fa-warning"></i> {{ Session::get("error_message") }}</div>
                @endif
                @if(Session::has('success_message'))
                    <div class="alert alert-success"><i class="fa fa-check"></i> {{ Session::get("success_message") }}</div>
                @endif
                <button type="submit" class="btn btn-lg btn-block btn-primary">Sign in</button>
               
                <a class="text-dark float-right" href="{{ url('/') }}"><i class="tio-home"></i> Back To Home</a>
              
                <div class="clearfix"></div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
        <!-- End Row -->
      </div>
      <!-- End Content -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection
