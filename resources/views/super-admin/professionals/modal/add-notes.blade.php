<div class="modal-dialog" role="document">
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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/professionals/save-notes') }}">  
          @csrf

           <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Note</label>
            <div class="col-sm-9">
              <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="notes"><?php if(!empty($notes)){echo $notes;}?></textarea>
              @error('notes')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
              <?php if(!empty($notes_updated_on)){ echo '<p class="text-secondary float-right">'.'Lastly updated on '.$notes_updated_on.'</p>';}?>
              <input type="hidden" name="id" value="{{$record->id}}">
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
    // initSelect();
    
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
                // $.each(response.message, function (index, value) {
                //     $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                //     $("*[name="+index+"]").parents(".js-form-message").find("*[name="+index+"]").removeClass('is-invalid');

                    
                //     var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                //     $("*[name="+index+"]").parents(".js-form-message").append(html);
                //     $(html).insertAfter("*[name="+index+"]");
                //     $("*[name="+index+"]").parents(".js-form-message").find("*[name="+index+"]").addClass('is-invalid');
                // });
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