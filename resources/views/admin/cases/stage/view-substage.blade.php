@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
   <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases/stages/list/'.base64_encode($record->CaseStage->Case->id)) }}">Stages</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/cases/stages/list/'.base64_encode($record->CaseStage->Case->id)) }}"><i class="tio mr-1"></i> Back</a>

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
        <div class="card-header">
            {{$record->name}}
        </div>
        <div class="card-body">
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('javascript')

<script type="text/javascript">


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