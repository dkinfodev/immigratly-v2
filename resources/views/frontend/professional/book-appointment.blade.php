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
                    <div class="js-fullcalendar fullcalendar-custom" data-hs-fullscreen-options='{
                    "initialDate": "2020-09-10"
                    }'></div>
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
<link rel="stylesheet" href="assets/vendor/fullcalendar/main.min.css">
<script src="assets/vendor/fullcalendar/main.min.js"></script>

<script>
   $(document).on('ready', function () {


     var fullcalendaDraggable = $.HSCore.components.HSFullcalendar.init($('.js-fullcalendar'), {
       initialDate: "2020-09-10",
       headerToolbar: {
         left: "prev,next today",
         center: "title",
         right: ""
       },
       editable: false,
       eventContent({event}) {
         return {
           html: `
           <div class='d-flex align-items-center px-2'>
             ${event.extendedProps.image ? `<img class="avatar avatar-xss" src="${event.extendedProps.image}" alt="Image Description">` : ''}
             <span class="fc-event-title fc-sticky">${event.title}</span>
           </div>
           `
         }
       },
       events: [
         {
           "title": "English Lesson",
           "start": "2020-09-03T01:00:00",
           "end": "2020-09-03T02:30:00"
         },
         {
           "title": "Spanish Lesson",
           "start": "2020-09-03T04:00:00",
           "end": "2020-09-03T05:30:00"
         },
         {
           "title": "Javascript Lesson",
           "start": "2020-09-14T01:00:00",
           "end": "2020-09-16T02:30:00"
         },
         {
           "title": "PHP Lesson",
           "start": "2020-09-06T04:00:00",
           "end": "2020-09-09T05:30:00"
         }
       ]
     });
   });
</script>
<script>

$(document).on('ready', function () {
    // initialization of fullcalendar
    // $('.js-fullcalendar').each(function () {
    //   var fullcalendar = $.HSCore.components.HSFullcalendar.init($(this));
    // });
  });
</script>
@endsection