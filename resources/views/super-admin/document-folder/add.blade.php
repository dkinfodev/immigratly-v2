@extends('layouts.master-old')

@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
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
<div class="document_folder">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/document-folder') }}">Document Folder</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('document-folder/')}}">
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
      <form id="documents-form" class="js-validate" action="{{ baseUrl('/documents/save') }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" name="name" id="name" placeholder="Enter document name" class="form-control">
          </div>
        </div>
        <!-- End Input Group -->

        <div class="form-group">
          <button type="button" class="btn add-btn btn-primary">Add</button>
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
      $(".add-btn").click(function(e){
        e.preventDefault(); 
        $(".add-btn").attr("disabled","disabled");
        $(".add-btn").find('.fa-spin').remove();
        $(".add-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
        
        var name = $("#name").val();
        var formData = $("#documents-form").serialize();
        $.ajax({
          url:"{{ baseUrl('document-folder/save') }}",
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){
          },
          success:function(response){
           $(".add-btn").find(".fa-spin").remove();
           $(".add-btn").removeAttr("disabled");
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
         $(".add-btn").find(".fa-spin").remove();
         $(".add-btn").removeAttr("disabled");
       }
     });
      });
    });
  </script>

  @endsection