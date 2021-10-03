<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/leads/assign/save') }}">  
          @csrf
          <!-- Form Group -->

          <input type="hidden" name="leads_id" id="leads_id" value="{{$lead_id}}">
          <div class="row form-group js-form-message">
            <label class="col-sm-12 col-form-label input-label">Select Staff<i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Name for quick lead"></i></label>


            @if(count($staff) < 1 )
            <label class="col-sm-12 col-form-label input-label"><span class="text-danger">No Staff Available</span></label>
            @endif
              
            <div class="col-sm-12">
                <div class="js-form-message form-group">

                  <select multiple class="js-select2-custom"
                          data-hs-select2-options='{
                            "placeholder": "Select Staff"
                          }' name="user_id[]">

                    

                    @if(count($staff) > 1 )                    
                      @foreach($staff as $key=>$s)
                       
                       <?php 
                            $ids = array();
                            if(!empty($leadAssigned)){
                              foreach($leadAssigned as $team){
                                $ids[] = $team->user_id;
                              }
                            }
                        ?>

                       <option value="{{$s->unique_id}}" {{ in_array($s->unique_id,$ids)?'selected':'' }}  data-option-template='<span class="d-flex align-items-center"><img class="avatar-xs rounded-circle mr-2" src="./assets/img/160x160/img9.jpg" alt="Image description" /><span>{{$s->first_name}} {{$s->last_name}} <small>({{ucwords($s->role)}})</small></span></span>'>
                            {{$s->first_name}} {{$s->last_name}} 
                          </option>
                       
                       
                        
                      @endforeach
                    @endif

                  </select>
                  <!-- End Select2 -->

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
    // initSelect();

    // initialization of select2
    $('.js-select2-custom').each(function () {
      var select2 = $.HSCore.components.HSSelect2.init($(this));
    });
    
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