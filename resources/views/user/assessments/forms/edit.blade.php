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
      <form id="form" class="js-validate" action="{{ baseUrl('assessments/forms/'.$assessment_id.'/update/'.$record['unique_id']) }}" method="post">
        @csrf
        <div class="form-group js-form-message">
          <label>Form Title</label>
          <input type="text" class="form-control" value="{{ $record['form_title'] }}" data-msg="Please enter a title." name="form_title" id="form_title">
        </div>
        <div id="build-wrap"></div>
        <div class="form-group js-form-message">
          <textarea class="form-control" style="display:none" data-msg="Please enter a title." name="form_json" id="form_json"></textarea>
        </div>

        <div class="form-group">
          <button type="button" id="saveData" class="btn add-btn btn-primary">Save</button>
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
<script src="assets/vendor/formBuilder/dist/form-builder.min.js"></script>
<script src="assets/vendor/formBuilder/dist/form-render.min.js"></script>
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
<script>
jQuery(($) => {
  const fbEditor = document.getElementById("build-wrap");
  var form_json = '<?php echo $record['form_json'] ?>';
  var datajson = JSON.parse(form_json);
  
  var options = {
    dataType: 'json',
    defaultFields:datajson
  };
  var formBuilder = $(fbEditor).formBuilder(options);

  document.getElementById("saveData").addEventListener("click", () => {
    const result = formBuilder.actions.save();
    var data = formBuilder.actions.getData('json', true);
    var dataJson = JSON.parse(data);
    if(dataJson.length <= 0){
      $("#form_json").val(data);
      errorMessage("No form fields addded");
    }else{
      saveForm(dataJson);
    }
  });
});
function saveForm(dataJson){
    // var formData = new FormData($("#form")[0]);
    var url  = $("#form").attr('action');
    var form_title = $("#form_title").val();
    $.ajax({
      url:url,
      type:"post",
      data:{
        _token:csrf_token,
        form_title:form_title,
        form_json:dataJson,
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