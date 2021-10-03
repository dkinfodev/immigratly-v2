@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <th width="5%">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record['id']) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th>

  <td>
      <a target="_blank" href="{{$record['url']}}"> {{$record['url']}} </a>
  </td>
  <td>
      {{$record['cron_time']}}
  </td>
  <td> 
     <!-- <a onclick="showPopup('{{ baseUrl('cron-urls/edit/'.base64_encode($record['id'])) }}')" href="javascript:;">
          <i class="tio-edit"></i>
     </a> -->
     <a  href="{{ baseUrl('cron-urls/history/'.base64_encode($record['id'])) }}" href="javascript:;" class="btn btn-sm btn-warning">
          <i class="fa fa-eye"></i> View Screenshot
     </a>
    <a href="javascript:;" onclick="confirmAction(this)" class="btn btn-sm btn-danger" data-href="{{baseUrl('cron-urls/delete/'.base64_encode($record['id']))}}"><i class="tio-delete"></i></a> 
  
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