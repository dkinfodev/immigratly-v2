@foreach($records as $key => $record)
<tr>
  <td scope="col">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td scope="col">
      {{$record->component_title}}
      @if($record->is_default == 1)
            <span class='text-danger'>(Default)</span>
      @endif
  </td>
  <td scope="col">
      <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
            data-hs-unfold-options='{
              "target": "#action-{{$key}}",
              "type": "css-animation"
            }'>
                More <i class="tio-chevron-down ml-1"></i>
        </a>

        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
          <a class="dropdown-item" href="{{baseUrl('visa-services/component-questions/'.$visa_service_id.'/edit/'.base64_encode($record->id))}}">Edit</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/component-questions/'.$visa_service_id.'/delete/'.base64_encode($record->id))}}">Delete</a> 
        </div>
      </div>
      
  </td>
</tr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
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