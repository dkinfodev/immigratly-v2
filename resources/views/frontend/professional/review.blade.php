@extends('frontend.layouts.master')
<!-- Hero Section -->
@section('styles')

@endsection

@section('content')


<style>
.blk{
  width: 100%;
}
.customer-rating
{
  font-size: 30px;
}
.rating {
  display: inline-block;
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
  text-align: right;
}

.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
  font-size: 33px;
}

.rating label:last-child .icon {
  color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: #fd7e14;
}

.active{
  color: #fd7e14;
}
.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #fd7e14;
}

</style>


<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;padding-bottom: 30px;">
    <div class="container space-1">
      <div class="w-lg-100 mx-lg-auto">
        <!-- Input -->
        <h1 class="text-lh-sm text-white">Professionals</h1>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<div class="container space-bottom-2">
    <div class="p-5 mt-5">
    <!-- Breadcrumbs -->
    <!-- Breadcrumbs -->
    <!-- <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('/professionals')}}">Professionals</a></li>

        <li class="breadcrumb-item active">Leave a Review</li>
      </ol>
    </nav> -->
    <!-- End Breadcrumbs -->

    <!-- End Breadcrumbs -->

    
    <!-- Content Section -->

    <div class="container space-1 space-top-lg-1 space-bottom-lg-2 mt-lg-n10">

      <div class="row">

      <div class="col-12">
        
        <div class="card card-bordered custom-content-card mt-5 p-5 mb-5">

          <div class="col-md-12">
            <div class="row">
              <div class="col-md-2 text-center">
                {{-- <img class="img-fluid w-100 rounded-lg" src="{{userProfile($record->id)}}" alt="Image Description"> --}}
                <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo('m','fastzone')}}" alt="Image Description">

                <span class="text-center">{{$record->first_name}} {{$record->last_name}}</span>
           
              </div>
              <div class="col-md-9 pl-5">

                <h3><img class="verified-badge" src="./assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified user" aria-describedby="tooltip851946">
                  {{ $professionalDetails->company_name }}</h3>
                  <br>
                  <div class="row">
                    <div class="col-6">
                      <i class="fas fa-map-marker-alt nav-icon"></i> 

                      {{ getCountryName($professionalDetails->country_id) }}

                      <br>
                      <i class="tio-globe nav-icon"></i> 
                      <?php
                      // $languages_known = json_decode($record->languages_known,true);
                      // $cnt = -1;
                      // foreach ($languages_known as $key => $lb) {
                      //   $cnt++;
                      // }  
                      // foreach ($languages_known as $key => $lb) {
                      //   $languages = getLanguageName($lb);
                      //   echo $languages;
                      //   if($key < $cnt){
                      //     echo ", ";
                      //   }
                      // }
                      ?>            
                    </div>
                    <div class="col-6">
                      <i class="fas fa-info nav-icon"></i> RIC ID - unknown
                      <br>
                      <i class="tio-call nav-icon"></i> {{ $professionalDetails->country_code }} {{ $professionalDetails->phone_no }}

                    </div>

                  </div>
                  <br>

                  <a class="btn btn-primary" href="{{url('professional/'.$record->unique_id)}}">More Details</a>

                </div>
              </div>
            </div>
          </div>

        </div>


        <div class="col-lg-8">
          <!-- Navbar -->
          <div class="navbar-expand-lg navbar-expand-lg-collapse-block navbar-light">
            <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
              <!-- Card -->
              <div class="card mb-5 w-100">
                <div class="card-body">

                  <form method="post" id="form2" action="{{ url('professional/send-review/'.$unique_id) }}" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  
                  <div class="form-group blk js-form-message">
                        <div class="rating">
                        <label>
                          <input type="radio" name="stars" value="1" />
                            <span class="icon"><i class="fa fa-star"></i></span>
                          </label>
                          <label>
                            <input type="radio" name="stars" value="2" />
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                          </label>
                          <label>
                            <input type="radio" name="stars" value="3" />
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>   
                          </label>
                          <label>
                            <input type="radio" name="stars" value="4" />
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                          </label>
                          <label>
                            <input type="radio" name="stars" value="5" />
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                            <span class="icon"><i class="fa fa-star"></i></span>
                          </label>
                        </div>
                   </div>     
                  <input type="hidden" name="rating" id="rating" class="form-control" /> 
                  <div class="form-group js-form-message">
                    <label>Review</label>
                    <textarea name="review" id="review" class="form-control" rows="5"></textarea>
                    @if($errors->has('review'))
                    <span class="help-block text-danger">
                      <strong>{{ $errors->first('review') }}</strong>
                    </span>
                    @endif   
                  </div>

                  <div class="form-group">
                  <input type="checkbox" name="chkagree" id="chkagree"> &nbsp; I have read and agree to the <a>Customer Review Submission Terms</a>
                  </div>

                  <input type="submit" name="btnsave" id="btnsave" class="btn btn-primary mt-5" value="Leave your review">
                  </form>

                </div>
              </div><!-- End Card -->
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <!-- Card -->
          <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
              <h5 class="card-header-title">Customer Review Ratings</h5>
            </div>
            <!-- End Header -->
            <!-- Body -->
            <div class="card-body">
              
              <div class="customer-rating">
                
                <?php

                if(!empty($avgRating)){
                  $total = 5 - $avgRating;  
                    if($avgRating>0){
                      for($i=0;$i<$avgRating;$i++) {
                        echo '<i class="fa fa-star active"></i>';
                      }
                    }
                }
                
                if($total > 0){
                  for($i=0;$i<$total;$i++) {
                      echo '<i class="fa fa-star"></i>';
                  }
                }  
                ?>
                

                <span class="rating-head text-black h2">{{$avgRating}}/5</span>
                
              </div>
              <p>Average of {{$totaluser}} Customer Reviews</p>
            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->

        </div>

        @foreach($reviewData as $key=>$review)
          <div class="col-lg-8 mb-2">
          <div class="card card-bordered">
            <div class="card-body">

              <div class="micro-customer-rating">
                
                <?php $total = 5; $rating = $review->rating; $und = $total - $rating; ?>
                
                <?php
                  if($rating > 0){
                    for($i=0;$i<$rating;$i++){
                      echo '<i class="fa fa-star active"></i>';
                    }
                  }  
                ?>

                <?php
                  if($und > 0){
                    for($i=0;$i<$und;$i++){
                      echo '<i class="fa fa-star"></i>';
                    }
                  }  
                ?>
                
              </div>
              <p>
              {{$review->review}}
              </p>
              <br>
              - By {{$review->UserDetail($review->user_id)}}
            </div>
          </div>
        </div>
        @endforeach
       
  </div>
  <!-- End Row -->
</div>
<!-- End Content Section -->



</div>
@endsection

@section("javascript")
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>



<script>

$(':radio').change(function() {
  //console.log('New star rating: ' + this.value);
  $("#rating").val(this.value);
});

  $("#form2").submit(function(e){
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    var url  = $("#form2").attr('action');
    $.ajax({
      url:url,
      type:"post",
      data:formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      beforeSend:function(){
        showLoader();
      },
      success:function(response){
        hideLoader();  
        if(response.status == true){
          successMessage(response.message);
          window.location.href = response.redirect_back;
        }else{
          validation(response.message);
        }
      },
      error:function(){
        internalError();
      }
    });
  });

</script>
@endsection