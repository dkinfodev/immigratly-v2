@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection


@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ url('/') }}">Home</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ url('/professionals') }}">Professional</a></li>

  <li class="breadcrumb-item active" aria-current="page">{{$subdomain}}</li>
</ol>
<!-- End Content -->
@endsection

@section('content')
<!-- Search Section -->
<style>
  td.fc-event-container a {
    text-align: center;
    height: 85px;
    padding-top: 55px;
}
</style>

<div class="container space-bottom-2 ">
  <div class="w-lg-100 ">
      <div class="row">
  
        <div class="col-lg-12">
          <!-- Card -->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">Appointment Type</h5>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
              <div class="row">
                 @foreach($appointment_types as $key => $type)
                <div class="col-sm-4">
                  <div class="card text-center">
                      <div class="card-body">
                          <h3>{{$type->name}}</h3>
                          <h4>{{$type->duration}}</h4>
                      </div>
                      <div class="card-footer">
                            <div class="form-group">
                            <!-- Checkbox -->
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio-{{$key}}" class="custom-control-input" name="appointment_type" value="{{$type->unique_id}}">
                                    <label class="custom-control-label" for="customRadio-{{$key}}">Select Type</label>
                                </div>
                                <!-- End Checkbox -->
                            </div>
                      </div>
                  </div>
                </div>
                @endforeach

                <hr>

                <div class="col-sm-12 mb-5">
                 <!-- Fullcalendar-->
                 <div id="calendar"></div>
                    <!-- <div class="js-fullcalendar fullcalendar-custom" data-hs-fullscreen-options='{
                    "initialDate": "2020-09-10"
                    }'></div> -->
                    <!-- End Fullcalendar -->
                </div>


              </div>
              <!-- End Row -->

            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->

        </div>
      </div>
    <!-- End Content Section -->
  </div>
</div>
@endsection

@section("javascript")
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
      // if (new_url != current_url) {

        $.ajax({
          url: "{{ url('professional/fetch-hours') }}",
          dataType: 'json',
          type: 'POST',
          data:{
            _token:csrf_token,
            location_id: "{{$location_id}}",
            professional:"{{$subdomain}}",
            year:year,
            start_date:start_date,
            end_date:end_date,
            month:month
          },
          success: function(response) {
           schedule = response.schedule;
            callback(schedule);
          }
        });
        // callback(schedule);
      // } else {
      //   callback(user_events);
      // }
    },
    eventClick: function(info, jsEvent, view) {
      var appointment_type = $("input[name=appointment_type]:checked").val();
      alert(appointment_type);
      if(appointment_type == undefined){
        alert("Select meeting duration first");
      }else{
        $.ajax({
          url: "{{ url('professional/fetch-available-slots') }}",
          dataType: 'json',
          type: 'POST',
          data:{
            _token:csrf_token,
            location_id: "{{$location_id}}",
            professional:"{{$subdomain}}",
            date:info.start.format('YYYY-MM-DD'),
            schedule_id:info.id,
            appointment_type_id:appointment_type
          },
          success: function(response) {
           schedule = response.schedule;
            callback(schedule);
          }
        });
      }
    }
  });
  
}
</script>

@endsection