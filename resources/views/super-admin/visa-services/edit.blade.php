@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Services</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
  <a class="btn btn-primary" href="{{baseUrl('visa-services')}}">
    <i class="tio mr-1"></i> Back 
  </a>
@endsection

@section('content')

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="visaServices-form" class="js-validate" action="{{ baseUrl('/visa-services/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Service Under</label>
          <div class="col-sm-10">
            <select class="form-control" id="parent_id" name="parent_id"
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
        <div class="form-group row dependent_checkbox">
          <label class="col-sm-2 col-form-label">Is Dependent</label>
          <div class="col-sm-10">  
            <div class="custom-control custom-checkbox mt-2">
              <input {{$record->is_dependent == 1?'checked':''}} type="checkbox" id="is_dependent" value="1" name="is_dependent" class="custom-control-input">
              <label class="custom-control-label" for="is_dependent">&nbsp;</label>
            </div>
          </div>
        </div>
        <div class="js-form-message form-group row dependent_visa_service" style="display: {{$record->is_dependent == 1?'':'none'}}">
          <label class="col-sm-2 col-form-label">Dependent Services</label>
          <div class="col-sm-10">
            <select class="form-control dependent_service" name="dependent_visa_service"
            data-hs-select2-options='{
              "placeholder": "Select Visa Service"
            }'
            >
              <option value="0">None</option>
              @foreach($main_services as $service)
              <option {{$record->dependent_visa_service == $service->unique_id?'selected':''}} value="{{ $service->unique_id }}">{{$service->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="js-form-message form-group row dependent_visa_service" style="display:none">
          <label class="col-sm-2 col-form-label">Select Questions</label>
          <div class="col-sm-10">
            <select class="form-control dependent_questions" name="dependent_questions[]" multiple
            data-hs-select2-options='{
              "placeholder": "Select Questions"
            }'
            >
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
      $("#parent_id").change(function(){
        if($(this).val() != 0){
          $(".dependent_checkbox").hide();
          $("#is_dependent").prop("checked",false);
          $(".dependent_visa_service").hide();
        }else{
          $(".dependent_checkbox").show();
        }
      })
      $(".dependent_service").change(function(){
        if($(this).val() != ''){
          var current_visa_service = "{{$record->dependent_visa_service}}";
          if($(this).val() == current_visa_service){
            $(".dependent_visa_service").hide();
            $(".dependent_questions").html('');
            return false;
          }
          $.ajax({
              type: "POST",
              url: BASEURL + '/visa-services/fetch-questions',
              data:{
                  _token:csrf_token,
                  visa_service_id:$(this).val(),
              },
              dataType:'json',
              beforeSend:function(){
                  showLoader();
                  $(".dependent_questions").html('');
              },
              success: function (response) {
                  hideLoader();
                  if(response.status == true){
                   
                    
                    $(".dependent_visa_service").show();
                    
                    $(".dependent_questions").html(response.options);
                  }else{
                    $(".dependent_questions").html('');
                  }
              },
              error:function(){
                internalError();
              }
          });
        }else{
          $(".dependent_questions").html('');
        }
      });
      $("#is_dependent").change(function(){
        if($(this).is(":checked")){
          $(".dependent_visa_service").show();
        }else{
          $(".dependent_visa_service").hide();
        }
      });
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
            showLoader();
          },
          success:function(response){
            hideLoader();
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