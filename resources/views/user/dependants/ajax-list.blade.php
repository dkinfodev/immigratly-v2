@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{$record->family_name}}
  </td>
  <td class="table-column-pl-0">
    {{$record->given_name}}
  </td>
  <td class="table-column-pl-0">
    {{$record->date_of_birth}}
  </td>
  <td class="table-column-pl-0">
    {{$record->gender}}
  </td>
  <td class="table-column-pl-0">
    @if($record->is_approved == 1)
      <span class="badge badge-success">Approved</span>
    @else
      <span class="badge badge-danger">Pending Approval</span>
    @endif
  </td>
  <td class="table-column-pl-0">
   
    <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>

      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('dependants/edit/'.$record->unique_id)}}">Edit</a>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('dependants/delete/'.base64_encode($record->id))}}">Delete</a> 
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