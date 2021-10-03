<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{ url('/') }}/" />
    <!-- Title -->
    <title>{{ companyName() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/frontend/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="assets/frontend/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
    <link rel="stylesheet" href="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.css">
    <link rel="stylesheet" href="assets/frontend/vendor/cubeportfolio/css/cubeportfolio.min.css">
    <link rel="stylesheet" href="assets/frontend/vendor/aos/dist/aos.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="assets/frontend/css/theme.min.css">

    <link rel="stylesheet" href="assets/frontend/css/front.css">
    <link rel="stylesheet" href="assets/vendor/toastr/toastr.css">
    @yield('style')

    <script>
    var BASEURL = "{{ baseUrl('/') }}";
    var SITEURL = "{{ url('/') }}";
    var csrf_token = "{{ csrf_token() }}";
    </script>
  </head>

  <body>
  <div class="loader">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <h4 class="text-danger">Loading...</h4>
    </div>
    @include('frontend.layouts.header')

    <main id="content" role="main" class="main pointer-event">
      @yield("content")
    </main>
      <!-- Footer -->
      
        <!-- ========== FOOTER ========== -->
  <footer class="bg-dark">
    <div class="container">
      <div class="space-top-2 space-bottom-1 space-bottom-lg-2">
        <div class="row justify-content-lg-between">
          <div class="col-lg-8">
            <!-- Logo -->
            <div class="mb-4">
              <a href="index.html" aria-label="Front">
                <img class="brand" src="./assets/svg/logos/logo-white.svg" alt="Logo">
              </a>
            </div>
            <!-- End Logo -->

            <!-- Nav Link -->
            <ul class="nav nav-sm nav-x-0 nav-white flex-column">
              <li class="nav-item">
                <a class="nav-link media" href="javascript:;">
                    <!--<span class="media">
                      <span class="fas fa-location-arrow mt-1 mr-2"></span>
                      <span class="media-body">
           153 Williamson Plaza, Maggieberg
                      </span>
                    </span>-->
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link media" href="tel:1-062-109-9222">
                    <!-- <span class="media">
                      <span class="fas fa-phone-alt mt-1 mr-2"></span>
                      <span class="media-body">
                       +1 (062) 109-9222 
                      </span>
                    </span>-->
                </a>
              </li>
            </ul>
            <!-- End Nav Link -->
          </div>
          
          <div class="col-lg-4">
             <!-- Nav Link -->
            <ul class="nav nav-sm nav-white nav-x-sm align-items-center">
              <li class="nav-item">
                <a class="nav-link" href="#">Privacy &amp; Policy</a>
              </li>
              <li class="nav-item opacity mx-3">&#47;</li>
              <li class="nav-item">
                <a class="nav-link" href="#">Terms</a>
              </li>
              <li class="nav-item opacity mx-3">&#47;</li>
              <li class="nav-item">
                <a class="nav-link" href="#">Site Map</a>
              </li>
            </ul>
            <!-- End Nav Link --> 
          </div>
        </div>
      </div>

      <hr class="opacity-xs my-0">

      <div class="space-1">
        <!-- Copyright -->
        <div class="w-md-75 text-lg-center mx-lg-auto">
          <p class="text-white opacity-sm small">&copy; Immigratly. 2021  All rights reserved.</p>
          <p class="text-white opacity-sm small">When you visit or interact with our sites, services or tools, we or our authorised service providers may use cookies for storing information to help provide you with a better, faster and safer experience and for marketing purposes.</p>
        </div>
        <!-- End Copyright -->
      </div>
    </div>
  </footer>
  <!-- ========== END FOOTER ========== -->

   <!-- ========== SECONDARY CONTENTS ========== -->
  <!-- Sign Up Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <!-- Header -->
        <div class="modal-close">
          <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
            <svg width="10" height="10" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
              <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
            </svg>
          </button>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="modal-body p-sm-5">
          <form class="js-validate">
            <!-- Sign in -->
            <div id="signinModalForm">
              <div class="text-center mb-5">
                <h2>Sign in</h2>
                <p>Don't have an account yet?
                  <a class="js-animation-link" href="javascript:;"
                     data-hs-show-animation-options='{
                         "targetSelector": "#signupModalForm",
                         "groupName": "idForm"
                       }'>Sign up here</a>
                </p>
              </div>

              <a class="btn btn-block btn-white mb-2" href="#">
                  <span class="d-flex justify-content-center align-items-center">
                    <img class="avatar avatar-xss mr-2" src="./assets/svg/brands/google.svg" alt="Image Description">
                    Sign in with Google
                  </span>
              </a>

              <a class="js-animation-link btn btn-block btn-primary mb-2" href="#"
                 data-hs-show-animation-options='{
                     "targetSelector": "#signinWithEmailModalForm",
                     "groupName": "idForm"
                   }'>Sign in with Email</a>
            </div>
            <!-- End Sign in -->

            <!-- Sign in with Modal -->
            <div id="signinWithEmailModalForm" style="display: none; opacity: 0;">
              <div class="text-center mb-5">
                <h2>Sign in</h2>
                <p>Don't have an account yet?
                  <a class="js-animation-link" href="javascript:;"
                     data-hs-show-animation-options='{
                         "targetSelector": "#signupModalForm",
                         "groupName": "idForm"
                       }'>Sign up here</a>
                </p>
              </div>

              <!-- Form Group -->
              <div class="js-form-message form-group">
                <label class="input-label" for="signinModalFormSrEmail">Your email</label>
                <input type="email" class="form-control" name="email" id="signinModalFormSrEmail" placeholder="email@address.com" aria-label="email@address.com" required data-msg="Please enter a valid email address.">
              </div>
              <!-- End Form Group -->

              <!-- Form Group -->
              <div class="js-form-message form-group">
                <label class="input-label" for="signinModalFormSrPassword">
                    <span class="d-flex justify-content-between align-items-center">
                      Password
                      <a class="js-animation-link link text-muted" href="javascript:;"
                         data-hs-show-animation-options='{
                           "targetSelector": "#forgotPasswordModalForm",
                           "groupName": "idForm"
                         }'>Forgot Password?</a>
                    </span>
                </label>
                <input type="password" class="form-control" name="password" id="signinModalFormSrPassword" placeholder="8+ characters required" aria-label="8+ characters required" required data-msg="Your password is invalid. Please try again.">
              </div>
              <!-- End Form Group -->

              <button type="submit" class="btn btn-block btn-primary">Sign in</button>
            </div>
            <!-- End Sign in with Modal -->

            <!-- Sign up -->
            <div id="signupModalForm" style="display: none; opacity: 0;">
              <div class="text-center mb-5">
                <h2>Sign up</h2>
                <p>Already have an account?
                  <a class="js-animation-link" href="javascript:;"
                     data-hs-show-animation-options='{
                         "targetSelector": "#signinModalForm",
                         "groupName": "idForm"
                       }'>Sign in here</a>
                </p>
              </div>

              <a class="btn btn-block btn-white mb-2" href="#">
                  <span class="d-flex justify-content-center align-items-center">
                    <img class="avatar avatar-xss mr-2" src="./assets/svg/brands/google.svg" alt="Image Description">
                    Sign up with Google
                  </span>
              </a>

              <a class="js-animation-link btn btn-block btn-primary mb-2" href="#"
                 data-hs-show-animation-options='{
                     "targetSelector": "#signupWithEmailModalForm",
                     "groupName": "idForm"
                   }'>Sign up with Email</a>

              <div class="text-center mt-3">
                <p class="font-size-1 mb-0">By continuing you agree to our <a href="#">Terms and Conditions</a></p>
              </div>
            </div>
            <!-- End Sign up -->

            <!-- Sign up with Modal -->
            <div id="signupWithEmailModalForm" style="display: none; opacity: 0;">
              <div class="text-center mb-5">
                <h2>Sign up</h2>
                <p>Already have an account?
                  <a class="js-animation-link" href="javascript:;"
                     data-hs-show-animation-options='{
                         "targetSelector": "#signinModalForm",
                         "groupName": "idForm"
                       }'>Sign in here</a>
                </p>
              </div>

              <!-- Form Group -->
              <div class="js-form-message form-group">
                <label class="input-label" for="signupModalFormSrEmail">Your email</label>
                <input type="email" class="form-control" name="email" id="signupModalFormSrEmail" placeholder="email@address.com" aria-label="email@address.com" required data-msg="Please enter a valid email address.">
              </div>
              <!-- End Form Group -->

              <!-- Form Group -->
              <div class="js-form-message form-group">
                <label class="input-label" for="signupModalFormSrPassword">Password</label>
                <input type="password" class="form-control" name="password" id="signupModalFormSrPassword" placeholder="8+ characters required" aria-label="8+ characters required" required data-msg="Your password is invalid. Please try again.">
              </div>
              <!-- End Form Group -->

              <!-- Form Group -->
              <div class="js-form-message form-group">
                <label class="input-label" for="signupModalFormSrConfirmPassword">Confirm password</label>
                <input type="password" class="form-control" name="confirmPassword" id="signupModalFormSrConfirmPassword" placeholder="8+ characters required" aria-label="8+ characters required" required data-msg="Password does not match the confirm password.">
              </div>
              <!-- End Form Group -->

              <button type="submit" class="btn btn-block btn-primary">Sign up</button>

              <div class="text-center mt-3">
                <p class="font-size-1 mb-0">By continuing you agree to our <a href="#">Terms and Conditions</a></p>
              </div>
            </div>
            <!-- End Sign up with Modal -->

            <!-- Forgot Password -->
            <div id="forgotPasswordModalForm" style="display: none; opacity: 0;">
              <div class="text-center mb-5">
                <h2>Forgot password?</h2>
                <p>Enter the email address you used when you joined and we'll send you instructions to reset your password.</p>
              </div>

              <!-- Form Group -->
              <div class="js-form-message form-group">
                <label class="input-label" for="resetPasswordSrEmail" tabindex="0">
                  <span class="d-flex justify-content-between align-items-center">
                    Your email
                    <a class="js-animation-link d-flex align-items-center link text-muted" href="javascript:;"
                       data-hs-show-animation-options='{
                         "targetSelector": "#signinModalForm",
                         "groupName": "idForm"
                       }'>
                      <i class="fas fa-angle-left mr-2"></i> Back to Sign in
                    </a>
                  </span>
                </label>
                <input type="email" class="form-control" name="email" id="resetPasswordSrEmail" tabindex="1" placeholder="Enter your email address" aria-label="Enter your email address" required data-msg="Please enter a valid email address.">
              </div>
              <!-- End Form Group -->

              <button type="submit" class="btn btn-block btn-primary">Submit</button>
            </div>
            <!-- End Forgot Password -->
          </form>
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="modal-footer d-block text-center py-sm-5">
          <small class="text-cap mb-4">Trusted by the world's best teams</small>

          <div class="w-85 mx-auto">
            <div class="row justify-content-between">
              <div class="col">
                <img class="img-fluid" src="./assets/svg/brands/gitlab-gray.svg" alt="Image Description">
              </div>
              <div class="col">
                <img class="img-fluid" src="./assets/svg/brands/fitbit-gray.svg" alt="Image Description">
              </div>
              <div class="col">
                <img class="img-fluid" src="./assets/svg/brands/flow-xo-gray.svg" alt="Image Description">
              </div>
              <div class="col">
                <img class="img-fluid" src="./assets/svg/brands/layar-gray.svg" alt="Image Description">
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
  <!-- End Sign Up Modal -->
  <!-- ========== END SECONDARY CONTENTS ========== -->
<!-- Go to Top -->
  <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;"
     data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": 15
         },
         "show": {
           "bottom": 15
         },
         "hide": {
           "bottom": -15
         }
       }
     }'>
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- End Go to Top -->


   <!-- JS Global Compulsory  -->

  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <!-- <script src="assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script> -->

  <!-- <script src="assets/frontend/vendor/jquery/dist/jquery.min.js"></script> -->
  <script src="assets/frontend/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
  <script src="assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <link rel="stylesheet" href="assets/vendor/icon-set/style.css">


    <!-- <script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
    <script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
    <script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script> -->
    <script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>

  <script src="assets/frontend/vendor/hs-header/dist/hs-header.min.js"></script>
  <script src="assets/frontend/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
  <script src="assets/frontend/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
  <script src="assets/frontend/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="assets/frontend/vendor/hs-show-animation/dist/hs-show-animation.min.js"></script>
  <script src="assets/frontend/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
  <script src="assets/frontend/vendor/hs-counter/dist/hs-counter.min.js"></script>
  <script src="assets/frontend/vendor/appear/dist/appear.min.js"></script>


  <script src="assets/frontend/vendor/cubeportfolio/js/jquery.cubeportfolio.min.js"></script>
  <script src="assets/frontend/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.js"></script>
  <script src="assets/frontend/vendor/typed.js/lib/typed.min.js"></script>
  <script src="assets/frontend/vendor/aos/dist/aos.js"></script>
  <script src="assets/vendor/toastr/toastr.min.js"></script>
  <script src="assets/js/theme-custom.js"></script>

  <!-- JS Front -->
  <script src="assets/frontend/js/theme.min.js"></script>

  <script src="assets/js/theme.min.js"></script>
  <script src="assets/js/theme-custom.js"></script>

  <!-- JS Plugins Init. -->
  <script>
    $(document).on('ready', function () {
      // INITIALIZATION OF HEADER
      // =======================================================
      var header = new HSHeader($('#header')).init();


      // INITIALIZATION OF MEGA MENU
      // =======================================================
      var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
        desktop: {
          position: 'left'
        }
      }).init();

      // INITIALIZATION OF UNFOLD
      // =======================================================
      var unfold = new HSUnfold('.js-hs-unfold-invoker').init();


      // INITIALIZATION OF TEXT ANIMATION (TYPING)
      // =======================================================
      var typed = $.HSCore.components.HSTyped.init(".js-text-animation");


      // INITIALIZATION OF AOS
      // =======================================================
      AOS.init({
        duration: 650,
        once: true
      });


      // INITIALIZATION OF FORM VALIDATION
      // =======================================================
      $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this), {
          rules: {
            confirmPassword: {
              equalTo: '#signupPassword'
            }
          }
        });
      });


      // INITIALIZATION OF SHOW ANIMATIONS
      // =======================================================
      $('.js-animation-link').each(function () {
        var showAnimation = new HSShowAnimation($(this)).init();
      });


      // INITIALIZATION OF COUNTER
      // =======================================================
      $('.js-counter').each(function() {
        var counter = new HSCounter($(this)).init();
      });


      // INITIALIZATION OF STICKY BLOCK
      // =======================================================
      var cbpStickyFilter = new HSStickyBlock($('#cbpStickyFilter'));


      // INITIALIZATION OF CUBEPORTFOLIO
      // =======================================================
      $('.cbp').each(function () {
        var cbp = $.HSCore.components.HSCubeportfolio.init($(this), {
          layoutMode: 'grid',
          filters: '#filterControls',
          displayTypeSpeed: 0
        });
      });

      $('.cbp').on('initComplete.cbp', function() {
        // update sticky block
        cbpStickyFilter.update();
      });

      $('.cbp').on('filterComplete.cbp', function() {
        // update sticky block
        cbpStickyFilter.update();
      });

      $('.cbp').on('pluginResize.cbp', function() {
        // update sticky block
        cbpStickyFilter.update();
      });

      // animated scroll to cbp container
      $('#cbpStickyFilter').on('click', '.cbp-filter-item', function (e) {
        $('html, body').stop().animate({
          scrollTop: $('#demoExamplesSection').offset().top
        }, 200);
      });


      // INITIALIZATION OF GO TO
      // =======================================================
      $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
      });
    });
  </script>

  <!-- IE Support -->
  <script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="./assets/vendor/babel-polyfill/dist/polyfill.js"><\/script>');
  </script>
    <!-- JS Plugins Init. -->
    @if(Session::has('success'))
    <script>
        successMessage('{{ Session::get("success") }}');
    </script>
    @endif

    @if(Session::has('error'))
    <script>
        errorMessage('{{ Session::get("error") }}');
    </script>
    @endif
    <script>
      initSelect();
      $(document).on('ready', function () {

        $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
          $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });
        $('.js-file-attach').each(function () {
          var customFile = new HSFileAttach($(this)).init();
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
        $('.js-hs-unfold-invoker').each(function () {
          var unfold = new HSUnfold($(this)).init();
        });

        // initialization of form search
        $('.js-form-search').each(function () {
          new HSFormSearch($(this)).init()
        });

        // initialization of select2
        $('select').each(function () {
          var select2 = $.HSCore.components.HSSelect2.init($(this));
        });
      });

      function showPopup(url,method='get',paramters = {}){
        $.ajax({
            url: url+"?_token="+csrf_token,
            dataType:'json',
            type:method,
            data:paramters,
            beforeSend:function(){
                showLoader();
                $("#popupModal").html('');
            },
            success: function (result) {
                hideLoader();
                if(result.status == true){
                    $("#popupModal").html(result.contents);
                    $("#popupModal").modal("show");
                }else{
                    if(result.message != undefined){
                        errorMessage(result.message);
                    }else{
                        errorMessage("No Modal Data found");    
                    }
                }
            },
            error:function(){
                hideLoader();
                internalError();
            }
        });
      }
    
    function closeModal(){
        $("#popupModal").html('');
        $("#popupModal").modal("hide");
    }
    </script>
    
    @yield('javascript')
  </body>
</html>