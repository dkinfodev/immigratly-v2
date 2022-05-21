@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
 <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/languages') }}">Languages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>

</ol>
<!-- End Content -->
@endsection


@section('header-right')
     <a class="btn btn-primary" href="{{baseUrl('languages/')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="languages">
 

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="languages-form" class="js-validate" action="{{ baseUrl('/languages/save') }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Language</label>
          <div class="col-sm-10">
           <input type="text" name="name" id="name" placeholder="Enter language" class="form-control">
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
        var formData = $("#languages-form").serialize();
        $.ajax({
          url:"{{ baseUrl('languages/save') }}",
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