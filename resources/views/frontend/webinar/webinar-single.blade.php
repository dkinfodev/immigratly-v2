@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')

<link rel="stylesheet" href="assets/frontend/vendor/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.css">

@endsection

@section('content')


<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-90 mx-lg-auto">
        
        <h4 class="h4 text-white mb-4">{{$webinar->Category->name}}</h4>
        <h1 class="h1 text-white mb-4">{{$webinar->title}} </h1>
        
      </div>
    </div>
  </div>
</div>
<!-- End Search Section -->




    <div class="container space-top-1 space-bottom-2 space-top-lg-2">

         <!-- User Profile Section -->
    <div class="container space-top-1 space-bottom-2">
      <div class="border-bottom w-md-75 w-lg-90 space-bottom-2 mx-md-auto">
        <div class="media d-block d-sm-flex">
          <div class="position-relative mx-auto mb-3 mb-sm-0 mr-sm-4" style="width: 160px; height: 160px;">
            <img class="img-fluid rounded-circle" src="assets/frontend/img/160x160/img1.jpg" alt="Image Description" width="160" height="160">
            <img class="bg-white position-absolute bottom-0 right-0 rounded-circle p-1" src="assets/frontend/svg/illustrations/top-vendor.svg" alt="Icon" width="36" height="36" title="Top Writer">
          </div>

          <div class="media-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h1 class="h3">Hanna Wolfe</h1>
              <div class="d-block">
                <button type="button" class="btn btn-xs btn-outline-primary font-weight-bold text-nowrap ml-1">Follow</button>
              </div>
            </div>

            <div class="row text-body font-size-1 mb-2">
              <div class="col-auto">
                <span class="h6">906</span>
                <span>Posts</span>
              </div>
              <div class="col-auto">
                <span class="h6">19.5k</span>
                <span>Followers</span>
              </div>
              <div class="col-auto">
                <span class="h6">109</span>
                <span>Following</span>
              </div>
            </div>

            <p class="mb-0">
              {{$webinar->short_description}} <br><br>
              Link to Join <a class="font-weight-bold" href="#">hannawolfe.com</a></p>
          </div>
        </div>
      </div>
    </div>
    <!-- End User Profile Section -->

      <div class="row">
      <div class="col-md-8">
      <div class="w-lg-90 mx-lg-auto text-justify">
        <p class="text-danger">{{$webinar->short_description}}</p> 

        <span class="h3">Webinar Date - {{$webinar->webinar_date}} </span> 
        <span class="h4 text-primary"> from {{$webinar->start_time}} to {{$webinar->end_time}} </span><br>
        <br>
        {!! $webinar->description !!}
        <br><br>
        Tags : 
        <span class="badge badge-secondary">{{$webinar->Category->name}}</span>
        <span class="badge badge-secondary">{{$webinar->Category->name}}</span>
        <span class="badge badge-secondary">{{$webinar->Category->name}}</span>
      </div> 
      </div>

      <div class="col-md-4 space-top-3 space-bottom-2 text-center">

        @if($webinar->paid_event == 1)
          <span class="h2 text-success">{{$webinar->price_group}}</span>          <br>
          <span class="h3"><i class="fa fa-rupee-sign"></i> {{$webinar->event_cost}}</span>

        @endif

      </div>
    </div>

    </div>  


@endsection

@section('javascript')
  <script src="assets/frontend/vendor/slick-carousel/slick/slick.js"></script>
  <script src="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.js"></script>

  <!-- JS Front -->
  <script src="assets/frontend/js/theme.min.js"></script>

  <!-- JS Plugins Init. -->
  <script>
    $(window).on('load', function () {

      // INITIALIZATION OF FORM VALIDATION
      // =======================================================
      $('.js-validate').each(function () {
        var validation = $.HSCore.components.HSValidation.init($(this));
      });


      // INITIALIZATION OF SLICK CAROUSEL
      // =======================================================
      $('.js-slick-carousel').each(function() {
        var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
      });


      // INITIALIZATION OF GO TO
      // =======================================================
      $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
      });
    });
  </script>

@endsection