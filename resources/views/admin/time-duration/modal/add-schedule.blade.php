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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/time-duration/save') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Name" aria-label="Enter Schedule Name" value="">
              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Duration in Minutes</label>
            <div class="col-sm-9">
            <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" placeholder="Enter duration" aria-label="Enter duration" value="">
             
              @error('duration')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->


          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Break time <small class="text-danger">(optional)</small></label>
            <div class="col-sm-9">
            <input type="number" class="form-control @error('break_time') is-invalid @enderror" name="break_time" id="break_time" placeholder="Enter break time minutes" aria-label="Enter break time" value="">
             
              @error('break_time')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message" style="display:none">
            <label class="col-sm-3 col-form-label input-label">Type</label>
            <div class="col-sm-9">
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
              <option value="">Select</option>
              <option selected value="minutes">Minutes</option>
              <option value="hours">Hours</option>
            </select>

              @error('type')
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
    initSelect('#popup-form ');
    
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
                validation(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
    });
});
</script>