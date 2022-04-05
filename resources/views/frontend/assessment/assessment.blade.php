@extends('frontend.layouts.master')

@section('content')
<!-- Content -->
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-90 mx-lg-auto">
        
        <h4 class="h4 text-white mb-4">{{$record->form_title}}</h4>
        
      </div>
    </div>
  </div>
</div>
<div class="container space-top-1 space-bottom-2 space-top-lg-2">
  <div class="w-lg-90 mx-lg-auto text-justify">
      <!-- Card -->
  <div class="card">

<div class="card-body">
  @if(Auth::check())
    @if($already_filled == 0)
      <form id="form" class="js-validate" method="post">
        @csrf  
        <!-- Form Group -->
        <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Full name <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Name for quick lead"></i></label>

            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <span class="js-form-message w-50">
                  <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" value="{{ \Auth::user()->first_name }}" placeholder="Your first name" aria-label="Your first name" >
                </span>
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="js-form-message w-50">
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ \Auth::user()->last_name }}" placeholder="Your last name" aria-label="Your last name">
                </span>
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ \Auth::user()->email }}" placeholder="Your email" aria-label="Email" value="">
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Phone </label>
            <div class="col-sm-3 js-form-message">
              <select name="country_code" id="country_code" class="custom-select">
                <option value="">Select Code</option>
                @foreach($countries as $key=>$c)
                <option {{ \Auth::user()->country_code == $c->phonecode?'selected':'' }} value="+{{$c->phonecode}}">+{{$c->phonecode}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-6 js-form-message">
              <input type="text" name="phone_no" id="phone_no" value="{{ \Auth::user()->phone_no }}" class="form-control @error('phone_no') is-invalid @enderror" placeholder="Your mobile no">
              @error('phone_no')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>      
          <!-- End Form Group -->
        <div class="render-wrap"></div>
        <div class="form-group text-center">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->
      </form>
    @else
    <div class="row">
        <div class="col-md-12">
          <div class="text-center">
                <h3 class="font-bold text-danger">You already filled the asssessment form</h3>
          </div>
        </div>
    </div>
    @endif
  @else
  <div class="row">
      <div class="col-md-12">
        <div class="text-center">
              <p class="font-bold">Please signup to see the assessment form</p>
              <div>
                <a href="{{ url('signup/user?assessment='.$assessment_id) }}" target="_blank" class="text-primary">Create an Account</a> Or <a target="_blank" href="{{ url('login?assessment='.$assessment_id) }}">Already have an Account</a>
              </div>
        </div>
      </div>
  </div>
  @endif
</div><!-- End Card body-->
</div>
<!-- End Card -->
  </div>
</div>


@endsection


@section('javascript')
<!-- JS Implementing Plugins -->
<!-- <script src="assets/vendor/formBuilder/dist/form-builder.min.js"></script>-->
<script src="assets/vendor/formBuilder/dist/form-render.min.js"></script>
<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
<script>
jQuery(($) => {
  var form_json = '<?php echo $form_json ?>';
  var formData = JSON.parse(form_json);
  $('.render-wrap').formRender({
      formData:form_json,
      dataType: 'json',
      render: true
    });
});
$(document).ready(function(){
  $("#form").submit(function(e){
    e.preventDefault();
    var url  = $("#form").attr('action');
    $.ajax({
      url:url,
      type:"post",
      data:$("#form").serialize(),
      dataType:"json",
      beforeSend:function(){
        showLoader();
      },
      success:function(response){
        hideLoader();
        if(response.status == true){
          successMessage(response.message);
          location.reload();
        }else{
          validation(response.message);
        }
      },
      error:function(){
          internalError();
      }
    });
  })
})

</script>

@endsection