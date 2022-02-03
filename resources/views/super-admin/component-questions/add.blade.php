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
        <a class="btn btn-primary" href="{{baseUrl('visa-services/component-questions/'.base64_encode($visa_service->id))}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection


@section('content')
<style>
#sortable {
    list-style: none;
    margin: 0px;
    padding: 0px;
}
#sortable li {
    margin: 12px;
    padding: 10px;
    border-radius: 7px;
}
#sortable li:hover {
    cursor: all-scroll;
}
</style>
<!-- Content -->
<div class="component_questions">
 
  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/visa-services/component-questions/'.base64_encode($visa_service->id).'/save') }}" method="post">

        @csrf
        <!-- Input Group -->
       
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Component Title</label>
          <div class="col-sm-9">
            <input type="text" name="component_title" id="component_title" placeholder="Enter Component Title" class="form-control" value="">
          </div>
          <div class="col-sm-1 p-2">
            <div class="custom-control custom-checkbox" data-toggle="tooltip" data-placement="left"  data-html="true" title="Show in Question">
              <input type="checkbox" class="custom-control-input row-checkbox" id="show_in_question" name="show_in_question" value="1">
              <label class="custom-control-label" for="show_in_question"></label>
            </div>
          </div>
        </div>
        <div class="form-group js-form-message row">
          <label class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea name="description" data-msg="Please enter description." id="description" class="form-control editor"></textarea>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Questions</label>
          <div class="col-sm-10">
          <div class="datatable-custom">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th class="text-center">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" id="checkAll" class="custom-control-input">
                          <label class="custom-control-label" for="checkAll">&nbsp;</label>
                        </div>
                      </th>
                      <th>Question</th>
                      <th>Dependent</th>
                      <th width="20%">Component</th>
                      <th width="20%">Question</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($questions as $key => $question)
                    <tr>
                        <td class="text-center">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customCheck-{{$key}}" name="ques[{{$question->unique_id}}][questions]" class="custom-control-input quescheck" value="{{$question->unique_id}}">
                            <label class="custom-control-label" for="customCheck-{{$key}}">&nbsp;</label>
                          </div>
                        </td>
                        <td class="questext">{{$question->question}}</td>
                        <td class="text-center">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="ques[{{$question->unique_id}}][is_dependent]" id="dependent-{{$key}}" class="custom-control-input dependent-checkbox" value="1" >
                            <label class="custom-control-label" for="dependent-{{$key}}">&nbsp;</label>
                          </div>
                        </td>
                        <td>
                          <select onchange="fetchComponentQues(this)" disabled class="dependent_component" disabled name="ques[{{$question->unique_id}}][dependent_component]">
                            <option value="">Select Component</option>
                            @foreach($components as $component)
                            <option value="{{$component->unique_id}}">{{$component->component_title}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <select class="dependent_question" disabled name="ques[{{$question->unique_id}}][dependent_question]">
                            <option value="">Select Quesstion</option>
                           
                          </select>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- <select id="question_selected" multiple required>
              @foreach($questions as $question)
              <option value="{{$question->unique_id}}">{{$question->question}}</option>
              @endforeach
            </select> -->
          </div>
        </div>
        <div class="js-form-message form-group row">
          <div class="col-md-12">
              <ul id="sortable" class="question-sort">
                
              </ul>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Minimum Score</label>
          <div class="col-sm-10">
            <input type="number" name="min_score" id="min_score" placeholder="Enter Minimum Score" class="form-control" value="">
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Maximum Score</label>
          <div class="col-sm-10">
            <input type="number" name="max_score" id="max_score" placeholder="Enter Maximum Score" class="form-control" value="">
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Group Linked To</label>
          <div class="col-sm-10">
            <select name="group" id="groups">
                <option value="">Select Group</option>
              @foreach($groups as $group)
                <option value="{{ $group->unique_id }}">{{$group->group_title}}</option>
              @endforeach
            </select>
            <div class="mt-3">
              <div class="custom-control custom-checkbox">
                  <input onchange="linkToDefault(this)" type="checkbox" name="default_group" id="default_group" class="custom-control-input row-checkbox non-eligible" value="1" >
                  <label class="custom-control-label non-eligible-label" for="default_group">Link to Default Group Only</label>
              </div>
            </div>
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
<script src="{{ asset('assets/vendor/sortablejs/js/jquery-ui.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/sortablejs/css/jquery-ui.css') }}">
<script type="text/javascript">
$(document).ready(function(){
  $( function() {
    $('#sortable').sortable();
  });
  $("#checkAll").change(function(){
    if($(this).is(":checked")){
      $(".quescheck").prop("checked",true);
    }else{
      $(".quescheck").prop("checked",false);
    }
  });
  $(".dependent-checkbox").change(function(){
    if($(this).is(":checked")){
      $(this).parents("tr").find(".dependent_component").removeAttr("disabled");
      $(this).parents("tr").find(".dependent_question").removeAttr("disabled");
    }else{
      $(this).parents("tr").find(".dependent_component,.dependent_question").val('').trigger("change");
      $(this).parents("tr").find(".dependent_component").attr("disabled","disabled");
      $(this).parents("tr").find(".dependent_question").attr("disabled","disabled");
    }
  });
  $(".quescheck").change(function(){
      var ques_id = $(this).val();
      if($(this).is(":checked")){
         
          var exists = 0;
          // $(".question-sort li").each(function(){
          //   if($(this).data("ques-id") == ques_id){
          //     exists = 1;
          //   }
          // });
          if(exists == 0){
              var text = $(this).parents("tr").find(".questext").text();
              var html ='<li data-ques-id="'+ques_id+'" class="ui-state-default">';
              html +='<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
              html +='<input type="hidden" name="questions[]" value="'+ques_id+'" />';
              html += text;
              html +='</li>';
              $("#sortable").append(html);
          }
        
      }else{
        $("li[data-ques-id='"+ques_id+"']").remove();
      }
  });
  $("#question_selected").change(function(){
      var ques_id = $(this).val();
      var ques_len = ques_id.length;
      
      // alert(ques_len);
      
      for(var i=0;i < ques_len;i++){
          var exists = 0;
          $(".question-sort li").each(function(){
            if($(this).data("ques-id") == ques_id[i]){
              exists = 1;
            }
          });
          if(exists == 0){
              var text = $("option[value="+ques_id[i]+"]").text();
              var html ='<li data-ques-id="'+ques_id[i]+'" class="ui-state-default">';
              html +='<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
              html +='<input type="hidden" name="questions[]" value="'+ques_id[i]+'" />';
              html += text;
              html +='</li>';
              $("#sortable").append(html);
          }
        }

        $(".question-sort li").each(function(){
          var exists = 0;
          for(var i=0;i < ques_len;i++){
            if($(this).data("ques-id") == ques_id[i]){
              exists = 1;
            }
          }
          if(exists == 0){
            $(this).remove();
          }
        });
  });
  initEditor("description"); 
  $("#form").submit(function(e){
        e.preventDefault(); 
        
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
function linkToDefault(e){
  if($(e).is(":checked")){
    $("#groups").attr("disabled","disabled");
  }else{
    $("#groups").removeAttr("disabled");
  }
}
function fetchComponentQues(e){
  if($(e).val() != ''){
    var component_id = $(e).val();
    $.ajax({
          url:"{{ baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/fetch-component-questions') }}",
          type:"post",
          data:{
            _token:csrf_token,
            component_id:component_id
          },
          dataType:"json",
          beforeSend:function(){
            showLoader();
          },
          success:function(response){
            hideLoader();
            if(response.status == true){
              $(e).parents("tr").find(".dependent_question").html(response.options);
            }else{
              $(e).parents("tr").find(".dependent_question").html('');
            }
        },
        error:function(){
          internalError();
        }
      });
  }
  
}
</script>

@endsection