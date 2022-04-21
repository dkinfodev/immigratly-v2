
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
        @if(Auth::check())
        <form method="post" id="popup-form" class="js-validate" action="{{ url('/professional/'.$subdomain.'/post-a-case') }}">
            @csrf
            <!-- Form Group -->
            <div class="row form-group">
                <label class="col-sm-3 col-form-label input-label">Case Title</label>
                <div class="col-sm-9 js-form-message">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('case_title') is-invalid @enderror" name="case_title"
                            id="case_title" placeholder="Enter Case Title" value=""
                            aria-label="Enter Case Title">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-sm-3 col-form-label input-label">Visa Services</label>
                <div class="col-sm-9 js-form-message">
                    <div class="visa-services">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <th>&nbsp;</th>
                                <th>Visa Service</th>
                                <th>Price</th>
                            </thead>
                            <tbody>
                                @foreach($visa_services as $key => $service)
                                <tr>
                                    <th width="5%" class="text-center">
                                        <div class="custom-control custom-radio">
                                            <input  type="radio" id="vs-{{$key}}" class="custom-control-input" onchange="selectService(this)" name="visa_service_id" value="{{$service['unique_id']}}">
                                            <label class="custom-control-label" for="vs-{{$key}}">&nbsp;</label>
                                        </div>
                                    </th>
                                    <td>
                                    {{ $service['visa_service']['name'] }}
                                    </td>
                                    <td>
                                    @if($service['price'] == 0)
                                        <span class="text-danger"> (Free) </span>
                                    @else
                                    ({{currencyFormat().$service['price']}})
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group js-form-message">
                <label class="input-label">Description <span class="input-label-secondary"></span></label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>    
        </form>
        @else
        <div class="text-center">
            <a href="{{ url('/login') }}" class="btn btn-outline-primary">Please Login to Start a Case</a>
        </div>
        @endif
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    initEditor("description"); 
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
