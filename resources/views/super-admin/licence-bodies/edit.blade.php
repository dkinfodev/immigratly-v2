@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/licence-bodies') }}">Licence Body</a></li>

  <li class="breadcrumb-item active" aria-current="page">Edit</li>

</ol>
<!-- End Content -->
@endsection


@section('header-right')
      <a class="btn btn-primary" href="{{baseUrl('licence-bodies/')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection



@section('content')
<!-- Content -->
<div class="licence_bodies">
  
  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="licenceBodies-form" class="js-validate" action="{{ baseUrl('/licence-bodies/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group">
          <label class="input-label">Licence Body</label>

          <input class="form-control form-control-flush" rows=3 name="name" id="name" placeholder="Enter name of licence body..." required data-msg="Please enter a licence body name." value="{{ $record->name }}" />
        </div>
        <!-- End Input Group -->

        <!-- Input Group -->
        <div class="js-form-message form-group">
          <label class="input-label">Country</label>
          <select name="country_id" id="country_id" class="custom-select custom-select-flush">
            @foreach($countries as $key=>$c)
            <option <?php if(($record->country_id)==($c->id)) {echo "selected";} else {echo ""; }  ?> value="{{$c->id}}" name="{{$c->name}}">{{$c->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <button type="button" class="btn update-btn btn-primary">Update</button>
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
      $(".update-btn").click(function(e){
        e.preventDefault(); 
        $(".update-btn").attr("disabled","disabled");
        $(".update-btn").find('.fa-spin').remove();
        $(".update-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
        
        var id = $("#rid").val();
        var name = $("#name").val();
        var country_id = $("#country_id").val();
        var formData = $("#licenceBodies-form").serialize();
        var url  = $("#licenceBodies-form").attr('action');
        $.ajax({
          url:url,
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){

          },
          success:function(response){
           $(".update-btn").find(".fa-spin").remove();
           $(".update-btn").removeAttr("disabled");
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
         $(".signup-btn").find(".fa-spin").remove();
         $(".signup-btn").removeAttr("disabled");
       }
     });
      });
    });
  </script>


  @endsection