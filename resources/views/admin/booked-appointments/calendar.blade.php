@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection



@section('content')
<style>
.available-appointment {
    height: 80px !important;
    margin-top: 15px !important;
}
td.fc-event-container a {
    text-align: center;
}
.day-off {
    padding-top: 25px;
}
</style>
<!-- Content -->
<div class="assessments">
  <!-- Page Header -->
  

  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
          <h5 class="card-header-title">Appointments with Clients</h5>
        </div>
        <div class="col-sm-6">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
              <a href="{{ baseUrl('/booked-appointments') }}"><i class="fa fa-th"></i> View Appointments in Grid</a>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="row p-3">
      <div class="col-sm-12">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/moment/moment-with-locales.min.js"></script>
<link rel="stylesheet" href="assets/vendor/fullcalendar-v3/dist/fullcalendar.min.css">
<script src="assets/vendor/fullcalendar-v3/dist/fullcalendar.min.js"></script>
<script>
$(document).ready(function() {
  loadCalendar();
});
function loadCalendar() {

  $('#calendar').fullCalendar({

    // other options here...
    eventColor: 'transparent',
    eventTextColor: '#999',
    events: function(start, end,timezone, callback) {
      var date = new Date(end);
      var year = date.getFullYear();
      var month = date.getMonth();
      var start_date = start.format('YYYY-MM-DD');
      var end_date = end.format('YYYY-MM-DD');
  
      var schedule = [];
        $.ajax({
          url: "{{ baseUrl('booked-appointments/fetch-appointments') }}",
          dataType: 'json',
          type: 'POST',
          beforeSend:function(){
            showLoader();
          },
          data:{
            _token:csrf_token,
            start_date:start_date,
            end_date:end_date,
            professional:"{{$professional}}",
            month:month
          },
          success: function(response) {
            hideLoader();
            schedule = response.schedule;
            callback(schedule);
          }
        });
    },
    eventClick: function(info, jsEvent, view) {
      if(info.time_type == 'day_off'){
        return false;
      }
      var appointment_type = $("input[name=appointment_type]:checked").val();
      if(appointment_type == undefined){
        alert("Select meeting duration first");
      }else{
        
        var url = "{{ baseUrl('professional/fetch-available-slots') }}";
        var param = {
           
            professional:"{{$professional}}",
            date:info.start.format('YYYY-MM-DD'),
            schedule_id:info.id,
            time_type:info.time_type,
            appointment_type_id:appointment_type
          };
        showPopup(url,"post",param);
        
      }
    }
  });
  
}
</script>
@endsection