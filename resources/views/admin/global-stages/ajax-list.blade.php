@foreach($records as $key => $record)
<tr>
    <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}"
                value="{{ base64_encode($record->id) }}">
            <label class="custom-control-label" for="row-{{$key}}"></label>
        </div>
    </td>
    <td class="table-column-pl-0">
        <div class="ml-3">
            <span class="d-block  mb-0">{{$record->name}}</span>
        </div>
    </td>
    <td class="table-column-pl-0">
        <div class="ml-3">
          @if($record->visa_service_id != 0)
            <span class="d-block  mb-0">
              @php 
                $visa_service = $record->Service($record->visa_service_id);
                if(!empty($visa_service)){
                  echo $visa_service->name;
                }else{
                  echo "N/A";
                }
              @endphp
            </span>
          @else
            <span class="d-block  mb-0">Not Linked to Service</span>
          @endif
        </div>
    </td>
    <td>
        <a href="{{baseUrl('global-stages/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp;
        <a href="javascript:;" class="text-danger" onclick="confirmAction(this)"
            data-href="{{baseUrl('global-stages/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a>

    </td>
</tr>
@endforeach