@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <!-- <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th> -->
  <td class="table-column-pl-0">
      {{$record->name}}
    </a>
  </td>
  <td> 
    <!-- <a href="{{baseUrl('visa-services/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> 
    <a href="javascript:;" onclick="deleteRecord('{{ base64_encode($record->id) }}')" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a>  -->
    <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action-{{$key}}",
            "type": "css-animation"
          }'>More  <i class="tio-chevron-down ml-1"></i>
        </a>
        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
          @if($record->eligible_type == 'group_eligible')
            <a class="dropdown-item" href="{{baseUrl('eligibility-check/g/'.$record->unique_id)}}">
          @else
            <a class="dropdown-item" href="{{baseUrl('eligibility-check/check/'.$record->unique_id)}}">
          @endif
          <i class="tio-checkmark-square dropdown-item-icon"></i>
              Check Eligibility
          </a>
          <a class="dropdown-item" href="{{baseUrl('eligibility-check/score/'.$record->unique_id)}}">
          <i class="tio-cube dropdown-item-icon"></i>
            Check Score
          </a>
          
        </div>
    </div>
</td>
</tr>

@endforeach
@endif

<script>
$(document).ready(function(){
  $(".parent-check").change(function(){
      var key = $(this).attr("data-key");
      if($(this).is(":checked")){
        $(".parent-"+key).prop("checked",true);
      }else{
        $(".parent-"+key).prop("checked",false);
      }
  })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>