@extends('layouts.master')

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
<div class="content container-fluid">
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
        <a class="btn btn-primary" href="{{baseUrl('visa-services/component-questions/'.base64_encode($visa_service->id))}}">
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
            <select id="question_selected" multiple required>
              @foreach($questions as $question)
              <option value="{{$question->unique_id}}">{{$question->question}}</option>
              @endforeach
            </select>
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

</script>

  @endsection