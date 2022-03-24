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
        <div class="col-lg-5">
          <!-- Navbar -->
          <div class="navbar-expand-lg navbar-expand-lg-collapse-block navbar-light">
            <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
              <!-- Card -->
              <div class="card mb-5">
                <div class="card-body">
                 
                  <div class="row">
                   <div class="col-md-4">
                    <div class="d-none d-lg-block mb-5">
                       <!-- Avatar -->
                      <div class="avatar avatar-xxl avatar-circle mb-3">
                        <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo('m',$professional->subdomain)}}" alt="Image Description">
                        <img class="avatar-status avatar-lg-status" src="./assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-toggle="tooltip" data-placement="top" title="Verified user">
                      </div>
                      <!-- End Avatar -->
                    </div>
                   </div>
                   <div class="col-md-8">

                      <h4 class="card-title h3">{{$company_data->company_name}}</h4>
                      <p class="card-text font-size-1">{{$company_data->email}}</p>
                      <p class="card-text font-size-1">Immigration Consultant of Canada</p>
                      <p class="card-text">Rating:N/A</p>
                      
                   </div> 
                    
                    
                  </div>

                  <hr>
                  <p class="font-size-2" style="color:#000;">
                  <i class="fa fa-map-marker nav-icon font-size-2"></i>
                    {{ getCountryName($company_data->country_id)}}
                  </p>

                  <hr>
                  <a href="tel:{{$company_data->country_code}} {{$company_data->phone_no}}" class="btn btn-outline btn-primary btn-block"><i class="tio-call nav-icon"></i>{{$company_data->country_code}} {{$company_data->phone_no}}</a>   
                  
                  <hr>
                  <div class="sharing-icons">
                  <p><i class="fa fa-share"></i> Share this profile</p>
                    <a class="btn btn-primary" href="www.facebook.com" style="margin-left: 10px;margin-right: 10px;"><i class="fa fa-facebook" style="font-size: 20px;padding-top:4px;"></i></a>


                    <a class="btn btn-info"  href="www.facebook.com" style="margin-left: 10px;margin-right: 10px;"><i class="fa fa-twitter" style="font-size: 20px;padding-top:4px;"></i></a>

                    
                    <a class="btn btn-warning"  href="www.facebook.com" style="margin-left: 10px;margin-right: 10px;"><i class="fa fa-envelope" style="font-size: 20px;padding-top:4px;"></i></a>


                    <a class="btn btn-primary bg-navy"  href="www.facebook.com" style="margin-left: 10px;margin-right: 10px;"><i class="fa fa-linkedin" style="font-size: 20px;padding-top:4px;"></i></a>


                    <a class="btn btn-secondary"  href="www.facebook.com" style="margin-left: 10px;margin-right: 10px;"><i class="fa fa-link" style="font-size: 20px;padding-top:4px;"></i></a>

                  </div>
                </div>
              </div>
              <!-- End Card -->
            </div>
          </div>
          <!-- End Navbar -->
        </div>

        <div class="col-lg-7">
          <!-- Card -->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">About</h5>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 mb-5">
                  <h5>Languages Known</h5>
                  <?php
                  $languages_known = json_decode($professionalAdmin->languages_known,true);
                  $cnt = -1;
                  foreach ($languages_known as $key => $lb) {
                    $cnt++;
                  }  
                  foreach ($languages_known as $key => $lb) {
                    $languages = getLanguageName($lb);
                    echo $languages;
                    if($key < $cnt){
                      echo ", ";
                    }
                  }
                  ?>
                </div>

                <hr>
                <div class="col-sm-12 mb-5">
                  <h5>Licence Body</h5>
                  <?php
                  if(!empty($company_data->license_body)){
                    $license_body = json_decode($company_data->license_body,true);
                    foreach ($license_body as $key => $lb) {
                      $licenceBody = getLicenceBodyName($lb);
                      echo $licenceBody ."<br>";
                    }
                  }else{
                    echo "<span class='text-danger'>N/A</span>";
                  }
                  ?>
                </div>

                <hr>
                <div class="col-sm-12 mb-5">
                  <h5>Experience</h5>
                  {{$company_data->years_of_expirences}}
                </div>

                <hr>
                <div class="col-sm-12 mb-5">
                  <h5>Member of other designated body</h5>
                  {{$company_data->member_of_other_designated_body}}
                </div>

                <hr>
                <div class="col-sm-12 mb-5">
                  <h5>Member of good standing</h5>
                  {{$company_data->member_of_good_standing}}
                </div>


              </div>
              <!-- End Row -->

            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->

          <!-- Card Contact-->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">Contact</h5>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
              <div class="row">
                
                <div class="col-md-12">
                  
                  @if(!empty($company_data->locations))
                  <table class="table table-striped">
                  @foreach($company_data->locations as $location)
                  <tr>
                    <td>{{$location->address}}</td>
                    <td align="right">
                        @if(Auth::check())
                        <a href="{{ baseUrl('professional/'.$subdomain.'/book-appointment/'.$location->unique_id) }}" class="btn btn-primary btn-sm">Book Appointment</a>
                        @else
                        <a href="{{ url('login') }}" class="text-primary">Login to Book Appointment</a>
                        @endif
                    </td>
                  </tr>
                  @endforeach
                </table>
                  @else
                  No Location Selected
                  @endif
                </div>
                
                <!-- <div class="col-md-6">
                  <p><b>Business Name</b> - {{$company_data->company_name}}</p>

                  <p><b>Address</b> - {{ $company_data->address}} {{ getCityName($company_data->city_id)}}, {{ getStateName($company_data->state_id)}}, {{ getCountryName($company_data->country_id)}} - {{ $company_data->zip_code}}</p>

                  <p></p>


                  <a href="tel:{{$company_data->country_code}} {{$company_data->phone_no}}" class="btn btn-outline-primary btn-sm  btn-block"><i class="tio-call nav-icon"></i>{{$company_data->country_code}} {{$company_data->phone_no}}</a>   
                  
                </div> -->

              </div>
              <!-- End Row -->

            </div>
            <!-- End Body -->
          </div>
          <!-- End Contact Card -->

          <!-- Card Resume-->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">Resume</h5>
            </div>
            <!-- End Header -->
            <!-- Body -->
            <div class="card-body">
                No Resume posted yet.    
            
            </div>
            <!-- End Body -->
          </div>
          <!-- End Resume Card -->

          <!-- Card Review-->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">Reviews</h5>
            </div>
            <!-- End Header -->
            <!-- Body -->
            <div class="card-body">

               <?php $checkForReview = checkReview($professional->unique_id); ?>

                @if($checkForReview > 0)
                  {{$checkForReview}} Reviews

                @else
                  <p>No Reviews posted yet.</p>
                @endif  

                @if(\Auth::check())
                  <p class="mt-3">
                  <a href="{{url('professional/write-review/'.$professional->unique_id)}}" class="btn btn-outline-primary">Write Review</a></p>
                @else

                  <p class="text-danger">Login to write review</p>
                @endif

            </div>
            <!-- End Body -->
          </div>
          <!-- End Review Card -->

          <!-- Card Review-->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">Costs</h5>
            </div>
            <!-- End Header -->
            <!-- Body -->
            <div class="card-body">
               
                <a class="btn btn-outline-primary">Contact for detail</a>
            
            </div>
            <!-- End Body -->
          </div>
          <!-- End Review Card -->
        </div>
      </div>
    <!-- End Content Section -->
  </div>
</div>
@endsection

@section("javascript")
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>


<script>


</script>
@endsection