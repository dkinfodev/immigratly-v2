@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>

  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('header-right')
        <a class="btn btn-primary" href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id))}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection



@section('content')
<!-- Content -->
<div class="eligibility_questions">
  
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
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Is Language Proficiency</label>
          <div class="col-sm-10 pt-2">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="language_prof_type" id="language_prof_type" class="custom-control-input row-checkbox non-eligible" value="1" >
                <label class="custom-control-label non-eligible-label" for="language_prof_type">&nbsp;</label>
              </div>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Is Wage Type</label>
          <div class="col-sm-10 pt-2">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="wage_type" id="wage_type" class="custom-control-input row-checkbox non-eligible" value="1" >
                <label class="custom-control-label non-eligible-label" for="wage_type">&nbsp;</label>
              </div>
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
              <label class="col-sm-2 col-form-label">Score Count Type</label>
              <div class="col-sm-10">
                  <select name="score_count_type" onchange="scoreCount(this.value)" disabled>
                      <option value="">Select Option</option>
                      <option  value="lowest_matching">Lowest Matching</option>
                      <option  value="range_matching">Range Matching</option>
                  </select>
              </div>
          </div>
          <!-- <div class="js-form-message form-group row score_points"  style="display:none">
              <div class="col-md-12">
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th colspan="3">Score Point</th>
                          </tr>
                          <tr>
                              <th>One Match</th>
                              <th>Two Match</th>
                              <th>Three Match</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>
                                  <input type="text" class="form-control" name="one_match" placeholder="Enter One Match Point" value="" />
                              </td>
                              <td>
                                  <input type="text" class="form-control" name="two_match" placeholder="Enter Two Match Point" value="" />
                              </td>
                              <td>
                                  <input type="text" class="form-control" name="three_match" placeholder="Enter Three Match Point" value="" />
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div> -->
          <div class="js-form-message form-group row">
              <label class="col-sm-2 col-form-label">Language Proficiency</label>
              <div class="col-sm-8">
                  <select id="lang_prof" name="language_proficiency" disabled >
                      <option value="">Select Option</option>
                      @foreach($language_proficiencies as $proficiency)
                        <option  value="{{$proficiency->unique_id}}">{{$proficiency->name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-md-2">
                  <button type="button" onclick="checkProficiency()" class="btn btn-outline-primary w-100 ">Add Options</button>
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
        <div class="option-blocks js-add-field"
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
                <!-- <div class="col-sm-2 wage_type_block" style="display:none">
                  <h6 class="card-title text-cap">Wage Type</h6>
                </div> -->
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
                      <div class="col-md-12">
                          <div class="option-heading h3"></div>
                      </div>
                      <div class="col-md-2 js-form-message criteria_block" style="display:none">
                          <!-- <select class="criteria">
                              <option value="">Select Option</option>
                              @foreach(criteria_options() as $criteria)
                              <option value="{{ $criteria['value'] }}">{{$criteria['label']}}</option>
                              @endforeach
                          </select> -->
                      </div>
                      <input type="hidden" class="language_proficiency_id" value="" />
                      <div class="col-md-2 js-form-message">
                        <input type="text" class="form-control mb-3 option_value" placeholder="Option Value" aria-label="Option Value">
                      </div>
                      <div class="col-md-2 js-form-message">
                        <input type="text" class="form-control mb-3 option_label" placeholder="Option Label" aria-label="Option Label">
                      </div>
                      <!-- <div class="col-md-2 js-form-message wage_type_block" style="display:none">
                          <select class="wage_type no_select2">
                              <option value="">Select Option</option>
                              @foreach(wagesTypes() as $wagetype)
                              <option value="{{ $wagetype }}">{{ucfirst($wagetype)}}</option>
                              @endforeach
                          </select>
                      </div> -->
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


          
          <div class="js-form-message form-group row score_points" style="display:none">
              <div class="col-md-12">
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th colspan="3">Score Points</th>
                          </tr>
                          <tr>
                              <th>Language</th>
                              <th>One Match</th>
                              <th>Two Match</th>
                              <th>Three Match</th>
                          </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>
                  </table>
              </div>
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
        <div class="form-group fun-facts-block">
            <div class="ff-add-field">

                <div class="form-group">
                    <!-- Container For Input Field -->
                    <div class="row">
                        <div class="col-md-3 pt-4">
                            <label>Enter Fun Facts</label>
                        </div>
                        <div class="col-md-9">
                            <div id="addFunFactsContainer">
                               
                            </div>
                            <a id="add-fun-facts" href="javascript:;"
                                class="form-link btn btn-sm btn-no-focus btn-ghost-primary">
                                <i class="tio-add"></i> Add More
                            </a>
                        </div>
                    </div>



                    <!-- Add Phone Input Field -->
                    <div id="addFunFactsTemplate" class="item-row" style="display: none;">
                        <!-- Content -->
                        <div class="item-row">
                            <div class="row">
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control mb-3 fun_facts" placeholder="Enter Fun Facts" aria-label="Fun Facts">
                                </div>
                                <div class="col-md-2">
                                    <a class="input-group-add-field-delete" href="javascript:;" onclick="deleteFunFacts(this)" data-toggle="tooltip" data-placement="top" title="Remove item">
                                        <i class="tio-clear"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Add Phone Input Field -->
                    </div>
                </div>
            </div>
            <!-- End Input Group -->
            </form>
        </div>
        <div class="form-group text-center">
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
    // $("#wage_type").change(function() {
    //     if ($(this).val() == '1') {
    //         $(".wage_type_block").show();
    //         $(".wage_type_block").find(".wage_type").removeAttr("disabled");
    //         $("#addOptionsContainer > .item-row:last").find(".wage_type_block").find('.wage_type').removeClass("no_select2");
    //         initSelect("#addOptionsContainer");
    //     } else {
    //         $(".wage_type_block").hide();
    //         $(".wage_type_block").find(".wage_type").attr("disabled","disabled");
    //     }
    // });
  $('.js-add-field.option-blocks').each(function () {
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
        // $("#addOptionsContainer > .item-row:last").find(".wage_type").attr("name","options["+index+"][wage_type]");
        
        $("#addOptionsContainer > .item-row:last").find(".image").attr("name","options["+index+"][image]");

        $("#addOptionsContainer > .item-row:last").find(".language_proficiency_id").attr("name", "options[" + index + "][language_proficiency_id]");

        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("name","options["+index+"][non_eligible]");
        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("id","row-"+index);
        $("#addOptionsContainer > .item-row:last").find(".non-eligible-label").attr("for","row-"+index);
        
        $("#addOptionsContainer > .item-row:last").find(".non-eligible-reason").attr("name","options["+index+"][non_eligible_reason]");
        $("#addOptionsContainer > .item-row:last").find(".non-eligible").attr("id","row-"+index);
                $("#addOptionsContainer > .item-row:last").find(".non-eligible-label").attr("for","row-"+index);
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
        // if($("#wage_type:checked").val() == '1'){
            // $("#addOptionsContainer > .item-row:last").find(".wage_type").attr("required","true");
            // $("#addOptionsContainer > .item-row:last").find(".wage_type_block").show();
            // $("#addOptionsContainer > .item-row:last").find(".wage_type_block").find('.wage_type').removeAttr('disabled');
            // $("#addOptionsContainer > .item-row:last").find(".wage_type_block").find('.wage_type').removeClass("no_select2");
        // }else{
            // $("#addOptionsContainer > .item-row:last").find(".wage_type_block").hide();
            // $("#addOptionsContainer > .item-row:last").find(".wage_type_block").find('.wage_type').attr('disabled','disabled');
            // $("#addOptionsContainer > .item-row:last").find(".wage_type_block").find('.wage_type').addClass("no_select2");
            

            // initSelect("#addOptionsContainer");
        // }
        $('[data-toggle="tooltip"]').tooltip();
        
      },
      deletedField: function() {
        $('.tooltip').hide();
      }
    }).init();
  });
  // $('.fun-facts-block .ff-add-field').each(function() {
  //     var addField = new HSAddField($(this), {
  //         addedField: function() {
  //             var index = randomNumber();
  //             $("#addFunFactsContainer > .item-row:last").find(".fun_facts").attr("name",
  //                 "fun_facts[" + index + "][fun_facts]");
  //             // $("#addFunFactsContainer > .item-row:last").find(".fun_fact_id").attr(
  //             //     "name", "fun_facts[" + index + "][id]");

  //         },
  //         deletedField: function() {
  //             $('.tooltip').hide();
  //         }
  //     }).init();
  // });
  $("#add-fun-facts").click(function(){
      var html = $("#addFunFactsTemplate").html();
      $("#addFunFactsContainer").append(html);
      var index = randomNumber();
      $("#addFunFactsContainer > .item-row:last").find(".fun_facts").attr("name","fun_facts[" + index + "][fun_facts]");
  })
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
function deleteFunFacts(e){
    $(e).parents(".item-row").remove();
}
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
    var value = $("#lang_prof").val();
    if(value != ''){
        if($(".option-heading[data-langprof="+value+"]").html() != undefined){
            errorMessage("Language Proficiency already added");
            return false;
        }
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
                    // $("#addOptionsContainer .item-row").remove();
                    var proficiencies = response.proficiencies;
                    var language_proficiency = response.language_proficiency;
                    var index = 0;
                    $.each(proficiencies, function(key, item) {
                        $("#add-item").trigger("click");
                        if(key == 0){
                            var lngprof = language_proficiency.name+" <a href='javascript:;' onclick='removeLangProf("+language_proficiency.unique_id+")' class='text-danger'>Remove</a>";
                            $("#addOptionsContainer .item-row:last-child").find(".option-heading").html(lngprof);
                            $("#addOptionsContainer .item-row:last-child").find(".option-heading").attr("data-langprof",language_proficiency.unique_id);
                        }
                        
                        $("#addOptionsContainer .item-row:last-child").attr("class","item-row "+language_proficiency.unique_id);
                        $("#addOptionsContainer .item-row:last-child").find(".option_value").val(item.clb_level);
                        $("#addOptionsContainer .item-row:last-child").find(".option_label").val(item.clb_level);
                        $("#addOptionsContainer .item-row:last-child").find(".language_proficiency_id").val(item.language_proficiency_id);
                    });
                    $("#lang_prof").val('');
                    $("#lang_prof").trigger("change");

                    var match_points = '<tr class="'+language_proficiency.unique_id+'">';
                    match_points += '<td>';
                    match_points += language_proficiency.name;
                    match_points += '</td>';
                    match_points += '<td>';
                    match_points += '<input type="text" class="form-control" name="match_score['+language_proficiency.unique_id+'][one_match]" placeholder="Enter One Match Point" value="" />';
                    match_points += '</td>';
                    match_points += '<td>';
                    match_points += '<input type="text" class="form-control" name="match_score['+language_proficiency.unique_id+'][two_match]" placeholder="Enter Two Match Point" value="" />';
                    match_points += '</td>';
                    match_points += '<td>';
                    match_points += '<input type="text" class="form-control" name="match_score['+language_proficiency.unique_id+'][three_match]" placeholder="Enter Three Match Point" value="" />';
                    match_points += '</td>';
                    
                    match_points += '</tr>';

                    $(".score_points tbody").append(match_points);
                }
            },
            error: function() {
                internalError();
            }
        });
    }else{
        errorMessage("Please select language proficiency");
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
    $("#addOptionsContainer .item-row").remove();
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
function scoreCount(value){
    if(value == 'range_matching'){
        $(".score_points").show();
    }else{
        $(".score_points").hide();
    }
}
function removeLangProf(lang_prof_id){
  $("."+lang_prof_id).remove();
}
</script>

  @endsection