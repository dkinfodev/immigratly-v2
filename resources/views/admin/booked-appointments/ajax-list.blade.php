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
          if($record->lead_id != ''){
             $client = $record->Lead($record->lead_id);
          }else{
            $client = $record->Client($record->client_id);
          }
          
        ?>
        <span class="avatar-initials">{{userInitial($client)}}</span>
      </div>
        <!-- <img class="avatar" src="./assets/svg/brands/guideline.svg" alt="Image Description"> -->
        <div class="ml-3">
          <span class="d-block h5 text-hover-primary mb-0">{{$client->first_name." ".$client->last_name }}</span>
          <div class="d-block text-danger">Appointment ID: {{$record->unique_id}}</div>
        </div>
    </a>
  </td>
  <!-- <td class="table-column-pl-0">
    
  </td> -->
  <td class="table-column-pl-0">
    @php 
    $location = professionalLocation($record->location_id);
    @endphp
    @if(!empty($location))
      {{$location->address}}
    @endif
  </td>
  <td class="table-column-pl-0">
    @php 
    $visa_service = professionalService(\Session::get('subdomain'),$record->visa_service_id,'unique_id');
   
    @endphp
    @if(!empty($visa_service->visa_service))
      {{$visa_service->visa_service->name}}
    @endif
  </td>
  <td class="table-column-pl-0">
      {{dateFormat($record->appointment_date)}}<br>
      {{$record->start_time." ".$record->end_time}}<br>
      ({{$record->meeting_duration }} Minutes)
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
      @if($record['appointment_date'] > date("Y-m-d"))
        <div class="btn-group">
          @if($record->status == 'awaiting' || $record->status == 'reject')
            <a class="p-2 btn btn-sm btn-success mr-2 js-nav-tooltip-link" href="{{baseUrl('booked-appointments/status/'.$record->unique_id)}}/approved" data-toggle="tooltip" data-html="true" title="Click to Approved"><i class="tio-done"></i></a>
          @endif

            <a class="p-2 btn btn-sm btn-warning mr-2 js-nav-tooltip-link" href="{{baseUrl('booked-appointments/view/'.$record->unique_id)}}" data-toggle="tooltip" data-html="true" title="Click to View"><i class="tio-book-opened"></i></a>
            <a class="p-2 btn btn-sm btn-danger mr-2 js-nav-tooltip-link" href="{{baseUrl('booked-appointments/status/'.$record->unique_id)}}/reject" data-toggle="tooltip" data-html="true" title="Click to Reject"><i class="tio-clear-circle"></i></a>
            <a class="p-2 btn btn-sm btn-info js-nav-tooltip-link" href="{{baseUrl('booked-appointments/reschedule-appointment/'.$record->unique_id)}}" data-toggle="tooltip" data-html="true" title="Click to Reschedule"><i class="tio-calendar"></i></a>
        </div>
      @else
        <span class="badge badge-warning">Appointment Expired</span>
      @endif
     
  </td>
</tr>
@endforeach


<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
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