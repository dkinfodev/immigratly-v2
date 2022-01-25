@extends('layouts.master-old')

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
<div class="combinational_options">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id)) }}">Eligibility Question</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id)) }}">
          Back
        </a>
      
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

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
                        <option value="{{ $question->unique_id }}">{{$question->question}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                  <label>Select Question</label>
                  <select class="selected_question" name="question"> 
                      <option value="">Select Question</option>
                      @foreach($questions as $question)
                        <option value="{{ $question->unique_id }}">{{$question->question}}</option>
                      @endforeach
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
                    <th>Score</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($question_combinations as $record)
                    <tr>
                      <td>
                        <b>Option One: </b>{{$record->CombinationalOption->OptionOne->option_label}}<br>
                        <b>Option Two: </b>{{$record->CombinationalOption->OptionTwo->option_label}}
                      </td>
                      <td>
                        <div><b>{{$record->Question->question}}</b></div>
                        {{$record->QuestionOption->option_label}}
                      </td>
                      <td>
                        {{$record->score}}
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
    
})
function fetchCombination(){
  var selected_question = $(".selected_question").val();
  var group_question_id = $(".group_question_id").val();
  if(selected_question != ''){
    $.ajax({
        type: "POST",
        url: BASEURL + '/visa-services/eligibility-questions/{{base64_encode($visa_service->id)}}/fetch-group-options',
        data:{
            _token:csrf_token,
            selected_question:selected_question,
            group_question_id:group_question_id,
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
</script>
@endsection