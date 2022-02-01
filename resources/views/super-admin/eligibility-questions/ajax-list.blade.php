@foreach($records as $key => $record)
<tr>
  <td scope="col">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td scope="col">
      {{$record->question}}
  </td>
  <td scope="col">
      @if($record->linked_to_cv == 'yes')
        <span class="badge badge-success">{{$record->cv_section}}</span>
      @else
      <span class="badge badge-danger">Not Linked</span>
      @endif
  </td>
  <td scope="col">
      
      
      @if(count($record->ComponentQuestions) > 0)
        @if($record->isDefaultQues($record->unique_id,$record->visa_service_id) > 0)
          <span class="badge badge-warning">Default Component</span>
        @else
          <span class="badge badge-success">Component</span>
        @endif
      @endif
      @if(count($record->ConditionalQuestions) > 0)
        <span class="badge badge-warning">Conditional</span>
      @endif
      @if(count($record->ConditionalQuestions) <= 0 && count($record->ComponentQuestions) <= 0)
        <span class="badge badge-secondary">None</span>
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
          <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/edit/'.base64_encode($record->id))}}">Edit</a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/set-pre-conditions/'.base64_encode($record->id))}}">Set Pre Condition</a>
          @if($record->QuestionInGroup)
          <!-- <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/set-group-conditions/'.base64_encode($record->id))}}">Set Group Condition</a> -->
          @endif
          @if($visa_service->eligible_type != 'group_eligible')
          <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/set-conditions/'.base64_encode($record->id))}}">Set Condition</a>
          @endif
          @if($record->CombinationalOptions->count() > 0)
            <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/multi-option-groups/'.base64_encode($record->id))}}">Set Multi Options Group</a>
          @endif
          <!--<a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/combinational-options/'.base64_encode($record->id))}}">Multiple Options</a>-->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/delete/'.base64_encode($record->id))}}">Delete</a> 
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
      $("#datatableCounterInfo,.set-eligible-pattern").show();
    }else{
      $("#datatableCounterInfo,.set-eligible-pattern").hide();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
</script>