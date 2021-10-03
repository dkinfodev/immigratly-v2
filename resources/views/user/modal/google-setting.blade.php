
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form"  action="{{ baseUrl('/connect-apps/google-setting') }}">  
          @csrf
          <p>Choose your preferred duration to backup your documents to Google Drive</p>
          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Backup Duration</label>
            <div class="col-sm-9 js-form-message">
              <select name="duration" class="custom-select">
                  <option {{ (!empty($record) && $record->gdrive_duration == 'none')?"selected":"" }} value="none">None</option>
                  <option {{ (!empty($record) && $record->gdrive_duration == 'daily')?"selected":"" }} value="daily">Daily</option>
                  <option {{ (!empty($record) && $record->gdrive_duration == 'weekly')?"selected":"" }} value="weekly">Weekly</option>
                  <option {{ (!empty($record) && $record->gdrive_duration == 'monthly')?"selected":"" }} value="monthly">Monthly</option>
              </select>
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