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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/leads/mark-as-client/'.base64_encode($lead_id)) }}">  
          @csrf
          <!-- Form Group -->
           <p class="text-danger">*To mark lead of <span class="badge badge-soft-primary">{{$lead->first_name." ".$lead->last_name}}</span> as client of for visa service 
            @if(!empty($lead->Service($lead->VisaService->service_id)))
            <span class="badge badge-soft-primary">{{$lead->Service($lead->VisaService->service_id)->name}}</span>
            @endif
            please fill below details
           </p>
           <div class="form-group js-form-message">
              <label class="input-label">Case Title <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Displayed on public forums, such as Front."></i></label>
              <div class="input-group input-group-merge">
                 <div class="input-group-prepend">
                    <div class="input-group-text">
                       <i class="tio-briefcase-outlined"></i>
                    </div>
                 </div>
                 <input type="text" data-msg="Please enter case title" class="form-control" name="case_title" id="case_title" placeholder="Enter case title here" aria-label="Enter case title here">
              </div>
           </div>
           <div class="row">
              <div class="col-sm-6">
                 <!-- Form Group -->
                 <div class="form-group js-form-message">
                    <label class="input-label">Start date</label>
                    <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                       <div class="input-group-prepend" data-toggle>
                          <div class="input-group-text">
                             <i class="tio-date-range"></i>
                          </div>
                       </div>
                       <input data-msg="Please select start date" type="text" name="start_date" class="flatpickr-custom-form-control form-control" id="start_date" placeholder="Select Start Date" data-input value="">
                    </div>
                 </div>
                 <!-- End Form Group -->
              </div>
              <div class="col-sm-6">
                 <!-- Form Group -->
                 <div class="form-group js-form-message">
                    <label class="input-label">End date</label>
                    <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                       <div class="input-group-prepend" data-toggle>
                          <div class="input-group-text">
                             <i class="tio-date-range"></i>
                          </div>
                       </div>
                       <input type="text" data-msg="Please select end date" name="end_date" class="flatpickr-custom-form-control form-control" id="end_date" placeholder="Select End Date" data-input value="">
                    </div>
                 </div>
                 <!-- End Form Group -->
              </div>
           </div>
           <!-- End Form Group -->
          <div id="response" class="text-center"></div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Mark as Client</button>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    // initSelect();
    $('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate:(new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
    $('#end_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate:(new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
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
              $("#response").addClass('');
              $("#response").html('');
              if(response.status == true){
                closeModal();
                successMessage(response.message);
                // popupModal("<?php echo baseUrl('cases/create-case') ?>/"+response.user_id);
                loadData();
              }else{
                if(response.error_type = 'validation'){
                  validation(response.message);
                }else{
                  $("#response").addClass("text-danger");
                  $("#response").html(response.message);  
                }
                
              }
            },
            error:function(){
              internalError();
            }
        });
    });
});
</script>