@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/services') }}">Services</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{baseUrl('/services')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection


@section('content')
<!-- Content -->
<div class="services">
  

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/services/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Service Name</label>
          <div class="col-sm-10 pt-2 font-weight-bold">
           {{$record->Service($record->service_id)->name}}
         </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Price</label>
          <div class="col-sm-10">
           <!-- <input type="text" name="name" placeholder="Enter price for your service" class="form-control"> -->
           <div class="js-quantity-counter input-group-quantity-counter">
              <input type="number" name="price" class="js-result form-control input-group-quantity-counter-control" value="1">

              <div class="input-group-quantity-counter-toggle">
                <a class="js-minus input-group-quantity-counter-btn" href="javascript:;">
                  <i class="tio-remove"></i>
                </a>
                <a class="js-plus input-group-quantity-counter-btn" href="javascript:;">
                  <i class="tio-add"></i>
                </a>
              </div>
            </div>
         </div>
        </div>
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
           <textarea class="form-control" id="description" name="description">{{$record->description}}</textarea>
         </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
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
<script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script type="text/javascript">
    
$(document).on('ready', function () {
  // initialization of quantity counter
  $('.js-quantity-counter').each(function () {
    var quantityCounter = new HSQuantityCounter($(this)).init();
  });

  $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
          url:url,
          type:"post",
          data:formData,
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
              $.each(response.message, function (index, value) {
                  $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                  $("[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
                  
                  var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                  $(html).insertAfter("*[name="+index+"]");
                  $("[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
              });
              // errorMessage(response.message);
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