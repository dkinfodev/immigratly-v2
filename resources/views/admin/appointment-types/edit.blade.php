@extends('layouts.master')

@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection

@section('header-right')
<a class="btn btn-primary" href="{{ baseUrl('/appointment-types') }}">
    <i class="tio mr-1"></i> Back
</a>
@endsection

@section('content')
<!-- Content -->
<div class="appointment-types">
   
    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <form id="form" class="js-validate" action="{{ baseUrl('appointment-types/update/'.base64_encode($record->id)) }}" method="post">
                @csrf
              <div class="row justify-content-md-between">
                <div class="col-md-12">
                  <div class="js-form-message row form-group">
                      <label for="addressLineLabelEg1" class="col-sm-3 col-form-label input-label">Name</span></label>

                      <div class="col-sm-9">
                      <input type="text" class="form-control form-control-hover-light" id="name" placeholder="Enter Schedule" name="name"  data-msg="Please enter schedule name" aria-label="Enter schedule name" value="{{ $record->name }}">
                      </div>

                  </div>
                </div>

                <div class="col-md-12">
                  <!-- Form Group -->
                    <div class="js-add-field row form-group">
                      <label for="addressLineLabelEg1" class="col-sm-3 col-form-label input-label">Duration</span></label>

                      <div class="col-sm-9">
                        <select class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration">
                          <option value="">Select</option>
                          <?php $durations = appointmentDuration() ?>
                          @foreach($durations as $duration)
                          <option value="{{$duration}}">{{$duration}}</option>
                          @endforeach
                        </select>

                        <!-- Container For Input Field -->
                        
                      </div>
                    </div>
                    <!-- End Form Group -->

                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn add-btn btn-primary">Save</button>
              </div>
                <!-- End Input Group -->
        </div><!-- End Card body-->
    </div>
    <!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')

<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>

<script>
$(document).on('ready', function() {
  
    $('.js-add-field').each(function () {
      new HSAddField($(this)).init();
    });
    $("#form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var url = $("#form").attr('action');
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                hideLoader();
                if (response.status == true) {
                    successMessage(response.message);
                    redirect(response.redirect_back);
                } else {
                    validation(response.message);
                }
            },
            error: function() {
                internalError();
            }
        });

    });
});

</script>

@endsection