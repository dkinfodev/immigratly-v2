@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input value="{{ base64_encode($record->id) }}" type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  
  <td class="table-column-pl-0">
    {{$record->form_title}}
  </td>
 
  <td class="table-column-pl-0">
      <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action-{{$key}}",
            "type": "css-animation"
          }'>More  <i class="tio-chevron-down ml-1"></i>
        </a>
        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{baseUrl('global-forms/edit/'.$record->unique_id)}}">
          <i class="tio-edit dropdown-item-icon"></i>
          Edit
          </a>
          <!-- <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('global-forms/send-form/'.$record->unique_id) ?>')">
          <i class="tio-envelope dropdown-item-icon"></i>
          Send Assessment Link
          </a> -->
          <a class="dropdown-item" href="{{baseUrl('global-forms/preview/'.$record->unique_id)}}">
          <i class="tio-pages-outlined dropdown-item-icon"></i>
            Preview
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('global-forms/delete/'.base64_encode($record->id))}}">
          <i class="tio-delete-outlined dropdown-item-icon"></i>
          Delete
          </a>
        </div>
    </div>
  </td>
  <td>
    @if($record->form_reply != '')
      <a href="{{ baseUrl('global-forms/view/'.$record->unique_id) }}" class="ml-2 btn btn-info btn-sm"><i class="tio-user"></i> Client Replied</a>
    @else
          &nbsp;
    @endif
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