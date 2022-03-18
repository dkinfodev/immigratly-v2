<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" action="{{ baseUrl('assessments/forms/'.$assessment_id.'/send-form/'.$form_id) }}" class="js-validate">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Enter Email</label>
            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="js-tagify tagify-form-control pl-2 form-control @error('name') is-invalid @enderror" name="emails" id="emails" value="" placeholder="Enter Emails" aria-label="Enter Emails" >

                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
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
<link rel="stylesheet" href="assets/vendor/@yaireo/tagify/dist/tagify.css">
<script src="assets/vendor/@yaireo/tagify/dist/tagify.min.js"></script>


<script type="text/javascript">
  $(document).ready(function(){
    $('.js-tagify').each(function () {
      var tagify = $.HSCore.components.HSTagify.init($(this));
    });
      $("#popup-form").submit(function(e){
          e.preventDefault();
          var formData = $("#popup-form").serialize();
          var emails = $("#emails").val();
         
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