@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th>
  <td class="table-column-pl-0">
      {{$record->name}}
    </a>
  </td>
  <td> 
  
    <a class="text-primary" href="{{baseUrl('visa-services/content/'.base64_encode($record->id))}}"><i class="tio-pages-outlined nav-icon"></i> Visa Content</a> 
  
</td>
</tr>
@foreach($record->SubServices as $key2 => $subservice)
<tr class="subservice pl-3">
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-{{ $key }}" id="sub-{{$key2}}" type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($subservice->id) }}">
      <label class="custom-control-label" for="sub-{{$key2}}"></label>
    </div>
  </th>
  <td class="table-column-pl-2 text-primary">
      {{$subservice->name}}
    </a>
  </td>
  <td> 
    <a class="text-primary" href="{{baseUrl('visa-services/content/'.base64_encode($record->id))}}"><i class="tio-pages-outlined nav-icon"></i> Visa Content</a> 
  </td>
</tr>
@endforeach
@endforeach
@else
<tr>
  <td colspan="3" class="text-center text-danger">No records available</td>
</tr>
@endif

<script>
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
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