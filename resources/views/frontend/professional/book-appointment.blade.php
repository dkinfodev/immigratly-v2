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

<div class="container space-bottom-2 ">
  <div class="w-lg-100 ">
      <div class="row">
        @if($type == 'services')
            <div class="col-md-12">
                <div class="card mb-3">
                  <div class="card-header">
                      <h3 class="card-title">Choose Visa Service for Booking Appointment</h3>
                  </div>
                  <div class="card-body">
                      <div class="form-group row">
                          <label class="custom-label pt-2 col-md-2">Select Visa Service</label>
                          <div class="col-md-10">
                              <select onchange="selectService(this)" class="form-control" name="visa_service">
                                  <option value="">Select Service </option>
                                    @foreach($visa_services as $key => $service)
                                      <option value="{{$service['unique_id']}}">{{$service['visa_service']['name']}} 
                                        @if($service['price'] == 0)
                                            (Free)
                                        @else
                                        ({{currencyFormat().$service['price']}})
                                        @endif
                                      </option>
                                    @endforeach
                                    
                              </select>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        @else
        <div class="col-lg-12">
          <!-- Card -->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title float-left">Book your appointment for {{$service->visa_service->name}}</h5>
              <h3 class="float-right text-danger">Charge:
                @if($service->price == 0)
                  Free
                @else
                {{currencyFormat().$service->price}}
                @endif
              </h3>
              <div class="clearfix"></div>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
              <div class="row">
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
                                    <input type="radio" id="customRadio-{{$key}}" class="custom-control-input" onchange="selectDuration(this)" name="appointment_type" value="{{$type['unique_id']}}">
                                    <label class="custom-control-label" for="customRadio-{{$key}}">Select Type</label>
                                </div>
                                <input type="radio" style="display:none" name="break_time" class="break_time" value="{{$type['time_duration']['break_time'] }}" />
                                <!-- End Checkbox -->
                            </div>
                      </div>
                  </div>
                </div>
                @endforeach

                <hr>

                <div class="col-sm-12 mb-5">
                 <!-- Fullcalendar-->
                 @if(!empty($appointment_types))
                 <div id="calendar"></div>
                 @else
                  <div class="text-center h3">No Booking Slots Available</div>
                 @endif
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
        @endif
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
@if($type != 'services')
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
          url: "{{ baseUrl('professional/fetch-hours') }}",
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
            month:month
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
        
        var url = "{{ baseUrl('professional/fetch-available-slots') }}";
        var param = {
            location_id: "{{$location_id}}",
            professional:"{{$subdomain}}",
            date:info.start.format('YYYY-MM-DD'),
            schedule_id:info.id,
            time_type:info.time_type,
            service_id:"{{ $service->unique_id}}",
            appointment_type_id:appointment_type,
            break_time:break_time
          };
        showPopup(url,"post",param);
        // $.ajax({
        //   url: "{{ url('professional/fetch-available-slots') }}",
        //   dataType: 'json',
        //   type: 'POST',
        //   data:{
        //     _token:csrf_token,
        //     location_id: "{{$location_id}}",
        //     professional:"{{$subdomain}}",
        //     date:info.start.format('YYYY-MM-DD'),
        //     schedule_id:info.id,
        //     appointment_type_id:appointment_type
        //   },
        //   success: function(response) {
        //    schedule = response.schedule;
        //     callback(schedule);
        //   }
        // });
      }
    }
  });
  
}
@endif
function selectService(e){
  var current_url = "{{ URL::current() }}";
  if($(e).val() != ''){
    window.location.href = current_url+"?service_id="+$(e).val();
  }else{
    window.location.href = current_url;
  }
}

function selectDuration(e){
  // $(".break_time").attr("disabled","disabled");
  $(e).parents(".card-footer").find(".break_time").prop("checked",true)
}
</script>

@endsection