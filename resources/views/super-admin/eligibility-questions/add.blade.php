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
<!-- Content -->
<div class="eligibility_questions">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id))}}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/save') }}" method="post">

        @csrf
        <!-- Input Group -->
       
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Question</label>
          <div class="col-sm-10">
            <input type="text" name="question" id="question" placeholder="Enter your Question" class="form-control" value="">
          </div>
        </div>
        <div class="form-group js-form-message row">
          <label class="col-sm-2 col-form-label">Additional Comment</label>
          <div class="col-sm-10">
            <textarea name="additional_notes" data-msg="Please enter description." id="additional_notes" class="form-control editor"></textarea>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Linked To CV</label>
          <div class="col-sm-10">
            <select name="linked_to_cv" id="linked_to_cv" required>
              <option value="">Select Option</option>
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          </div>
        </div>
        <div style="display:none" id="cv_section">
          <div class="js-form-message form-group row">
            <label class="col-sm-2 col-form-label">CV Section</label>
            <div class="col-sm-10">
              <select name="cv_section" onchange="checkCvOption(this.value)">
                <option value="">Select Option</option>
                <option value="age">Age</option>
                <option value="expirences">Expirences</option>
                <option value="education">Education</option>
                <option value="language_proficiency">Language proficiency</option>
              </select>
            </div>
          </div>
        </div>
        <div id="language_proficiency" style="display:none" id="language_proficiency">
          <div class="js-form-message form-group row">
              <label class="col-sm-2 col-form-label">Language Type</label>
              <div class="col-sm-10">
                  <select name="language_type" disabled>
                      <option value="">Select Option</option>
                      <option value="first_official">First Official</option>
                      <option value="second_official">Second Official</option>
                  </select>
              </div>
          </div>

          <div class="js-form-message form-group row">
              <label class="col-sm-2 col-form-label">Language Proficiency</label>
              <div class="col-sm-10">
                  <select name="language_proficiency" disabled onchange="checkProficiency(this.value)">
                      <option value="">Select Option</option>
                      @foreach($language_proficiencies as $proficiency)
                        <option  value="{{$proficiency->unique_id}}">{{$proficiency->name}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Option Type</label>
          <div class="col-sm-10">
            <select name="option_type" required>
              <option value="">Select Option</option>
              <option value="radio">Radio</option>
              <option value="dropdown">Dropdown</option>
            </select>
          </div>
        </div>
        <div class="js-add-field"
               data-hs-add-field-options='{
                  "template": "#addOptionsTemplate",
                  "container": "#addOptionsContainer",
                  "limit":100,
                  "defaultCreated": 1
                }'>
            <!-- Title -->
            <div class="bg-light border-bottom p-2 mb-3">
              <div class="row">
                <div class="col-sm-2 criteria_block" style="display:none">
                  <h6 class="card-title text-cap">Criteria</h6>
                </div>
                <div class="col-sm-2">
                  <h6 class="card-title text-cap">Option Value</h6>
                </div>
                <div class="col-sm-2 d-none d-sm-inline-block">
                  <h6 class="card-title text-cap">Option Label</h6>
                </div>
                <div class="col-sm-2 d-none d-sm-inline-block">
                  <h6 class="card-title text-cap">Score</h6>
                </div>
                <div class="col-sm-2 d-none d-sm-inline-block">
                  <h6 class="card-title text-cap">Image</h6>
                </div>
                <div class="col-sm-2 d-none d-sm-inline-block">
                  <h6 class="card-title text-cap">Non Eligible</h6>
                </div>
              </div>
            </div>
            <div class="form-group">
            <!-- Container For Input Field -->
            <div id="addOptionsContainer"></div>

            <a id="add-item" href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
              <i class="tio-add"></i> Add item
            </a>

            <!-- Add Phone Input Field -->
            <div id="addOptionsTemplate" class="item-row" style="display: none;">
              <!-- Content -->
              <div class="input-group-add-field">
              <?php
              $index = randomNumber(4);
              ?>
                <div class="row">
                  <div class="col-md-2 js-form-message criteria_block" style="display:none">
                      <!-- <select class="criteria">
                          <option value="">Select Option</option>
                          @foreach(criteria_options() as $criteria)
                          <option value="{{ $criteria['value'] }}">{{$criteria['label']}}</option>
                          @endforeach
                      </select> -->
                  </div>
                  <div class="col-md-2 js-form-message">
                    <input type="text" class="form-control mb-3 option_value" placeholder="Option Value" aria-label="Option Value">
                  </div>
                  <div class="col-md-2 js-form-message">
                    <input type="text" class="form-control mb-3 option_label" placeholder="Option Label" aria-label="Option Label">
                  </div>
                  <div class="col-md-2 js-form-message">
                    <input type="number" class="form-control mb-3 score" placeholder="Score" aria-label="Score">
                  </div>
                  <div class="col-md-2 js-form-message">
                    <input type="file" accept="image/*" class="form-control-plaintext mb-3 image" placeholder="Image" aria-label="Image">
                  </div>
                  <div class="col-md-2 non-elg-area js-form-message text-left">
                    <div class="custom-control custom-checkbox">
                      <input onchange="checkEligible(this)" type="checkbox" class="custom-control-input row-checkbox non-eligible" value="1" >
                      <label class="custom-control-label non-eligible-label" for="row-0">Non eligible</label>
                    </div>
                    <textarea style="display:none" placeholder="Enter reason for non eligible" class="form-control mt-2 non-eligible-reason"></textarea> 
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
       
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Components Linked to</label>
          <div class="col-sm-10">
            <select name="components" id="components" >
              @foreach($components as $component)
                <option {{$component->is_default == 1?'selected':''}} value="{{ $component->unique_id }}">{{$component->component_title}}</option>
              @endforeach
            </select>
            <div class="mt-3">
              <div class="custom-control custom-checkbox">
                  <input onchange="linkToDefault(this)" type="checkbox" name="default_component" id="default_component" class="custom-control-input row-checkbox non-eligible" value="1" >
                  <label class="custom-control-label non-eligible-label" for="default_component">Link to Default Component Only</label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="js-form-message form-group row">
            <label class="col-sm-2 col-form-label">Response Comment</label>
            <div class="col-sm-10">
                <textarea name="response_comment" data-msg="Please enter description." id="response_comment" class="form-control editor"></textarea>
            </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->
      </form>
      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

@section('javascript')
<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
    initEditor("additional_notes"); 
    initEditor("response_comment"); 
    $("#linked_to_cv").change(function(){
        if($(this).val() == 'yes'){
          $("#cv_section").show();
        }else{
          $("#cv_section").hide();
        }
    });
    
  $('.js-add-field').each(function () {
    new HSAddField($(this), {
      addedField: function() {
        var index = randomNumber();
        var criteria ='<select class="criteria">';
        criteria +='<option value="">Select Option</option>';
        <?php foreach(criteria_options() as $criteria){ ?>
        criteria +='<option value="<?php echo $criteria['value'] ?>"><?php echo $criteria['label'] ?></option>';
        <?php } ?>
        criteria +='</select>';
        setTimeout(function(){
          $("#addOptionsContainer > .item-row:last").find(".criteria_block").html(criteria);
          initSelect("#addOptionsContainer > .item-row:last");
          $("#addOptionsContainer > .item-row:last").find(".criteria").attr("name","options[" + index + "][criteria]");
        },100);
        $("#addOptionsContainer > .item-row:last").find(".option_value").attr("name","options["+index+"][option_value]");
        $("#addOptionsContainer > .item-row:last").find(".option_value").attr("required","true");
        $("#addOptionsContainer > .item-row:last").find(".option_label").attr("name","options["+index+"][option_label]");
        $("#addOptionsContainer > .item-row:last").find(".option_label").attr("required","true");
        $("#addOptionsContainer > .item-row:last").find(".score").attr("name","options["+index+"][score]");
        $("#addOptionsContainer > .item-row:last").find(".score").attr("required","true");
        $("#addOptionsContainer > .item-row:last").find(".image").attr("name","options["+index+"][image]");

        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("name","options["+index+"][non_eligible]");
        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("id","row-"+index);
        $("#addOptionsContainer > .item-row:last").find(".non-eligible-label").attr("for","row-"+index);
        
        $("#addOptionsContainer > .item-row:last").find(".non-eligible-reason").attr("name","options["+index+"][non_eligible_reason]");
        
        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("name","options["+index+"][non_eligible]");
        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("id","row-"+index);
        $("#addOptionsContainer > .item-row:last").find(".non-eligible-label").attr("for","row-"+index);
        
        $("#addOptionsContainer > .item-row:last").find(".non-eligible-reason").attr("name","options["+index+"][non_eligible_reason]");
        
        if($("select[name=cv_section]").val() == 'age' || $("select[name=cv_section]").val() == 'expirences'){
            $("#addOptionsContainer > .item-row:last").find(".criteria_block").show();
        }else{
            $("#addOptionsContainer > .item-row:last").find(".criteria_block").hide();
            $("#addOptionsContainer > .item-row:last").find(".criteria_block").html('');
        }
        $('[data-toggle="tooltip"]').tooltip();
        
      },
      deletedField: function() {
        $('.tooltip').hide();
      }
    }).init();
  });
  $("#form").submit(function(e){
        e.preventDefault(); 
        if($("#addOptionsContainer .item-row").length <= 0){
          errorMessage("Please add the options");
          return false;
        }
        var formData = new FormData($(this)[0]);
        $.ajax({
          url:$("#form").attr('action'),
          type:"post",
          data:formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          beforeSend:function(){
            showLoader();
          },
          success:function(response){
            hideLoader();
            if(response.status == true){
              successMessage(response.message);
              window.location.href = response.redirect_back;
            }else{
              validation(response.message);
            }
        },
        error:function(){
          internalError();
       }
     });
  });
});
function checkEligible(e){
  if($(e).is(":checked")){
    $(e).parents(".non-elg-area").find(".non-eligible-reason").show();
  }else{
    $(e).parents(".non-elg-area").find(".non-eligible-reason").hide();
  }
}
function linkToDefault(e){
  if($(e).is(":checked")){
    $("#components").attr("disabled","disabled");
  }else{
    $("#components").removeAttr("disabled");
  }
}
function checkProficiency(value){
    
    if(value != ''){
        $.ajax({
            url: "{{ baseUrl('visa-services/fetch-proficiency') }}",
            type: "get",
            data:{
                proficiency_id:value,
            },
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    $("#addOptionsContainer .item-row").remove();
                    var proficiencies = response.proficiencies;
                    $.each(proficiencies, function(key, item) {
                        $("#add-item").trigger("click");
                        $("#addOptionsContainer .item-row:last-child").find(".option_value").val(item.clb_level);
                        $("#addOptionsContainer .item-row:last-child").find(".option_label").val(item.clb_level);
                    });
                }
            },
            error: function() {
                internalError();
            }
        });
    }
}
function checkCvOption(value){
  $("#language_proficiency").hide();
    $(".criteria_block").hide();
    $("#language_proficiency select").attr('disabled','disabled');
    if(value == 'language_proficiency'){
        $("#language_proficiency").show();
        $("#language_proficiency select").removeAttr('disabled');
    }
    if(value == 'age' || value == 'expirences'){
        $(".criteria_block").show();
        $(".criteria_block select").removeAttr('disabled');
    }
    if(value == 'education'){
        $.ajax({
            url: "{{ baseUrl('visa-services/fetch-educations') }}",
            type: "get",
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    $("#addOptionsContainer .item-row").remove();
                    var educations = response.educations;
                    $.each(educations, function(key, item) {
                        $("#add-item").trigger("click");
                        $("#addOptionsContainer .item-row:last-child").find(".option_value").val(item.id);
                        $("#addOptionsContainer .item-row:last-child").find(".option_label").val(item.name);
                    });
                }
            },
            error: function() {
                internalError();
            }
        });
    }
}
</script>

  @endsection