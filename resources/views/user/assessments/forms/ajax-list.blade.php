@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input value="{{ $record['unique_id'] }}" type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  
  <td class="table-column-pl-0">
    {{$record->form_title}}
  </td>
  
  <td class="table-column-pl-0">
  <a class="btn btn-primary btn-sm" href="{{baseUrl('assessments/forms/'.$assessment_id.'/view/'.$record->unique_id)}}">View</a>
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