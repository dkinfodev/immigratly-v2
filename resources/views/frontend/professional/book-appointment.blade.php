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
  .book-steps{
    display:none;
  }
</style>

<div class="container space-bottom-2 ">
  <div class="w-lg-100 ">
      <div class="row">
       
        <div class="col-lg-12">
          <!-- Card -->
          <div class="float-right mb-3">
            <div class="mb-3">
                  <h3 class="text-danger">Charge:<span class="service_price">N/A</span></h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="book-steps bs-step-1" style="display:block">
              <div class="card mb-3 mb-lg-5">
                @if($action != 'edit')
                <div class="d-block mt-2" style="margin-left:10px">
                  <a href="{{ baseUrl('/professional/'.$subdomain.'/appointment-services/'.$location_id) }}" class="text-danger"><i class="fa fa-angle-left"></i> Back To Service</a>
                </div>
                @endif
                <div class="card-header">
                  <h5 class="card-header-title float-left">
                    @if($action == 'edit')
                      Edit your appointment for {{$service->visa_service->name}} dated on {{dateFormat($appointment->appointment_date)}}
                      <div class="mt-2">
                        <span class="text-danger"><b>Duration:</b>{{$appointment->meeting_duration}} Minutes</span>
                        <span class="text-danger"> | <b>Time:</b>{{$appointment->start_time}} to {{$appointment->end_time}}</span>
                      </div>
                    @else
                    Book your appointment for {{$service->visa_service->name}}
                    @endif
                  </h5>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="card-body">
                  <div class="row w-100">
                    @foreach($appointment_types as $key => $type)
                    @if(isset($type['service_prices']) && !empty($type['service_prices']))
                    <div class="col-sm-4 appointment_types">
                      <div class="card text-center">
                          <div class="card-body p-2">
                              <h3>{{$type['name']}}</h3>
                           
                              <h4>{{$type['time_duration']['name']}}</h4>
                              <h5 class="text-danger">
                                @if($type['service_prices']['price'] != 0)
                                  {{currencyFormat($type['service_prices']['price'])}}
                                @else
                                  Free
                                  @endif
                              </h5>
                          </div>
                          <div class="card-footer p-2">
                                <div class="form-group">
                                <!-- Checkbox -->
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio-{{$key}}" class="custom-control-input" onchange="selectDuration(this)" name="appointment_type" value="{{$type['unique_id']}}">
                                        <label class="custom-control-label" for="customRadio-{{$key}}">Select Type</label>
                                    </div>
                                    <input type="radio" style="display:none" name="break_time" class="break_time" value="{{$type['time_duration']['break_time'] }}" />
                                    <input type="radio" style="display:none" name="price" class="price" value="{{$type['service_prices']['price'] }}" />
                                    <!-- End Checkbox -->
                                </div>
                          </div>
                      </div>
                    </div>
                    @endif
                    @endforeach
                    <hr>
                    <div class="col-sm-12 mb-5">
                    <!-- Fullcalendar-->
                    @if(!empty($appointment_types))
                        <div id="calendar"></div>
                    @else
                      <div class="text-center h3">No Booking Slots Available</div>
                    @endif
                    </div>
                  </div>
                  </div>
                  <!-- End Row -->
                </div>
              </div>
          </div>
          <div class="book-steps bs-step-2">
                <div class="booking-slots"></div>
          </div>
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
@if($type != 'services')
$(document).ready(function() {
  loadCalendar();
  $("input[name=visa_service]").change(function(){
    $(".continuebtn").removeAttr("disabled");
  });
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
      var price = $("input[name=price]:checked").val();
      if(appointment_type == undefined){
        alert("Select meeting duration first");
      }else{
        
        var url = "{{ baseUrl('professional/fetch-available-slots') }}";
        var param = {
            _token:"{{csrf_token()}}",
            location_id: "{{$location_id}}",
            professional:"{{$subdomain}}",
            date:info.start.format('YYYY-MM-DD'),
            schedule_id:info.id,
            time_type:info.time_type,
            service_id:"{{ $service->unique_id}}",
            appointment_type_id:appointment_type,
            break_time:break_time,
            price:price,
            action:"{{$action}}",
            eid:"{{$eid}}",
          };
          // showPopup(url,"post",param);
          $.ajax({
          url: url,
          dataType: 'json',
          type: 'POST',
          beforeSend:function(){
            showLoader();
          },
          data:param,
          success: function(response) {
            hideLoader();
            $(".book-steps").hide();
            $(".bs-step-2").show();
            $(".booking-slots").html(response.contents);
          }
        });
      }
    }
  });
  
}
@else
$(document).ready(function() {
  $("input[name=visa_service]").change(function(){
    $(".continuebtn").removeAttr("disabled");
  });
});
@endif

function selectService(){
  var current_url = "{{ URL::current() }}";
  var service_id = $("input[name=visa_service]:checked").val();
  if(service_id != '' && service_id != undefined){
    window.location.href = current_url+"?service_id="+service_id;
  }else{
    errorMessage("Select service to continue");
  }
}

function selectDuration(e){
  // $(".break_time").attr("disabled","disabled");
  $(e).parents(".card-footer").find(".break_time").prop("checked",true);
  $(e).parents(".card-footer").find(".price").prop("checked",true)
  var price = $(e).parents(".card-footer").find(".price").val();
  $(".service_price").html("{{currencyFormat()}}"+price);
  
}
</script>

@endsection