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

        <div class="card-body">
        <form id="form" action="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id.'/save-pattern') }}">
                @csrf
                <div class="js-form-message form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Visa Service</label>
                    <div class="col-sm-6">
                        <select id='sub_visa_service' name="sub_visa_service" required>
                            <option value="">Select Visa Service</option>
                            @foreach($sub_visa_services as $visa_service)
                            <option value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach($questions as $question)
                <div class="form-group">
                    <div class="font-weight-bold">
                        <i class="tio-chevron-right"></i> {{$question->question}}
                    </div>
                    <div class="mt-3">
                        <select name="questions[{{$question->unique_id}}][]" multiple>
                            <option value="" disabled>Select Option</option>
                            @foreach($question->Options as $option)
                            <option value="{{$option->option_value}}">{{$option->option_label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endforeach
                <div class="response p-2 text-danger"></div>
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary">Save Pattern</button>
                </div>
            </form>
        </div><!-- End Card body-->
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
</script>

@endsection