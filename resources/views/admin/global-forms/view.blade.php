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
@section('content')
<!-- Content -->
<div class="assessments">
  <!-- Page Header -->

  <!-- End Page Header -->

  <!-- Card -->
  <div class="card">

    <div class="card-body">

        <div class="form-group js-form-message">
          <h3>Form Title:<b> {{$record->form_title}}</b></h3>
        </div>
        <div class="render-wrap"></div>
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
var form_json = '<?php echo $record->form_json ?>';
var formData = JSON.parse(form_json);
$('.render-wrap').formRender({
  formData:form_json,
  dataType: 'json',
  render: true,
  layoutTemplates: {
      default: function(field, label, help, data) {
        help = $('<div/>')
          .addClass('helpme')
          .attr('id', 'row-' + data.id)
          .append(help);
        return $('<div/>').append(label, field, help);
      }
    }
});
</script>

@endsection