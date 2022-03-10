@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{$record->assessment_title}}
  </td>
  <td class="table-column-pl-0">
    @if(!empty($record->VisaService))
      {{$record->VisaService->name}}
    @else
      <span class="text-danger">N/A</span>
    @endif
  </td>
  <td class="table-column-pl-0">{{$record->amount_paid}}</td>
  <td class="table-column-pl-0">
    @if($record->Invoice->payment_status == 'paid')
        <span class="badge badge-success">{{$record->Invoice->payment_status}}</span>
    @else
        <span class="badge badge-danger">{{$record->Invoice->payment_status}}</span>
    @endif
  </td>
  <td class="table-column-pl-0">
    @if($record->professional_assigned == 1)
        <div class="text-primary">
          <?php
          $company_data = professionalDetail($record->professional);
          if(!empty($company_data)){
            echo "<div class='text-danger'><i class='tio-user'></i> ".$company_data->company_name."</div>";
          }
          ?>
        </div>
    @else
      <span class="badge badge-warning">Professional not assigned</span>
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
          <a class="dropdown-item" href="{{baseUrl('assessments/edit/'.$record->unique_id)}}">Edit</a>
        @if($record->professional_assigned == 0)
        <a class="dropdown-item" href="{{baseUrl('assessments/view/'.$record->unique_id)}}">View</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('assessments/delete/'.base64_encode($record->id))}}">Delete</a> 
        @else
        <a class="dropdown-item" href="{{baseUrl('assessments/view/'.$record->unique_id)}}">View</a>
        @endif
        
        
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