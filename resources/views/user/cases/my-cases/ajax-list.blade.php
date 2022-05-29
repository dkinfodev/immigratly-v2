@foreach($records as $key => $record)

<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{$record->case_title}}
  </td>
  <td class="table-column-pl-0">
    @if(!empty($record->VisaService))
      {{$record->VisaService->name}}
    @else
      <span class="text-danger">N/A</span>
    @endif
  </td>

  <td class="table-column-pl-0">
    @if($record->assign_case == 1)
      <span class="text-success">Case Awarded</span>
      <div class="text-danger">
        @php 
          $company_data = professionalDetail($record->assign_to);
          echo $company_data->company_name;
        @endphp
      </div>
    @else
    <span class="text-warnging">Pending</span>
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
      @if($record->assign_case == 0)
          <a class="dropdown-item" href="{{baseUrl('my-cases/edit/'.$record->unique_id)}}">Edit</a>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('my-cases/delete/'.base64_encode($record->id))}}">Delete</a>        
      @endif
          <a class="dropdown-item" href="{{baseUrl('my-cases/view/'.$record->unique_id)}}">View</a>
          
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