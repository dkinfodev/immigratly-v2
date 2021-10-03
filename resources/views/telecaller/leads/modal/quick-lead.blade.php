<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/leads/create-quick-lead') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Full name <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Name for quick lead"></i></label>

            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="Your first name" aria-label="Your first name" >
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="Your last name" aria-label="Your last name">
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your email" aria-label="Email" value="">
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Phone </label>
            <div class="col-sm-3">
              <select name="country_code" id="country_code" class="custom-select">
                @foreach($countries as $key=>$c)
                <option id="{{$c->phonecode}}" value="+{{$c->phonecode}}">+{{$c->phonecode}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-6">
              <input type="text" name="phone_no" id="phone_no" class="form-control @error('phone_no') is-invalid @enderror" placeholder="Your mobile no">
              @error('phone_no')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Visa Service </label>
            <div class="col-sm-9">

              <select name="visa_service_id" id="visa_service_id" class="custom-select">
                <option value="">Select Service</option>
                @foreach($visa_services as $service)
                  @if(!empty($service->Service($service->service_id)))
                    <option value="{{$service->id}}">{{$service->Service($service->service_id)->name}} </option>
                  @endif
                @endforeach
              </select>
              @error('visa_service_id')
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