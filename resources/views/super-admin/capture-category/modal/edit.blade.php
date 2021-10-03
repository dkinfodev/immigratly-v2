<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('capture-category/update') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group">
            <input type="hidden" name="id" value="{{base64_encode($record->id)}}">

            <label class="col-sm-3 col-form-label input-label">Name</label>
            <div class="col-sm-9 js-form-message">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $record->name }}" placeholder="Enter name" aria-label="Enter news category name" >
                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>

          <div class="row form-group">
            <label class="col-sm-3 col-form-label input-label">Short Name</label>
            <div class="col-sm-9 js-form-message">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="form-control @error('short_name') is-invalid @enderror" name="short_name" id="short_name" value="{{ $record->short_name }}" placeholder="Enter short name" aria-label="Enter short name" >
                @error('short_name')
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
                  validaton(response.message);
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