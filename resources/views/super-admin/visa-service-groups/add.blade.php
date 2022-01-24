@extends('layouts.master-old')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                      <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
                      <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Services</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                  </nav>
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
              </div>
              <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{baseUrl('visa-service-groups')}}">
                  <i class="tio mr-1"></i> Back 
                </a>
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
  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/visa-service-groups/save') }}" method="post">
        @csrf
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Group Title</label>
          <div class="col-sm-10 js-form-message">
            <input type="text" name="group_title" id="group_title" placeholder="Enter Group Title" class="form-control">
          </div>
        </div>
        <!-- End Input Group -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10 js-form-message">
            <textarea name="description" id="description" placeholder="Enter Description" class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10 js-form-message">  
            <input type="file" name="image" id="image" class="form-control" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Program Type</label>
          <div class="col-sm-10 js-form-message">
            <select name="program_type" id="program_type">
              <option value="">Select Option</option>
              @foreach($program_types as $program)
              <option value="{{$program->id}}">{{$program->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Visa Services</label>
          <div class="col-sm-10 js-form-message">
            <select name="visa_services[]" multiple id="visa_services">
              <option value="" disabled>Select Option</option>
              @foreach($visa_services as $visa_service)
              <option value="{{$visa_service->unique_id}}">{{$visa_service->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
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
        initEditor("description");
        $("#form").submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var url  = $("#form").attr('action');
            if($("#visa_services").val() == ''){
              var html = '<div id="visa_services-error" class="invalid-feedback required-error">The Visa Service fields required.</div>';
              $("#visa_services").parents(".js-form-message").append(html);
              $("#visa_services").parents(".js-form-message").find(".custom-select").addClass('is-invalid');
              $("#visa_services").parents(".js-form-message").find(".tom-select-custom").addClass('is-invalid');
              return false;
            }
            $.ajax({
              url:url,
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
                  redirect(response.redirect_back);
                }else{
                  validation(response.message);
                  
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