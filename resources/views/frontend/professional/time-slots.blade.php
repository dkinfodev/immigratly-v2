<div class="modal-dialog modal-xl" role="document">
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
      <form method="post" id="popup-form"  action="{{ baseUrl('/place-booking') }}">
          @csrf

          <input type="hidden" name="professional" value="{{$professional}}" />
          <input type="hidden" name="location_id" value="{{$location_id}}" />
          <input type="hidden" name="interval" value="{{$interval}}" />          
          <input type="hidden" name="schedule_id" value="{{$schedule_id}}" />
          <input type="hidden" name="date" value="{{$date}}" />
          <div class="imm-education-add-inner">
                <h3>Available time slot for {{$date}}</h3>
                <div class="row js-form-message">
                @foreach($time_slots as $key => $slot)
                <div class="col-3">
                    <div class="card text-center bg-light mb-3">
                        <div class="card-body">
                            <h3>{{$slot['start_time']}} to {{$slot['end_time']}}</h3>
                        </div>
                        <div class="card-footer">
                                <div class="form-group">
                                <!-- Checkbox -->
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="duration-{{$key}}" class="custom-control-input" name="duration" value="{{$slot['start_time'].'-'.$slot['end_time']}}">
                                        <label class="custom-control-label" for="duration-{{$key}}">Select Duration</label>
                                    </div>
                                    <!-- End Checkbox -->
                                </div>
                        </div>
                    </div>
                </div>
                  @endforeach
            </div>
          </div>
      </form>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Book Slot</button>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    initSelect('#popup-form ');
    
    $("#popup-form").submit(function(e){
        e.preventDefault();
        var duration = $("input[name=duration]:checked").val();
        if(duration == undefined){
          alert ("Select your time slot");
          return false;
        }
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