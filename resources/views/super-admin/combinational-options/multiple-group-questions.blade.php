@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
  
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id)) }}">Eligibility Question</a></li>

  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
        <a class="btn btn-primary" href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id)) }}">
          Back
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="combinational_options">
  
  <!-- Card -->
  <div class="card">
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                  <label>Multi Options Questions</label>
                  <select class="group_question_id" name="group_question_id"> 
                      <option value="">Select Question</option>
                      @foreach($group_questions as $question)
                        <option data-cvtype="{{ $question->cv_section }}" value="{{ $question->unique_id }}">{{$question->question}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group got" style="display:none">
                  <label>Option Type</label>
                  <select class="group_opt_type" name="group_opt_type"> 
                      <option disabled value="">Select Options</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Options</label>
                  <select class="group_options" multiple name="group_options[]"> 
                      <option disabled value="">Select Options</option>
                  </select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                  <label>Select Question</label>
                  <select class="selected_question" name="question"> 
                      <option  value="">Select Question</option>
                      @foreach($questions as $question)
                        <option value="{{ $question->unique_id }}">{{$question->question}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group qot" style="display:none">
                  <label>Option Type</label>
                  <select class="question_opt_type" name="question_opt_type"> 
                      <option disabled value="">Select Options</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Options</label>
                  <select class="question_options" multiple name="question_options[]"> 
                      <option disabled value="">Select Options</option>
                  </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group pt-4">
                  <button onclick="fetchCombination()" type="button" class="btn btn-primary"><i class="tio-refresh"></i></button>
              </div>
            </div>
        </div>

        <div class="mt-3" id="combination_questions">

        </div>

        <div class="mt-3">
          <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Group Option</th>
                    <th>Question Option</th>
                    <th>Behaviour</th>
                    <th>Score</th>
                    <th>Level</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($question_combinations as $record)
                    <tr>
                      <td>
                        <div><b>Question: </b> {{$record->GroupQuestion->question}}</div>
                        <div><b>Option One: </b>{{$record->CombinationalOption->OptionOne->option_label}}</div>
                        <div><b>Option Two: </b>{{$record->CombinationalOption->OptionTwo->option_label}}</div>
                      </td>
                      <td>
                        <div><b>Question: </b>{{$record->Question->question}}</div>
                        <div><b>Option:</b>{{$record->QuestionOption->option_label}}</div>
                      </td>
                      <td>
                        {{$record->behaviour}}
                      </td>
                      <td>
                        {{$record->score}}
                      </td>
                      <td>
                        {{$record->level}}
                      </td>
                      <td>
                        <a class="btn btn-sm btn-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/multi-option-groups/'.base64_encode($record->id))}}/delete"><i class="tio-delete"></i></a> 
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    $(".group_question_id").change(function(){
        var question_id = $(this).val();
        if($(this).val() != ''){
            $.ajax({
              type: "GET",
              url: BASEURL + '/visa-services/eligibility-questions/{{base64_encode($visa_service->id)}}/fetch-question',
              data:{
                  _token:csrf_token,
                  question_id:$(this).val(),
              },
              dataType:'json',
              beforeSend:function(){
                  showLoader();
              },
              success: function (response) {
                  hideLoader();
                  $(".group_options").html('');
                  if(response.status == true){
                        $(".group_opt_type").html(response.options);
                        $(".got").show();
                  }else{
                      $(".group_opt_type").html('');
                      $(".got").hide();
                      fetchOptions(question_id,"group_options");
                  }
              },
              error:function(){
                internalError();
              }
          });
        }
    });

    $(".selected_question").change(function(){
        var question_id = $(this).val();
        if($(this).val() != ''){
            $.ajax({
              type: "GET",
              url: BASEURL + '/visa-services/eligibility-questions/{{base64_encode($visa_service->id)}}/fetch-question',
              data:{
                  _token:csrf_token,
                  question_id:$(this).val(),
              },
              dataType:'json',
              beforeSend:function(){
                  showLoader();
              },
              success: function (response) {
                  hideLoader();
                  $(".question_options").html('');
                  if(response.status == true){
                        $(".question_opt_type").html(response.options);
                        $(".qot").show();
                  }else{
                      $(".question_opt_type").html('');
                      $(".qot").hide();
                      fetchOptions(question_id,"question_options");
                  }
                  // if(response.status == true){
                  //   $(".question_options").html(response.options);
                  // }else{
                  //   $(".question_options").html('');
                  // }
              },
              error:function(){
                internalError();
              }
          });
        }
    });
    $(".group_opt_type").change(function(){
        if($(this).val() != ''){
          var question_id = $(".group_question_id").val();
          var language_proficiency_id = $(this).val();
          fetchOptions(question_id,"group_options",language_proficiency_id);
        }
    });

    $(".question_opt_type").change(function(){
        if($(this).val() != ''){
          var question_id = $(".selected_question").val();
          var language_proficiency_id = $(this).val();
          fetchOptions(question_id,"question_options",language_proficiency_id);
        }
    });
})
function fetchCombination(){
  var selected_question = $(".selected_question").val();
  var group_question_id = $(".group_question_id").val();
  var group_options = $(".group_options").val();
  var question_options = $(".question_options").val();
  if(selected_question != '' && group_question_id != '' && group_options != '' && question_options != ''){
    $.ajax({
        type: "POST",
        url: BASEURL + '/visa-services/eligibility-questions/{{base64_encode($visa_service->id)}}/fetch-group-options',
        data:{
            _token:csrf_token,
            component_id:"{{$component_id}}",
            selected_question:selected_question,
            group_question_id:group_question_id,
            group_options:group_options,
            question_options:question_options,
        },
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (response) {
            hideLoader();
            if(response.status == true){
              $("#combination_questions").html(response.contents);
              initSelect();
            }else{
              $("#combination_questions").html('');
            }
        },
        error:function(){
          internalError();
        }
    });
  }
}
function fetchOptions(question_id,ele,language_proficiency_id = ''){
  $.ajax({
      type: "GET",
      url: BASEURL + '/visa-services/eligibility-questions/{{base64_encode($visa_service->id)}}/fetch-options',
      data:{
          _token:csrf_token,
          question_id:question_id,
          language_proficiency_id:language_proficiency_id
      },
      dataType:'json',
      beforeSend:function(){
          showLoader();
      },
      success: function (response) {
          hideLoader();
          if(response.status == true){
            $("."+ele).html(response.options);
          }else{
            $("."+ele).html('');
          }
      },
      error:function(){
        internalError();
      }
  });
}
</script>
@endsection