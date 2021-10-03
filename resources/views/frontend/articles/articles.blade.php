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
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-90 mx-lg-auto">
        
        <h2 class="h1 text-white">Read Our Latest Articles</h2>

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
           
            <!-- End Responsive Toggle Button -->

            <div id="sidebarNav" class="collapse navbar-collapse">
              <div class="mt-5 mt-lg-0">


                <h2 class="h4"><a class="text-inherit">Filter By Category</a></h2>
          
                @foreach($services as $service)
                <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="{{url('articles/'.$service->slug)}}">
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
                <p class="font-size-1 mr-md-auto mb-0"><span class="text-dark font-weight-bold">{{$articles->total()}}</span> articles</p>
              </div>
            </div>
          </div>
          <!-- End Filter -->
          @foreach($articles as $key=>$article)
          <!-- Card -->
          <a class="d-block border-bottom pb-5 mb-5" href="{{url('article/'.$article->slug)}}">
            <div class="row mx-md-n2">
              <div class="col-md-4 px-md-2 mb-3 mb-md-0">
                <div class="position-relative">
                  <?php
                  if($article->images != ''){
                    $images = explode(",",$article->images);
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
                    <small class="btn btn-xs btn-success btn-pill text-uppercase shadow-soft py-1 px-2 mb-3">{{$article->Category->name}}</small>
                  </div>

                </div>
              </div>

              <div class="col-md-8">
                <div class="media mb-2">
                  <div class="media-body mr-7">
                    <h3 class="text-hover-primary">{{ substr($article->title,0,100) }}<?php if(strlen($article->title)>100){echo "...";} ?></h3>
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

                <p class="font-size-1 text-body mb-0">{!! substr($article->short_description,0,300) !!}<?php if(strlen($article->short_description)>300){echo "...";} ?></p>
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