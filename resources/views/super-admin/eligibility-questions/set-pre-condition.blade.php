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
    <a class="btn btn-primary"
        href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id))}}">
        <i class="tio mr-1"></i> Back
    </a>
@endsection


@section('content')
<!-- Content -->
<div class="eligibility_questions">
    

    <!-- Card -->
    <div class="card">
        <div class="card-header">
            <h2>Question: {{$record->question}}</h2>
        </div>
        <div class="card-body">
            <form id="form" class="js-validate"
                action="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/set-pre-conditions/'.base64_encode($record->id)) }}"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
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
                                            <input disabled type="text"
                                                value="{{ $option->option_value }}" class="form-control mb-3 option_value"
                                                placeholder="Option Value" aria-label="Option Value">
                                        </div>
                                        <div class="col-md-3 js-form-message">
                                            <input disabled type="text"
                                                value="{{ $option->option_label }}" class="form-control mb-3 option_label"
                                                placeholder="Option Label" aria-label="Option Label">
                                        </div>
                                        <div class="col-md-3 js-form-message">
                                            <div class="row opt-row">
                                                
                                                <div class="col-md-11">
                                                    <select class="select2" name="component[{{ $option->id }}]">
                                                        <option value="">Select Component</option>
                                                        @foreach($components as $component)
                                                        <option {{(isset($conditionalComponents[$option->id]) && $conditionalComponents[$option->id] == $component['component']['unique_id'])?'selected':'' }} value="{{$component['component']['unique_id']}}">{{$component['component']['component_title']}}</option>
                                                        @endforeach
                                                    </select>             
                                                </div>      
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Row -->
                                </div>
                            </div>
                            @endforeach
                            </div>
                        
                        </div>
                    
                        <div class="form-group text-center">
                            <button type="submit" class="btn add-btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
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
                    location.reload();
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