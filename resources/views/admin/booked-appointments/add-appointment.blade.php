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
  .book-steps{
    display:none;
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
        <div class="col-sm-8 col-md-8 mb-3 mb-sm-0">
          <h5 class="card-header-title">Schedule Appointment</h5>
        </div>
        <div class="col-sm-4 col-md-4">
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="card-body">
        <!-- Step Form -->
      <form id="form" action="{{ baseUrl('booked-appointments/save') }}" class="js-validate js-step-form"
         data-hs-step-form-options='{
         "progressSelector": "#createAppointmentStepFormProgress",
         "stepsSelector": "#createProjectStepFormContent",
         "endSelector": "#createAppointmentBtn",
         "isValidate": true
         }'>
         @csrf
         <!-- Step -->
         <ul id="createAppointmentStepFormProgress" class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createAppointmenStepDetails"
                  }'>
                  <span class="step-icon step-icon-soft-dark">1</span>
                  <div class="step-content">
                     <span class="step-title">Appointment For</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createVisaServiceStepTerm"
                  }'>
                  <span class="step-icon step-icon-soft-dark">2</span>
                  <div class="step-content">
                     <span class="step-title">Visa Service</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createAppointmentDateStepTerm"
                  }'>
                  <span class="step-icon step-icon-soft-dark">3</span>
                  <div class="step-content">
                     <span class="step-title">Appointment Date</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createBookSlot"
                  }'>
                  <span class="step-icon step-icon-soft-dark">4</span>
                  <div class="step-content">
                     <span class="step-title">Book Slots
                     </span>
                  </div>
               </a>
            </li>
         </ul>
         <!-- End Step -->
         <!-- Content Step Form -->
         <div id="createProjectStepFormContent">
            <div id="createAppointmenStepDetails" class="active">
              
               <!-- Form Group -->
               <div class="row p-3 mb-3">
                  <div class="col-md-6">
                      <div class="form-group row js-form-message ">
                        <label class="custom-label col-md-4 pt-2">Appointment for</label>
                        <div class="col-md-8">
                          <select name="appointment_for" required onchange="appointmentFor(this.value)">
                              <option value="">Select Option</option>
                              <option value="leads">Lead</option>
                              <option value="clients">Client</option>
                          </select> 
                        </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group row leads appointment_for  js-form-message" style="display:none">
                        <label class="custom-label col-md-4 pt-2">Select Lead</label>
                        <div class="col-md-8">
                          <select name="user_id" required disabled>
                              <option value="">Select Lead</option>
                              @foreach($leads as $lead)
                              <option value="{{$lead->unique_id}}">{{$lead->first_name." ".$lead->last_name}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group row clients appointment_for js-form-message" style="display:none">
                        <label class="custom-label col-md-4 pt-2">Select Client</label>
                        <div class="col-md-8">
                          <select name="user_id" required disabled>
                              <option value="">Select Client</option>
                              @foreach($clients as $client)
                              <option value="{{$client->master_id}}">{{$client->first_name." ".$client->last_name}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="d-flex align-items-center">
                  
                  <div class="ml-auto">
                    <button type="button" class="btn btn-primary"
                        data-hs-step-form-next-options='{
                        "targetSelector": "#createVisaServiceStepTerm"
                        }'>
                      Next <i class="tio-chevron-right"></i>
                    </button>
                  </div>
              </div>
            </div>
            <div id="createVisaServiceStepTerm" style="display: none;">
              <div class="form-group row js-form-message">
                  <label class="custom-label col-md-3 pt-2">Address</label>
                  <div class="col-md-9">
                    <select name="location_id" id="location_id" required >
                        <option value="">Select Address</option>
                        @foreach($professional_locations as $location)
                        @php 
                        $checkHours = locationHours(\Session::get('subdomain'),$location->unique_id);
                        @endphp
                        @if(!empty($checkHours))
                        <option value="{{$location->unique_id}}">{{$location->address}}</option>
                        @endif
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row js-form-message">
                  <label class="custom-label col-md-3 pt-2"> Visa Service</label>
                  <div class="col-md-9">
                    <select name="visa_service_id" id="visa_service_id" required onchange="appointmentType(this.value)">
                        <option value="">Select Visa Service</option>
                        @foreach($visa_services as $service)
                            @if(!empty($service->Service($service->service_id)))
                        <option value="{{$service->unique_id}}">{{$service->Service($service->service_id)->name}}</option>
                            @endif
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="appointment_types row mb-5">

                        </div>
                    </div>
                </div>
               <!-- Footer -->
               <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createAppointmenStepDetails"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="ml-auto"> 
                     <button type="button" class="btn btn-primary move_to_calendar" style="display:none" onclick="loadCalendar()"
                        data-hs-step-form-next-options='{
                        "targetSelector": "#createAppointmentDateStepTerm"
                        }'>
                     Next <i class="tio-chevron-right"></i>
                     </button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
            <div id="createAppointmentDateStepTerm" style="display:none">
                <div class="mb-3">
                  <div class="calendar_error text-danger"></div>
                  <div id="calendar"></div>
                </div>
                  <!-- Footer -->
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-ghost-secondary mr-2"
                      data-hs-step-form-prev-options='{
                      "targetSelector": "#createVisaServiceStepTerm"
                      }'>
                    <i class="tio-chevron-left"></i> Previous step
                    </button>
                    <div class="ml-auto" style="display:none;">
                      <button type="button" id="book_slot_btn" class="btn btn-primary"
                          data-hs-step-form-next-options='{
                          "targetSelector": "#createBookSlot"
                          }'>
                      Next <i class="tio-chevron-right"></i>
                      </button>
                    </div>
                </div>
                <!-- End Footer -->
            </div>
            <div id="createBookSlot" style="display: none;">
              
               <div class="book-slots"></div>

               <div class="text-danger" id="validation_error"></div>
               <!-- End Toggle Switch -->
               <!-- Footer -->
               <div class="d-sm-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createVisaServiceStepTerm"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="d-flex justify-content-end ml-auto">
                     <button id="createAppointmentBtn" type="button" class="btn btn-primary">Create Appointment</button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
         </div>
         <!-- End Content Step Form -->
         <!-- Message Body -->
         <!-- End Message Body -->
      </form>
      <!-- End Step Form -->
        <!-- <div class="book-steps bs-step-1" style="display:block">
          <div class="row p-3 mb-3">
              <div class="col-md-6">
                  <div class="form-group row">
                    <label class="custom-label col-md-4 pt-2">Appointment for</label>
                    <div class="col-md-8">
                      <select name="appointment_for" onchange="appointmentFor(this.value)">
                          <option value="">Select Option</option>
                          <option value="leads">Lead</option>
                          <option value="clients">Client</option>
                      </select> 
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group row leads appointment_for" style="display:none">
                    <label class="custom-label col-md-4 pt-2">Select Lead</label>
                    <div class="col-md-8">
                      <select name="lead">
                          <option value="">Select Lead</option>
                          @foreach($leads as $lead)
                          <option value="{{$lead->unique_id}}">{{$lead->first_name." ".$lead->last_name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row clients appointment_for" style="display:none">
                    <label class="custom-label col-md-4 pt-2">Select Client</label>
                    <div class="col-md-8">
                      <select name="client">
                          <option value="">Select Client</option>
                          @foreach($clients as $client)
                          <option value="{{$client->unique_id}}">{{$client->first_name." ".$client->last_name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
              </div>
          </div>
        </div> -->
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
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script>
function appointmentFor(value){
  $(".appointment_for").hide();
  $(".appointment_for").find("select").attr("disabled","disabled");
  
  $(".appointment_for").find("select").val("").trigger("change");
  if(value != ''){
    $("."+value).show();
    $("."+value).find("select").removeAttr("disabled");
  }
}
function appointmentType(value){
  if(value != ''){
      $.ajax({
        url:"{{ baseUrl('/booked-appointments/fetch-appointment-types') }}",
        type:"post",
        data:{
          _token:"{{csrf_token()}}",
          visa_service_id:value,
        },
        dataType:"json",
        beforeSend:function(){
          showLoader();
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            $(".appointment_types").html(response.html);
          }else{
            $(".appointment_types").html('');
          }
        },
        error:function(){
          internalError();
        }
    });
  }else{

  }
    
}
$(document).ready(function(){
  $('.js-validate').each(function() {
    $.HSCore.components.HSValidation.init($(this));
  });
  $('.js-step-form').each(function () {
     var stepForm = new HSStepForm($(this), {
       validate: function(){
       },
       finish: function() {
         // $("#createProjectStepFormProgress").hide();
         // $("#createProjectStepFormContent").hide();
         // $("#createProjectStepSuccessMessage").show();
        var formData = $("#form").serialize();
        var url  = $("#form").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
              showLoader();
              $("#validation_error").html('');
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                redirect(response.redirect_back);
              }else{
                $("#validation_error").html(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
       }
     }).init();
  });
  
})
function selectDuration(e){
  // $(".break_time").attr("disabled","disabled");
  $(".move_to_calendar").show();
  $(e).parents(".card-footer").find(".break_time").prop("checked",true);
  $(e).parents(".card-footer").find(".price").prop("checked",true)
  var price = $(e).parents(".card-footer").find(".price").val();
  $(".service_price").html("{{currencyFormat()}}"+price);
  
}

function loadCalendar() {
 var location_id = $("#location_id").val();
 $('#calendar').fullCalendar('destroy');

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
        location_id: location_id,
        year:year,
        start_date:start_date,
        end_date:end_date,
        month:month,
        action:"",
        eid:"",
      },
      success: function(response) {
        hideLoader();
        schedule = response.schedule;
        if(!response.schedule_available){
          $(".calendar_error").html("No schedule available for this location");
        }else{
          $(".calendar_error").html("");
        }
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
  if($("#nocharge").is(":checked")){
    var price = 0;
  }else{
    var price = $("input[name=price]:checked").val();
  }
  if(appointment_type == undefined){
    alert("Select meeting duration first");
  }else{
    var location_id = $("#location_id").val();
    var visa_service_id = $("#visa_service_id").val();
    var url = "{{ baseUrl('booked-appointments/fetch-available-slots') }}";
    var param = {
        _token:"{{ csrf_token() }}",
        location_id:location_id,
        time_slot_for:"add-appointment",
        date:info.start.format('YYYY-MM-DD'),
        schedule_id:info.id,
        time_type:info.time_type,
        price:price,
        service_id:visa_service_id,
        appointment_type_id:appointment_type,
        break_time:break_time,
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
            $("#book_slot_btn").trigger("click");
            $(".book-slots").html(response.contents);
          }error:function(){
            internalError();
          }
        });
  }
}
});
  
}
</script>
@endsection