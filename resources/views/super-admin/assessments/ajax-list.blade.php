@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{$record->Client->first_name." ".$record->Client->last_name}}
  </td>
  <td class="table-column-pl-0">
    <a class="text-primary" href="{{baseUrl('assessments/view/'.$record->unique_id)}}">{{$record->assessment_title}}</a>
  </td>
  <td class="table-column-pl-0">
    @if(!empty($record->VisaService))
    {{$record->VisaService->name}}
    @else
    <span class="text-danger">NA</span>
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
  @if($assigned == 1 && $record->professional != '')
    <?php
      $company_data = professionalDetail($record->professional);
      if(!empty($company_data)){
    ?>
      <td class="table-column-pl-0">
          {{$company_data->company_name}}
      </td>
    <?php
      }
    ?>
  @endif
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
        <a class="dropdown-item" href="{{baseUrl('assessments/view/'.$record->unique_id)}}"><i class="tio-comment-text-outlined"></i> View Assessment</a>
        <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('assessments/assign-to-professional/'.$record->unique_id) ?>')"><i class="tio-user"></i> Assign to Professioanal</a>
        <div class="dropdown-divider"></div>
        <!-- <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('assessments/delete/'.base64_encode($record->id))}}">Delete</a>  -->
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