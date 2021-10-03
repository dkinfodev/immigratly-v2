@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-100 mx-lg-auto">
        <!-- Input -->
        <h1 class="text-lh-sm text-white">{{$visaServices->name}}</h1>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<div class="container space-bottom-2">
  <div class="w-lg-100 mx-lg-auto">
    <!-- Breadcrumbs -->
        <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Visa Services</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$visaServices->name}}</li>
      </ol>
    </nav>
    <!-- End Breadcrumbs -->


    <!-- End Breadcrumbs -->

    <!-- Article -->
    <div class="card card-bordered custom-content-card">
      <div class="col-md-12 text-right">

          @if(!Auth::check())
          @if($visaServices->eligible_type == 'group_eligible')
            <a class="btn btn-dark" href="{{url('check-eligibility/g/'.$visaServices->unique_id)}}">
          @else
            <a class="btn btn-dark" href="{{url('check-eligibility/check/'.$visaServices->unique_id)}}">
          @endif
          <i class="tio-checkmark-square"></i>
              Check Eligibility
          </a>
          @endif
          
       </div>   
      <!-- <h1 class="h2">What's Front?</h1> -->
      <!-- <p>How Front works, what it can do for your business and what makes it different to other solutions.</p> -->

      @foreach($records as $key=>$record)
        <div class="space-bottom-2">
          <div class="media mb-5">
            <h3>{{$record->title}}</h3>
          </div>
        
          <div class="description">
            <?php echo $record->description ?>
          </div>
        </div>
      @endforeach


    </div>
    <!-- End Article -->
  </div>
  
  
</div>
@endsection

@section("javascript")
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
@endsection