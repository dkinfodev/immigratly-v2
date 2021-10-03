@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')

<link rel="stylesheet" href="assets/frontend/vendor/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.css">

@endsection

@section('content')
    <!-- Hero Section -->
    <div class="position-relative bg-primary overflow-hidden">
      <div class="container position-relative z-index-2 space-top-3 space-top-md-4 space-bottom-3 space-bottom-md-4">
        <div class="w-md-80 w-xl-60 text-center mx-md-auto">
          <div class="mb-7">
            <h1 class="display-4 text-white mb-4">One Place Solution for all type of Immigration </h1>
           
          </div>
          <a class="btn btn-light btn-wide transition-3d-hover" href="#">Post a Case</a>
          <a class="btn text-white" href="#">Find a Professional <i class="fas fa-angle-right fa-sm ml-1"></i></a>
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


    <!-- Features Section -->
    <div id="featuresSection" class="container">
      <div class="row justify-content-lg-between align-items-lg-center">
        <div class="col-lg-5 mb-9 mb-lg-0">
          <div class="mb-3">
            <h2 class="h2">Self Assessment</h2>
          </div>

          <p>Get your assessment check for the visa and check your eligibility for the visa yourself</p>


          <div class="mt-4">
            <a class="btn btn-primary btn-wide transition-3d-hover" href="#">Free Self Assessment</a>
          </div>
        </div>

        <div class="col-lg-6 col-xl-5">
          <!-- SVG Element -->
          <div class="position-relative min-h-500rem mx-auto" style="max-width: 28rem;">
            <figure class="position-absolute top-0 right-0 z-index-2 mr-11" data-aos="fade-up">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 450 450" width="165" height="165">
                <g>
                  <defs>
                    <path id="circleImgID2" d="M225,448.7L225,448.7C101.4,448.7,1.3,348.5,1.3,225l0,0C1.2,101.4,101.4,1.3,225,1.3l0,0
                      c123.6,0,223.7,100.2,223.7,223.7l0,0C448.7,348.6,348.5,448.7,225,448.7z"/>
                  </defs>
                  <clipPath id="circleImgID1">
                    <use xlink:href="#circleImgID2"/>
                  </clipPath>
                  <g clip-path="url(#circleImgID1)">
                    <image width="450" height="450" xlink:href="assets/frontend/img/450x450/img1.jpg" ></image>
                  </g>
                </g>
              </svg>
            </figure>

            <figure class="position-absolute top-0 left-0" data-aos="fade-up" data-aos-delay="300">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 335.2 335.2" width="120" height="120">
                <circle fill="none" stroke="#377DFF" stroke-width="75" cx="167.6" cy="167.6" r="130.1"/>
              </svg>
            </figure>

            <figure class="d-none d-sm-block position-absolute top-0 left-0 mt-11" data-aos="fade-up" data-aos-delay="200">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 515 515" width="200" height="200">
                <g>
                  <defs>
                    <path id="circleImgID4" d="M260,515h-5C114.2,515,0,400.8,0,260v-5C0,114.2,114.2,0,255,0h5c140.8,0,255,114.2,255,255v5
                      C515,400.9,400.8,515,260,515z"/>
                  </defs>
                  <clipPath id="circleImgID3">
                    <use xlink:href="#circleImgID4"/>
                  </clipPath>
                  <g clip-path="url(#circleImgID3)">
                    <image width="515" height="515" xlink:href="assets/frontend/img/515x515/img1.jpg" transform="matrix(1 0 0 1 1.639390e-02 2.880859e-02)"></image>
                  </g>
                </g>
              </svg>
            </figure>

            <figure class="position-absolute top-0 right-0" style="margin-top: 11rem; margin-right: 13rem;" data-aos="fade-up" data-aos-delay="250">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 67 67" width="25" height="25">
                <circle fill="#00C9A7" cx="33.5" cy="33.5" r="33.5"/>
              </svg>
            </figure>

            <figure class="position-absolute top-0 right-0 mr-3" style="margin-top: 8rem;" data-aos="fade-up" data-aos-delay="350">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 141 141" width="50" height="50">
                <circle fill="#FFC107" cx="70.5" cy="70.5" r="70.5"/>
              </svg>
            </figure>

            <figure class="position-absolute bottom-0 right-0" data-aos="fade-up" data-aos-delay="400">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 770.4 770.4" width="280" height="280">
                <g>
                  <defs>
                    <path id="circleImgID6" d="M385.2,770.4L385.2,770.4c212.7,0,385.2-172.5,385.2-385.2l0,0C770.4,172.5,597.9,0,385.2,0l0,0
                      C172.5,0,0,172.5,0,385.2l0,0C0,597.9,172.4,770.4,385.2,770.4z"/>
                  </defs>
                  <clipPath id="circleImgID5">
                    <use xlink:href="#circleImgID6"/>
                  </clipPath>
                  <g clip-path="url(#circleImgID5)">
                    <image width="900" height="900" xlink:href="assets/frontend/img/900x900/img2.jpg" transform="matrix(1 0 0 1 -64.8123 -64.8055)"></image>
                  </g>
                </g>
              </svg>
            </figure>
          </div>
          <!-- End SVG Element -->
        </div>
      </div>
    </div>
    <!-- End Features Section -->


   <!-- Articles Section -->
    <div class="container space-top-2 space-top-lg-3">
      <!-- Title -->
      <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        <h2 class="h1">Read our Latest Articles</h2>
      </div>
      <!-- End Title -->

      <div class="row mx-n2 mb-5 mb-md-9">
        @if(count($articles) > 0)
        @foreach($articles as $key=>$article)
        <div class="col-sm-6 col-lg-3 px-2 mb-3 mb-lg-0">
          <!-- Card -->
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

          <a class="card h-100 transition-3d-hover" href="#">
            <img class="card-img-top" src="{{$image}}">
            <div class="card-body">
              <span class="d-block small font-weight-bold text-cap mb-2">{{$article->Category->name}}</span>
              <h5 class="mb-5">{{substr($article->short_description,0,30)}}<?php if(strlen($article->short_description)>29){echo "...";} ?></h5>
                <span class="mt-2 float-left d-block small font-weight-bold text-cap">{{dateFormat($article->created_at)}}</span>
                <span class="float-right mt-1 text-danger"><small>Read More</small></span>
            </div>
          </a>

          <!-- End Card -->
        </div>
        @endforeach
        @else
        <div class="col-md-12">
          <div class="alert alert-danger text-center">No articles available</div>
        </div>
        @endif
        <!--
        <div class="col-sm-6 col-lg-3 px-2 mb-3 mb-lg-0">
         
          <a class="card h-100 transition-3d-hover" href="#">
            <img class="card-img-top" src="assets/frontend/img/500x280/img10.jpg" alt="Image Description">
            <div class="card-body">
              <span class="d-block small font-weight-bold text-cap mb-2">Business</span>
              <h5 class="mb-0">What CFR really is about</h5>
            </div>
          </a>
         
        </div>

        <div class="col-sm-6 col-lg-3 px-2 mb-3 mb-sm-0">
          
          <a class="card h-100 transition-3d-hover" href="#">
            <img class="card-img-top" src="assets/frontend/img/500x280/img11.jpg" alt="Image Description">
            <div class="card-body">
              <span class="d-block small font-weight-bold text-cap mb-2">Business</span>
              <h5 class="mb-0">Should Product Owners think like entrepreneurs?</h5>
            </div>
          </a>
          
        </div>

        <div class="col-sm-6 col-lg-3 px-2">
          
          <a class="card h-100 transition-3d-hover" href="#">
            <img class="card-img-top" src="assets/frontend/img/500x280/img12.jpg" alt="Image Description">
            <div class="card-body">
              <span class="d-block small font-weight-bold text-cap mb-2">Facilitate</span>
              <h5 class="mb-0">Announcing Front Strategies: Ready-to-use rules</h5>
            </div>
          </a>
          
        </div>-->

      </div>

      <!-- Info -->
      <div class="position-relative z-index-2 text-center">
        <div class="d-inline-block font-size-1 border bg-white text-center rounded-pill py-3 px-4">
          Want to read more? <a class="font-weight-bold ml-3" href="#">Go here <span class="fas fa-angle-right ml-1"></span></a>
        </div>
      </div>
      <!-- End Info -->

    </div>
    <!-- End Articles Section -->


     <!-- Whats Great Section -->
    <div class="container space-2 space-lg-3">
      <!-- Title -->
      <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        <span class="d-block small font-weight-bold text-cap mb-2">Benefits</span>
        <h2 class="h1">What's Great About It?</h2>
      </div>
      <!-- End Title -->

      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <!-- Icon Blocks -->
          <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-2">
              <i class="fa fa-user-tie" style="font-size:40px;"></i>  
            </figure>
            <h3>Licenced Professionals</h3>
            <!--<p>Automate best strategies and focus more on generating hq creatives.</p>-->
          </div>
          <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <!-- Icon Blocks -->
          <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-2">
              <i class="fa fa-calendar-day" style="font-size:40px;"></i>  
            </figure>
            <h3>Case Tracking</h3>
            <!--<p>Automate best strategies and focus more on generating hq creatives.</p>-->
          </div>
          <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <!-- Icon Blocks -->
          <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-2">
              <i class="fa fa-file-alt" style="font-size:40px;"></i>  
            </figure>
            <h3>Document Management</h3>
            
          </div>
          <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4 mt-5 mb-md-0">
          <!-- Icon Blocks -->
          <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-2">
              <i class="fa fa-id-card" style="font-size:40px;"></i>  
            </figure>
            <h3>Details Case Assessment</h3>
        
          </div>
          <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4 mt-5 mb-md-0">
          <!-- Icon Blocks -->
          <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-2">
             <i class="fa fa-money-check-alt" style="font-size:40px;"></i>  
            </figure>
            <h3>Safe Payment</h3>
            
          </div>
          <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4 mt-5 mb-md-0">
          <!-- Icon Blocks -->
          <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-2">
              
              <i class="fa fa-comment-dots" style="font-size:40px;"></i>
            </figure>
            <h3>Live Message & Chat</h3>
            
          </div>
          <!-- End Icon Blocks -->
        </div>


      </div>
    </div>
    <!-- End Whats Great Section -->


    <!-- Webinar Section -->
    <div class="container space-1 space-lg-1">
      
        <!-- Title -->
        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
          <h2 class="h1">Recent Webinars</h2>
        </div>
        <!-- End Title -->
       
        <!-- Title -->
        <div class="row mb-5">
          <div class="col-6">
            <h2 class="h3 mb-0">Recents</h2>
          </div>
          <div class="col-6 text-right">
            <a class="font-weight-bold" href="#">View all <i class="fas fa-angle-right fa-sm ml-1"></i></a>
          </div>
        </div>
        <!-- End Title -->

      <div class="row mb-3">
        @if(count($webinars) > 0)
        @foreach($webinars as $webinar)
          <div class="col-sm-6 col-lg-4 mb-3 mb-sm-8">
            <!-- Blog Card -->
            <article class="card h-100">
              <div class="card-img-top position-relative">
                <img class="card-img-top" src="assets/svg/illustrations/yelling-reverse.svg" alt="Image Description">
                <!-- <figure class="ie-curved-y position-absolute right-0 bottom-0 left-0 mb-n1">
                  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
                    <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                  </svg>
                </figure> -->
              </div>

              <div class="card-body">
                <p class="text-primary">{{$webinar->Category->name}}</p>
                <h3><a class="text-inherit" href="{{ url('webinar/'.$webinar->slug) }}">{{$webinar->title}}</a></h3>
                <p>
                  {{substr($webinar->short_description,0,100)}}...
                </p>
                <p class="text-muted font-size-1">Webinar Date {{dateFormat($webinar->webinar_date)}}</p>
              </div>

              <?php 
              $company_data = professionalDetail($webinar->professional); 
              if(!empty($company_data)){
              ?>
              <div class="card-footer border-0 pt-0">
                <div class="media align-items-center">
                  <div class="avatar-group">
                    <a class="avatar avatar-xs avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="{{$company_data->company_name}}">
                      <img class="avatar-img" src="{{ professionalLogo('m',$webinar->professional) }}" alt="Image Description">
                    </a> {{$company_data->company_name}}
                  </div>
                  <div class="media-body d-flex justify-content-end text-primary font-size-1 ml-2">
                     Join
                  </div>
                </div>
              </div>
              <?php } ?>
            </article>
            <!-- End Blog Card -->
          </div>
        @endforeach
        @else
        <div class="col-md-12">
          <div class="alert alert-danger text-center">No Webniar events available</div>
        </div>
        @endif
      </div>

    </div>    
    <!--End Webinar -->
      
    <!-- Professional Section -->
    <div class="container space-1 space-lg-1">
      <!-- Title -->
      <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        <h2 class="h1">Trust the professionals</h2>
        <p>We've helped some great companies brand, design and get to market.</p>
      </div>
      <!-- End Title -->

      <!-- Team Carousel -->
      <div class="js-slick-carousel slick slick-gutters-3 mb-5 mb-lg-3"
           data-hs-slick-carousel-options='{
             "slidesToShow": 4,
             "dots": true,
             "dotsClass": "slick-pagination",
             "responsive": [{
               "breakpoint": 1200,
                 "settings": {
                   "slidesToShow": 3
                 }
               }, {
               "breakpoint": 992,
               "settings": {
                 "slidesToShow": 2
                 }
               }, {
               "breakpoint": 768,
               "settings": {
                 "slidesToShow": 2
                 }
               }, {
               "breakpoint": 554,
               "settings": {
                 "slidesToShow": 1
               }
             }]
           }'>

        <!--
        <div class="js-slide pb-6">
          <img class="img-fluid w-100 rounded-lg" src="assets/frontend/img/400x500/img28.jpg" alt="Image Description">
          <div class="card mt-n7 mx-3">
            <div class="card-body text-center">
              <h4 class="mb-1">Christina Kray</h4>
              <p class="font-size-1 mb-0">Project Manager</p>
            </div>
          </div>
        </div>-->

        <!--
        <div class="js-slide pb-6">
          <img class="img-fluid w-100 rounded-lg" src="assets/frontend/img/400x500/img29.jpg" alt="Image Description">
          <div class="card mt-n7 mx-3">
            <div class="card-body text-center">
              <h4 class="mb-1">Jeff Fisher</h4>
              <p class="font-size-1 mb-0">CEO, Director</p>
            </div>
          </div>
        </div>-->

        @foreach($professionals as $key=>$prof)
        {{$key}}
        <?php
          $company_data = professionalDetail($prof->subdomain);
          if(!empty($company_data)){
        ?>
        <div class="js-slide pb-6">
          <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo('m',$prof->subdomain)}}" alt="Image Description">
          <div class="card mt-n7 mx-3">
            <div class="card-body text-center">
              <h5 class="mb-1">{{$company_data->company_name}}</h5>
              
            </div>
          </div>
        </div>
        <?php } ?>
        @endforeach

      </div>
      <!-- End Team Carousel -->

      <!-- Info -->
      <div class="position-relative z-index-2 text-center">
        <div class="d-inline-block font-size-1 border bg-white text-center rounded-pill py-3 px-4">
          Want to work with us? <a class="font-weight-bold ml-3" href="./page-hire-us.html">We are hiring <span class="fas fa-angle-right ml-1"></span></a>
        </div>
      </div>
      <!-- End Info -->
    </div>
    <!-- End Professional Section -->
 

     <!-- News Section -->
    <div class="container space-2 space-lg-3">
      
      <!-- Title -->
      <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        <h2 class="h1">Latest News</h2>
      </div>
      <!-- End Title -->

      <div class="row justify-content-lg-between">

      @if(count($news) > 0)
      @foreach($news as $key=>$n)
        <div class="col-lg-6">
          
          <article class="row mb-7">
            <div class="col-md-5">
              <img class="card-img" src="assets/frontend/img/400x500/img5.jpg" alt="Image Description">
            </div>
            <div class="col-md-7">
              <div class="card-body d-flex flex-column h-100 px-0">
                <span class="d-block mb-2">
                  <a class="font-weight-bold" href="#">{{$n->fetchNewsCategory->name}}</a>
                </span>
                <h3><a class="text-inherit" href="#">{{$n->title}}</a></h3>
                <p>{!! substr($n->description,0,80) !!}<?php if(strlen($n->description)>79){echo "...";} ?></p>
                <div class="media align-items-center mt-auto">
                  <a class="avatar avatar-sm avatar-circle mr-3" href="blog-profile.html">
                    <img class="avatar-img" src="assets/frontend/img/100x100/img11.jpg" alt="Image Description">
                  </a>
                  <div class="media-body">
                    <span class="text-dark">
                      <a class="d-inline-block text-inherit font-weight-bold" href="blog-profile.html">{{$n->fetchUser->first_name}}</a>
                    </span>
                    <small class="d-block">{{$n->news_date}}</small>
                  </div>
                </div>
              </div>
            </div>
          </article>
          <!-- End Blog -->
          <!-- Sticky Block End Point -->
          <div id="stickyBlockEndPoint"></div>
        </div>

        @endforeach
        @else
        <div class="col-md-12">
          <div class="alert alert-danger text-center">No news available</div>
        </div>
        @endif
          <!--<div class="col-lg-6">
          <!- Blog 
          <article class="row mb-7">
            <div class="col-md-5">
              <img class="card-img" src="assets/frontend/img/400x500/img7.jpg" alt="Image Description">
            </div>
            <div class="col-md-7">
              <div class="card-body d-flex flex-column h-100 px-0">
                <span class="d-block mb-2">
                  <a class="font-weight-bold" href="#">Business</a>
                </span>
                <h3><a class="text-inherit" href="blog-single-article.html">Front becomes an official Instagram Marketing Partner</a></h3>
                <p>Great news we're eager to share.</p>
                <div class="media align-items-center mt-auto">
                  <a class="avatar avatar-sm avatar-circle mr-3" href="blog-profile.html">
                    <img class="avatar-img" src="assets/frontend/img/100x100/img3.jpg" alt="Image Description">
                  </a>
                  <div class="media-body">
                    <span class="text-dark">
                      <a class="d-inline-block text-inherit font-weight-bold" href="blog-profile.html">Aaron Larsson</a>
                    </span>
                    <small class="d-block">Feb 15, 2020</small>
                  </div>
                </div>
              </div>
            </div>
          </article>
           End Blog -->

          <!-- Blog -
          <article class="row mb-7">
            <div class="col-md-5">
              <img class="card-img" src="assets/frontend/img/400x500/img5.jpg" alt="Image Description">
            </div>
            <div class="col-md-7">
              <div class="card-body d-flex flex-column h-100 px-0">
                <span class="d-block mb-2">
                  <a class="font-weight-bold" href="#">Announcements</a>
                </span>
                <h3><a class="text-inherit" href="blog-single-article.html">Announcing a free plan for small teams</a></h3>
                <p>At Wake, our mission has always been focused on bringing openness.</p>
                <div class="media align-items-center mt-auto">
                  <a class="avatar avatar-sm avatar-circle mr-3" href="blog-profile.html">
                    <img class="avatar-img" src="assets/frontend/img/100x100/img11.jpg" alt="Image Description">
                  </a>
                  <div class="media-body">
                    <span class="text-dark">
                      <a class="d-inline-block text-inherit font-weight-bold" href="blog-profile.html">Hanna Wolfe</a>
                    </span>
                    <small class="d-block">Feb 4, 2020</small>
                  </div>
                </div>
              </div>
            </div>
          </article>
          -- End Blog -->

          <!-- Sticky Block End Point -->
          <!--<div id="stickyBlockEndPoint"></div>
        </div>-->

      </div>

    </div>
    <!-- End News Section -->


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