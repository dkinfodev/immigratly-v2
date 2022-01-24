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
@if($visa_service->question_as_sequence == 1)

$(document).ready(function(){
    var all_fill = 1;
    $('.noneEligibleToast').toast({
        delay: 1500,
        autohide:false
    });
    
    $("select").change(function(){
        $(this).parents(".group-block").find("*[name]").each(function(){
            
            if($(this).get(0).tagName == 'SELECT'){
                
                if($(this).val() == ''){
                    all_fill = 0;
                }
            }else{
                var name = $(this).attr("name");
                if($("input[name='"+name+"']:checked") == undefined){
                    all_fill = 0;
                }
                
            }
        });
    })
    $("input[type=radio]").change(function(){
        $(this).parents(".group-block").find("*[name]").each(function(){
            
            if($(this).get(0).tagName == 'SELECT'){
                
                if($(this).val() == ''){
                    all_fill = 0;
                }
            }else{
                var name = $(this).attr("name");
                if($("input[name='"+name+"']:checked") == undefined){
                    all_fill = 0;
                }
                
            }
        });
    });
    
})
@endif
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
function preConditionalComp(option_value,question_id){
    $.ajax({
        url:"{{ baseUrl('/eligibility-check/check-pre-condition') }}",
        type:"post",
        data:{
            _token:csrf_token,
            option_id:option_value,
            question_id:question_id
        },
        dataType:"json",
        beforeSend:function(){
        //   showLoader();
          $(".comp-ques-"+question_id).hide();
          $(".comp-ques-"+question_id).find("select").attr("disabled","disabled");
          $(".comp-ques-"+question_id).find("input").attr("disabled","disabled");
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            $(".component-"+response.component_id).show();
            $(".comp-ques-"+question_id).find("select").removeAttr("disabled");
            $(".comp-ques-"+question_id).find("input").removeAttr("disabled");
          }else{
            $(".response").html(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
}
function countTotal(e,component_id,question_id){
    var max_score = $(e).parents(".component-block").attr("data-max");
    var min_score = $(e).parents(".component-block").attr("data-min");
    var none_eligibile = $(e).attr("data-noneligible");
    if(none_eligibile == 1){
        var none_eligible_reason = $(e).attr("data-none-eligible-reason");
        // errorMessage(none_eligible_reason);
        $("#noneEligibleToast-"+question_id).toast("show");
        $("#noneEligibleToast-"+question_id).find(".toast-body").html(none_eligible_reason);
        return false;
    }else{
        $("#noneEligibleToast-"+question_id).toast("hide");
        $("#noneEligibleToast-"+question_id).find(".toast-body").html('');

    }
    // alert(component_id+" quest: "+question_id+" min_score: "+min_score+" max_score: "+max_score);
    // var score = 0;
    // $(".component-"+component_id+" select").each(function(){
    //     if($(this).find("option:selected")){
    //         if($(this).val() != ''){
    //             var sel_score = $(this).find("option[value='"+$(this).val()+"']").attr("data-score");
    //             score += parseInt(sel_score);
    //         }
    //     }
    // });
    // $(".component-"+component_id+" input[type=radio]:checked").each(function(){
    //     if($(this).val() != ''){
    //         var sel_score = $(this).attr("data-score");
    //         score += parseInt(sel_score);
    //     }
    // });
    // if(score > max_score){
    //     errorMessage("Score exceed more then component max score");
    //     return false;
    // }
}
</script>
@endsection