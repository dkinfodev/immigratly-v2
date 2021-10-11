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
<div class="visa_services">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('/visa-services')}}">
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
      <form id="visaServices-form" class="js-validate" action="{{ baseUrl('/visa-services/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Service Under</label>
          <div class="col-sm-10">
            <select class="form-control" name="parent_id"
            data-hs-select2-options='{
              "placeholder": "Select Service"
            }'
            >
              <option value="0">None</option>
              @foreach($main_services as $service)
              <option {{ ($record->parent_id == $service->id)?'selected':'' }} value="{{ $service->id }}">{{$service->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">  
            <input type="text" name="name" id="name" placeholder="Enter visa service" class="form-control" value="{{$record->name}}">
          </div>
        </div>
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Documents</label>
          <div class="col-sm-10">
            <?php
              $document_folders = explode(",",$record->document_folders);
            ?>
            <select class="form-control" multiple name="document_folders[]"
              data-hs-select2-options='{
                "placeholder": "Select Documents"
              }'
            >
              @foreach($documents as $document)
              <option {{ (in_array($document->id,$document_folders))?'selected':'' }} value="{{ $document->id }}">{{$document->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Assessment Price</label>
          <div class="col-sm-10">  
            <input type="text" name="assessment_price" id="assessment_price" placeholder="Enter Assessment Price" class="form-control" value="{{$record->assessment_price}}">
          </div>
        </div>
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">CV Type</label>
          <div class="col-sm-10">
            
            <select class="form-control" name="cv_type"
              data-hs-select2-options='{
                "placeholder": "Select CV Type"
              }'
            >
              <option value="">Select CV Type</option>
              @foreach($cv_types as $type)
              <option {{$record->cv_type == $type->id?"selected":""}} value="{{ $type->id }}">{{$type->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="js-form-message form-group row">
            <label class="col-sm-2 col-form-label">Eligible Type</label>
            <div class="col-sm-10">
                <select name="eligible_type" id="eligible_type" required>
                <option value="">Select Option</option>
                <option {{$record->eligible_type == 'group_eligible'?'selected':''}} value="group_eligible">Group Eligible</option>
                <option {{$record->eligible_type == 'normal_eligible'?'selected':''}} value="normal_eligible">Normal Eligible</option>
                </select>
            </div>
        </div>
        <div class="form-group">
          <button type="button" class="btn update-btn btn-primary">Update</button>
        </div>
        <!-- End Input Group -->

      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

  @section('javascript')
  <script type="text/javascript">
    $(document).ready(function(){
      $(".update-btn").click(function(e){
        e.preventDefault(); 
        $(".update-btn").attr("disabled","disabled");
        $(".update-btn").find('.fa-spin').remove();
        $(".update-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
        
        var id = $("#rid").val();
        var name = $("#name").val();
        var formData = $("#visaServices-form").serialize();
        var url = $("#visaServices-form").attr('action');
        $.ajax({
          url:url,
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){

          },
          success:function(response){
           $(".update-btn").find(".fa-spin").remove();
           $(".update-btn").removeAttr("disabled");
           if(response.status == true){
            successMessage(response.message);
            window.location.href = response.redirect_back;
          }else{
            $.each(response.message, function (index, value) {
              $("input[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
              $("input[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');

              var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
              $(html).insertAfter("*[name="+index+"]");
              $("input[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
            });
          }
        },
        error:function(){
         $(".update-btn").find(".fa-spin").remove();
         $(".update-btn").removeAttr("disabled");
       }
     });
      });
    });
  </script>

  @endsection