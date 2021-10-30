<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/services/add-folder/'.$service_id) }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Name</label>
            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter folder name" aria-label="Enter folder name" >
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
                  $.each(response.message, function (index, value) {
                      $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                      $("*[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
                      
                      var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                      $("*[name="+index+"]").parents(".js-form-message").append(html);
                      $("*[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
                  });
                  // errorMessage(response.message);
                }
              },
              error:function(){
                internalError();
              }
          });
      });
  });
</script>