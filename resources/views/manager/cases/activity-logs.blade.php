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
<!-- Page Header -->
@include(roleFolder().'.cases.case-navbar')

<!-- Card -->
<div class="case-logs">
    <!-- Step -->
    <ul class="step">
        <!-- Step Item -->
        @foreach($activity_logs as $dlog)
        <li class="step-item">
            <div class="step-content-wrapper">
                <small class="step-divider">{{dateFormat($dlog->created_at)}}</small>
            </div>
        </li>
        <!-- End Step Item -->
        <?php
        $log_date = dateFormat($dlog->created_at,"Y-m-d");
        $logs = $dlog->dateWiseLogs($dlog->case_id,$log_date);
        ?>
            @foreach($logs as $log)
            <!-- Step Item -->
            <li class="step-item">
                <div class="step-content-wrapper">
                    <div class="step-avatar">
                        @if($log->added_by == 'user')
                        <img class="step-avatar-img" src="{{ userProfile($log->user_id) }}" alt="Image Description">
                        @else
                        <img class="step-avatar-img" src="{{ professionalProfile($log->user_id,'t',$subdomain) }}" alt="Image Description">
                        @endif
                    </div>

                    <div class="step-content">
                        <h5 class="mb-1">
                            @if($log->added_by == 'user')
                                <?php
                                    $user = userDetail($log->user_id);
                                ?>
                                @if(!empty($user))
                                    <a class="text-dark" href="javascript:;">{{ $user->first_name." ".$user->last_name  }}</a>
                                @else
                                    <a class="text-danger" href="javascript:;">N/A</a>
                                @endif
                            @else
                                <?php
                                    $user = professionalUser($log->user_id,$subdomain);
                                ?>
                                @if(!empty($user))
                                    <a class="text-dark" href="javascript:;">{{ $user->first_name." ".$user->last_name  }}</a>
                                @else
                                    <a class="text-danger" href="javascript:;">N/A</a>
                                @endif
                            @endif
                        </h5>

                        <p class="font-size-sm">{{$log->comment}}</p>

                    
                    </div>
                </div>
            </li>
            @endforeach
        @endforeach
        <!-- End Step Item -->

    </ul>
    <!-- End Step -->
</div>
<!-- End Card -->

<!-- End Row -->

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
// initEditor("description"); 
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

            }
        }).init();
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
            $("#city").html('');
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