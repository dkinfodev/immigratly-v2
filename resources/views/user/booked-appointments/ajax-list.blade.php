@foreach($records as $key => $record)
<tr>
  <!-- <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td> -->
  <td>
    <a class="d-flex align-items-center" href="javascript:;">
        <?php
          $company_data = professionalDetail($record->professional);
          // $company_data = array();
          if(!empty($company_data)){
            echo "<div class='text-danger'>".$company_data->company_name."</div>";
          }
        ?>
    </a>
    @php 
    $location = professionalLocation($record->location_id,$record->professional);
    @endphp
    @if(!empty($location))
    <i class='tio-globe'></i> {{$location->address}}
    @endif
  </td>
  <td class="table-column-pl-0">
    @php 
    $visa_service = professionalService($record->professional,$record->visa_service_id,'unique_id');

    @endphp
    @if(!empty($visa_service->visa_service))
      {{$visa_service->visa_service->name}}
    @endif
  </td>
  <td class="table-column-pl-0">
      {{dateFormat($record->appointment_date)}}<br>
      {{$record->start_time." ".$record->end_time}}
  </td>
  <td class="table-column-pl-0">
      {{$record->meeting_duration }} Minutes
  </td>
  <td class="table-column-pl-0">
      @if($record->status == 'awaiting')
      <span class="badge badge-warning">{{$record->status}}</span>
      @elseif($record->status == 'approved')
      <span class="badge badge-success">{{$record->status}}</span>
      @else
      <span class="badge badge-danger">{{$record->status}}</span>
      @endif
  </td>
  <td class="table-column-pl-0">
      @if($record->payment_status == 'pending')
      <span class="badge badge-warning">{{$record->payment_status}}</span>
      @if($record->payment_status != 'paid')
          <!-- <a class="text-primary" href="{{baseUrl('appointment-payment/'.$record->unique_id)}}"><i class="tio-dollar"></i> Click to Pay</a> -->
        @endif
      @elseif($record->payment_status == 'paid')
      <span class="badge badge-success">{{$record->payment_status}}</span>
      @else
      <span class="badge badge-danger">{{$record->payment_status}}</span>
     
      @endif
  </td>
  <td class="table-column-pl-0">
    @if($record->appointment_date > date("Y-m-d"))
    <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>
      
      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('professional/'.$record->professional.'/book-appointment/'.$record->location_id)}}?service_id={{ $record->visa_service_id }}&action=edit&eid={{ $record->unique_id }}">Edit</a>
        @if($record->payment_status != 'paid')
        <a class="dropdown-item" href="{{baseUrl('appointment-payment/'.$record->unique_id)}}">Pay Now</a>
        @endif
        {{-- <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('booked-appointments/delete/'.base64_encode($record->id))}}">Delete</a> --}}
        
      </div>
    </div>
    @else
    <span class="text-danger">Appointment End</span>
    @endif
  </td>
</tr>
@endforeach


<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $(".row-checkbox").change(function(){
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").show();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
</script>