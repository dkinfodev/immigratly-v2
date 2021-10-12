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
<div class="eligibility_questions">
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
                <a class="btn btn-primary"
                    href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id))}}">
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
            <form id="form" class="js-validate"
                action="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/set-group-conditions/'.base64_encode($record->id)) }}"
                method="post">

                @csrf
                <!-- Input Group -->

                <!-- End Input Group -->
                <div class="js-form-message form-group row">
                    <div class="col-sm-10">
                        {{$record->question}}
                        <div class="font-weight-bold">{{$group->QuestionsGroups->group_title}}</div>
                    </div>
                </div>
                
                <div class="js-add-field" data-hs-add-field-options='{
                  "template": "#addOptionsTemplate",
                  "container": "#addOptionsContainer",
                  "defaultCreated": 0
                }'>
                    <!-- Title -->
                    <div class="bg-light border-bottom p-2 mb-3">
                        <div class="row">

                            <div class="col-sm-3">
                                <h6 class="card-title text-cap">Option Value</h6>
                            </div>
                            <div class="col-sm-3 d-none d-sm-inline-block">
                                <h6 class="card-title text-cap">Option Label</h6>
                            </div>
                            <div class="col-sm-3 d-none d-sm-inline-block">
                                <h6 class="card-title text-cap">Component</h6>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Container For Input Field -->
                        <input type="hidden" name="question_id" class="question_id" value="{{$record->unique_id}}" />
                        <div id="addOptionsContainer">
                          @foreach($record->Options as $key => $option)
                          <div class="item-row">
                            <div class="input-group-add-field">
                                
                                <?php
                                $index = randomNumber(4);
                                ?>
                                <div class="row">
                                    <div class="col-md-3 js-form-message">
                                        <input disabled name="options[{{$index}}][option_value]" type="text"
                                            value="{{ $option->option_value }}" class="form-control mb-3 option_value"
                                            placeholder="Option Value" aria-label="Option Value">
                                    </div>
                                    <div class="col-md-3 js-form-message">
                                        <input disabled name="options[{{$index}}][option_label]" type="text"
                                            value="{{ $option->option_label }}" class="form-control mb-3 option_label"
                                            placeholder="Option Label" aria-label="Option Label">
                                    </div>
                                    <div class="col-md-3 js-form-message">
                                        <div class="row opt-row">
                                            <div class="col-md-1 p-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" {{isset($conditionalComponents[$option->id])?'checked':''}} class="custom-control-input row-checkbox" id="crow-{{$key}}">
                                                    <label class="custom-control-label" for="crow-{{$key}}"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-11">
                                                <select class="select2" {{!isset($conditionalComponents[$option->id])?'disabled':''}} name="component[{{ $option->id }}]">
                                                    <option value="">Select Component</option>
                                                    @foreach($components as $component)
                                                    <option {{(isset($conditionalComponents[$option->id]) && $conditionalComponents[$option->id] == $component->unique_id)?'selected':'' }} value="{{$component->unique_id}}">{{$component->component_title}}</option>
                                                    @endforeach
                                                </select>             
                                            </div>      
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3 js-form-message">
                                        <div class="row opt-row">
                                            <div class="col-md-1 p-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input  type="checkbox" {{isset($conditionalQuestions[$option->id])?'checked':''}} class="custom-control-input row-checkbox" id="qrow-{{$key}}">
                                                    <label class="custom-control-label" for="qrow-{{$key}}"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-11">
                                                <select class="select2" {{!isset($conditionalQuestions[$option->id])?'disabled':''}} name="question[{{ $option->id }}]">
                                                    <option value="">Select Question</option>
                                                    @foreach($questions as $question)
                                                    <option {{(isset($conditionalQuestions[$option->id]) && $conditionalQuestions[$option->id] == $question->unique_id)?'selected':'' }} value="{{$question->unique_id}}">{{$question->question}}</option>
                                                    @endforeach
                                                </select>             
                                            </div>      
                                        </div>
                                    </div> -->
                                </div>
                                <!-- End Row -->
                            </div>
                          </div>
                          @endforeach
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
<script type="text/javascript">
$(document).ready(function() {
    $(".row-checkbox").change(function(){
        $(this).parents(".item-row").find(".row-checkbox").not($(this)).prop("checked",false);
        $(this).parents(".item-row").find(".select2").val('').trigger("change");
        $(this).parents(".item-row").find(".select2").attr("disabled","disabled");
        if($(this).is(":checked")){
            $(this).parents(".opt-row").find(".select2").removeAttr("disabled");
        }
    })
    $("#form").submit(function(e) {
        e.preventDefault();
        if ($("#addOptionsContainer .item-row").length <= 0) {
            errorMessage("Please add the options");
            return false;
        }
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: $("#form").attr('action'),
            type: "post",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    successMessage(response.message);
                    window.location.href = response.redirect_back;
                } else {
                    validation(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });
    });
});
</script>

@endsection