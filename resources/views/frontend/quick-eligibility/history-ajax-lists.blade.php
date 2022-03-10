@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{$record->VisaService->name}}
  </td>
  <td class="table-column-pl-0">
    {{dateFormat($record->created_at)}}
  </td>
  
  <td class="table-column-pl-0">
    <a href="{{ baseUrl('/quick-eligibility/report/'.$record->unique_id) }}" class="btn btn-primary">View Report</a>
  </td>
</tr>
@endforeach


<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $(".row-checkbox").change(function(){
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").show();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
</script>
