@extends('layouts.master')

@section('content')
<style>
.sortable {
    list-style: none;
    margin: 0px;
    padding: 0px;
}

.sortable li {
    margin: 12px;
    border-radius: 7px;
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

                <a class="btn btn-primary btn-sm"
                    href="{{ baseUrl('/eligibility-check') }}">
                    Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- Card -->
    <div class="card">
        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <form id="form" action="{{ baseUrl('/eligibility-check/check/'.$visa_service_id) }}">
            <input type="hidden" name="eligible_type" value="normal" />
                @csrf
                <ul class="sortable mt-2 mb-2">
                    @foreach($question_sequence as $record)
                    <li class="ui-state-default" data-question="{{$record->Question->unique_id}}">

                        <div class="font-weight-bold"><i class="tio-arrow-large-forward"></i>
                            {{$record->Question->question}}</div>
                        @if($record->Question->additional_notes != '')
                        <div class="mt-2"><?php echo $record->Question->additional_notes ?></div>
                        @endif
                        <div class="question-options mt-2">
                            @if($record->Question->option_type == 'dropdown')
                            @if(!empty($record->Question->ComponentQuestions) ||
                            !empty($record->Question->ConditionalQuestions))
                            <select class="select2"
                                onchange="conditionalQuestion('{{ $record->Question->unique_id }}',this,'select')"
                                name="question[{{$record->Question->unique_id}}]">
                                @else
                                <select class="select2" name="question[{{$record->Question->unique_id}}]">
                                    @endif
                                    <option value="">Select Option</option>
                                    @foreach($record->Question->Options as $option)
                                    <option data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                                        {{$option->option_label}} ({{$option->score}})</option>
                                    @endforeach
                                </select>
                                @endif
                                @if($record->Question->option_type == 'radio')
                                <!-- Form Check -->
                                @foreach($record->Question->Options as $option)
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio">
                                        @if(!empty($record->Question->ComponentQuestions) ||
                                        !empty($record->Question->ConditionalQuestions))
                                        <input type="radio" data-option-id="{{$option->id}}"
                                            id="customInlineRadio-{{$option->id}}"
                                            onchange="conditionalQuestion('{{ $record->Question->unique_id }}',this,'radio')"
                                            value="{{ $option->option_value }}" class="custom-control-input"
                                            name="question[{{$record->Question->unique_id}}]">
                                        @else
                                        <input type="radio" data-option-id="{{$option->id}}"
                                            id="customInlineRadio-{{$option->id}}" value="{{ $option->option_value }}"
                                            class="custom-control-input"
                                            name="question[{{$record->Question->unique_id}}]">
                                        @endif
                                        <label class="custom-control-label"
                                            for="customInlineRadio-{{$option->id}}">{{$option->option_label}} ({{$option->score}})</label>
                                    </div>
                                </div>
                                <!-- End Form Check -->
                                @endforeach

                                @endif
                                <!-- End Form Check -->
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="response p-2 text-danger"></div>
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- End Table -->

    </div>
    <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script>
$(document).ready(function(){
  $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        dataType:"json",
        beforeSend:function(){
          showLoader();
          $(".response").html('');
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            redirect(response.redirect_back);
          }else{
            $(".response").html(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
    });
});
function conditionalQuestion(question_id, e, ele) {
    var option_value = '';
    var value = $(e).val();
    if (ele == 'select') {
        option_value = $(e).find("option[value='" + value + "']").attr("data-option-id");
    }
    if (ele == 'radio') {
        option_value = $(e).attr("data-option-id");
    }
    $.ajax({
        type: "POST",
        url: BASEURL + '/eligibility-check/fetch-conditional',
        data: {
            _token: csrf_token,
            condition_type:"normal",
            question_id: question_id,
            option_value: option_value
        },
        dataType: 'json',
        beforeSend: function() {
            // showLoader();
            $(".conditional-" + question_id).remove();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $("li[data-question=" + question_id + "]").append(response.contents);
                initSelect();
            }
        },
        error: function() {
            internalError();
        }
    });
}
</script>
@endsection