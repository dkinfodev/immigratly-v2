@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id) }}">Eligibility Question</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection


@section('header-right')
        <a class="btn btn-primary" href="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id) }}">
          Back
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="combination_questions">
  
  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      <h2>Combination Questions</h2>
    </div>
    <!-- End Header -->
    <div class="card-body">
        <!-- <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                  <label>Component</label>
                  <select class="component_id" name="component_id"> 
                      <option value="">Select Component</option>
                      @foreach($components as $component)
                      <option value="{{$component->unique_id}}">{{$component->component_title}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                  <label>Question One</label>
                  <select class="question_one" onchange="fetchOptions(this.value,'question_one_options')" name="question_one"> 
                      <option value="">Select Question One</option>
                      @foreach($questions as $question)
                        <option value="{{$question->EligibilityQuestion->unique_id}}">{{$question->EligibilityQuestion->question}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label>Options</label>
                  <select class="question_one_options" name="question_one_options[]" multiple></select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                  <label>Question Two</label>
                  <select class="question_two" onchange="fetchOptions(this.value,'question_two_options')" name="question_two"> 
                      <option value="">Select Question Two</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Options</label>
                  <select class="question_two_options" name="question_two_options[]" multiple></select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group pt-3">
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
                    <th>Question One</th>
                    <th>Question Two</th>
                    <th>Behaviour</th>
                    <th>Score</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($records as $record)
                    <tr>
                      <td>
                        <div><strong>Question: </strong>{{$record->QuestionInfo($record->question_id_one)->question}}</div>
                        <div><strong>Option: </strong>{{$record->OptionInfo($record->option_id_one)->option_label}}</div>
                      </td>
                      <td>
                        <div><strong>Question: </strong>{{$record->QuestionInfo($record->question_id_two)->question}}</div>
                        <div><strong>Option: </strong>{{$record->OptionInfo($record->option_id_two)->option_label}}</div>
                      </td>
                      <td>
                        {{$record->behaviour}}
                      </td>
                      <td>
                        {{$record->score}}
                      </td>
                      <td>
                        <a class="btn btn-sm btn-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/combination-questions/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
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
    $(".question_one").change(function(){
      $(".question_two").html('');
      if($(this).val() != ''){
          $.ajax({
            type: "POST",
            url: BASEURL + '/visa-services/eligibility-questions/{{$visa_service_id}}/fetch-questions',
            data:{
                _token:csrf_token,
                component_id:"{{ $component_id }}",
                question_id:$(this).val()
            },
            dataType:'json',
            beforeSend:function(){
                showLoader();
            },
            success: function (response) {
                hideLoader();
                if(response.status == true){
                  $(".question_two").html(response.options);
                }
            },
            error:function(){
              internalError();
            }
        });
      }
    })


    $(".component_id").change(function(){
      $(".question_one").html('');
      if($(this).val() != ''){
          $.ajax({
            type: "POST",
            url: BASEURL + '/visa-services/eligibility-questions/{{$visa_service_id}}/fetch-component-questions',
            data:{
                _token:csrf_token,
                component_id:$(this).val()
            },
            dataType:'json',
            beforeSend:function(){
                showLoader();
            },
            success: function (response) {
                hideLoader();
                if(response.status == true){
                  $(".question_one").html(response.options);
                }
            },
            error:function(){
              internalError();
            }
        });
      }
    })
})
function fetchCombination(){
  var question_one = $(".question_one").val();
  var question_two = $(".question_two").val();
  var question_one_options = $(".question_one_options").val();
  var question_two_options = $(".question_two_options").val();
  if(question_one != '' && question_two != ''){
    $.ajax({
        type: "POST",
        url: BASEURL + '/visa-services/eligibility-questions/{{$visa_service_id}}/combination-questions/fetch-combinations',
        data:{
            _token:csrf_token,
            component_id:"{{$component_id}}",
            question_one:question_one,
            question_one_options:question_one_options,
            question_two:question_two,
            question_two_options:question_two_options,
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
function fetchOptions(question_id,ele){
  $.ajax({
      type: "GET",
      url: BASEURL + '/visa-services/eligibility-questions/{{$visa_service_id}}/fetch-options',
      data:{
          _token:csrf_token,
          question_id:question_id,
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