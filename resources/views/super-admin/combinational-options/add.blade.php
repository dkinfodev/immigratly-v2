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
    <!-- Header -->
    <div class="card-header">
      <h2>{{$question->question}}</h2>
    </div>
    <!-- End Header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                  <label>Select Options</label>
                  <select class="option_one" multiple name="option_one[]"> 
                      <option value="">Select Option One</option>
                      @foreach($question->Options as $option)
                        <option value="{{ $option->id }}">{{$option->option_label}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <!-- <div class="col-md-5">
              <div class="form-group">
                  <label>Option Two</label>
                  <select class="option_two" name="option_two[]"> 
                      <option value="">Select Option Two</option>
                  </select>
              </div>
            </div> -->
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
                    <th>Option One</th>
                    <th>Option Two</th>
                    <th>Score</th>
                    <th>Level</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($records as $record)
                    <tr>
                      <td>
                        @if(!empty($record->OptionOne))
                        {{$record->OptionOne->option_label}}
                        @else
                        {{$record->option_one_id}}
                        @endif
                      </td>
                      <td>
                        @if(!empty($record->OptionTwo))
                          {{$record->OptionTwo->option_label}}
                        @else
                        {{$record->option_two_id}}
                        @endif
                      </td>
                      <td>
                        {{$record->score}}
                      </td>
                      <td>
                        {{$record->level}}
                      </td>
                      <td>
                        <a class="btn btn-sm btn-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/combination-questions/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
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
  var option_one = $(".option_one").val();
  var question_two = $(".question_two").val();
  if(option_one != ''){
    $.ajax({
        type: "POST",
        url: BASEURL + '/visa-services/eligibility-questions/{{base64_encode($visa_service->id)}}/combinational-options/{{ base64_encode($question->id) }}/fetch-options',
        data:{
            _token:csrf_token,
            option_one:option_one,
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