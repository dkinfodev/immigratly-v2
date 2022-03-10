@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->name}}</span>
      </div>
    </a>
  </td>
  <td class="table-column-pl-0">
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->slug}}</span>
      </div>
    </a>
  </td>
  <td> 

      <a href="{{baseUrl('privileges/action/'.base64_encode($moduleId).'/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp; 
      <a href="javascript:;" class="text-danger" onclick="confirmAction(this)" data-href="{{baseUrl('privileges/action/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@endforeach
