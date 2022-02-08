@extends('layouts.master')
@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Visa Services</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary btn-sm"
    href="{{ baseUrl('/eligibility-check') }}">
    Back
</a>
@endsection
@section('content')

<!-- Sidebar Detached Content -->
<div class="sidebar-detached-content mt-3 mt-lg-0" style="background:#f8fafd">
    <!-- Page Header -->
    <div class="imm-view-program-details-container-header">
        <div class="page-header">
            <!-- Profile Cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper">
                    <img class="profile-cover-img" src="./assets/img/1920x400/img1.jpg" alt="Image Description">
                </div>
            </div>
            <!-- End Profile Cover -->
            <div class="imm-view-details-main-title">
                <div class="row mb-3 align-items-center">

                    <!-- End Col -->
                    <div class="col-xs-12 col-sm-3">
                        <!-- Media -->
                        <div class="d-flex">
                            <div class="imm-program-logo-container w-100">
                                @if(!empty($group) && file_exists(public_path('uploads/visa-groups/'.$group->VisaGroup->image)))
                                    <img class="imm-program-logo" src="{{ asset('/public/uploads/visa-groups/'.$group->VisaGroup->image) }}"  />
                                @endif
                            </div>


                        </div>
                        <!-- End Media -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xs-12 col-sm-9">
                        <div class="imm-view-details-main-title-program">
                            <h3 class="card-title mb-2">
                                <a class="text-dark" href="../demo-jobs/employer.html">{{$group->VisaGroup->group_title}}</a>
                            </h3>
                            <div class="imm-self-assessment-container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex" style="text-align:right">

                                            <img class="me-1" src="./assets/img/checked.svg" alt="" style="width:18px">
                                            <p><b>{{ $group->VisaGroup->VisaServices->count() }}</b> Nomination pathways</p>
                                            <img class="ml-2 me-1" src="./assets/img/checked.svg" alt="" style="width:18px">
                                            <p>{{$visa_service->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->



            </div>










            <!-- Nav Scroller -->

            <div class="imm-vieww-program-details-menu bg-white zi-2">

                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs bg-white" id="pageHeaderTab">
                    <li class="nav-item active">
                        <a class="nav-link" href="#about-section">All programs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jobs-section">My assessments<span
                                class="badge bg-info rounded-pill ms-1">+9</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reviews-section">Latest news</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#interview-section">Recent draws</a>
                    </li>

                </ul>
                <!-- End Nav -->
            </div>

            <!-- End Nav Scroller -->

        </div>
    </div>
    <!-- End Page Header -->
    <!-- Card Grid -->
    <div class="imm-specific-program-container">
        <div class="row">


            <div class="col-lg-12">
                
                <!-- End Row -->

                <div class="row mb-3">
                    <!-- End Col -->
                    <!-- End Col -->
                    <div class="col-12  mb-5">
                        <?php echo $group_form ?>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Card Grid -->
</div>
<!-- End Sidebar Detached Content -->
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
                
                // $(".qs-"+group_id+"-"+component_id+"-"+question_id).after(response.contents);
                 $(".component-"+component_id).after(response.contents);
                
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
    var quesid = $(e).attr("data-quesid");
    var value = $(e).val();

    // var index = $("*[data-quesid='"+quesid+"']").length;
    // var current_index = $("form *[data-quesid='"+quesid+"']").index(e);
    // $("*[data-quesid='"+quesid+"']").each(function(){
    //     var index = $("form *[data-quesid='"+quesid+"']").index(this);
    //     var element = $(this).attr("data-element");
    //     if(index > current_index){
    //         if(element == 'select'){
    //             $(this).find("option[value='"+value+"']").attr("selected","selected");
    //         }
    //         if(element == 'radio'){
    //             var cur_val = $(this).val();
    //             if(value == cur_val){
    //                 $(this).prop("checked",true);
    //             }
    //             // $("*[data-quesid='"+quesid+"'][value='"+value+"']").prop("checked",true);
    //         }
    //     }
    // });
    // $("*[data-quesid='"+quesid+"']").find("option[value='"+value+"']").attr("selected","selected");
    // $("*[data-quesid='"+quesid+"'][value='"+value+"']").prop("checked",true);
    
    

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
function dependentQuestion(e,question_id,element){
    
    var value = $(e).val();
    if(element == 'dropdown'){
        $("*[data-dependent='"+question_id+"']").find("option[value='"+value+"']").attr("selected","selected");
        $("*[data-dependent='"+question_id+"']").trigger("change");;
        var text = $("*[data-dependent='"+question_id+"']").find("option[value='"+value+"']").text();
        $("*[data-dependent='"+question_id+"'][value='"+value+"']").parents(".imm-assessment-form-list-question").find(".preselect").html(text);
    }else{
        $("*[data-dependent='"+question_id+"'][value='"+value+"']").prop("checked",true);
        var text = $(e).parents(".form-check").text();
        $("*[data-dependent='"+question_id+"'][value='"+value+"']").parents(".imm-assessment-form-list-question").find(".preselect").html(text);
        setTimeout(function(){   
            $("*[data-dependent='"+question_id+"'][value='"+value+"']").trigger("change");
        },1000);
        
    }
    
}
</script>
@endsection