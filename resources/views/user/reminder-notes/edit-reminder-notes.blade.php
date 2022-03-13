<style>
.invalid-feedback {
    position: absolute;
    bottom: -20px;
}
</style>

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
      <form method="post" id="popup-form"  action="{{ baseUrl('/notes/edit-reminder-note/'.base64_encode($record->id)) }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Reminder Date</label>

            <div class="col-sm-9 js-form-message">
              <input autocomplete="off" value="{{ dateFormat($record->reminder_date,'d/m/Y') }}" type="text" class="form-control reminder_date @error('reminder_date') is-invalid @enderror" name="reminder_date" id="reminder_date" placeholder="Enter Reminder Date" aria-label="Enter Reminder Date" value="">
              @error('reminder_date')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Message</label>

            <div class="col-sm-9 js-form-message">
              <textarea class="form-control @error('message') is-invalid @enderror" name="message" placeholder="Enter your message..." aria-label="Percentage">{{$record->message}}</textarea>
              @error('message')
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
  
    $('.reminder_date').datepicker({
          format: "d/m/yyyy",
          autoclose: true,
    })
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