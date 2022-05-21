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
     <div class="card-header pt-5 pb-0">
         <h3 class="card-title">{{$record->form_title}}</h3>
     </div>
    <div class="card-body pt-0">
     <?php echo $form_preview ?>
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