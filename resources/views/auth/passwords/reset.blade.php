
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
           <!-- <div class="text-center mb-5">
            <h1 class="display-4">Reset Password</h1>
           </div> -->

          <div class="clearfix"></div>
            <div class="w-100 pt-10 pt-lg-7 pb-7">
              <!-- Form -->
              <form class="js-validate" action="{{ url('reset-password') }}" method="post">
                @csrf
               
                 <div class="text-center mb-5">
                  <h3 class="display-6">Reset Password</h3>
                  <p>Create new password. Atleast 6 characters long.</p>
                </div>

                <input type="hidden" name="token" value="{{ $token }}">

                    <div class="js-form-message form-group">
                        <label class="input-label" for="signupSrEmail">Your email</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    <div class="js-form-message form-group">
                        <label class="input-label" for="signupSrEmail">Password</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    <div class="js-form-message form-group">
                        <label class="input-label" for="signupSrEmail">Confirm Password</label>

                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                    </div>
                    <!-- End Form Group -->

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                    <button type="submit" class="btn btn-lg btn-block  btn-primary">
                        {{ __('Reset Password') }}
                    </button>
                    </div>
                </div>
            
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



