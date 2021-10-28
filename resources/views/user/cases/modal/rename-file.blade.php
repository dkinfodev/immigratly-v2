<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/cases/documents/rename-file/'.$subdomain.'/'.$record['unique_id']) }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Rename File</label>
            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="form-control @error('file_name') is-invalid @enderror" name="name" id="name" value="" placeholder="Enter folder name" aria-label="Enter folder name" >
                @error('file_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <em class="text-danger">enter name without extension</em>
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
                  if(response.error_type=='validation'){
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