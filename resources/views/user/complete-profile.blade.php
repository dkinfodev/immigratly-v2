@extends('frontend.layouts.master')
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
                            <h4>Sign Up</h4>
                            <p class="step-text">Achieve virtually any design and layout from within the one template.
                            </p>
                        </div>
                    </div>
                </li>

                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-primary">2</span>
                        <div class="step-content">
                            <h4>Complete profile</h4>
                            <p class="step-text">We strive to figure out ways to help your business grow through all
                                platforms.
                            </p>
                        </div>
                    </div>
                </li>


            </ul>
            <!-- End Step -->


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
                                    src="./assets/svg/brands/google.svg" alt="Image Description"></div>

                        </div>
                    </div>

                    <div class="col-lg-8 col-xl-8 text-center-xs">
                        <!-- Heading -->
                        <div class="mb-5 mb-md-7">
                            <h1 class="h2">Hey {{ Auth::user()->first_name." ".Auth::user()->last_name }}!</h1>
                            <p>We need some more information</p>

                        </div>
                        <!-- End Heading -->
                    </div>
                </div>
                <span class="type-label user-label">User</span>
            </div>

            <!-- Form -->
            <!-- <form class="js-validate needs-validation" novalidate> -->
            <form id="form" class="js-validate" action="{{ baseUrl('/complete-profile') }}" method="post">
               @csrf
                <!-- Form -->
                <div class="mb-3 js-form-message">
                    <label class="form-label" for="signupModalFormSignupEmail">Country</label>
                    <!-- Select -->
                    <div class="tom-select-custom">
                        <select name="country_id" class="js-select form-select" autocomplete="off" data-hs-tom-select-options='{
          "placeholder": "Select a Country...",
          "hideSearch": true
        }'>
                            <option value="">Select Country...</option>
                            @foreach($countries as $country)
                                    <option {{$record2->country_id == $country->id?"selected":""}}
                                        value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                        </select>
                    </div>
                    <!-- End Select -->
                </div>
                <!-- End Form -->
                <!-- Form -->
                <div class="mb-3 js-form-message">
                    <label class="form-label" for="signupModalFormSignupEmail">Gender</label>
                    <!-- Select -->
                    <div class="tom-select-custom">
                        <select class="js-select form-select" name="gender" autocomplete="off" data-hs-tom-select-options='{
                              "placeholder": "Select a gender...",
                              "hideSearch": true
                           }'>
                            <option value="">Select a gender...</option>
                            <option {{($record2->gender == 'male')?'selected':''}} value="male">Male</option>
                           <option {{($record2->gender == 'female')?'selected':''}} value="female">Female
                           </option>
                           <option {{($record2->gender == 'other')?'selected':''}} value="other">Other
                           </option>
                        </select>
                    </div>
                    <!-- End Select -->
                </div>
                <!-- End Form -->
                <!-- Form -->
                <div class="mb-3 js-form-message">
                    <label class="form-label" for="signupModalFormSignupEmail">How do we identify you?</label>
                    <!-- Select -->
                    <div class="tom-select-custom">
                        <select name="cv_type" class="js-select form-select" autocomplete="off" data-hs-tom-select-options='{
          "placeholder": "Select a profile...",
          "hideSearch": true
        }'>
                            <option value="">Select a profile...</option>
                            @foreach($cv_types as $type)
                              <option {{$record2->cv_type == $type->id?"selected":""}} value="{{$type->id}}">
                                    {{$type->name}}</option>
                              @endforeach
                        </select>
                    </div>
                    <!-- End Select -->
                </div>
                <!-- End Form -->

                <!-- Form -->
                <!-- Date -->
                <div class="mb-3 js-form-message">
                    <label for="DateLabel" class="form-label">Date of Birth</label>
                    <input type="text" name="date_of_birth" class="js-input-mask form-control" id="DateLabel" placeholder="xx/xx/xxxx"
                        data-hs-mask-options='{
                        "mask": "00/00/0000"
                     }'>
                </div>
                <!-- End Date -->
                <!-- End Form -->

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">Complete</button>
                </div>


            </form>
            <!-- End Form -->


        </div>
    </div>
    <!-- End Col -->
</div>
<!-- End Row -->
<!-- Content -->

<!-- End Content -->
@endsection
@section('javascript')
<!-- JS Implementing Plugins -->
<!-- JS Implementing Plugins -->

<!-- <script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="assets/vendor/quill/dist/quill.min.js"></script>


<script src="assets/front/vendor/imask/dist/imask.min.js"></script> -->
<script>
    (function () {
      
      // INITIALIZATION OF SELECT
      // =======================================================
      HSCore.components.HSTomSelect.init('.js-select')

    })()
  </script>
<script>
$(document).ready(function(){
    // $('#date_of_birth').datepicker({
    //     format: 'dd/mm/yyyy',
    //     autoclose: true,
    //     maxDate: (new Date()).getDate(),
    //     todayHighlight: true,
    //     orientation: "bottom auto"
    // });
    // // initialization of Show Password
    // $('.js-toggle-password').each(function() {
    //     new HSTogglePassword(this).init()
    // });

    // // initialization of quilljs editor
    // $('.js-flatpickr').each(function() {
    //     $.HSCore.components.HSFlatpickr.init($(this));
    // });
    // initEditor("about_professional");
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
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    successMessage(response.message);
                    redirect(response.redirect_back);
                } else {
                    validation(response.message);
                    // $.each(response.message, function (index, value) {
                    //   $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                    //   $("[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');

                    //   var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                    //   $("[name="+index+"]").parents(".js-form-message").append(html);
                    //   $("[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
                    // });
                    // errorMessage(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });
    });

});


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