@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      {{$record->name}}
  </td>
  <td>{{$record->CountryName->name}}</td>
  <td> 
    <a href="{{baseUrl('licence-bodies/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp; 
    <a href="javascript:;" class="text-danger" onclick="confirmAction(this)" data-href="{{baseUrl('licence-bodies/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a>   
  </td>
</tr>
@endforeach
