@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-100 mx-lg-auto">
        <!-- Input -->
        <h1 class="text-lh-sm text-white">Visa Services</h1>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<div class="container space-bottom-2">
  <div class="w-lg-100 mx-lg-auto">
    <!-- Breadcrumbs -->
        <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Visa Services</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
      </ol>
    </nav>
    <!-- End Breadcrumbs -->


    <!-- End Breadcrumbs -->

    <!-- Article -->
    <div class="card card-bordered custom-content-card">

        <?php echo $group_form ?>

    </div>
    <!-- End Article -->
  </div>
  
  
</div>
@endsection

@section("javascript")
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>

<script>
$(document).ready(function(){
  
});
initForm("{{$visa_service_id}}");
function conditionalQuestion(e, ele) {
    var option_value = '';
    var group_id = $(e).parents(".quesli").attr("data-group");
    var question_id = $(e).parents(".quesli").attr("data-question");
    var component_id = $(e).parents(".quesli").attr("data-component");
    var value = $(e).val();
    if (ele == 'select') {
        option_value = $(e).find("option[value='" + value + "']").attr("data-option-id");
    }
    if (ele == 'radio') {
        option_value = $(e).attr("data-option-id");
    }
    $.ajax({
        type: "POST",
        url: SITEURL + '/check-eligibility/fetch-group-conditional',
        data: {
            _token: csrf_token,
            question_id: question_id,
            group_id:group_id,
            component_id:component_id,
            option_value: option_value
        },
        dataType: 'json',
        beforeSend: function() {
          
            $(".cond-"+group_id+"-"+component_id+"-"+question_id).remove();
        },
        success: function(response) {
            hideLoader();
            if (response.status == true) {
                $(".qs-"+group_id+"-"+component_id+"-"+question_id).append(response.contents);
                initSelect();
            }
        },
        error: function() {
            internalError();
        }
    });
}
function initForm(form_id){
    $("#form-"+form_id).submit(function(e){
      e.preventDefault();
      var formData = $("#form-"+form_id).serialize();
      var url  = $("#form-"+form_id).attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        dataType:"json",
        beforeSend:function(){
          showLoader();
          $(".response").html('');
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            redirect(response.redirect_back);
          }else{
            $(".response").html(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
    });
}
</script>
@endsection