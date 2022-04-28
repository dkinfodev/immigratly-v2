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
          <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Choose Visa Service for Booking Appointment</h3>
                </div>
                <div class="card-body">
                    @if(Session::has('error_message'))
                        <div class="alert alert-warning text-center"><i class="fa fa-warning"></i> {{ Session::get("error_message") }}</div>
                    @endif
                    <div class="form-group row">
                        <label class="custom-label mb-2 font-bold">
                          <strong>Select Visa Service</strong>
                        </label>
                        <div class="col-md-12">
                            <div class="visa-services">
                                @if(!empty($visa_services))
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <th>&nbsp;</th>
                                        <th>Visa Service</th>
                                        <!-- <th>Price</th> -->
                                    </thead>
                                    <tbody>
                                        @foreach($visa_services as $key => $service)
                                          <tr>
                                              <th width="5%" class="text-center">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="vs-{{$key}}" class="custom-control-input" name="visa_service" value="{{$service['unique_id']}}">
                                                    <label class="custom-control-label" for="vs-{{$key}}">&nbsp;</label>
                                                </div>
                                              </th>
                                              <td>
                                              {{ $service['visa_service']['name'] }}
                                              </td>
                                              {{--<td>
                                              @if($service['price'] == 0)
                                                  <span class="text-danger"> (Free) </span>
                                              @else
                                              ({{currencyFormat().$service['price']}})
                                              @endif
                                              </td> --}}
                                          </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="float-right">
                                    <button type="button" onclick="selectService()" class="mt-3 btn btn-sm btn-primary continuebtn" disabled>Continue</button>
                                </div>
                                @else
                                  <div class="text-danger text-center">No Service available for Appointment</div>
                                @endif
                            </div>
                            {{-- <select onchange="selectService(this)" class="form-control" name="visa_service">
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
                                  
                            </select> --}}
                        </div>
                    </div>
                  </div>
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
<script>
$(document).ready(function() {
  $("input[name=visa_service]").change(function(){
    $(".continuebtn").removeAttr("disabled");
  });
});

function selectService(){
  var current_url = "{{ baseUrl('professional/'.$subdomain.'/book-appointment/'.$location_id) }}";
  var service_id = $("input[name=visa_service]:checked").val();
  if(service_id != '' && service_id != undefined){
    window.location.href = current_url+"?service_id="+service_id;
  }else{
    errorMessage("Select service to continue");
  }
}

</script>

@endsection