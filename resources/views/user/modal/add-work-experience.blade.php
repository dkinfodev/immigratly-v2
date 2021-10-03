<style>
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
      <form method="post" id="popup-form"  action="{{ baseUrl('/work-experiences/add') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Company Name</label>

            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('employment_agency') is-invalid @enderror" name="employment_agency" id="employment_agency" placeholder="Company Name" aria-label="Company Name" value="">
              @error('employment_agency')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Position</label>

            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="position" placeholder="Post you are working on" aria-label="Position" value="">
              @error('position')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Join Date</label>
            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('join_date') is-invalid @enderror" name="join_date" id="join_date" placeholder="Join Date" aria-label="Join Date" value="">
              @error('join_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Leave Date</label>
            <div class="col-sm-9 js-form-message">
              <input type="text" class="form-control @error('leave_date') is-invalid @enderror" name="leave_date" id="leave_date" placeholder="Leave Date" aria-label="Leave Date" value="">
              @error('leave_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Job Type </label>
            <div class="col-sm-9 js-form-message">
              <select name="job_type" id="job_type" class="custom-select">
                  <option value="">Select Job Type</option>
                  <option value="Full Time">Full Time</option>
                  <option value="Part Time">Part Time</option>
                  <option value="Other">Other</option>
              </select>
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Job Duties</label>
            <div class="col-sm-9 js-form-message">
              <textarea name="exp_details" class="form-control" required placeholder="Job Duties"></textarea>
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">NOC Type </label>
            <div class="col-sm-9 js-form-message">
              <select name="noc_type" id="noc_type" class="custom-select">
                  <option value="">Select NOC Type</option>
                  <option value="NOC 00/0"> NOC 00/0</option>
                  <option value="NOC A">NOC A</option>
                  <option value="NOC B">NOC B</option>
                  <option value="NOC C">NOC C</option>
                  <option value="NOC D">NOC D</option>
              </select>
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">NOC Code</label>
            <div class="col-sm-9 js-form-message">
            <select name="noc_code[]" id="noc_code" multiple>
                @foreach($noc_codes as $noc_code)
                  <option value="{{$noc_code->id}}">{{$noc_code->code}} - {{$noc_code->name}}</option>
                @endforeach
            </select>
              <!-- <input type="text" class="form-control @error('noc_code') is-invalid @enderror" name="noc_code" id="noc_code" placeholder="NOC Code" aria-label="NOC Code" value=""> -->
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