@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{ baseUrl('/cases/stages/'.$subdomain.'/'.$case_id) }}">Stages</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/cases/stages/'.$subdomain.'/'.$case_id) }}"><i class="tio mr-1"></i> Back</a>

@endsection

@section('content')
<style>
.h-100 {
    height: auto !important;
}
</style>
<!-- Content -->
<div class="content container-fluid">
    
    <!-- Card -->
    <div class="card">
        <div class="card-header p-4">
            <h2>{{$record['name']}}</h2>
        </div>
        <div class="card-body p-3">
          @if($record['stage_type'] == 'fill-form')
            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                       @if($record['form_reply'] != '')
                        <a data-toggle="tooltip" data-html="true" title="View Client Reply" href="{{baseUrl('global-forms/edit/'.$record->type_id)}}" class="btn btn-info btn-sm"><i class="tio-globe"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <h3 class="page-title mt-3 mb-3">{{$record['fill_form']['form_title']}}</h3>
                    <form id="form" class="js-validate" method="post">
                    @csrf  
                      <div class="render-wrap"></div>
                      <div class="form-group text-center">
                        <button type="submit" class="btn add-btn btn-primary">Save</button>
                      </div>
                      <!-- End Input Group -->
                    </form>
                 </div>
            </div>
          @endif
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('javascript')
<script src="assets/vendor/formBuilder/dist/form-render.min.js"></script>
<script type="text/javascript">
jQuery(($) => {
  @if($record['stage_type'] == 'fill-form')
  var form_json = '<?php echo $record['fill_form']['form_json'] ?>';
  var formData = JSON.parse(form_json);
  $('.render-wrap').formRender({
      formData:form_json,
      dataType: 'json',
      render: true
    });
  @endif
});

$(document).on('ready', function () {    
    $("#form").submit(function(e){
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var url  = $("#form").attr('action');
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
            redirect(response.redirect);
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