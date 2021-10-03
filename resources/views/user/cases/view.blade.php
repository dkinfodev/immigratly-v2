@extends('layouts.master')

@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('/cases')}}">
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
     <!-- Step Form -->
      <form id="form" class="js-validate js-step-form">
         @csrf
         <!-- Content Step Form -->
         <div id="createProjectStepFormContent">
            <div id="createProjectStepDetails" class="active">
              
               <!-- Form Group -->
               <div class="form-group js-form-message">
                  <label class="input-label">Case Title</label>
                  <div class="input-group input-group-merge">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-briefcase-outlined"></i>
                        </div>
                     </div>
                     <div class="form-control">{{ $record['case_title'] }}</div>
                  </div>
               </div>
               <!-- End Form Group -->
               <div class="row">
                  <div class="col-sm-4">
                     <!-- Form Group -->
                     <div class="form-group js-form-message">
                        <label class="input-label">Start date</label>
                        <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                           <div class="input-group-prepend" data-toggle>
                              <div class="input-group-text">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                           <div class="form-control">{{ $record['start_date'] }}</div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-4">
                     <!-- Form Group -->
                     <div class="form-group js-form-message">
                        <label class="input-label">End date</label>
                        <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                           <div class="input-group-prepend" data-toggle>
                              <div class="input-group-text">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                           <div class="form-control">{{ $record['end_date'] }}</div>
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-4">
                     <div class="js-form-message form-group">
                        <label class="input-label font-weight-bold">Visa Service</label>
                        <div class="form-control">{{$record['MainService']['name']}}</div>
                      </div>
                  </div>
               </div>
               <div class="form-group js-form-message">
                  <label class="input-label">Description</label>
                  <?php echo $record['description'] ?>
               </div>
               <!-- List Group -->
               @if(count($record['assinged_member']))
               <div class="form-group js-form-message">
                  <label class="input-label">Assigned Staffs</label>
               </div>
              <div class="row">
                @foreach($record['assinged_member'] as $key => $member)
                <!-- Card -->
                <div class="col-md-3">
                  <div class="card h-100" style="max-width: 20rem;">
                    <!-- Body -->
                    <div class="card-body text-center">
                      <!-- Avatar -->
                      <div class="avatar avatar-xl avatar-circle avatar-border-lg avatar-centered mb-3">
                        <img class="avatar-img" src="{{ professionalProfile($member['member']['unique_id'],'t',$subdomain) }}" alt="Image Description">
                        
                      </div>
                      <!-- End Avatar -->

                      <h3 class="mb-1"><a class="text-dark" href="#">{{ $member['member']['first_name']." ".$member['member']['last_name'] }}</a></h3>

                      <div class="mb-3">
                        <i class="tio-city mr-1"></i>
                        <span>{{ $member['member']['role'] }}</span>
                      </div>
                    </div>
                    <!-- End Body -->
                  </div>
                </div>
                @endforeach
              </div>
              @endif
            </div>
         </div>
         <!-- End Content Step Form -->
         <!-- Message Body -->
         
         <!-- End Message Body -->
      </form>
      <!-- End Step Form -->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
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