@extends('layouts.master')


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/global-forms') }}">Global Forms</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
  
</ol>
<!-- End Content -->
@endsection

@section('header-right')
 <a class="btn btn-primary" href="{{ baseUrl('global-forms') }}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection

@section('content')
<!-- Content -->
<div class="assessments">
  

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('global-forms/save') }}" method="post">
        @csrf
        <div class="form-group js-form-message">
          <label>Form Title</label>
          <input type="text" class="form-control" data-msg="Please enter a title." name="form_title" id="form_title">
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
<!-- <link href="assets/vendor/formBuilder/dist/form-builder.css" /> -->
<script>
jQuery(($) => {
  const fbEditor = document.getElementById("build-wrap");
  var options = {
    dataType: 'json',
    disableFields: ['button','hidden','starRating'],
    layoutTemplates: {
      default: function(field, label, help, data) {
        help = $('<div/>')
          .addClass('helpme')
          .attr('id', 'row-' + data.id)
          .append(help);
        return $('<div/>').append(label, field, help);
      }
    }
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