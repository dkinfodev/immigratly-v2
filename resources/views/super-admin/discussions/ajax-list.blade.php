@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ $record->unique_id }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  
  <td>
    <div class="d-flex">
      {{$record->group_title}}
    </div>
  </td>
  <td>{{$record->User->first_name." ".$record->User->last_name}}</td>
  <td>{{dateFormat($record->created_at)}}</td>
  <td>
    @if($record->status=='open')
      <label class="toggle-switch toggle-switch-sm d-flex align-items-center mb-3" for="status-{{$record->id}}">
        <input type="checkbox" data-id="{{ $record->unique_id }}" onchange="changeStatus(this)" checked class="toggle-switch-input" id="status-{{$record->id}}" value="open">
        <span class="toggle-switch-label">
          <span class="toggle-switch-indicator"></span>
        </span>
        <span class="toggle-switch-content">
          <span class="d-block">Open</span>
        </span>
      </label>
    @else
      <label class="toggle-switch toggle-switch-sm d-flex align-items-center mb-3" for="status-{{$record->id}}">
        <input type="checkbox" data-id="{{ $record->unique_id }}" onchange="changeStatus(this)" class="toggle-switch-input" id="status-{{$record->id}}" value="close">
        <span class="toggle-switch-label">
          <span class="toggle-switch-indicator"></span>
        </span>
        <span class="toggle-switch-content">
          <span class="d-block">Close</span>
        </span>
      </label>
    @endif
  </td>
  <td scope="col">
    <a class="js-nav-tooltip-link" data-toggle="tooltip" data-placement="top" title="View Group Comments" data-original-title="View Group Comments" href="{{ baseUrl('discussions/comments/'.$record->unique_id) }}">
      <i class="tio-chat-outlined"></i>
      {{$record->comments_count}}
    </a>
  </td>
  <td>
    <div class="row">
      <div class="col-auto">
        <div class="hs-unfold">
          <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
             data-hs-unfold-options='{
               "target": "#action-{{$key}}",
               "type": "css-animation"
             }'>
                  More <i class="tio-chevron-down ml-1"></i>
          </a>

          <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <a class="dropdown-item" href="{{baseUrl('discussions/edit/'.$record->unique_id)}}">Edit</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('discussions/delete/'.$record->unique_id)}}">Delete</a> 
          </div>
        </div>
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