<style type="text/css">
.professional-card {
    border: 1px solid #d4c7c7;
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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/assessments/assign-to-professional/'.$assessment->unique_id) }}">  
        @csrf
        <div class="row">
          <div class="col-md-12 mb-3">
            <h3>Select Professional to assign assessment:</h3>
          </div>
          @foreach($professionals as $key=>$prof)
          <?php 
            $check_service = professionalService($prof->subdomain,$assessment->visa_service_id);
            $company_data = professionalDetail($prof->subdomain);
          ?>
          @if(!empty($check_service))
            @if(!empty($company_data))
            <div class="col-md-3">
                <div class="card mb-4 professional-card">
                  <div class="card-image">
                    <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo('m',$prof->subdomain)}}" alt="Image Description">
                  </div>
                  <div class="card-footer text-center">
                      <div class="custom-control custom-radio">
                        <input type="radio" {{$prof->subdomain == $assessment->professional?'checked':''}} value="{{$prof->subdomain}}" id="customRadio-{{$key}}" class="custom-control-input" name="professional">
                        <label class="custom-control-label" for="customRadio-{{$key}}"><h3>{{ $company_data->company_name }}</h3></label>
                      </div>
                  </div>
                </div>
            </div>
            @endif
          @endif
          @endforeach
        </div>    
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Assign</button>
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