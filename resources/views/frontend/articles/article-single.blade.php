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
        
        <h4 class="h4 text-white mb-4">{{$article->Category->name}}</h4>
        <h1 class="h1 text-white mb-4">{{$article->title}} </h1>
        
      </div>
    </div>
  </div>
</div>
<!-- End Search Section -->




    <div class="container space-top-1 space-bottom-2 space-top-lg-2">


       <div class="w-lg-90 mx-lg-auto text-justify">
      

        <p class="text-primary">{{$article->short_description}}</p> 

        

        <small class="float-right">Added On - {{date('d-m-Y',strtotime($article->created_at))}} </small><br>
        <br>

        {!! $article->description !!}

        <br><br>
        @if(!empty($article->ArticleTags))
        Tags : 
        @foreach($article->ArticleTags as $tag)
        <span class="badge badge-secondary">{{$tag->Tag->name}}</span>
        @endforeach
        @endif

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