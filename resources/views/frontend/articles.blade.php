@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')

<link rel="stylesheet" href="assets/frontend/vendor/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.css">

@endsection

@section('content')

  <!-- Hero Section -->
    <div class="position-relative bg-primary overflow-hidden">
      <div class="container position-relative z-index-2 space-top-3 space-top-md-4 space-bottom-2 space-bottom-md-3">
        <div class="w-md-80 w-xl-60 text-center mx-md-auto">
          <div class="mb-7">
            <h1 class="h1 text-white mb-4">Read Our Latest Articles </h1>
            <p class="text-white">Latest Updates and Hand-picked Resource</p> 
          </div>
         
        </div>
      </div>

      <!-- SVG Shapes -->
      <figure class="position-absolute top-0 left-0 w-60">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1246 1078">
          <g opacity=".4">
            <linearGradient id="doubleEllipseTopLeftID1" gradientUnits="userSpaceOnUse" x1="2073.5078" y1="1.7251" x2="2273.4375" y2="1135.5818" gradientTransform="matrix(-1 0 0 1 2600 0)">
              <stop offset="0.4976" style="stop-color:#559bff"/>
              <stop offset="1" style="stop-color:#377DFF"/>
            </linearGradient>
            <polygon fill="url(#doubleEllipseTopLeftID1)" points="519.8,0.6 0,0.6 0,1078 863.4,1078   "/>
            <linearGradient id="doubleEllipseTopLeftID2" gradientUnits="userSpaceOnUse" x1="1717.1648" y1="3.779560e-05" x2="1717.1648" y2="644.0417" gradientTransform="matrix(-1 0 0 1 2600 0)">
              <stop offset="1.577052e-06" style="stop-color:#559bff"/>
              <stop offset="1" style="stop-color:#377DFF"/>
            </linearGradient>
            <polygon fill="url(#doubleEllipseTopLeftID2)" points="519.7,0 1039.4,0.6 1246,639.1 725.2,644   "/>
          </g>
        </svg>
      </figure>
      <figure class="position-absolute right-0 bottom-0 left-0 mb-n1">
        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
          <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
        </svg>
      </figure>
      <!-- End SVG Shapes -->
    </div>
    <!-- End Hero Section -->
   
    <div class="container space-top-2 space-top-lg-3">
      <div class="row mb-3">

        @foreach($articles as $key=>$article)
        <div class="col-sm-6 col-lg-4 mb-3 mb-sm-8">
          <!-- Blog Card -->
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

          <article class="card h-100">
            <div class="card-img-top position-relative">
              <img class="card-img-top" src="{{$image}}" alt="Image Description">
              <figure class="ie-curved-y position-absolute right-0 bottom-0 left-0 mb-n1">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
                  <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                </svg>
              </figure>
            </div>

            <div class="card-body">
              <h6 class="text-primary">{{$article->Category->name}}</h6>

              <h3><a class="text-inherit" href="{{url('articles/'.$article->slug)}}">{{ substr($article->title,0,100) }}<?php if(strlen($article->title)>100){echo "...";} ?></a></h3>
              <p class="">{!! substr($article->short_description,0,300) !!}<?php if(strlen($article->short_description)>300){echo "...";} ?></p>
            </div>

            <div class="card-footer border-0 pt-0">
              <div class="media align-items-center">
               
                <div class="media-body d-flex justify-content-end text-muted font-size-1 ml-2">
                  {{date('d-m-Y',strtotime($article->created_at))}}
                </div>
              </div>
            </div>
          </article>
          <!-- End Blog Card -->
        </div>
        @endforeach
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