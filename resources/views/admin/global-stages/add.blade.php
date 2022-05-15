@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/global-stages') }}">Global Stage Profile</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add</li>

</ol>
<!-- End Content -->
@endsection


@section('header-right')
<a class="btn btn-primary" href="{{baseUrl('global-stages')}}">
    <i class="tio mr-1"></i> Back
</a>
@endsection


@section('content')
<!-- Content -->

<!-- Card -->
<div class="card">

    <div class="card-body">
        <form id="form" class="js-validate" action="{{ baseUrl('/global-stages/save') }}" method="post">
            @csrf
            <input type="hidden" name="redirect_back" value="{{$redirect_back}}" />
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="js-form-message col-sm-10">
                    <input type="text" name="name" required id="name" placeholder="Stage Profile Title" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label">Do you want link this profile with service?</label>
                <div><strong>Note: For all such service it will act as default</strong></div>
                <div class="custom-control custom-checkbox mt-3">
                  <input type="checkbox" class="custom-control-input row-checkbox" name="link_to_service" id="link_to_service" value="1">
                  <label class="custom-control-label" for="link_to_service">Yes</label>
                </div>
            </div>
            <div class="js-form-message form-group row visa_services" style="display:none">
                <label class="col-sm-2 col-form-label">Visa Service</label>
                <div class="col-sm-10">
                    <select name="visa_service_id">
                        <option value="">Select Service</option>
                        @foreach($services as $service)
                        <option value="{{ $service->service_id }}">{{$service->Service($service->service_id)->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">

              <div class="js-add-field"
                  data-hs-add-field-options='{
                      "template": "#addStagesTemplate",
                      "container": "#addStagesContainer",
                      "defaultCreated": 0
                    }'>
                <!-- Title -->
                <div class="bg-light border-bottom p-2 mb-3">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6 class="card-title text-cap">Stage Name</h6>
                    </div>
                  </div>
                </div>

                <!-- Container For Input Field -->
                <div id="addStagesContainer"></div>

                <a href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
                  <i class="tio-add"></i> Add Stage
                </a>

                <!-- Add Phone Input Field -->
                <div id="addStagesTemplate" class="item-row" style="display: none;">
                  <!-- Content -->
                  <div class="input-group-add-field">
                    <div class="row">
                      <div class="col-md-9 js-form-message">
                        <input type="text" class="form-control mb-3 stage_name" placeholder="Stage Name" aria-label="Stage Name">
                      </div>
                      <div class="col-md-3">
                        <a href="javascript:;" onclick="addSubStages(this)" class="form-link p-2 mt-2 btn btn-sm btn-no-focus btn-ghost-primary">
                          <i class="tio-add"></i> Add Sub Stages
                        </a>
                      </div>
                      <div class="col-md-12">
                          <div class="sub-stages">
                          </div>
                      </div>
                    </div>
                    <!-- End Row -->

                    <a class="js-delete-field input-group-add-field-delete" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Remove item">
                      <i class="tio-clear"></i>
                    </a>
                  </div>
                  <!-- End Content -->
                </div>
                <!-- End Add Phone Input Field -->
              </div>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn add-btn btn-primary">Add</button>
            </div>
            <!-- End Input Group -->
        </form>
    </div><!-- End Card body-->
</div>
<!-- End Card -->
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
    $("#link_to_service").change(function(){
        if($(this).is(":checked")){
          $(".visa_services").show();
        }else{
          $(".visa_services").hide();
        }
    })
    $('.js-add-field').each(function () {
      new HSAddField($(this), {
        addedField: function() {
          var index = randomNumber();
          $("#addStagesContainer > .item-row:last").attr("data-index",index);
          $("#addStagesContainer > .item-row:last").find(".stage_name").attr("name","items["+index+"][stage_name]");
          $("#addStagesContainer > .item-row:last").find(".stage_name").attr("required","true");

          $('[data-toggle="tooltip"]').tooltip();
        },
        deletedField: function() {
          $('.tooltip').hide();
        }
      }).init();
    });
    
    $('.js-validate').each(function() {
        $.HSCore.components.HSValidation.init($(this));
    });
    $(".add-btn").click(function(e) {
        e.preventDefault();

        var formData = $("#form").serialize();
        $.ajax({
            url: $("#form").attr("action"),
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
                    window.location.href = response.redirect_back;
                } else {
                  validation(response.message);
                }
            },
            error: function() {
              hideLoader();
            }
        });
    });
});

function addSubStages(e){
  var index2 = randomNumber();
  var index = $(e).parents(".item-row").attr("data-index");
  var html = '<div class="row sub-stage-row">';
  html += '<div class="col-md-5">';
  html += '<div class="form-group"><input type="text" required placeholder="Enter Sub Stage Name" name="items['+index+'][sub_stages]['+index2+'][name]" class="form-control sub_stage_name"></div>';
  html += '</div>';
  html += '<div class="col-md-5">';
  html += '<div class="form-group"><select required class="form-control sub_stage_type" name="items['+index+'][sub_stages]['+index2+'][stage_type]">';
  html += '<option value="">Select Type</option>';
  html += '<option data-type="fill-form" value="fill-form">Fill Form</option>';
  html += '<option data-type="case-task" value="case-task">Case Task</option>';
  html += '<option data-type="case-document" value="case-document">Case Document</option>';
  html += '</select></div>';
  html += '</div>';
  html += '<div class="col-md-2">';
  html += '<div class="mt-3"><a href="javascript:;" onclick="removeSubStages(this)" class="text-danger"><i class="tio-clear"></i></a></div>';
  html += '</div>';
  html += '</div>';
  $(e).parents(".item-row").find(".sub-stages").append(html);
}

function removeSubStages(e){
  $(e).parents(".sub-stage-row").remove();
}
</script>

@endsection