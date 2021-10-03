@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      {{$record->name}}
      
  </td>
  <td class="table-column-pl-0">
     {{$record->slug}}
      
  </td>
  <td>
    <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>More  <i class="tio-chevron-down ml-1"></i>
      </a>
      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('employee-privileges/edit/'.base64_encode($record->id))}}">
         <i class="tio-edit dropdown-item-icon"></i>
         Edit
        </a>
        <a class="dropdown-item" href="{{baseUrl('employee-privileges/action/'.base64_encode($record->id))}}">
         <i class="tio-pages-outlined dropdown-item-icon"></i>
         Module Actions
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('employee-privileges/delete/'.base64_encode($record->id))}}">
         <i class="tio-delete-outlined dropdown-item-icon"></i>
         Delete
        </a>
        
      </div>
    </div>
   </td>
  
</tr>
@endforeach

<script type="text/javascript">
$(document).ready(function(){

  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>