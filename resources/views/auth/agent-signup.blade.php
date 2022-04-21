@extends('frontend.layouts.master')

@section('content')
<link rel="stylesheet" href="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">

<link rel="stylesheet" href="assets/front/css/front.css">
<link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">

<style>
span.select2-selection.select2-selection--single {
    height: 51px;
}
.select2-selection__rendered {
    padding: 11px 11px !important;
}
li.select2-selection__choice {
    padding: 9px !important;
}
.step{
    display:none;
}
.step.active{
    display:block !important;
}
</style>
<div class="row">
    <div class="col-lg-12 col-xl-12">
        <div class="flex-grow-1 p-1">
            <!-- Clients -->
            <div class="position-absolute start-0 end-0 bottom-0 text-center p-5">
                <div class="row justify-content-center">
                    <div class="col text-center py-3">
                        <img class="avatar avatar-lg avatar-4x3" src="assets/front/svg/brands/fitbit-white.svg"
                            alt="Logo">
                    </div>


                    <div class="col text-center py-3">
                        <img class="avatar avatar-lg avatar-4x3" src="assets/front/svg/brands/capsule-white.svg"
                            alt="Logo">
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Clients -->
        </div>
    </div>

    <div class="col-lg-6 col-xl-6 offset-md-3">
        <div class="flex-grow-1 margin-auto-sm">

            <!-- Form -->
            <form id="signup-form" class="js-validate  needs-validation" action="{{ url('signup/agent') }}"
                method="post" novalidate>
                @csrf
                <div class="step active step-1">
                    <div class="type-label-holder-wrap-outer">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="mb-5 mb-md-7 text-center">
                                    <h1 class="h2">Create an account</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="fullNameSrEmail">Full name</label>
                        <!-- Form Group -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="js-form-message">
                                    <input type="text" class="form-control form-control-lg" name="first_name"
                                        id="first_name" placeholder="First name" aria-label="First name" required
                                        data-msg="Please enter your first name.">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="js-form-message">
                                    <input type="text" name="last_name" id="last_name" class="form-control form-control-lg"
                                        placeholder="Last name" aria-label="Last name" required
                                        data-msg="Please enter your last name.">
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->
                    </div>

                    <div class="mb-3 js-form-message">
                        <label class="form-label" for="email">Your email</label>
                        <input type="email" class="form-control form-control-lg" name="email" id="signupSrEmail"
                            placeholder="youremail@abc.com" aria-label="youremail@abc.com" required>

                    </div>

                    <div class="mb-3 js-form-message">
                        <label class="form-label" for="fullNameSrEmail">Your phone number</label>
                        <!-- Form Group -->
                        <div class="row">
                            <div class="col-6 ">
                                <!-- Select -->

                                <select class="js-select form-select" id="country_code" name="country_code">
                                    <option value="Select">Select</option>
                                    @foreach($countries as $code)
                                    <option {{ old("country_code") =='+'.$code->phonecode?"selected":"" }}
                                        value="+{{ $code->phonecode }}">+{{ $code->phonecode }}
                                        ({{$code->name}})</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-sm-6">
                                <div class="js-form-message">
                                    <input type="text" name="phone_no" id="phone_no" class="form-control form-control-lg"
                                        placeholder="Enter your number" aria-label="Phone number" required
                                        data-msg="Enter your number.">
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Form -->
                    <div class="mb-3 js-form-message">
                        <label class="form-label" for="password">Password</label>

                        <div class="input-group input-group-merge" data-hs-validation-validate-class>
                            <input type="password" class="js-toggle-password form-control form-control-lg"
                                name="password" id="password" placeholder="6+ characters required"
                                aria-label="6+ characters required" required data-hs-toggle-password-options='{
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
                    </div>

                    <!-- Form -->
                    <div class="mb-3 js-form-message">
                        <label class="form-label" for="confirmPassword">Confirm Password</label>

                        <div class="input-group input-group-merge" data-hs-validation-validate-class>
                            <input type="password" class="js-toggle-password form-control form-control-lg"
                                name="password_confirmation" id="password_confirmation"
                                placeholder="6+ characters required" aria-label="6+ characters required" required
                                data-hs-toggle-password-options='{
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


                    </div>

                    <!-- Check -->
                    <div class="form-check mb-3 js-form-message">
                        <input type="checkbox" class="form-check-input" id="termsAndConditions"
                            name="termsAndConditions" required>
                        <label class="form-check-label small" for="termsAndConditions"> By submitting
                            this form I have read and acknowledged the <a href="javascript:;">Terms &amp;
                                Conditions</a></label>
                    </div>
                    <!-- End Check -->
                    <div class="d-grid mb-3">
                        <button type="button" class="btn btn-primary btn-lg signup-btn">Sign up</button>
                    </div>
                </div>
                            
                <div class="step step-2">
                    <div class="type-label-holder-wrap-outer">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="mb-5 mb-md-7 text-center">
                                    <h2 class="h2">Verify OTP</h2>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <p id="opt_response"></p>
                                <div class="js-form-message mb-3">
                                    <label id="creditCardLabel" class="input-label">Enter Verfication Code</label>
                                    <input type="text" class="js-masked-input form-control" id="verify_code" placeholder="xxxxxx"
                                        data-hs-mask-options='{
                                        "template": "000000"
                                        }'>
                                        <a class="float-right" href="javascript:;" onclick="resendOtp()">Resend OTP</a>
                                        <div class="clearfix"></div>
                                 </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3 btn-group w-100">
                                    <button type="button" onclick="goBack('step-1')" class="btn btn-lg btn-outline-secondary back-btn">Back</button>
                                    <button type="button" onclick="verifyOtp(this)" class="btn btn-lg btn-primary btn-lg">Verify Otp</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- End Form -->

        </div>
    </div>
    <!-- End Col -->
</div>

@endsection

@section("javascript")
<div id="verify-screen"></div>

<div id="verificationModal" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Choose Verification Option
                </h5>
                <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                    aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>An OTP will be send for verification. Choose the option for sending OTP</p>
                <div class="js-form-message form-control">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="verify_type" value="email"
                            id="verficationRadio1">
                        <label class="custom-control-label" for="verficationRadio1">Email (<span id="vr_email"></span>)
                        </label>
                    </div>
                </div>
                <div class="js-form-message form-control">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="verify_type" value="mobile_no"
                            id="verficationRadio2">
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
<!-- <div id="verificationCodeModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Verification Code</h5>
                <button type="button" onclick="closePopupModal('verificationCodeModal')"
                    class="btn btn-xs btn-icon btn-soft-secondary" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" width="10" height="10" viewBox="0 0 18 18"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p id="opt_response"></p>
                <div class="js-form-message">
                    <label id="creditCardLabel" class="input-label">Enter Verfication
                        Code</label>
                    <input type="text" class="js-masked-input form-control" id="verify_code" placeholder="xxxxxx"
                        data-hs-mask-options='{
                    "template": "000000"
                    }'>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="closePopupModal('verificationCodeModal')" class="btn btn-white"
                    data-dismiss="modal">Close</button>
                <button type="button" onclick="verifyOtp(this)" class="btn btn-primary">Verify
                    OTP</button>
            </div>
        </div>
    </div>
</div> -->
<!-- End Row -->

<script src="assets/front/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>


<script>
(function() {
    // INITIALIZATION OF TOGGLE PASSWORD
    // =======================================================
    new HSTogglePassword('.js-toggle-password')

    // HSCore.components.HSTomSelect.init('.js-select')

    $('.js-select2-custom').each(function() {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });

})();
</script>

<script>
var verify_status = '';
$(document).ready(function() {
    $("select").select2();
    $(".signup-btn").click(function(e) {
        e.preventDefault();
        $(".signup-btn").attr("disabled", "disabled");
        $(".signup-btn").find('.fa-spin').remove();
        $(".signup-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
        // var verify_by = 'sms';
        // var phone_no = $("#phone_no").val();
        // var country_code = $("#country_code").val();
        // var value = country_code + phone_no;
        // var formData = $("#signup-form").serialize();
        // formData += "&verify_by=" + verify_by;
        // formData += "&value=" + value;
        var formData = $("#signup-form").serialize();
        if (verify_status != '') {
            formData += "&verify_status=" + verify_status;
        }
        $.ajax({
            url: "{{ url('signup/agent') }}",
            type: "post",
            data: formData,
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                $(".signup-btn").find(".fa-spin").remove();
                $(".signup-btn").removeAttr("disabled");
                if (response.status == true) {
                    window.location.href = response.redirect_back;
                } else {
                    if ((response.error_type == 'validation')) {
                        validation(response.message);
                    } else {
                        if (response.error_type == undefined) {
                            errorMessage(response.message);
                            return false;
                        }
                        if (response.error_type == 'not_verified') {
                            // $("#verificationModal").modal("show");
                            // $("#verficationRadio1").val("email:" + response.email);
                            // $("#verficationRadio2").val("mobile_no:" + response.mobile_no);
                            // $("#vr_email").html(response.email);
                            // $("#vr_mobile").html(response.mobile_no);
                            sendOtp("email:" + response.email);
                        }
                        if (response.error_type == 'verification_pending') {
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

function goBack(step) {
    $(".step").removeClass("active");
    $("."+step).addClass("active");
}
function resendOtp(){
    var email = $("#signupSrEmail").val();
    if(email != ''){
        sendOtp("email:" + email);
    }else{
        alert("test");
        errorMessage("Please enter email");
    }
}
function sendOtp(value) {
    //alert("hello");
    //showLoader();
    // $("#verify_code").val('');
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
            check: "professional",
            value: value,
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
                successMessage(response.message);
                $(".step").removeClass("active");
                $(".step-2").addClass("active");
                // $("#verificationCodeModal").modal("show");
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
    // if (verify_code == '') {
    //     errorMessage("Please enter verification code");
    //     return false;
    // }
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

function closePopupModal(id) {
    $("#" + id).modal("hide");
}
</script>
@endsection