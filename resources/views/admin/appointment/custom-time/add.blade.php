<style>
.hidden{
  display: none;
}
</style>

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
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/custom-time/'.$location_id.'/save') }}">  
          @csrf
          <!-- Form Group -->

          <input type="hidden" name="location_id" id="location_id" value="{{$location_id}}">
          

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Type</label>
            <div class="col-sm-9">
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
              <option value="">Select</option>
              <option value="custom-time">Custom Time</option>
              <option value="day-off">Day Off</option>
            </select>

              @error('type')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Date</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('date') is-invalid @enderror" name="date" id="date" placeholder="Enter Date" aria-label="Enter Date" value="">
              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->


          <div class="row form-group desc hidden js-form-message">
            <label class="col-sm-3 col-form-label input-label">Description</label>
            <div class="col-sm-9">
              <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Enter Description" aria-label="Enter description" value="">
              @error('description')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row time hidden form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">From</label>
            <div class="col-sm-9">
             <!--  <input type="date" class="form-control @error('from') is-invalid @enderror" name="date" id="date" placeholder="Enter Date" aria-label="Enter Date" value=""> -->

              <input type="text" class="js-masked-input form-control from"  id="from" name="from" placeholder="xx:xx"
                                data-hs-mask-options='{
                                "template": "00:00"
                                }'>


              @error('from')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->


          <!-- Form Group -->
          <div class="row time hidden form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">To</label>
            <div class="col-sm-9">
             <!--  <input type="date" class="form-control @error('from') is-invalid @enderror" name="date" id="date" placeholder="Enter Date" aria-label="Enter Date" value=""> -->

             <input type="text" class="js-masked-input form-control from"  id="to" name="to" placeholder="xx:xx"
                                data-hs-mask-options='{
                                "template": "00:00"
                                }'>

              @error('to')
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

    $('.js-masked-input').each(function () {
      $.HSCore.components.HSMask.init($(this));
    });

    $('#date').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          maxDate:(new Date()).getDate(),
          todayHighlight: true,
          orientation: "bottom auto"
        });

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

    $("#type").change(function(){
        if($(this).val() == "custom-time"){
            $(".time").removeClass("hidden"); 
            $(".desc").addClass("hidden"); 
                  
        }else if($(this).val() == "day-off"){
            $(".time").addClass("hidden");
            $(".desc").removeClass("hidden"); 
            $("#from").val = "";
            $("#to").val = "";
        }
        else{
           $(".time").addClass("hidden");
           $(".desc").addClass("hidden");
        }
    });
</script>