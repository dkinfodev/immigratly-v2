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
<div class="licence_bodies">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/licence-bodies') }}">Licence Body</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="users-add-user.html">
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
      <form id="licenceBodies-form" class="js-validate" action="{{ baseUrl('/licence-bodies/save') }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group">
          <label class="input-label">Licence Body</label>
          <input class="form-control form-control-flush" name="name" id="name" placeholder="Enter name of licence body..." required data-msg="Please enter a licence body name." value="" />
        </div>
        <!-- End Input Group -->

        <!-- Input Group -->
        <div class="js-form-message form-group">
          <label class="input-label">Country</label>
          <select name="country_id" id="country_id" class="custom-select custom-select-flush">
            @foreach($countries as $key=>$c)
            <option value="{{$c->id}}" name="{{$c->name}}">{{$c->name}}</option>
            @endforeach
          </select>
        </div>

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
        var country_id = $("#country_id").val();
        var formData = $("#licenceBodies-form").serialize();
        $.ajax({
          url:"{{ baseUrl('licence-bodies/save') }}",
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