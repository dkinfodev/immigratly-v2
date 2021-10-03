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
      <form id="form" class="js-validate disabled-form" action="{{ baseUrl('assessments/forms/'.$assessment_id.'/save/'.$record['unique_id']) }}" method="post">
        @csrf
        <div class="form-group js-form-message">
          <h3 class="pull-left">Form Title:<b> {{$record['assessment_form']['form_title']}}</b></h3>
          <h3 class="pull-right">Added On:<b> {{dateFormat($record['created_at'])}}</b></h3>
          <div class="clearfix"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
              @foreach($form_json as $form)
              <tr>
                <th>{{$form['label']}}</th>
                <td>{{$form['value']}}</td>
              </tr>
              @endforeach
            </table>
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

$(document).ready(function(){
  $(".form-control").each(function(){
      $(this).attr("disabled","disabled");
  })
})

</script>

@endsection