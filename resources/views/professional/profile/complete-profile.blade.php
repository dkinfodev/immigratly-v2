@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
@endsection

@section('content')

<div class="row">
  <div class="col-lg-6 col-xl-4  d-lg-flex justify-content-center position-relative offset-xl-2 offset-md-0" style="">
    <div class="flex-grow-1 p-5">
      <!-- Step -->
      <ul class="step">
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-success"><i class="bi bi-check-lg"></i></span>
            <div class="step-content">
              <h4>Sign up</h4>
              <p class="step-text">Achieve virtually any design and layout from within the one template.</p>
            </div>
          </div>
        </li>

        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary">2</span>
            <div class="step-content">
              <h4>Complete profile</h4>
              <p class="step-text">We strive to figure out ways to help your business grow through all platforms.</p>
            </div>
          </div>
        </li>
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary">3</span>
            <div class="step-content">
              <h4>Profile review</h4>
              <p class="step-text">We strive to figure out ways to help your business grow through all platforms.</p>
            </div>
          </div>
        </li>
        
      </ul>
      <!-- End Step -->    
    </div>
  </div>

  <div class="col-lg-6 col-xl-4 justify-content-center align-items-center min-vh-lg-100 ">
    
    <div class="flex-grow-1 margin-auto-sm" style="max-width: 28rem;">  
    
      <div class="type-label-holder-wrap-outer">

        <div class="row">
          <div class="col-lg-4 col-xl-4">
           <div class="type-label-holder-wrap text-center ">
            <div class="type-label-holder"><img class="avatar avatar-xss" src="./assets/svg/brands/google.svg" alt="Image Description"></div>
           </div>
          </div>

          <div class="col-lg-8 col-xl-8 text-center-xs">
            
            <!-- Heading -->
            <div class="mb-5 mb-md-7">
              <h1 class="h2">Hey {{ \Auth::user()->id }}</h1>
              <p>We need some more information</p>
            </div>
            <!-- End Heading -->
            
        </div><!-- row end -->


      </div>

    </div>


</div>

@endsection


@section('javascript')

<script>


  $(document).on('ready', function () {
    // initialization of form validation
    $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });

    // initialization of step form
    $('.js-step-form').each(function () {
      var stepForm = new HSStepForm($(this), {
        finish: function() {
          $("#validationFormProgress").hide();
          $("#validationFormContent").hide();
          $("#validationFormSuccessMessage").show();
        }
      }).init();
    });
  });

</script>

<script>
  $(document).on('ready', function () {
    // initialization of quilljs editor
    var quill = $.HSCore.components.HSQuill.init('.js-quill-custom-template');
  });
</script>



@endsection

