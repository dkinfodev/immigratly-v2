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
<!-- Content -->
<div class="nws">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('visa-services')}}">
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
      <form id="visaServices-form" class="js-validate" action="{{ baseUrl('/visa-services/score-range/'.base64_encode($visa_service_id)) }}" method="post">
        @csrf
         <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Good Score</label>
          <div class="col-sm-10">
            <input type="text" name="good_score" id="good_score" placeholder="Enter Good Score" class="form-control" value="{{(!empty($score_range))?$score_range->good_score:''}}">
          </div>
        </div>
        <!-- End Input Group -->
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">May Be Score</label>
          <div class="col-sm-10">
            <input type="text" name="may_be_score" id="may_be_score" placeholder="Enter May Be Score" class="form-control" value="{{(!empty($score_range))?$score_range->may_be_score:''}}">
          </div>
        </div>
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Difficult Range Score</label>
          <div class="col-sm-10">
            <input type="text" name="difficult_range_score" id="difficult_range_score" placeholder="Enter Difficult Score" class="form-control" value="{{(!empty($score_range))?$score_range->difficult_range_score:''}}">
          </div>
        </div>
        
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">None Eligible Score</label>
          <div class="col-sm-10">
            <input type="text" name="none_eligible_score" id="none_eligible_score" placeholder="Enter None Eligible Score" class="form-control" value="{{(!empty($score_range))?$score_range->none_eligible_score:''}}">
          </div>
        </div>

        <div class="form-group">
          <button type="button" class="btn add-btn btn-primary">Save</button>
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
        var formData = $("#visaServices-form").serialize();
        $.ajax({
          url:$("#visaServices-form").attr("action"),
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
            location.reload();
          }else{
            validation(response.message);
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