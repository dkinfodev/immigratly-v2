<style>
.folder-icon .tio-lg {
    font-size: 80px;
}
.folder-block {
  padding: 16px;
  border:2px solid transparent;
  cursor: pointer;
  tranistion:0.6s;
}
.folder-block.active {
  background-color: #eee;
  border-color: #1164FF;
  tranistion:0.6s;
}
</style>
<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <h4 class="text-danger text-left mb-3">*Choose the folder you want to move the file into</h4>
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/documents/files/file-move-to') }}">  
          @csrf
         <input type="hidden" value="{{ $record->unique_id }}" name="id" />
         <div class="row">
            @foreach($user_folders as $key => $doc)
              @if($record->folder_id != $doc->unique_id)
                <div class="col-md-3 col-sm-12 col-lg-3">
                    <div class="folder-block text-center">

                        <div class="clearfix"></div>
                        <div class="custom-control custom-radio" style="display:none">
                          <input type="radio" class="custom-control-input" name="folder_id" id="extra-{{$key}}" value="{{$doc->unique_id}}">
                          <label class="custom-control-label" for="extra-{{$key}}"></label>
                        </div>
                        <input type="radio" class="custom-control-input" name="doc_type" value="extra" style="display:none">
                        <div class="folder-icon">
                            <i class="tio tio-folder-add tio-lg"></i>
                        </div>
                        <div class="foler-name mt-2">
                            <h3>{{$doc->name}}</h3>
                        </div>
                    </div>
                </div>
              @endif
            @endforeach
         </div>

      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      $(".folder-block").click(function(){
        $(".folder-block").removeClass("active");
        $(this).addClass("active");
        $(this).find(".custom-control-input").prop("checked",true);
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