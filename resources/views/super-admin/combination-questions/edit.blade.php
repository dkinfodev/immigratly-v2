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
<div class="combination_question">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions') }}">Groups Questions</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions')}}">
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
      <form id="form" class="js-validate" action="{{ baseUrl('/visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/groups-questions/edit/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
       
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Group Title</label>
          <div class="col-sm-10">
            <input type="text" name="group_title" id="group_title" placeholder="Enter Group Title" class="form-control" value="{{$record->group_title}}">
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Minimum Score</label>
          <div class="col-sm-10">
            <input type="number" name="min_score" id="min_score" placeholder="Enter Minimum Score" class="form-control" value="{{$record->min_score}}">
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Maximum Score</label>
          <div class="col-sm-10">
            <input type="number" name="max_score" id="max_score" placeholder="Enter Maximum Score" class="form-control" value="{{$record->max_score}}">
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Questions</label>
          <div class="col-sm-10">
            <select name="questions[]" multiple placeholder="Select Questions">
              @foreach($questions as $question)
              <option {{ in_array($question->unique_id,$question_ids)?'selected':'' }} value="{{$question->unique_id}}">{{$question->question}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Components</label>
          <div class="col-sm-10">
            <select name="components[]" multiple placeholder="Select Compoent">
              @foreach($components as $component)
              <option {{ in_array($component->unique_id,$component_ids)?'selected':'' }} value="{{$component->unique_id}}">{{$component->component_title}}</option>
              @endforeach
            </select>
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
$(document).ready(function(){
    
  $("#form").submit(function(e){
        e.preventDefault(); 
        
        var formData = new FormData($(this)[0]);
        $.ajax({
          url:$("#form").attr('action'),
          type:"post",
          data:formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          beforeSend:function(){
            showLoader();
          },
          success:function(response){
            hideLoader();
            if(response.status == true){
              successMessage(response.message);
              window.location.href = response.redirect_back;
            }else{
              if(response.error_type == 'validation'){
                validation(response.message);
              }

              if(response.error_type == 'no_component_question'){
                errorMessage(response.message);
              }
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