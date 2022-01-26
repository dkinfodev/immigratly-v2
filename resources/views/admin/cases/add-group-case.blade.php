@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
  <a class="btn btn-primary" href="{{baseUrl('/cases')}}">
    <i class="tio mr-1"></i> Back
  </a>
@endsection

@section('content')
<!-- Content -->
<div class="add-case">

    <!-- Page Header -->
    <div class="page-header">
        <div class="media mb-3">
            <!-- Avatar -->
            <div class="avatar avatar-xl avatar-4by3 mr-2">
                <img class="avatar-img" src="./assets/svg/brands/guideline.svg" alt="Image Description">
            </div>
            <!-- End Avatar -->

            <div class="media-body">
                <div class="row">
                    <div class="col-lg mb-3 mb-lg-0">
                        <h1 class="page-header-title">Add new case</h1>

                        <div class="row align-items-center">


                            <div class="col-auto">
                                <div class="row align-items-center">
                                    <div class="col-auto">Due date: Unknown</div>


                                </div>
                            </div>

                            <div class="col-auto">
                                <!-- Select -->
                                <div class="select2-custom">
                                    <select class="js-select2-custom custom-select-sm" size="1" style="opacity: 0;"
                                        id="ownerLabel" data-hs-select2-options='{
                              "minimumResultsForSearch": "Infinity",
                              "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                              "dropdownAutoWidth": true,
                              "width": true
                            }'>
                                        <option value="owner1" selected
                                            data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="./assets/img/160x160/img6.jpg" alt="Avatar" /><span class="media-body">Mark Williams</span></span>'>
                                            Mark Williams</option>
                                        <option value="owner2"
                                            data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="./assets/img/160x160/img10.jpg" alt="Avatar" /><span class="media-body">Amanda Harvey</span></span>'>
                                            Amanda Harvey</option>
                                        <option value="owner3"
                                            data-option-template='<span class="media align-items-center"><i class="tio-user-outlined text-body mr-2"></i><span class="media-body">Assign to owner</span></span>'>
                                            Assign to owner</option>
                                    </select>
                                </div>
                                <!-- End Select -->
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12">
                                <span>Client:</span>
                                <span>Not assigned</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-auto">
                        <small class="text-cap mb-2">Team members:</small>

                        <div class="d-flex">
                            Not assigned
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Media -->

        <!-- Nav -->

    </div>
    <!-- End Page Header -->
    <!-- Step Form -->
    <form id="form" action="{{ baseUrl('cases/add-group-case') }}" class="js-validate js-step-form">
        @csrf
        <div class="row">
          <div class="col-lg-9">
            <div id="createProjectStepFormContent">
                <div id="createProjectStepDetails" class="active">
                    <!-- Form Group -->
                    <div class="form-group">
                        <label for="clientNewProjectLabel" class="input-label">Client</label>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="form-group js-form-message mb-0">
                                    <!-- Select -->
                                    <div class="select2-custom">
                                        <select class="js-select2-custom custom-select" required name="client_id"
                                            id="client_id" onchange="fetchDependents(this.value)">
                                            <option value="">Select Client</option>
                                            @foreach($clients as $client)
                                            <option value="{{$client->unique_id}}">
                                                {{$client->first_name." ".$client->last_name}} ({{$client->email}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- End Select -->
                                </div>
                                <div id="show-msg"
                                    style="color:#377dff; background-color: rgba(55, 125, 255, 0.1);padding:0.875rem;margin-top:1rem;border-radius:0.3125rem;display:none">
                                    This client does not have any dependents. You can add dependents from the
                                    clients' list section or
                                    choose the single-user option from the create case list.
                                </div>

                            </div>
                            <div class="col-1 text-center">OR</div>
                            <div class="col-sm-3">
                                <a class="btn btn-white"
                                    onclick="showPopup('<?php echo baseUrl('cases/create-client') ?>')"
                                    href="javascript:;">
                                    <i class="tio-add mr-1"></i>New client
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->
                    <!-- Form Group -->
                    <div class="form-group js-form-message">
                        <label class="input-label">Case Title</label>
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-briefcase-outlined"></i>
                                </div>
                            </div>
                            <input type="text" required data-msg="Please enter case title" class="form-control"
                                name="case_title" id="case_title" placeholder="Enter case title here"
                                aria-label="Enter case title here">
                        </div>
                    </div>
                    <!-- End Form Group -->
                    <div class="row">
                        <div class="col-sm-4">
                            <!-- Form Group -->
                            <div class="form-group js-form-message">
                                <label class="input-label">Start date</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend" data-toggle>
                                        <div class="input-group-text">
                                            <i class="tio-date-range"></i>
                                        </div>
                                    </div>
                                    <input required autocomplete="off" data-msg="Please select start date"
                                        type="text" name="start_date" class="form-control" id="start_date"
                                        placeholder="Select Start Date" data-input value="">
                                </div>
                            </div>
                            <!-- End Form Group -->
                        </div>
                        <div class="col-sm-4">
                            <!-- Form Group -->
                            <div class="form-group js-form-message">
                                <label class="input-label">End date</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend" data-toggle>
                                        <div class="input-group-text">
                                            <i class="tio-date-range"></i>
                                        </div>
                                    </div>
                                    <input type="text" autocomplete="off" data-msg="Please select end date"
                                        name="end_date" class="form-control" id="end_date"
                                        placeholder="Select End Date" data-input value="">
                                </div>
                            </div>
                            <!-- End Form Group -->
                        </div>
                      
                    </div>
                    <div class="form-group js-form-message">
                        <label class="input-label">Description <span
                                class="input-label-secondary">(Optional)</span></label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>


                    <!-- Footer -->
                    <div class="d-flex align-items-center">
                        <div class="ml-auto">
                            <button type="submit" id="savebtn" class="btn btn-primary">
                                Next <i class="tio-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <!-- End Footer -->
                </div>
            </div>
          </div>
          <div class="col-lg-3">
            <!-- Step -->
            <ul id="createProjectStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepDetails"
                    }'>
                        <span class="step-icon step-icon-soft-dark">1</span>
                        <div class="step-content">
                            <span class="step-title">Add Case</span>
                        </div>
                    </a>
                </li>
                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepClients"
                    }'>
                        <span class="step-icon step-icon-soft-dark">2</span>
                        <div class="step-content">
                            <span class="step-title">Select Clients</span>
                        </div>
                    </a>
                </li>
                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepAssignTeam"
                    }'>
                        <span class="step-icon step-icon-soft-dark">3</span>
                        <div class="step-content">
                            <span class="step-title">Assign Staff</span>
                        </div>
                    </a>
                </li>
                <li class="step-item">
                    <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                    "targetSelector": "#createProjectStepMembers"
                    }'>
                        <span class="step-icon step-icon-soft-dark">4</span>
                        <div class="step-content">
                            <span class="step-title">Confirmation
                            </span>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- End Step -->
          </div>
        </div>
    </form>
<!-- End Step Form -->
</div>
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
<script type="text/javascript">
initEditor("description");
$(document).on('ready', function() {
    $("#client_id").change(function() {
        if ($(this).val() != '') {
            var text = $("#client_id").find("option:selected").text();
            $("#client_name_text").html(text.trim());
        } else {
            $("#client_name_text").html('');
        }
    });
    $("[name=case_title]").change(function() {
        if ($(this).val() != '') {
            $("#case_title_text").html($(this).val());
        } else {
            $("#case_title_text").html('');
        }
    });
    $("[name=start_date]").change(function() {
        if ($(this).val() != '') {
            $("#start_date_text").html($(this).val());
        } else {
            $("#start_date_text").html('');
        }
    });
    $("[name=end_date]").change(function() {
        if ($(this).val() != '') {
            $("#end_date_text").html($(this).val());
        } else {
            $("#end_date_text").html('');
        }
    });
    $("#visa_service_id").change(function() {
        if ($(this).val() != '') {
            var text = $("#visa_service_id").find("option:selected").text();
            $("#visa_service_text").html(text.trim());
        } else {
            $("#visa_service_text").html('');
        }
    });
    $("#assign_teams").change(function() {
        if ($("#assign_teams").val() != '') {
            var html = '';
            $("#assign_staff_list").show();
            $(".staff").remove();
            $("#assign_teams").find("option:selected").each(function() {
                var text = $(this).attr('data-name');
                var role = $(this).attr('data-role');

                html += '<li class="text-left staff">';
                html += '<a class="nav-link media" href="javascript:;">';
                html += '<i class="tio-group-senior nav-icon text-dark"></i>';
                html += '<span class="media-body">';
                html += '<span class="d-block text-dark">' + text.trim() + '</span>';
                html += '<small class="d-block text-muted">' + role + '</small>';
                html += '</span></a></li>';
            });
            $("#assign_staff_list ul").append(html);
        } else {
            $("#assign_staff_list").hide();
            $("#assign_staff_list .staff").remove();
        }
    });
    $('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate: (new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    })
    .on('changeDate', function(selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#end_date').datepicker('setStartDate', startDate);
    });
$('#end_date').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
    maxDate: (new Date()).getDate(),
    todayHighlight: true,
    orientation: "bottom auto"
});
    $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this));
    });
    $('.js-step-form').each(function() {
        var stepForm = new HSStepForm($(this), {
            validate: function() {},
            finish: function() {
                // $("#createProjectStepFormProgress").hide();
                // $("#createProjectStepFormContent").hide();
                // $("#createProjectStepSuccessMessage").show();
                var formData = $("#form").serialize();
                var url = $("#form").attr('action');
                $.ajax({
                    url: url,
                    type: "post",
                    data: formData,
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
                            // errorMessage(response.message);
                        }
                    },
                    error: function() {
                        internalError();
                    }
                });
            }
        }).init();
    });
    $("#form").submit(function(e) {
        e.preventDefault();
        var formData = $("#form").serialize();
        var url = $("#form").attr('action');
        $.ajax({
            url: url,
            type: "post",
            data: formData,
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
                    // errorMessage(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });
    });
});

function fetchDependents(client_id) {
    $.ajax({
        url: "{{ baseUrl('cases/fetch-client-dependents') }}",
        type: "post",
        data: {
            _token: csrf_token,
            client_id: client_id
        },
        dataType: "json",
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                if (response.count > 0) {
                    $("#savebtn").removeAttr("disabled");
                    $("#show-msg").hide();
                } else {
                    $("#savebtn").attr("disabled",true);
                    $("#show-msg").show();
                }
            } else {
                $("#savebtn").removeAttr("disabled");
                $("#show-msg").hide();
            }
        },
        error: function() {
          internalError();
        }
    });
}
</script>

@endsection