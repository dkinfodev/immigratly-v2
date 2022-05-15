@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('content')
<!-- Page Header -->
@include(roleFolder().'.cases.case-navbar')

<!-- Card -->
<div class="row">
    <div class="col-md-9">
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">

                <div class="row">
                    <div class="col-md-4">
                        <h6 class="card-subtitle pt-3 mb-0">Case stages</h6>
                    </div>
                    <div class="col-md-4 offset-md-4">
                        <div class="add-btn float-right">
                            @if($case->stage_start == 0)
                            <a class="btn btn-info mr-2 btn-sm" data-toggle="tooltip" data-placement="top" title="Start Stage" href="<?php echo baseUrl('cases/stages/stage-start/'.base64_encode($case->id)) ?>"><i class="tio-checkmark-square-outlined"></i></a>
                            @endif
                            <a class="btn btn-primary btn-sm" data-toggle="tooltip"
                                data-placement="top" title="Add New Stage"
                                href="<?php echo baseUrl('cases/stages/add/'.base64_encode($case->id)) ?>"><i class="tio-add mr-1"></i></a>
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div id="tableList" class="t"></div>
    </div>
    <div class="col-md-3">
      <div class="row">
          <div class="col-md-12 pt-2 mb-2">
              <label class="custom-form-label">Stage Profile</label>
          </div>
          <div class="col-md-12">
              <select class="form-control" name="stage_profile" id="stage_profile">
                  <option value="">Select Stage Profile</option>
                  <option {{$case->stage_profile == 'default'?'selected':'' }}
                      value="default">Default</option>
                  @foreach($stage_profiles as $stage)
                  <option {{$case->stage_profile_id == $stage->unique_id?'selected':'' }}
                      value="{{$stage->unique_id}}">{{$stage->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="col-md-12 mt-2">
              @if($case->stage_start == 0)
              <button type="button" onclick="saveStageProfile()"
                  class="btn btn-warning btn-lg w-100 p-2">Submit</button>
              @endif
                  <a class="btn btn-info w-100 btn-lg mt-2"
                                    href="<?php echo baseUrl('/global-stages/add?redirect_back='.url()->current()) ?>"><i
                                        class="tio-add mr-1"></i> Create Stage Profile</a>
          </div>
      </div>
    </div>
</div>
<!-- End Body -->

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
<script src="assets/vendor/appear/dist/appear.min.js"></script>
<script src="assets/vendor/circles.js/circles.min.js"></script>
<!-- JS Front -->
<script type="text/javascript">
// initEditor("description"); 
$(document).ready(function() {

    $("#datatableSearch").keyup(function() {
        var value = $(this).val();
        if (value == '') {
            loadData();
        }
        if (value.length > 3) {
            loadData();
        }
    });

});
loadData();

function loadData(page = 1) {
    var search = $("#datatableSearch").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/cases/stages/ajax-list?page=' + page,
        data: {
            _token: csrf_token,
            case_id: "{{$case->unique_id}}"
        },
        dataType: 'json',
        beforeSend: function() {
            var cols = $("#tableList").length;
            // $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
            showLoader();
        },
        success: function(data) {
            hideLoader();
            $("#tableList").html(data.contents);
            initPagination(data);
            $('.js-circle').each(function() {
                var circle = $.HSCore.components.HSCircles.init($(this));
            });

        },
        error: function() {
            internalError();
        }
    });
}


function saveStageProfile() {
    var stage_profile = $("#stage_profile").val();
    if (stage_profile == '') {
        errorMessage("Select Stage Profile");
        return false;
    }
    $.ajax({
        type: "POST",
        url: BASEURL + '/cases/stages/save-stage-profile',
        data: {
            _token: csrf_token,
            case_id: "{{$case->unique_id}}",
            stage_profile: stage_profile
        },
        dataType: 'json',
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                successMessage("Profile saved successfully");
                location.reload();
            } else {
                errorMessage("Something went wrong");
            }
        },
        error: function() {
            internalError();
        }
    });
}
</script>

@endsection