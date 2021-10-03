@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  
  <td class="table-column-pl-0">
      {!! substr($record->description,0,100) !!}...
  </td>

 
  <td> 
    @if(employee_permission('visa-content','edit-visa-content'))
      <a href="{{baseUrl('visa-services/content/'.$visa_service_id.'/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a>
    @endif
    @if(employee_permission('visa-content','delete-visa-content'))
      <a href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/content/'.$visa_service_id.'/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
    @endif
  </td>
</tr>
@endforeach
