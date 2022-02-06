@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pl-0 " >
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td scope="col" class="table-column-pl-0">
      <div class="">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->name}}</span>
      </div>
    </a>
  </td>

  <td scope="col" class="table-column-pl-0"> 
      <a href="{{baseUrl('language-proficiency/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp; 
      <a href="javascript:;" class="text-danger" onclick="confirmAction(this)" data-href="{{baseUrl('language-proficiency/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@endforeach
