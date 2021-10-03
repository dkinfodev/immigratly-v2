@extends('layouts.master')

@section('content')
<!-- Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>
                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">
                <a class="btn btn-primary"
                    href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id))}}">
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
            <form id="form" class="js-validate"
                action="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/edit/'.base64_encode($record->id)) }}"
                method="post">

                @csrf
                <!-- Input Group -->

                <!-- End Input Group -->
                <div class="js-form-message form-group row">
                    <label class="col-sm-2 col-form-label">Question</label>
                    <div class="col-sm-10">
                        <input type="text" name="question" id="question" placeholder="Enter your Question"
                            class="form-control" value="{{$record->question}}">
                    </div>
                </div>
                <div class="js-form-message form-group row">
                    <label class="col-sm-2 col-form-label">Additional Comment</label>
                    <div class="col-sm-10">
                        <textarea name="additional_notes" data-msg="Please enter description." id="additional_notes" class="form-control editor">{{$record->additional_notes}}</textarea>
                    </div>
                </div>
                <div class="js-form-message form-group row">
                        <label class="col-sm-2 col-form-label">Linked To CV</label>
                        <div class="col-sm-10">
                            <select name="linked_to_cv" id="linked_to_cv" required>
                                <option value="">Select Option</option>
                                <option {{$record->linked_to_cv == 'yes'?'selected':''}} value="yes">Yes</option>
                                <option {{$record->linked_to_cv == 'no'?'selected':''}} value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:{{$record->linked_to_cv == 'no'?'none':'block'}}" id="cv_section">
                      <div class="js-form-message form-group row">
                          <label class="col-sm-2 col-form-label">CV Section</label>
                          <div class="col-sm-10">
                              <select name="cv_section" onchange="checkCvOption(this.value)">
                                  <option value="">Select Option</option>
                                  <option {{$record->cv_section == 'age'?'selected':''}} value="age">Age</option>
                                  <option {{$record->cv_section == 'expirences'?'selected':''}} value="expirences">Expirences</option>
                                  <option {{$record->cv_section == 'education'?'selected':''}} value="education">Education</option>
                                  <option {{$record->cv_section == 'language_proficiency'?'selected':''}} value="language_proficiency">Languages Proficiency</option>
                              </select>
                          </div>
                      </div>
                    </div>
                    <div id="language_proficiency" style="display:{{$record->cv_section == 'language_proficiency'?'block':'none'}}" id="language_proficiency">
                    <div class="js-form-message form-group row">
                        <label class="col-sm-2 col-form-label">Language Type</label>
                        <div class="col-sm-10">
                            <select name="language_type" disabled>
                                <option value="">Select Option</option>
                                <option {{ ($record->language_type == 'first_official')?'selected':''}} value="first_official">First Official</option>
                                <option {{ ($record->language_type == 'second_official')?'selected':''}} value="second_official">Second Official</option>
                            </select>
                        </div>
                    </div>
                      <div class="js-form-message form-group row">
                          <label class="col-sm-2 col-form-label">Select Language Proficiency</label>
                          <div class="col-sm-10">
                              <select name="language_proficiency" {{$record->cv_section != 'language_proficiency'?'disabled':''}} onchange="checkProficiency(this.value)">
                                  <option value="">Select Option</option>
                                  @foreach($language_proficiencies as $proficiency)
                                    <option {{ ($record->language_proficiency == $proficiency->unique_id)?'selected':''}} value="{{$proficiency->unique_id}}">{{$proficiency->name}}</option>
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
                                <option {{$record->option_type == 'radio'?'selected':''}} value="radio">Radio</option>
                                <option {{$record->option_type == 'dropdown'?'selected':''}} value="dropdown">Dropdown
                                </option>
                            </select>
                        </div>
                    </div>
                <div class="js-add-field" data-hs-add-field-options='{
                  "template": "#addOptionsTemplate",
                  "container": "#addOptionsContainer",
                  "limit":100,
                  "defaultCreated": 0
                }'>
                    <!-- Title -->
                    <div class="bg-light border-bottom p-2 mb-3">
                        <div class="row">
                            <div class="col-sm-2 criteria_block" style="display:{{($record->cv_section == 'age' || $record->cv_section == 'expirence')?'block':'none'}}">
                                <h6 class="card-title text-cap">Criteria</h6>
                            </div>
                            <div class="col-sm-2">
                                <h6 class="card-title text-cap">Option Value</h6>
                            </div>
                            <div class="col-md-2 d-none d-sm-inline-block">
                                <h6 class="card-title text-cap">Option Label</h6>
                            </div>
                            <div class="col-md-2 d-none d-sm-inline-block">
                                <h6 class="card-title text-cap">Score</h6>
                            </div>
                            <div class="col-md-2 d-none d-sm-inline-block">
                                <h6 class="card-title text-cap">Image</h6>
                            </div>
                            <div class="col-sm-2 d-none d-sm-inline-block">
                                <h6 class="card-title text-cap">Non Eligible</h6>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Container For Input Field -->
                        <div id="addOptionsContainer">
                          @foreach($record->Options as $option)
                          <div class="item-row">
                            <div class="input-group-add-field">
                                
                                <?php
                                $index = randomNumber(4);
                                ?>
                                <div class="row">
                                    <input type="hidden" name="options[{{$index}}][id]" class="option_id"
                                        value="{{base64_encode($option->id)}}" />
                                    <div class="col-md-2 js-form-message criteria_block" style="display:{{($record->cv_section == 'age' || $record->cv_section == 'expirence')?'block':'none'}}" >
                                   
                                        <select name="options[{{$index}}][criteria]" class="criteria no_select2">
                                            <option value="">Select Option</div>
                                            @foreach(criteria_options() as $criteria)
                                            <option {{($criteria['value'] == $option->criteria)?'selected':''}} value="{{ $criteria['value'] }}">{{$criteria['label']}}</option>
                                            @endforeach
                                        </select>
                                    </div>   
                                    <div class="col-md-2 js-form-message">
                                        <input name="options[{{$index}}][option_value]" type="text"
                                            value="{{ $option->option_value }}" class="form-control mb-3 option_value"
                                            placeholder="Option Value" aria-label="Option Value">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input name="options[{{$index}}][option_label]" type="text"
                                            value="{{ $option->option_label }}" class="form-control mb-3 option_label"
                                            placeholder="Option Label" aria-label="Option Label">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input name="options[{{$index}}][score]" type="number"
                                            value="{{ $option->score }}" class="form-control mb-3 score"
                                            placeholder="Score" aria-label="Score">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input name="options[{{$index}}][image]" accept="image/*" type="file"
                                            class="form-control-plaintext mb-3 image" placeholder="Image"
                                            aria-label="Image">
                                        @if($option->image != '' && file_exists(public_path('uploads/images/'.$option->image)))
                                        <div class="file_image mb-3">
                                            <img width="100" height="100"
                                                src="{{ asset('public/uploads/images/'.$option->image) }}"
                                                class="img-responsive" />
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-2 non-elg-area js-form-message text-left">
                                        <div class="custom-control custom-checkbox">
                                        <input onchange="checkEligible(this)" id="row-{{$index}}" name="options[{{$index}}][non_eligible]"  {{$option->non_eligible == 1?'checked':'' }} type="checkbox" class="custom-control-input row-checkbox non-eligible" value="1" >
                                        <label class="custom-control-label non-eligible-label non_eligible" for="row-{{$index}}">Non eligible</label>
                                        </div>
                                        <textarea style="display:{{$option->non_eligible == 1?'block':'none' }}" name="options[{{$index}}][non_eligible_reason]"  placeholder="Enter reason for non eligible" class="form-control mt-2 non-eligible-reason">{{$option->non_eligible_reason}}</textarea> 
                                    </div>
                                </div>
                                <a class="js-delete-field input-group-add-field-delete ext-delete"
                                    href="javascript:;" data-toggle="tooltip" data-placement="top"
                                    title="Remove item">
                                    <i class="tio-clear"></i>
                                </a>
                                <!-- End Row -->
                            </div>
                          </div>
                          @endforeach
                        </div>
                        <a href="javascript:;" id="add-item"
                            class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary">
                            <i class="tio-add"></i> Add item
                        </a>

                        <!-- Add Phone Input Field -->
                        <div id="addOptionsTemplate" class="item-row" style="display: none;">
                            <!-- Content -->
                            <div class="input-group-add-field">

                                <div class="row">
                                    <input type="hidden" class="option_id" value="0" />
                                    <div class="col-md-2 js-form-message criteria_block" style="display:none">
                                        <select class="criteria no-select2" disabled>
                                            <option value="">Select Option</div>
                                            @foreach(criteria_options() as $criteria)
                                            <option value="{{ $criteria['value'] }}">{{$criteria['label']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="text" class="form-control mb-3 option_value"
                                            placeholder="Option Value" aria-label="Option Value">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="text" class="form-control mb-3 option_label"
                                            placeholder="Option Label" aria-label="Option Label">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="number" class="form-control mb-3 score" placeholder="Score"
                                            aria-label="Score">
                                    </div>
                                    <div class="col-md-2 js-form-message">
                                        <input type="file" accept="image/*" class="form-control-plaintext mb-3 image"
                                            placeholder="Image" aria-label="Image">
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
                                <a class="js-delete-field input-group-add-field-delete" href="javascript:;"
                                    data-toggle="tooltip" data-placement="top" title="Remove item">
                                    <i class="tio-clear"></i>
                                </a>
                                
                            </div>
                            <!-- End Content -->
                        </div>
                        <!-- End Add Phone Input Field -->
                    </div>
                    
                    <div class="js-form-message form-group row">
                        <label class="col-sm-2 col-form-label">Component Linked to</label>
                        <div class="col-sm-10">
                            <select name="components" id="components">
                            @foreach($components as $component)
                                <option {{ (in_array($component->unique_id,$component_ids))?'selected':'' }} value="{{ $component->unique_id }}">{{$component->component_title}}</option>
                            @endforeach
                            </select>
                            <div class="mt-3">
                                <div class="custom-control custom-checkbox">
                                    <input onchange="linkToDefault(this)" name="default_component" type="checkbox" id="default_component" class="custom-control-input row-checkbox non-eligible" value="1" >
                                    <label class="custom-control-label non-eligible-label" for="default_component">Link to Default Component Only</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="js-form-message form-group row">
                        <label class="col-sm-2 col-form-label">Response Comment</label>
                        <div class="col-sm-10">
                            <textarea name="response_comment" data-msg="Please enter description." id="response_comment" class="form-control editor">{{$record->response_comment}}</textarea>
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
$(document).ready(function() {
    initEditor("additional_notes"); 
    initEditor("response_comment"); 
    $(".ext-delete").click(function() {

        $(this).parents(".item-row").remove();
    });
    $("#linked_to_cv").change(function() {
        if ($(this).val() == 'yes') {
            $("#cv_section").show();
        } else {
            $("#cv_section").hide();
        }
    });
    
    $('.js-add-field').each(function() {
        new HSAddField($(this), {
            addedField: function() {
                var index = randomNumber();
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
                $("#addOptionsContainer > .item-row:last").find(".option_id").attr("name","options[" + index + "][id]");
                $("#addOptionsContainer > .item-row:last").find(".option_value").attr("name", "options[" + index + "][option_value]");
                $("#addOptionsContainer > .item-row:last").find(".option_value").attr("required", "true");
                $("#addOptionsContainer > .item-row:last").find(".option_label").attr("name", "options[" + index + "][option_label]");
                $("#addOptionsContainer > .item-row:last").find(".option_label").attr("required", "true");
                $("#addOptionsContainer > .item-row:last").find(".score").attr("name","options[" + index + "][score]");
                $("#addOptionsContainer > .item-row:last").find(".score").attr("required","true");
                $("#addOptionsContainer > .item-row:last").find(".image").attr("name","options[" + index + "][image]");
                
                
                $("#addOptionsContainer > .item-row:last").find(".criteria").attr("name","options[" + index + "][criteria]");
                if($("select[name=cv_section]").val() == 'age' || $("select[name=cv_section]").val() == 'expirences'){
                    $("#addOptionsContainer > .item-row:last").find(".criteria_block").show();
                }else{
                    $("#addOptionsContainer > .item-row:last").find(".criteria_block").hide();
                    $("#addOptionsContainer > .item-row:last").find(".criteria_block").html('');
                }
                $('[data-toggle="tooltip"]').tooltip();
                initSelect("#addOptionsContainer > .item-row:last");

            },
            deletedField: function() {
                $('.tooltip').hide();
            }
        }).init();
    });
    $("#form").submit(function(e) {
        e.preventDefault();
        if ($("#addOptionsContainer .item-row").length <= 0) {
            errorMessage("Please add the options");
            return false;
        }
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: $("#form").attr('action'),
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
                    window.location.href = response.redirect_back;
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
        initSelect("#addOptionsContainer > .item-row:last");
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