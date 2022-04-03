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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/locations/save') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Address</label>
            <div class="col-sm-9">
            <textarea type="text" class="form-control @error('name') is-invalid @enderror" name="address" id="name" placeholder="Enter Your Location" aria-label="Enter Your Location"></textarea>
              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Type</label>
            <div class="col-sm-9">
            
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Enter type" aria-label="Enter type">
              <option value="">Select</option>
              <option value="onsite">On-site</option>
              <option value="online">Online</option>
            </select>
              @error('type')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
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