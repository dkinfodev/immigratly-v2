<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Careers | Front - Multipurpose Responsive Template</title>
    <base href="{{ url('/') }}/" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/front/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
    <link rel="stylesheet" href="assets/vendor/icon-set/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    

    
    <link rel="stylesheet" type="text/css" href="assets/vendor/sweetalert2/sweetalert2.min.css">
    <!-- <link rel="stylesheet" href="assets/front/vendor/tom-select/dist/css/tom-select.bootstrap5.css"> -->
    <link rel="stylesheet" href="assets/front/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/icon-set/style.css">
    <link rel="stylesheet" href="assets/front/css/front.css">
    <link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />

    
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="assets/css/theme.min.css">
    <link rel="stylesheet" href="assets/vendor/toastr/toastr.css">
    <script>
    var BASEURL = "{{ baseUrl('/') }}";
    var SITEURL = "{{ url('/') }}";
    var csrf_token = "{{ csrf_token() }}";
    </script>
</head>

<body>
<div class="loader">
<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
    <span class="sr-only"></span>
</div>
<h4 class="text-danger">Loading...</h4>
</div>
    @include('frontend.layouts.header')

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <div class="container-fluid position-relative zi-2">
            <div class="container">
                @yield('content')
             </div>
        </div>
    </main>
    <!-- ========== FOOTER ========== -->
    <footer class="bg-dark">
        <div class="container pb-1 pb-lg-5">
            
            <div class="row mb-7">
                <div class="col-sm mb-3 mb-sm-0">
                    <!-- Socials -->
                    <ul class="list-inline list-separator list-separator-light mb-0">
                        <li class="list-inline-item">
                            <a class="link-sm link-light" href="#">Privacy &amp; Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-sm link-light" href="#">Terms</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-sm link-light" href="#">Site Map</a>
                        </li>
                    </ul>
                    <!-- End Socials -->
                </div>

                <div class="col-sm-auto">
                    <!-- Socials -->
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-facebook"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-google"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-twitter"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-github"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <!-- Button Group -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-soft-light btn-xs dropdown-toggle"
                                    id="footerSelectLanguage" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-dropdown-animation>
                                    <span class="d-flex align-items-center">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/us.svg"
                                            alt="Image description" width="16" />
                                        <span>English (US)</span>
                                    </span>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="footerSelectLanguage">
                                    <a class="dropdown-item d-flex align-items-center active" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/us.svg"
                                            alt="Image description" width="16" />
                                        <span>English (US)</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/de.svg"
                                            alt="Image description" width="16" />
                                        <span>Deutsch</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/es.svg"
                                            alt="Image description" width="16" />
                                        <span>Español</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/cn.svg"
                                            alt="Image description" width="16" />
                                        <span>中文 (繁體)</span>
                                    </a>
                                </div>
                            </div>
                            <!-- End Button Group -->
                        </li>
                    </ul>
                    <!-- End Socials -->
                </div>
            </div>

            <!-- Copyright -->
            <div class="w-md-85 text-lg-center mx-lg-auto">
                <p class="text-white-50 small">&copy; Front. 2021 Htmlstream. All rights reserved.</p>
                <p class="text-white-50 small">When you visit or interact with our sites, services or tools, we or our
                    authorised service providers may use cookies for storing information to help provide you with a
                    better, faster and safer experience and for marketing purposes.</p>
            </div>
            <!-- End Copyright -->
        </div>
    </footer>

    <!-- ========== END FOOTER ========== -->

    <!-- ========== SECONDARY CONTENTS ========== -->
    <!-- Sign Up -->
    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-close">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="modal-body">
                    <!-- Log in -->
                    <div id="signupModalFormLogin" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Log in</h2>
                            <p>Don't have an account yet?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormSignup",
                         "groupName": "idForm"
                       }'>Sign up</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <div class="d-grid gap-2">
                            <a class="btn btn-white btn-lg" href="#">
                                <span class="d-flex justify-content-center align-items-center">
                                    <img class="avatar avatar-xss me-2" src="assets/front/svg/brands/google-icon.svg"
                                        alt="Image Description">
                                    Log in with Google
                                </span>
                            </a>

                            <a class="js-animation-link btn btn-primary btn-lg" href="#" data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormLoginWithEmail",
                       "groupName": "idForm"
                     }'>Log in with Email</a>
                        </div>
                    </div>
                    <!-- End Log in -->

                    <!-- Log in with Modal -->
                    <div id="signupModalFormLoginWithEmail" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Log in</h2>
                            <p>Don't have an account yet?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormSignup",
                         "groupName": "idForm"
                       }'>Sign up</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <form class="js-validate needs-validation" novalidate>
                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label" for="signupModalFormLoginEmail">Your email</label>
                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="signupModalFormLoginEmail" placeholder="email@site.com"
                                    aria-label="email@site.com" required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label" for="signupModalFormLoginPassword">Password</label>

                                    <a class="js-animation-link form-label-link" href="javascript:;"
                                        data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormResetPassword",
                       "groupName": "idForm"
                     }'>Forgot Password?</a>
                                </div>

                                <input type="password" class="form-control form-control-lg" name="password"
                                    id="signupModalFormLoginPassword" placeholder="8+ characters required"
                                    aria-label="8+ characters required" required minlength="8">
                                <span class="invalid-feedback">Please enter a valid password.</span>
                            </div>
                            <!-- End Form -->

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary form-control-lg">Log in</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Log in with Modal -->

                    <!-- Sign up -->
                    <div id="signupModalFormSignup">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Sign up</h2>
                            <p>Already have an account?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>Log in</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <div class="d-grid gap-3">
                            <a class="btn btn-white btn-lg" href="#">
                                <span class="d-flex justify-content-center align-items-center">
                                    <img class="avatar avatar-xss me-2" src="assets/front/svg/brands/google-icon.svg"
                                        alt="Image Description">
                                    Sign up with Google
                                </span>
                            </a>

                            <a class="js-animation-link btn btn-primary btn-lg" href="#" data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormSignupWithEmail",
                       "groupName": "idForm"
                     }'>Sign up with Email</a>

                            <div class="text-center">
                                <p class="small mb-0">By continuing you agree to our <a href="#">Terms and
                                        Conditions</a></p>
                            </div>
                        </div>
                    </div>
                    <!-- End Sign up -->

                    <!-- Sign up with Modal -->
                    <div id="signupModalFormSignupWithEmail" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Sign up</h2>
                            <p>Already have an account?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>Log in</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <form class="js-validate need-validate" novalidate>
                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label" for="signupModalFormSignupEmail">Your email</label>
                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="signupModalFormSignupEmail" placeholder="email@site.com"
                                    aria-label="email@site.com" required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label" for="signupModalFormSignupPassword">Password</label>
                                <input type="password" class="form-control form-control-lg" name="password"
                                    id="signupModalFormSignupPassword" placeholder="8+ characters required"
                                    aria-label="8+ characters required" required>
                                <span class="invalid-feedback">Your password is invalid. Please try again.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-3" data-hs-validation-validate-class>
                                <label class="form-label" for="signupModalFormSignupConfirmPassword">Confirm
                                    password</label>
                                <input type="password" class="form-control form-control-lg" name="confirmPassword"
                                    id="signupModalFormSignupConfirmPassword" placeholder="8+ characters required"
                                    aria-label="8+ characters required" required
                                    data-hs-validation-equal-field="#signupModalFormSignupPassword">
                                <span class="invalid-feedback">Password does not match the confirm password.</span>
                            </div>
                            <!-- End Form -->

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary form-control-lg">Sign up</button>
                            </div>

                            <div class="text-center">
                                <p class="small mb-0">By continuing you agree to our <a href="#">Terms and
                                        Conditions</a></p>
                            </div>
                        </form>
                    </div>
                    <!-- End Sign up with Modal -->

                    <!-- Reset Password -->
                    <div id="signupModalFormResetPassword" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Forgot password?</h2>
                            <p>Enter the email address you used when you joined and we'll send you instructions to reset
                                your password.</p>
                        </div>
                        <!-- En dHeading -->

                        <form class="js-validate need-validate" novalidate>
                            <div class="mb-3">
                                <!-- Form -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label" for="signupModalFormResetPasswordEmail" tabindex="0">Your
                                        email</label>

                                    <a class="js-animation-link form-label-link" href="javascript:;"
                                        data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>
                                        <i class="bi-chevron-left small"></i> Back to Log in
                                    </a>
                                </div>

                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="signupModalFormResetPasswordEmail" tabindex="1"
                                    placeholder="Enter your email address" aria-label="Enter your email address"
                                    required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                                <!-- End Form -->
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary form-control-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Reset Password -->
                </div>
                <!-- End Body -->

                <!-- Footer -->
                <div class="modal-footer d-block text-center py-sm-5">
                    <small class="text-cap mb-4">Trusted by the world's best teams</small>

                    <div class="w-85 mx-auto">
                        <div class="row justify-content-between">
                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/gitlab-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->

                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/fitbit-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->

                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/flow-xo-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->

                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/layar-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </div>
    <div class="modal fade imm-addeducation-modal" id="popupModal" tabindex="-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <!-- Go To -->
    <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;" data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'>
        <i class="bi-chevron-up"></i>
    </a>
    <!-- ========== END SECONDARY CONTENTS ========== -->
    

  <!-- JS Global Compulsory  -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
  <script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
  <script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
  <script src="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
  <script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
  <script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
  <script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
  <!-- <script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script> -->
  <script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
  <script src="assets/vendor/quill/dist/quill.min.js"></script>
  <script src="assets/vendor/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
  <script src="assets/vendor/@yaireo/tagify/dist/tagify.min.js"></script>
  <script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="assets/vendor/datatables.net.extensions/select/select.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="assets/vendor/jszip/dist/jszip.min.js"></script>
  <script src="assets/vendor/pdfmake/build/pdfmake.min.js"></script>
  <script src="assets/vendor/pdfmake/build/vfs_fonts.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>
  <script src="assets/vendor/toastr/toastr.min.js"></script>
  <script src="assets/vendor/ckeditor/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- JS Front -->
  <script src="assets/js/theme.min.js"></script>
  <script src="assets/js/theme-custom.js"></script>
    
  <script>
    $(document).on('ready', function () {

      initSelect();

      // INITIALIZATION OF UNFOLD
      // =======================================================
      // $('.js-hs-action').each(function () {
      //   var unfold = new HSUnfold($(this)).init();
      // });
      // $(".js-hs-unfold-invoker").click(function(){
      //     $(this).next(".hs-unfold-content").fadeToggle();
      // });
      
      $('[data-toggle="tooltip"]').tooltip();
      $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
      // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
      // =======================================================
      var sidebar = $('.js-navbar-vertical-aside').hsSideNav();

              // INITIALIZATION OF FILE ATTACH
        // =======================================================


        
        // INITIALIZATION OF SELECT2
        // =======================================================
        // $('.js-select2-custom').each(function () {
        //   var select2 = $.HSCore.components.HSSelect2.init($(this));
        // });


      // INITIALIZATION OF MEGA MENU
      // =======================================================
      var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
        // eventType: 'click',
        desktop: {
          position: 'left'
        }
      }).init();
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

    @yield("javascript")
</body>

</html>