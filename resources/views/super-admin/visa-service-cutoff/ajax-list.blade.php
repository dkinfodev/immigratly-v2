@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      {{dateFormat($record->cutoff_date)}}
  </td>
  <td class="table-column-pl-0">
      {{$record->cutoff_point}}
  </td>
  <td> 
      <a href="{{baseUrl('visa-services/cutoff/'.$visa_service_id.'/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a>
      <a href="javascript:;" class="text-danger" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/cutoff/'.$visa_service_id.'/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  </td>
</tr>
@endforeach
