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
        <div class="form-group js-form-message">
              <h>Form Title:<b> {{$record['fill_form']['form_title']}}</b></h3>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                  @foreach($form_json as $form)
                  @if(isset($form['value']))
                  <tr>
                    <th>{{$form['label']}}</th>
                    <td>{{$form['value']}}</td>
                  </tr>
                  @endif
                  @endforeach
                </table>
            </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>

  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    initSelect('#popup-form ');
    
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