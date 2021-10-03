@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-100 mx-lg-auto">
        <!-- Input -->
        <h1 class="text-lh-sm text-white">Check Eligibility</h1>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<div class="container space-bottom-2">
  <div class="w-lg-100 mx-lg-auto">
    <!-- Breadcrumbs -->
        <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Visa Services</a></li>
        <li class="breadcrumb-item active" aria-current="page">Check Eligibility</li>
      </ol>
    </nav>
    <!-- End Breadcrumbs -->

 
    <!-- End Breadcrumbs -->

    <!-- Article -->
    <div class="card card-bordered custom-content-card">

        <form id="form" action="{{ url('/check-eligibility/check/'.$visa_service_id) }}">
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
    <!-- End Article -->
  </div>
  
  
</div>
@endsection



@section('javascript')
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>

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