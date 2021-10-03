@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="usersDataCheck1">
      <label class="custom-control-label" for="usersDataCheck1"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->name}}</span>
      </div>
    </a>
  </td>


  <td> <a href="{{baseUrl('documents/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp; <a href="{{baseUrl('documents/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@endforeach
