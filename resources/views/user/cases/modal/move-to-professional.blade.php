<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/cases/documents/move-to-professional/'.$case_id.'/'.$folder_id.'/'.$subdomain) }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Professional Folder</label>
            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <select name="folder_id">
                    <option value="">Select Folder</option>
                    @foreach($case_folders as $folder)
                    <option value="extra:{{$folder['unique_id']}}">{{$folder['name']}}</option>
                    @endforeach
                    <?php
                    $default_documents = $service['Documents'];
                    ?>
                    @foreach($default_documents as $folder)
                    <option value="default:{{$folder['unique_id']}}">{{$folder['name']}}</option>
                    @endforeach
                    @foreach($documents as $folder)
                    <option value="other:{{$folder['unique_id']}}">{{$folder['name']}}</option>
                    @endforeach
                </select>
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
      initSelect("#popup-form");
      $("#popup-form").submit(function(e){
          e.preventDefault();
          var formData = $("#popup-form").serialize();
          var file_ids = [];
          $(".row-checkbox:checked").each(function(){
            file_ids.push($(this).val());
          });
          var file_id = file_ids.join(",");
          formData +="&file_ids="+file_id;
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