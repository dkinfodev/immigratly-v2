@extends('frontend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-6 col-xl-4  d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative offset-xl-2 offset-md-0">
        <div class="flex-grow-1 p-5">
            <!-- Blockquote -->
            <figure class="text-center">
                <div class="mb-4">
                    <img class="avatar avatar-xl avatar-4x3"
                        src="assets/front/svg/brands/mailchimp-white.svg" alt="Logo">
                </div>

                <blockquote class="blockquote">“ It has many landing page variations to choose from, which
                    one is always a big advantage. ”</blockquote>

                <figcaption class="blockquote-footer">
                    <div class="mb-3">
                        <img class="avatar avatar-circle" src="assets/front/img/160x160/img9.jpg"
                            alt="Image Description">
                    </div>

                    Lida Reidy
                    <span class="blockquote-footer-source">Project Manager | Mailchimp</span>
                </figcaption>
            </figure>
            <!-- End Blockquote -->

            <!-- Clients -->
            <div class="position-absolute start-0 end-0 bottom-0 text-center p-5">
                <div class="row justify-content-center">
                    <div class="col text-center py-3">
                        <img class="avatar avatar-lg avatar-4x3"
                            src="assets/front/svg/brands/fitbit-white.svg" alt="Logo">
                    </div>
                    <!-- End Col -->

                    <div class="col text-center py-3">
                        <img class="avatar avatar-lg avatar-4x3"
                            src="assets/front/svg/brands/business-insider-white.svg" alt="Logo">
                    </div>
                    <!-- End Col -->

                    <div class="col text-center py-3">
                        <img class="avatar avatar-lg avatar-4x3"
                            src="assets/front/svg/brands/capsule-white.svg" alt="Logo">
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Clients -->
        </div>
    </div>
    <!-- End Col -->

    <div class="col-lg-6 col-xl-4 justify-content-center align-items-center min-vh-lg-100 ">
        <div class="flex-grow-1 margin-auto-sm" style="max-width: 28rem;">
            <div class="type-label-holder-wrap-outer">
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="type-label-holder-wrap text-center ">

                            <div class="type-label-holder"><img class="avatar avatar-xss"
                                    src="assets/front/svg/brands/google.svg" alt="Image Description"></div>

                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-8">
                        <div class="mb-5 mb-md-7 text-center-xs">
                            <h1 class="h2">Create an account</h1>
                            <p>Not a user? <a class="link" href="./page-login.html">View other sign-ups</a>
                            </p>

                        </div>
                    </div>
                </div>
                <span class="type-label user-label">User</span>
            </div>
            <div class="text-center">
                <p>Already have an account? <a class="link" href="{{ url('login') }}">Log in here</a></p>
            </div>
            <!-- Form -->
            <form id="signup-form" class="js-validate needs-validation" novalidate>
                @csrf
                <div class="d-grid mb-3">
                    <a class="btn btn-lg btn-white btn-block" href="{{ url('login/google') }}">
                        <span class="d-flex justify-content-center align-items-center">
                            <img class="avatar avatar-xss me-2" src="assets/front/svg/brands/google.svg"
                                alt="Google Sign-up">
                            Sign up with Google
                        </span>
                    </a>
                </div>
                <div class="d-grid mb-3">
                    <a class="btn btn-lg btn-white btn-block" href="#">
                        <span class="d-flex justify-content-center align-items-center">
                            <img class="avatar avatar-xss me-2"
                                src="assets/front/svg/brands/facebook-icon.svg" alt="Facebook Sign-up">
                            Sign up with Facebook
                        </span>
                    </a>
                </div>
                <div class="text-center mb-4">
                    <span class="divider text-muted">OR</span>
                </div>


                <!-- Form -->
                <div class="mb-3">
                    <label class="form-label" for="fullNameSrEmail">Full name</label>
                    <!-- Form Group -->
                    <!-- Form Group -->
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="js-form-message form-group">
                                <input type="text" class="form-control form-control-lg" name="first_name"
                                    id="first_name" placeholder="First name" aria-label="First_name" required
                                    data-msg="Please enter your first name.">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="js-form-message form-group">
                                <input type="text" class="form-control form-control-lg" name="last_name"
                                    id="last_name" placeholder="Last name" aria-label="last_name" required
                                    data-msg="Please enter your last name.">
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->
                    <!-- End Form Group -->
                </div>
                <!-- End Form -->
                <!-- Form -->
                <div class="mb-3 js-form-message">
                    <label class="form-label" for="signupModalFormSignupEmail">Your email</label>
                    <input type="email" class="form-control form-control-lg" name="email" id="signupSrEmail"
                                    placeholder="Markwilliams@example.com" aria-label="Markwilliams@example.com"
                                    required data-msg="Please enter a valid email address.">
                    <span class="invalid-feedback">Please enter a valid email address.</span>
                </div>
                <!-- End Form -->

                <!-- Form -->
                <div class="mb-3 js-form-message">
                    <label class="form-label" for="signupModalFormSignupPassword">Password</label>

                    <div class="input-group input-group-merge" data-hs-validation-validate-class>
                        <input type="password" class="js-toggle-password form-control form-control-lg"
                            name="password" id="password"
                            placeholder="8+ characters required" aria-label="8+ characters required"
                            required data-hs-toggle-password-options='{
                                "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                "defaultClass": "bi-eye-slash",
                                "showClass": "bi-eye",
                                "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                            }'>
                        <a class="js-toggle-password-target-1 input-group-append input-group-text"
                            href="javascript:;">
                            <i class="js-toggle-passowrd-show-icon-1 bi-eye"></i>
                        </a>
                    </div>



                    <span class="invalid-feedback">Your password is invalid. Please try again.</span>
                </div>
                <!-- End Form -->
                
                  <!-- Form -->
                  <div class="mb-3 js-form-message">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>

                    <div class="input-group input-group-merge" data-hs-validation-validate-class>
                        <input type="password" class="js-toggle-password form-control form-control-lg"
                            name="password_confirmation" id="password_confirmation"
                            placeholder="8+ characters required" aria-label="8+ characters required"
                            required data-hs-toggle-password-options='{
                                "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                "defaultClass": "bi-eye-slash",
                                "showClass": "bi-eye",
                                "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                            }'>
                        <a class="js-toggle-password-target-2 input-group-append input-group-text"
                            href="javascript:;">
                            <i class="js-toggle-passowrd-show-icon-2 bi-eye"></i>
                        </a>
                    </div>

                    <span class="invalid-feedback">Your password is invalid. Please try again.</span>
                </div>
                <!-- End Form -->

                <!-- Check -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="signupHeroFormPrivacyCheck"
                        name="signupFormPrivacyCheck" required>
                    <label class="form-check-label small" for="signupHeroFormPrivacyCheck"> By submitting
                        this form I have read and acknowledged the <a href=./page-privacy.html>Terms &amp; Conditions</a></label>
                    <span class="invalid-feedback">Please accept our Terms &amp; Conditions.</span>
                </div>
                <!-- End Check -->

                <div class="d-grid mb-3">
                    <button type="button" class="btn btn-primary btn-lg signup-btn">Sign up</button>
                </div>


            </form>
            <!-- End Form -->
            <div class="mt-5 mt-md-7">
                <div class="other-type-label-holder-wrap-outer"> <span
                        class="other-type-label user-label">Other Sign-ups</span>
                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="type-label-holder-wrap text-center ">

                                <div class="type-label-holder"><img class="avatar avatar-xss"
                                        src="assets/front/svg/brands/google.svg" alt="Image Description">
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-8 col-xl-8">
                            <!-- Heading -->
                            <div class="mb-5 mb-md-7 text-center-xs">
                                <h1 class="h2">Professional Signup</h1>
                                <p>Create account for professionals</p>

                            </div>
                            <!-- End Heading -->
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- End Col -->
</div>

@endsection

@section("javascript")
<div id="verify-screen"></div>
<div id="verificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Choose Verification Option
                </h5>
                <button type="button" class="btn btn-xs btn-icon btn-soft-secondary"
                    data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" width="10" height="10" viewBox="0 0 18 18"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>An OTP will be send for verification. Choose the option for sending OTP</p>
                <div class="js-form-message form-control">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="verify_type"
                            value="email" id="verficationRadio1">
                        <label class="custom-control-label" for="verficationRadio1">Email (<span
                                id="vr_email"></span>) </label>
                    </div>
                </div>
                <div class="js-form-message form-control">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="verify_type"
                            value="mobile_no" id="verficationRadio2">
                        <label class="custom-control-label" for="verficationRadio2">Mobile
                            Number (<span id="vr_mobile"></span>)</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" onclick="sendOtp(this)" class="btn btn-primary">Send
                    OTP</button>
            </div>
        </div>
    </div>
</div>
<div id="verificationCodeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Verification Code</h5>
                <button type="button" class="btn btn-xs btn-icon btn-soft-secondary"
                    data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" width="10" height="10" viewBox="0 0 18 18"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p id="opt_response"></p>
                <div class="js-form-message form-group">
                    <label id="creditCardLabel" class="input-label">Enter Verfication
                        Code</label>
                    <input type="text" class="js-masked-input form-control" id="verify_code"
                        placeholder="xxxxxx" data-hs-mask-options='{
                    "template": "000000"
                    }'>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="verifyOtp(this)"
                    class="btn btn-primary">Verify
                    OTP</button>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
<script src="assets/front/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>


<script>
    (function() {
         // INITIALIZATION OF TOGGLE PASSWORD
         // =======================================================
        new HSTogglePassword('.js-toggle-password')

    })();

</script>

<script type="text/javascript">

// INITIALIZATION OF TOGGLE PASSWORD
// =======================================================



var verify_status = '';
$(document).ready(function() {
    // new HSTogglePassword('.js-toggle-password');
    // $('.js-masked-input').each(function() {
    //     var mask = $.HSCore.components.HSMask.init($(this));
    // });



    $(".signup-btn").click(function(e) {
        e.preventDefault();
        $(".signup-btn").attr("disabled", "disabled");
        $(".signup-btn").find('.fa-spin').remove();
        $(".signup-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");

        var formData = $("#signup-form").serialize();
        if (verify_status != '') {
            formData += "&verify_status=" + verify_status;
        }
        $.ajax({
            url: $("#signup-form").attr("action"),
            type: "post",
            data: formData,
            dataType: "json",
            beforeSend: function() {
                
            },
            success: function(response) {
                $(".signup-btn").find(".fa-spin").remove();
                $(".signup-btn").removeAttr("disabled");
                if (response.status == true) {
                    window.location.href = response.redirect_back;
                } else {
                    if ((response.error_type == 'validation')) {
                        validation(response.message);
                    } else {
                        if (response.error_type == 'not_verified') {
                            // $("#verificationModal").modal("show");
                            // $("#verficationRadio1").val("email:" + response.email);
                            sendOtp("email:" + response.email);
                            // $("#verficationRadio2").val("mobile_no:" + response.mobile_no);
                            // $("#vr_email").html(response.email);
                            // $("#vr_mobile").html(response.mobile_no);
                        }
                        if (response.error_type == ' verification_pending') {
                            verify_status = '';
                            sendOtp("email:" + response.email);
                            // $("#verificationModal").modal("show");
                            // $("#verficationRadio1").val("email:" + response.email);
                            // $("#verficationRadio2").val("mobile_no:" + response.mobile_no);
                            // $("#vr_email").html(response.email);
                            // $("#vr_mobile").html(response.mobile_no);
                        }
                    }
                }
            },
            error: function() {
                $(".signup-btn").find(".fa-spin").remove();
                $(".signup-btn").removeAttr("disabled");
            }
        });
    });
});

function sendOtp(value) {
    $("#verify_code").val('');
    //var value = '';
    // if ($("input[name=verify_type]:checked").val() != undefined && $("input[name=verify_type]:checked").val() != '') {
    //     value = $("input[name=verify_type]:checked").val();
    // } else {
    //     errorMessage("Please select any one option");
    //     return false;
    // }
    $.ajax({
        url: "{{ url('send-verify-code') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            value: value,
            check:"user",
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            $("#opt_response").html("");
            if (response.status == true) {
                $("#verificationModal").modal("hide");
                $("#opt_response").html("<b>" + response.message + "</b>");
                $("#verificationCodeModal").modal("show");
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            hideLoader();
        }

    });
}

function verifyOtp(e) {
    //   $(e).attr("disabled","disabled");
    //   $(e).html("Verifying...");
    var verify_code = $("#verify_code").val();
    var verify_by = 'email';
    // if ($("input[name=verify_type]:checked").val() != undefined && $("input[name=verify_type]:checked").val() != '') {
    //     verify_by = $("input[name=verify_type]:checked").val();
    // } else {
    //     errorMessage("Please select any one option");
    //     return false;
    // }
    if (verify_code == '') {
        errorMessage("Please enter verification code");
        return false;
    }
    $.ajax({
        url: "{{ url('verify-code') }}",
        type: "post",
        data: {
            _token: "{{ csrf_token() }}",
            verify_code: verify_code,
            verify_by: verify_by,
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            $("#opt_response").html("");
            if (response.status == true) {
                successMessage(response.message);
                $("#verificationCodeModal").modal("show");
                verify_status = 'true';
                $(".signup-btn").trigger("click");
            } else {
                errorMessage(response.message);
            }
        },
        error: function() {
            hideLoader();
        }
    });
}
</script>
@endsection