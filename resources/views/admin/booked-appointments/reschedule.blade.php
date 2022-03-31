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
<!-- Content -->
<div class="assessments">
  <!-- Page Header -->
  

  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-8 col-md-8 mb-3 mb-sm-0">
          <h5 class="card-header-title">Reschedule Client's Appointment</h5>
          <div class="mt-2">
            <span class="text-danger"><b>Duration:</b>{{$record['meeting_duration']}} Minutes</span>
            <span class="text-danger"> | <b>Time:</b>{{$record['start_time']}} to {{$record['end_time']}}</span>
          </div>
        </div>
        <div class="col-sm-4 col-md-4">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
              <a href="{{ baseUrl('/booked-appointments') }}"><i class="fa fa-th"></i> View Appointments in Grid</a>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="row p-3 mb-3">
    @foreach($appointment_types as $key => $type)
        <div class="col-sm-4 appointment_types">
          <div class="card text-center">
              <div class="card-body">
                  <h3>{{$type['name']}}</h3>
                  <h4>{{$type['time_duration']['name']}}</h4>
              </div>
              <div class="card-footer">
                    <div class="form-group">
                    <!-- Checkbox -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio-{{$key}}" class="custom-control-input" onchange="selectDuration(this)" name="appointment_type" {{ ($record['appointment_type_id'] == $type['unique_id'])?'checked':'' }} value="{{$type['unique_id']}}">
                            <label class="custom-control-label" for="customRadio-{{$key}}">Select Type</label>
                        </div>
                        <input type="radio" style="display:none" name="break_time" class="break_time" value="{{$type['time_duration']['break_time'] }}" {{ ($record['break_time'] == $type['time_duration']['break_time'])?'checked':'' }} />
                        <!-- End Checkbox -->
                    </div>
              </div>
          </div>
        </div>
        @endforeach

    </div>
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
      url: "{{ baseUrl('booked-appointments/fetch-hours') }}",
      dataType: 'json',
      type: 'POST',
      beforeSend:function(){
        showLoader();
      },
      data:{
        _token:csrf_token,
        location_id: "{{$location_id}}",
        professional:"{{$subdomain}}",
        year:year,
        start_date:start_date,
        end_date:end_date,
        month:month,
        action:"{{$action}}",
        eid:"{{$eid}}",
      },
      success: function(response) {
        hideLoader();
        schedule = response.schedule;
        callback(schedule);
      }
    });
},
dayRender: function(date, cell){
    var maxDate = new Date();
    if (date < maxDate){
        $(cell).addClass('disabled bg-disabled');
    }
},  
eventClick: function(info, jsEvent, view) {
  var maxDate = new Date();
  maxDate = maxDate.setDate(maxDate.getDate() - 1);
  if(info.start < maxDate){
    errorMessage("Not allowed to book for past date");
    return false;
  }
  if(info.time_type == 'day_off'){
    return false;
  }
  var appointment_type = $("input[name=appointment_type]:checked").val();
  var break_time = $("input[name=break_time]:checked").val();
  if(appointment_type == undefined){
    alert("Select meeting duration first");
  }else{
    
    var url = "{{ baseUrl('booked-appointments/fetch-available-slots') }}";
    var param = {
        location_id: "{{$location_id}}",
        professional:"{{$subdomain}}",
        date:info.start.format('YYYY-MM-DD'),
        schedule_id:info.id,
        time_type:info.time_type,
        service_id:"{{ $service->unique_id}}",
        appointment_type_id:appointment_type,
        break_time:break_time,
        action:"{{$action}}",
        eid:"{{$eid}}",
      };
    showPopup(url,"post",param);
  }
}
});
  
}
</script>
@endsection