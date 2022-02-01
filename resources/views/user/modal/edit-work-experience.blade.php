<style>
span.select2-selection.select2-selection--multiple.custom-select {
    height: auto !important;
}
</style>
@php
$start_year = date("Y");
$end_year = date("Y") - 20;
@endphp
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <div class="imm-modal-slanted-div angled lower-start">
          <div class="row">
            <div class="col-10">
              <h3 class="modal-title" id="exampleModalLongTitle">{{$pageTitle}}</h3>
            </div>
            <div class="col-2" style="text-align:right"> 
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

          </div>
        </div>
    </div>
    <div class="modal-body imm-education-modal-body">
    <form method="post" id="popup-form"  action="{{ baseUrl('/work-experiences/edit/'.base64_encode($record->id)) }}">  
          @csrf
          <div class="imm-education-add-inner">
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">
                <label for="fieldOfStudyNameLabel" class="form-label">Job title</label>

                <div class="row">
                  <div class="col-12 js-form-message">
                    <div class="input-group">
                      <input type="text" class="js-input-mask form-control" value="{{$record->position}}" name="job_title" id="job_title">

                      <!-- Select -->
                      <select class="form-select no_select2" name="job_type" id="job_type" style="max-width: 10rem;">
                        <option {{$record->job_type == 'Full-time'?'selected':''}} value="Full-time">Full-time</option>
                        <option {{$record->job_type == 'Part-time'?'selected':''}} value="Part-time">Part-time</option>
                        <option {{$record->job_type == 'Contract'?'selected':''}} value="Contract">Contract</option>
                        <option {{$record->job_type == 'Self-Employed'?'selected':''}} value="Self-Employed">Self-Employed</option>
                        <option {{$record->job_type == 'Other'?'selected':''}} value="Other">Other</option>
                      </select>
                      <!-- End Select -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Form -->
            </div>
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4 js-form-message">
                <label for="employment_agency" class="form-label">Job Description</label>
                <textarea type="text" class="form-control" name="exp_details" id="exp_details">{{$record->exp_details}}</textarea>
              </div>
              <!-- End Form -->
            </div>
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4 js-form-message">
                <label for="employment_agency" class="form-label">Company name</label>
                <input type="text" value="{{$record->employment_agency}}" class="form-control" name="company" id="company"
                  aria-label="Accounting">
              </div>
              <!-- End Form -->
            </div>

            <div class="form-check mt-2 mb-2">
              <input type="checkbox" name="is_current_job" class="form-check-input" id="is_current_job">
              <label class="form-check-label" for="is_current_job">Is this current job?</label>

            </div>
            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">
                <div class="row">
                  <div class="col-6">
                    <label for="schoolFromMonthLabel" class="form-label">From</label>

                    <div class="row gx-2">
                      <div class="col-sm-8 mb-2 mb-sm-0 js-form-message">
                        <!-- Select -->
                        @php
                        $join_date = explode(" ",$record->join_date);
                        @endphp
                        <select id="schoolFromMonthLabel" name="from_month" class="form-select no_select2">
                          @foreach(monthsName() as $month)
                            <option {{$join_date[0] == $month?'selected':''}} value="{{ $month }}">{{$month}}</option>
                          @endforeach
                        </select>
                        <!-- End Select -->
                      </div>
                      <!-- End Col -->

                      <div class="col-sm-4 js-form-message">
                        <!-- Select -->
                        <select class="form-select no_select2 no_select2" name="from_year">
                          @for($i=$start_year;$i >= $end_year;$i--)
                            <option {{$join_date[1] == $i?'selected':''}} value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                        <!-- End Select -->
                      </div>
                      <!-- End Col -->
                    </div>
                    <!-- End Row -->
                  </div>
                  <!-- End Form -->
                  <div class="col-6">
                    <label class="form-label">To</label>

                    <div class="row gx-2">
                      <div class="col-sm-8 mb-2 mb-sm-0 js-form-message">
                        <!-- Select -->
                        @php
                        $leave_date = explode(" ",$record->leave_date);
                        @endphp
                        <select class="form-select no_select2" name="to_month">
                          @foreach(monthsName() as $month)
                            <option {{$leave_date[0] == $month?'selected':''}} value="{{ $month }}">{{$month}}</option>
                          @endforeach
                        </select>
                        <!-- End Select -->
                      </div>
                      <!-- End Col -->

                      <div class="col-sm-4 js-form-message">
                        <!-- Select -->
                        <select class="form-select no_select2" name="to_year">
                          @for($i=$start_year;$i >= $end_year;$i--)
                            <option {{$leave_date[1] == $i?'selected':''}} value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                        <!-- End Select -->
                      </div>
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->
                </div>
              </div>
            </div>
            <!-- End Form -->

            <div class="col-12">
              <!-- Form -->
              <div class="mb-4">
                <div class="row">
                  <div class="col-6 js-form-message">
                    <label for="we_country_id" class="form-label">Country</label>

                    <!-- Select -->
                    <select id="we_country_id" onchange="stateList(this.value,'we_state_id')" class="form-select no_select2" name="country_id">
                      @foreach($countries as $country)
                      <option {{$record->country_id == $country->id?'selected':''}} value="{{$country->id}}">{{ $country->name }}</option>
                      @endforeach
                    </select>
                    <!-- End Select -->
                  </div>
                  <div class="col-6 js-form-message">
                    <label for="we_state_id" class="form-label">State/Province</label>
                    <select id="we_state_id" class="form-select no_select2" name="state_id">
                      <option value="">Select State</option>
                      @foreach($states as $state)
                      <option {{$record->state_id == $state->id?'selected':''}} value="{{$state->id}}">{{ $state->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Form -->
            </div>
            <!-- Container For Input Field -->

            <a href="javascript:;" class="js-create-field form-link">
              <i class="bi-plus-circle me-1"></i>

              National Occupational Classification (NOC)

            </a>
            <div class="col-12">
              <div class="imm-eca-add-section">
                <!-- Form -->

                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="mb-4 js-form-message">
                      <label for="educationLabel" class="form-label">NOC Level</label>

                      <!-- Select -->
                      <select id="educationLabel" class="form-select no_select2" name="noc_type">
                          <option {{ ($record->noc_type == 'NOC 00/0')?"selected":"" }} value="NOC 00/0"> NOC 00/0</option>
                          <option {{ ($record->noc_type == 'NOC A')?"selected":"" }} value="NOC A">NOC A</option>
                          <option {{ ($record->noc_type == 'NOC B')?"selected":"" }} value="NOC B">NOC B</option>
                          <option {{ ($record->noc_type == 'NOC C')?"selected":"" }} value="NOC C">NOC C</option>
                          <option {{ ($record->noc_type == 'NOC D')?"selected":"" }} value="NOC D">NOC D</option>

                      </select> <!-- End Select -->
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="mb-4 js-form-message">

                      <label for="educationLabel" class="form-label">NOC Code</label>

                      <!-- Select -->
                      <select id="noc_code" class="form-select" name="noc_code[]" multiple>
                       <option disabled value="">Select NOC Code</option>
                       <?php
                          $noc_code_ids = explode(",",$record->noc_code);
                        ?>
                        @foreach($noc_codes as $noc_code)
                          <option {{(in_array($noc_code->id,$noc_code_ids))?'selected':'' }} value="{{$noc_code->id}}">{{$noc_code->code}} - {{$noc_code->name}}</option>
                        @endforeach

                      </select> <!-- End Select -->

                    </div>
                  </div>
                </div>
                <div class="imm-display-notification bg-soft-primary mt-2 mb-4">
                  The National Occupational Classification (NOC) is Canada’s national system for describing occupations.
                </div>
              </div>
            </div>
          </div>
          <!-- End Body -->

            <!-- Footer -->
            <div class="modal-footer d-block text-right">
              <button type="submit" form="popup-form" class="btn btn-primary" style="float:right">
                <i class="bi-plus me-1"></i> Save Experience
              </button>
            </div>
          <!-- End Footer -->
          </form>
        </div>
    <!-- <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div> -->
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    initSelect();
    $('#join_date').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom'
    })
    .on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#leave_date').datepicker('setStartDate', startDate);
    });
    $('#leave_date').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom'
    });
    $("#popup-form").submit(function(e){
        e.preventDefault();
        var formData = $("#popup-form").serialize();
        var url  = $("#popup-form").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
              showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                closeModal();
                location.reload();
              }else{
                if(response.error_type == 'validation'){
                  validation(response.message);
                }else{
                  errorMessage(response.message);
                }
              }
            },
            error:function(){
              internalError();
            }
        });
    });
});
</script>

{{--<style>
.invalid-feedback {
    position: absolute;
    bottom: -20px;
}
</style>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form"  action="{{ baseUrl('/work-experiences/edit/'.base64_encode($record->id)) }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Company Name</label>

            <div class="col-sm-9">
              <input type="text" class="form-control @error('employment_agency') is-invalid @enderror" name="employment_agency" id="employment_agency" placeholder="Company Name" aria-label="Company Name" value="{{$record->employment_agency}}">
              @error('employment_agency')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Position</label>

            <div class="col-sm-9">
              <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="position" placeholder="Post you are working on" aria-label="Position" value="{{$record->position}}">
              @error('position')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Join Date</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('join_date') is-invalid @enderror" name="join_date" id="join_date" placeholder="Join Date" aria-label="Join Date" value="{{$record->join_date}}">
              @error('join_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Leave Date</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('leave_date') is-invalid @enderror" name="leave_date" id="leave_date" placeholder="Leave Date" aria-label="Leave Date" value="{{$record->leave_date}}">
              @error('leave_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Job Type </label>
            <div class="col-sm-9">
              <select name="job_type" id="job_type" class="custom-select">
                  <option value="">Select Job Type</option>
                  <option {{ ($record->job_type == 'Full Time')?"selected":"" }} value="Full Time">Full Time</option>
                  <option {{ ($record->job_type == 'Part Time')?"selected":"" }} value="Part Time">Part Time</option>
                  <option {{ ($record->job_type == 'Other')?"selected":"" }} value="Other">Other</option>
              </select>
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Job Duties</label>
            <div class="col-sm-9">
              <textarea name="exp_details" class="form-control" required placeholder="Job Duties">{{$record->exp_details}}</textarea>
            </div>
          </div>      
          <!-- End Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">NOC Type </label>
            <div class="col-sm-9 js-form-message">
              <select name="noc_type" id="noc_type" class="custom-select">
                  <option value="">Select NOC Type</option>
                  <option {{ ($record->noc_type == 'NOC 00/0')?"selected":"" }} value="NOC 00/0"> NOC 00/0</option>
                  <option {{ ($record->noc_type == 'NOC A')?"selected":"" }} value="NOC A">NOC A</option>
                  <option {{ ($record->noc_type == 'NOC B')?"selected":"" }} value="NOC B">NOC B</option>
                  <option {{ ($record->noc_type == 'NOC C')?"selected":"" }} value="NOC B">NOC C</option>
                  <option {{ ($record->noc_type == 'NOC D')?"selected":"" }} value="NOC B">NOC D</option>
              </select>
            </div>
          </div> 
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">NOC Code</label>
            <div class="col-sm-9">
              <select name="noc_code[]" id="noc_code" multiple>
                  <?php
                    $noc_code_ids = explode(",",$record->noc_code);
                  ?>
                  @foreach($noc_codes as $noc_code)
                    <option {{(in_array($noc_code->id,$noc_code_ids))?'selected':'' }} value="{{$noc_code->id}}">{{$noc_code->code}} - {{$noc_code->name}}</option>
                  @endforeach
              </select>
              <!-- <input type="text" class="form-control @error('noc_code') is-invalid @enderror" name="noc_code" id="noc_code" placeholder="NOC Code" aria-label="NOC Code" value="{{$record->noc_code}}"> -->
              @error('noc_code')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

        </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    initSelect();
    $('#join_date').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom'
    })
    .on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#leave_date').datepicker('setStartDate', startDate);
    });
    $('#leave_date').datepicker({
          format: "MM yyyy",
          viewMode: "months", 
          minViewMode: "months",
          orientation: 'auto bottom',
    });
    // var startDate = new Date($('#join_date').val());
    // var startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
    // $('#leave_date').datepicker('setStartDate', startDate);
    
    // var startDate = new Date($('#join_date').val());
    // var startDate.setDate(startDate.getDate(new Date($('#join_date').val()));
    // $('#leave_date').datepicker('setStartDate', startDate);
    $("#popup-form").submit(function(e){
        e.preventDefault();
        var formData = $("#popup-form").serialize();
        var url  = $("#popup-form").attr('action');
        $.ajax({
            url:url,
            type:"post",
            data:formData,
            dataType:"json",
            beforeSend:function(){
              showLoader();
            },
            success:function(response){
              hideLoader();
              if(response.status == true){
                successMessage(response.message);
                closeModal();
                location.reload();
              }else{
                if(response.error_type == 'validation'){
                  validation(response.message);
                }else{
                  errorMessage(response.message);
                }
              }
            },
            error:function(){
              internalError();
            }
        });
    });
});
</script>
--}}