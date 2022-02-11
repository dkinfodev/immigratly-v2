@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      <span class="d-block h5 text-hover-primary mb-0">{{$record->name}}</span>
  </td>
  <td> 
    <a href="{{baseUrl('document-folder/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> 
    <a href="javascript:;" class="text-danger" onclick="confirmAction(this)" data-href="{{baseUrl('document-folder/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a>   
  </td>
</tr>
@endforeach
