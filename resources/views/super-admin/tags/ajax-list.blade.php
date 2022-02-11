@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>

  <td>
      {{$record->name}}
  </td>
  <td> 
     <a onclick="showPopup('{{ baseUrl('tags/edit/'.base64_encode($record->id)) }}')" href="javascript:;">
          <i class="tio-edit"></i>
     </a>
    <a href="javascript:;" class="text-danger" onclick="confirmAction(this)" data-href="{{baseUrl('tags/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@endforeach
@endif

<script>
$(document).ready(function(){
  $(".parent-check").change(function(){
      var key = $(this).attr("data-key");
      if($(this).is(":checked")){
        $(".parent-"+key).prop("checked",true);
      }else{
        $(".parent-"+key).prop("checked",false);
      }
  })
})
</script>