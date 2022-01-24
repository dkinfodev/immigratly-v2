@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th>
  <td class="table-column-pl-0">
      {{$record->group_title}}
  </td>
  <!-- <td>
    @if(!empty($record->VisaServices))
      @foreach($record->VisaServices as $visa_service)
        {{$visa_service->VisaService->name}}
      @endforeach
    @endif
  </td> -->
  <td> 
    <?php 
      $index = randomNumber(5);
    ?>
    <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action-{{$index}}",
            "type": "css-animation"
          }'>More  <i class="tio-chevron-down ml-1"></i>
        </a>
        <div id="action-{{$index}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{baseUrl('visa-service-groups/edit/'.base64_encode($record->id))}}">
          <i class="tio-edit dropdown-item-icon"></i>
          Edit
          </a>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-service-groups/delete/'.base64_encode($record->id))}}">
          <i class="tio-delete-outlined dropdown-item-icon"></i>
          Delete
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