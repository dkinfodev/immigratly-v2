@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')
<!-- Page Header -->
  @include(roleFolder().'.cases.case-navbar')

  <!-- Card -->
  <div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
      <h6 class="card-subtitle mb-0">Description</h6>

    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <?php echo $record['description'] ?>
    </div>
    <!-- End Body -->
  </div>
  <!-- End Card -->

  <!-- End Row -->

@endsection

@section('javascript')
<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->
<script type="text/javascript">
// initEditor("description"); 
$(document).on('ready', function () {
  $("#client_id").change(function(){
    if($(this).val() != ''){
      var text = $("#client_id").find("option:selected").text();
      $("#client_name_text").html(text.trim());
    }else{
      $("#client_name_text").html('');
    }
  });
  $("[name=case_title]").change(function(){
    if($(this).val() != ''){
      $("#case_title_text").html($(this).val());
    }else{
      $("#case_title_text").html('');
    }
  });
  $("[name=start_date]").change(function(){
    if($(this).val() != ''){
      $("#start_date_text").html($(this).val());
    }else{
      $("#start_date_text").html('');
    }
  });
  $("[name=end_date]").change(function(){
    if($(this).val() != ''){
      $("#end_date_text").html($(this).val());
    }else{
      $("#end_date_text").html('');
    }
  });
  $("#visa_service_id").change(function(){
    if($(this).val() != ''){
      var text = $("#visa_service_id").find("option:selected").text();
      $("#visa_service_text").html(text.trim());
    }else{
      $("#visa_service_text").html('');
    }
  });
  $("#assign_teams").change(function(){
    if($("#assign_teams").val() != ''){
      var html = '';
      $("#assign_staff_list").show();
      $(".staff").remove();
      $("#assign_teams").find("option:selected").each(function(){
          var text = $(this).attr('data-name');
          var role = $(this).attr('data-role');

          html +='<li class="text-left staff">';
          html +='<a class="nav-link media" href="javascript:;">';
          html +='<i class="tio-group-senior nav-icon text-dark"></i>';
          html +='<span class="media-body">';
          html +='<span class="d-block text-dark">'+text.trim()+'</span>';
          html +='<small class="d-block text-muted">'+role+'</small>';
          html +='</span></a></li>';
      });
      $("#assign_staff_list ul").append(html);
    }else{
      $("#assign_staff_list").hide();
      $("#assign_staff_list .staff").remove();
    }
  });
  $('#start_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('#end_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });
  $('.js-step-form').each(function () {
     var stepForm = new HSStepForm($(this), {
       validate: function(){
       },
       finish: function() {
        
       }
     }).init();
   });
});
function stateList(country_id,id){
    $.ajax({
        url:"{{ url('states') }}",
        data:{
          country_id:country_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
           $("#city").html('');
        },
        success:function(response){
          if(response.status == true){
            $("#"+id).html(response.options);
          } 
        },
        error:function(){
           
        }
    });
}
function cityList(state_id,id){
    $.ajax({
        url:"{{ url('cities') }}",
        data:{
          state_id:state_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
        },
        success:function(response){
          if(response.status == true){
            $("#"+id).html(response.options);
          } 
        },
        error:function(){
           
        }
    });
}
</script>

@endsection