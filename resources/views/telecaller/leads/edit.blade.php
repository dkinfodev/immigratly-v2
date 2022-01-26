@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/leads') }}">Leads</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{baseUrl('/leads')}}">
          <i class="tio mr-1"></i> Back 
        </a>
@endsection

@section('content')
<!-- Content -->
<div class="leads">
 

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="form" class="js-validate" action="{{ baseUrl('/leads/edit/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="row justify-content-md-between">
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">First name</label>
              <input type="text" class="form-control form-control-hover-light" id="first_name" placeholder="Your first name" name="first_name"  data-msg="Please enter your first name" aria-label="Your first name" value="{{ $record->first_name }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Last name</label>
              <input type="text" class="form-control form-control-hover-light" id="last_name" placeholder="Your last name" data-msg="Please enter your last name" name="last_name" aria-label="Your last name" value="{{ $record->last_name }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Email</label>
              <input type="email" name="email" placeholder="Your email" value="{{ $record->email }}" data-msg="Please enter your email" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Phone No</label>
              <div class="row">
                <div class="col-sm-3">
                  <div class="js-form-message">
                    <select name="country_code" id="country_code" data-msg="Please choose country code" class="form-control">
                      <option value="">Select Country</option>
                      @foreach($countries as $country)
                      <option {{$record->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="js-form-message">
                    <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" data-msg="Please enter your phone number." value="{{$record->phone_no}}">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Date of Birth</label>
              <input type="text" name="date_of_birth" placeholder="Your Date of Birth" id="date_of_birth" value="{{ $record->date_of_birth }}" data-msg="Please enter your date of birth" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Gender</label>
              <select name="gender" data-msg="Please select gender" class="form-control">
                <option value="">Select Gender</option>
                <option {{($record->gender == 'male')?'selected':''}} value="male">Male</option>
                <option {{($record->gender == 'female')?'selected':''}} value="female">Female</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Country</label>
              <select name="country_id" id="country_id" onchange="stateList(this.value,'state_id')" class="form-control">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                <option {{$record->country_id == $country->id?"selected":""}} value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">State</label>
              <select name="state_id" id="state_id" aria-label="State" data-msg="Please select your state" onchange="cityList(this.value,'city_id')" class="form-control">
                <option value="">Select State</option>
                @foreach($states as $state)
                <option {{$record->state_id == $state->id?"selected":""}} value="{{$state->id}}">{{$state->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">City</label>
              <select name="city_id" id="city_id"  aria-label="City" data-msg="Please select your city" class="form-control">
                <option value="">Select City</option>
                @foreach($cities as $city)
                <option {{$record->city_id == $city->id?"selected":""}} value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Address</label>
              <input type="text" name="address" placeholder="Your address" value="{{ $record->address }}" data-msg="Please enter your address" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Zipcode</label>
              <input type="text" name="zip_code" placeholder="Your Zipcode" value="{{ $record->zip_code }}" data-msg="Please enter your zipcode" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="js-form-message form-group">
              <label class="input-label font-weight-bold">Visa Service</label>
              <select name="visa_service_id" id="visa_service_id" class="custom-select">
                <option value="">Select Service</option>
                @foreach($visa_services as $service)
                  @if(!empty($service->Service($service->service_id)))
                    <option {{$record->visa_service_id == $service->unique_id?"selected":""}} value="{{$service->unique_id}}">{{$service->Service($service->service_id)->name}} </option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->
      </form>
      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

@section('javascript')
<script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script type="text/javascript">
    
$(document).on('ready', function () {
  // initialization of quantity counter
  $('.js-quantity-counter').each(function () {
    var quantityCounter = new HSQuantityCounter($(this)).init();
  });
  $('#date_of_birth').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
          url:url,
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){
            showLoader();
          },
          success:function(response){
            hideLoader();
            if(response.status == true){
              successMessage(response.message);
              redirect(response.redirect_back);
            }else{
              validation(response.message);
              // errorMessage(response.message);
            }
          },
          error:function(){
            internalError();
          }
      });
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