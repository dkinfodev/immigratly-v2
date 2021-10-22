@extends('layouts.master')
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
<style>
.sortable {
    list-style: none;
    margin: 0px;
    padding: 0px;
}

.sortable li {
    margin: 12px;
    border-radius: 7px;
}
</style>
<!-- Content -->
<div class="grp-eligibility">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                    </ol>
                </nav>

                <h1 class="page-title">{{$pageTitle}}</h1>
            </div>

            <div class="col-sm-auto">

                <a class="btn btn-primary btn-sm"
                    href="{{ baseUrl('/eligibility-check') }}">
                    Back
                </a>
            </div>
        </div>
        <!-- End Row -->
    </div>
        <?php echo $group_form ?>
    </div>
    <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
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
        url: BASEURL + '/eligibility-check/fetch-group-conditional',
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