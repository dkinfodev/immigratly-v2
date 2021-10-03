@extends('frontend.layouts.master')
<!-- Hero Section -->
@section('style')

<link rel="stylesheet" href="assets/frontend/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
<link rel="stylesheet" href="assets/frontend/vendor/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="assets/frontend/vendor/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.css">

@endsection

@section('content')

<!-- Search Section -->
<div class="bg-dark">
    <div class="bg-img-hero-center"
        style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
        <div class="container space-1">
            <div class="w-lg-90 mx-lg-auto">

                <h2 class="h1 text-white">Join Our Webinars</h2>

            </div>
        </div>
    </div>
</div>
<!-- End Search Section -->


<!-- Courses Section -->
<div class="container space-2 space-top-lg-1 space-bottom-lg-1">
    <div class="row">
        <div class="col-lg-3 mb-5 mb-lg-0">
            <div class="navbar-expand-lg navbar-expand-lg-collapse-block">
                <!-- Responsive Toggle Button -->
                <button type="button" class="navbar-toggler btn btn-block border py-3" aria-label="Toggle navigation"
                    aria-expanded="false" aria-controls="sidebarNav" data-toggle="collapse" data-target="#sidebarNav">
                    <span class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">View all categories</span>
                        <span class="navbar-toggler-default">
                            <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor"
                                    d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z" />
                            </svg>
                        </span>
                        <span class="navbar-toggler-toggled">
                            <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor"
                                    d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                            </svg>
                        </span>
                    </span>
                </button>
                <!-- End Responsive Toggle Button -->

                <div id="sidebarNav" class="collapse navbar-collapse">
                    <div class="mt-5 mt-lg-0">

                        <h2 class="h4"><a class="text-inherit">Filter By Category</a></h2>


                        @foreach($services as $service)
                        <a class="dropdown-item d-flex justify-content-between align-items-center px-0"
                            href="{{url('webinars/'.$service->slug)}}">
                            {{$service->name}}
                        </a>
                        @endforeach

                    </div>


                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <!-- Filter -->
            <div class="border-bottom pb-3 mb-5">
                <div class="row justify-content-md-start align-items-md-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <p class="font-size-1 mr-md-auto mb-0"><span class="text-dark font-weight-bold">195
                                courses</span> to get started</p>
                    </div>
                </div>
            </div>
            <!-- End Filter -->

            @foreach($webinars as $key=>$webinar)
            <!-- Card -->
            <a class="d-block border-bottom pb-5 mb-5" href="{{url('webinar/'.$webinar->slug)}}">
                <div class="row mx-md-n2">
                    <div class="col-md-4 px-md-2 mb-3 mb-md-0">
                        <div class="position-relative">
                            <?php
                  if($webinar->images != ''){
                    $images = explode(",",$webinar->images);
                      if(file_exists(public_path('uploads/articles/'.$images[0]))){
                          $image = url('public/uploads/articles/'.$images[0]);
                      }
                      else
                      {
                       $image = "assets/frontend/img/500x280/img9.jpg"; 
                      }
                    }else{
                    $image = "assets/frontend/img/500x280/img9.jpg";
                  } ?>

                            <img class="card-img-top" src="{{$image}}">

                            <div class="position-absolute top-0 left-0 mt-1 ml-3">
                                <small  class="btn btn-xs btn-success btn-pill text-uppercase shadow-soft py-1 px-2 mb-3">
                                    @if(!empty($webinar->Category))
                                    {{$webinar->Category->name}}
                                    @else
                                    N/A
                                    @endif
                                </small>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="media mb-2">
                            <div class="media-body mr-7">
                                <h3 class="text-hover-primary">
                                    {{ substr($webinar->title,0,100) }}<?php if(strlen($webinar->title)>100){echo "...";} ?>
                                </h3>
                            </div>

                            <!--
                  <div class="d-flex mt-1 ml-auto">
                    <div class="text-right">
                      <small class="d-block text-muted text-lh-sm"><del>$114.99</del></small>
                      <span class="d-block h5 text-primary text-lh-sm mb-0">$99.99</span>
                    </div>
                  </div>-->
                        </div>

                        <div class="d-flex justify-content-start align-items-center small text-muted mb-2">
                            <!--
                  <div class="d-flex align-items-center">
                    <div class="avatar-group">
                      <span class="avatar avatar-xs avatar-circle" data-toggle="tooltip" data-placement="top" title="Nataly Gaga">
                        <img class="avatar-img" src="assets/frontend/img/100x100/img1.jpg" alt="Image Description">
                      </span>
                    </div>
                  </div>
                  <div class="ml-auto">
                    <i class="fa fa-book-reader mr-1"></i>
                    10 lessons
                  </div>
                  <span class="text-muted mx-2">|</span>
                  <div class="d-inline-block">
                    <i class="fa fa-clock mr-1"></i>
                    3h 25m
                  </div>
                  <span class="text-muted mx-2">|</span>
                  <div class="d-inline-block">
                    <i class="fa fa-signal mr-1"></i>
                    All levels
                  </div>-->
                        </div>

                        <p class="font-size-1 text-body mb-0">{!! substr($webinar->short_description,0,300)
                            !!}<?php if(strlen($webinar->short_description)>300){echo "...";} ?></p>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            @endforeach

        </div>
    </div>
</div>
<!-- End Courses Section -->



@endsection

@section('javascript')

<script src="assets/frontend/vendor/slick-carousel/slick/slick.js"></script>
<script src="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.js"></script>

<script src="assets/frontend/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
<script src="assets/frontend/vendor/select2/dist/js/select2.full.min.js"></script>

<!-- JS Front -->
<script src="assets/frontend/js/theme.min.js"></script>

<!-- JS Plugins Init. -->
<script>
$(window).on('load', function() {

    // INITIALIZATION OF FORM VALIDATION
    // =======================================================
    $('.js-validate').each(function() {
        var validation = $.HSCore.components.HSValidation.init($(this));
    });


    // INITIALIZATION OF SLICK CAROUSEL
    // =======================================================
    $('.js-slick-carousel').each(function() {
        var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
    });


    // INITIALIZATION OF GO TO
    // =======================================================
    $('.js-go-to').each(function() {
        var goTo = new HSGoTo($(this)).init();
    });
});
</script>

@endsection