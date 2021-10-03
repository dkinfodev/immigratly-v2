@extends('layouts.master')

@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/assessments') }}">Assessments</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ baseUrl('assessments/forms/'.$assessment_id) }}">
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
      <form id="form" class="js-validate" action="{{ baseUrl('assessments/forms/'.$assessment_id.'/save/'.$record->unique_id) }}" method="post">
        @csrf
        <div class="form-group js-form-message">
          <h>Form Title:<b> {{$record->form_title}}</b></h3>
        </div>
        <div class="render-wrap"></div>
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
<!-- JS Implementing Plugins -->
<!-- <script src="assets/vendor/formBuilder/dist/form-builder.min.js"></script> -->
<script src="assets/vendor/formBuilder/dist/form-render.min.js"></script>
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
<script>
jQuery(($) => {
var form_json = '<?php echo $form_json ?>';
var formData = JSON.parse(form_json);
$('.render-wrap').formRender({
      formData:form_json,
      dataType: 'json',
      render: true
    });
});
function saveForm(dataJson){
    // var formData = new FormData($("#form")[0]);
    var url  = $("#form").attr('action');
    $.ajax({
      url:url,
      type:"post",
      data:{
        _token:csrf_token,
        form_reply:dataJson,
      },
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
}
</script>

@endsection