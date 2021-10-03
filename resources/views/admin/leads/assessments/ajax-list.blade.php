@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  
  <td>
    {{$record['unique_id']}}
  </td>
  <td>
    {{$record['assessment']['assessment_title']}}
  </td>
  <td>{{$record['assessment_form']['form_title']}}</td>
  <td>
    @if(!empty($record['assessment']['visa_service']['name']))
    {{$record['assessment']['visa_service']['name']}}
    @else
      <span class="text-danger">NA</span>
    @endif
  </td>
  
  <td>
    {{dateFormat($record['created_at'])}}
  </td>
  
  <td>
    <a class="btn btn-primary btn-sm" href="{{baseUrl('leads/assessments-view/'.$record['unique_id'])}}">View</a>
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