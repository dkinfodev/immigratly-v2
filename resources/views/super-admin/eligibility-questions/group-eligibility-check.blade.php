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
            <form id="form" action="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id.'/group-pattern/add') }}">

                @csrf
                <input type="hidden" name="eligible_type" value="group" />
                <div class="p-3">
                    <div class="js-form-message form-group row">
                        <label class="col-sm-2 col-form-label">Visa Service</label>
                        <div class="col-sm-6">
                            <select id='sub_visa_service' name="sub_visa_service">
                                <option value="">Select Visa Service</option>
                                @foreach($sub_visa_services as $visa_service)
                                <option value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                 <ul class="sortable-ul mt-2 mb-2">
                    @foreach($question_sequence as $record)
                    <li class="ui-state-default" data-question="{{$record->Group->unique_id}}">

                        <div class="font-weight-bold text-danger p-2"><i class="tio-arrow-large-forward"></i>
                            {{$record->Group->group_title}}</div>
                            @if($record->Group->description != '')
                            <p>
                            {{$record->Group->description}}
                            </p>
                            @endif
                            @foreach($record->Components as $component)
                                <?php
                                $grp_comp = checkIfGroupConditional($record->Group->unique_id,$component->Component->unique_id);
                                ?>
                                @if(empty($grp_comp))
                                <div class="component-blocks mt-3 bg-light p-3">
                                    <div class="font-weight-bold text-warning">
                                        <i class="tio-chevron-right"></i> {{$component->Component->component_title}}
                                    </div>
                                    <ul class="sortable-ul mt-2 mb-2">
                                        @foreach($component->Component->Questions as $ques)
                                        <?php
                                            $option_selected = array();
                                            $check_ques = checkGroupConditionalQues($record->Group->unique_id,$component->Component->unique_id,$ques->EligibilityQuestion->unique_id);
                                           
                                        ?>
                                        <li class="ui-state-default quesli qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }}" data-group="{{ $record->Group->unique_id }}" data-component="{{$component->Component->unique_id}}" data-question="{{$ques->EligibilityQuestion->unique_id}}">

                                            <div class="font-weight-bold"><i class="tio-arrow-right-circle"></i>
                                                {{$ques->EligibilityQuestion->question}}</div>
                                            @if($ques->EligibilityQuestion->additional_notes != '')
                                            <div class="mt-2"><?php echo $ques->EligibilityQuestion->additional_notes ?></div>
                                            @endif
                                            
                                            <div class="question-options mt-2">
                                                @if($ques->EligibilityQuestion->option_type == 'dropdown')
                            
                                                @if(!empty($check_ques))
                                                    <select  class="select2" onchange="conditionalQuestion(this,'select')" name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                                @else
                                                    <select class="select2" name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                                @endif
                                                        <option value="">Select Option</option>
                                                        @foreach($ques->EligibilityQuestion->Options as $option)
                                                        <option data-option-id="{{$option->id}}" value="{{ $option->option_value }}">
                                                            {{$option->option_label}} ({{$option->score}})</option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                    @if($ques->EligibilityQuestion->option_type == 'radio')
                                                    <!-- Form Check -->
                                                    @foreach($ques->EligibilityQuestion->Options as $option)
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            
                                                        @if(!empty($check_ques))
                                                        <input type="radio" data-option-id="{{$option->id}}"
                                                            id="customInlineRadio-{{$component->component_id}}-{{$option->id}}"
                                                            onchange="conditionalQuestion(this,'radio')"
                                                            value="{{ $option->option_value }}" class="custom-control-input"
                                                            name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                                        @else
                                                        <input type="radio" data-option-id="{{$option->id}}"
                                                            id="customInlineRadio-{{$component->component_id}}-{{$option->id}}" value="{{ $option->option_value }}"
                                                            class="custom-control-input"
                                                            name="question[{{ $record->Group->unique_id }}][{{ $component->Component->unique_id }}][{{$ques->EligibilityQuestion->unique_id}}]">
                                                        @endif
                                                            
                                                            <label class="custom-control-label"
                                                                for="customInlineRadio-{{$component->component_id}}-{{$option->id}}">{{$option->option_label}} ({{$option->score}})</label>
                                                        </div>
                                                    </div>
                                                    <!-- End Form Check -->
                                                    @endforeach

                                                    @endif
                                                    <!-- End Form Check -->
                                            </div>
                                        </li>
                                        @if($ques->EligibilityQuestion->linked_to_cv == 'yes' && !empty($check_ques))
                                            <script>
                                                setTimeout(function(){

                                                    @if($ques->EligibilityQuestion->option_type == 'radio')
                                                    var e = $(".qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} input[type=radio]:checked");
                                                    conditionalQuestion(e,'radio');
                                                    @endif

                                                    @if($ques->EligibilityQuestion->option_type == 'select')
                                                    var e = $(".qs-{{ $record->Group->unique_id }}-{{ $component->Component->unique_id }}-{{ $ques->EligibilityQuestion->unique_id }} select");
                                                    conditionalQuestion(e,'select');
                                                    @endif
                                                },1000);
                                            </script>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            @endforeach
                        
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
function conditionalQuestion(e, ele) {
    var option_value = '';
    var group_id = $(e).parents(".quesli").attr("data-group");
    var question_id = $(e).parents(".quesli").attr("data-question");
    var component_id = $(e).parents(".quesli").attr("data-component");
    var value = $(e).val();
    if (ele == 'select') {
        option_value = $(e).find("option[value='" + value + "']").attr("data-option-id");
    }
    if (ele == 'radio') {
        option_value = $(e).attr("data-option-id");
    }
    $.ajax({
        type: "POST",
        url: BASEURL + '/visa-services/eligibility-questions/{{$visa_service_id}}/fetch-group-conditional',
        data: {
            _token: csrf_token,
            question_id: question_id,
            group_id:group_id,
            component_id:component_id,
            option_value: option_value
        },
        dataType: 'json',
        beforeSend: function() {
          
            $(".cond-"+group_id+"-"+component_id+"-"+question_id).remove();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $(".qs-"+group_id+"-"+component_id+"-"+question_id).append(response.contents);
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