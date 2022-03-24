@foreach($records as $key => $record)
<tr>
  <!-- <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td> -->
  <td class="table-column-pl-0">
    <a class="d-flex align-items-center" href="javascript:;">
      <div class="avatar avatar-soft-primary mt-4 avatar-circle">
        <?php
          $client = userDetail($record['client']['unique_id']);
        ?>
        <span class="avatar-initials">{{userInitial($client)}}</span>
      </div>
        <!-- <img class="avatar" src="./assets/svg/brands/guideline.svg" alt="Image Description"> -->
        <div class="ml-3">
          <span class="d-block h5 text-hover-primary mb-0">{{$record['client']['first_name']." ".$record['client']['last_name'] }}</span>
          <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record['created_at']) }}</span>
          
        </div>
    </a>
  </td>
  <!-- <td class="table-column-pl-0">
    
  </td> -->
  <td class="table-column-pl-0">
    @php 
    $location = professionalLocation($record['location_id']);
    @endphp
    @if(!empty($location))
      {{$location->address}}
    @endif
  </td>
  <td class="table-column-pl-0">
    @php 
    $visa_service = professionalService($record['professional'],$record['visa_service_id'],'unique_id');

    @endphp
    @if(!empty($visa_service->visa_service))
      {{$visa_service->visa_service->name}}
    @endif
  </td>
  <td class="table-column-pl-0">
      {{dateFormat($record['appointment_date'])}}<br>
      {{$record['start_time']." ".$record['end_time']}}<br>
      ({{$record['meeting_duration'] }} Minutes)
  </td>
  <td class="table-column-pl-0">
      @if($record['status'] == 'awaiting')
      <span class="badge badge-warning">{{$record['status']}}</span>
      @elseif($record['status'] == 'approved')
      <span class="badge badge-success">{{$record['status']}}</span>
      @else
      <span class="badge badge-danger">{{$record['status']}}</span>
      @endif
  </td>
  <td class="table-column-pl-0">
      @if($record['payment_status'] == 'pending')
      <span class="badge badge-warning">{{$record['payment_status']}}</span>
      @elseif($record['payment_status'] == 'paid')
      <span class="badge badge-success">{{$record['payment_status']}}</span>
      @else
      <span class="badge badge-danger">{{$record['payment_status']}}</span>
      @endif
  </td>
  <td class="table-column-pl-0">
    {{currencyFormat().$record['price']}}
  </td>
  <td class="table-column-pl-0">
      @if($record['status'] == 'awaiting' || $record['status'] == 'reject')
        <a class="badge badge-success" href="{{baseUrl('booked-appointments/status/'.$record['unique_id'])}}/approved">Click to Approve</a>
      @endif
        <a class="badge badge-danger" href="{{baseUrl('booked-appointments/status/'.$record['unique_id'])}}/reject">Click to Reject</a>
     
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