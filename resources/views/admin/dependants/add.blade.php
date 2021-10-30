@extends('layouts.master')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('content')
<style>
.service-btn {
    padding: 2px !important;
    height: auto;
    width: auto;
}
.other_name{
    display:none;
}
</style>
<!-- Content -->
<div class="assessments">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{baseUrl('leads/dependants/'.$client_id)}}">
                    <i class="tio mr-1"></i> Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <form id="form" action="{{ baseUrl('leads/dependants/'.$client_id.'/save') }}" class="js-validate" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3>Personal Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="family_name">Family Name</label>
                            <input type="text" id="family_name" name="family_name" class="form-control" placeholder="Family Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="given_name">Given Name</label>
                            <input type="text" id="given_name" name="given_name" class="form-control" placeholder="Given Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group js-form-message">
                            <label class="input-label">Have you ever used any other name?</label>
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customInlineRadio1" class="custom-control-input" name="other_name"
                                        value="yes">
                                    <label class="custom-control-label" for="customInlineRadio1">Yes</label>
                                </div>
                            </div>
                            <!-- End Form Check -->

                            <!-- Form Check -->
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customInlineRadio2"
                                        class="custom-control-input indeterminate-checkbox" name="other_name" value="no">
                                    <label class="custom-control-label" for="customInlineRadio2">No</label>
                                </div>
                            </div>
                            <!-- End Form Check -->

                        </div>
                    </div>
                    <div class="col-md-6 other_name">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="other_family_name">Other Family Name</label>
                            <input type="text" id="other_family_name" name="other_family_name" class="form-control" placeholder="Other Family Name">
                        </div>
                    </div>
                    <div class="col-md-6 other_name">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="other_given_name">Other Given Name</label>
                            <input type="text" id="other_given_name" name="other_given_name" class="form-control" placeholder="Other Given Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="family_name">Date of Birth</label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="Date of Birth" aria-label="Date of birth"  data-msg="">
                                <div class="input-group-addon p-2">
                                <i class="tio-date-range"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label">Country of Birth</label>
                            <select name="country_of_birth" id="country_of_birth" data-msg="Please select gender."
                                class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="city_of_birth">City of Birth</label>
                            <input type="text" autocomplete="off" id="city_of_birth" name="city_of_birth" class="form-control" placeholder="City of Birth">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label">Gender</label>
                            <select name="gender" id="gender" data-msg="Please select gender."
                                class="form-control">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                
            </div>
            <!-- End Card -->
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3>Passport Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="passport_number">Passport Number</label>
                            <input type="text" id="passport_number" name="passport_number" class="form-control" placeholder="Passport Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="given_name">Passport Country</label>
                            <select name="passport_country" id="passport_country" data-msg="Please select country."
                                class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="family_name">Issue Date</label>
                            <div class="input-group js-form-message">
                                <input type="text" autocomplete="off" name="issue_date" id="issue_date" class="form-control" placeholder="Issue Date" aria-label="Issue Date"  data-msg="">
                                <div class="input-group-addon p-2">
                                <i class="tio-date-range"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group js-form-message">
                            <label class="input-label">Expiry Date</label>
                            <div class="input-group js-form-message">
                                <input type="text" autocomplete="off" name="expiry_date" id="expiry_date" class="form-control" placeholder="Expiry Date" aria-label="Expiry Date"  data-msg="">
                                <div class="input-group-addon p-2">
                                <i class="tio-date-range"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- End Card -->
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3>Primary Contact</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="primary_phone_no">Primary Phone Number</label>
                            <input type="text" id="primary_phone_no" name="primary_phone_no" class="form-control" placeholder="Primary Phone Number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="secondary_phone_no">Secondary Phone Number</label>
                            <input type="text" id="secondary_phone_no" name="secondary_phone_no" class="form-control" placeholder="Secondary Phone Number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group js-form-message">
                            <label class="input-label" for="business_phone_no">Business Phone Number</label>
                            <input type="text" id="business_phone_no" name="business_phone_no" class="form-control" placeholder="Business Phone Number">
                        </div>
                    </div>
                </div>              
            </div>
            <!-- End Card -->
        </div>
        <div class="text-center mt-3">
            <button type="submit" id="validationFormFinishBtn" class="btn add-btn btn-primary">Save</button>
        </div>
    </form>
    <!-- End Content -->
    @endsection

    @section('javascript')

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

    <script type="text/javascript">
    $(document).on('ready', function() {
        $("input[name=other_name]").change(function(){
            if($(this).val() == 'yes'){
                $(".other_name").show();
            }else{
                $(".other_name").hide();
            }
        })
        $('#date_of_birth').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            maxDate:(new Date()).getDate(),
            todayHighlight: true,
            orientation: "bottom auto"
        });
        $('#issue_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: "bottom auto"
        });
        $('#expiry_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: "bottom auto"
        });
        $("#form").submit(function(e) {
            e.preventDefault();
            var formData = $("#form").serialize();
            $.ajax({
                url: $("#form").attr("action"),
                type: "post",
                data: formData,
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
                    }
                },
                error: function() {
                    internalError();
                }
            });
        });
    });

    </script>

    @endsection