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
      {{$record->name}}
  </td>
  <td class="table-column-pl-0">
    @if(!empty($record->CvTypeDetail))
      {{$record->CvTypeDetail->name}}
    @else
      <span class="text-danger">None</span>
    @endif
  </td>
  <td class="table-column-pl-0">
    {{ ucwords(str_replace("_"," ",($record->eligible_type))) }}
  </td>
  <td> 
    <!-- <a href="{{baseUrl('visa-services/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> 
    <a href="javascript:;" onclick="deleteRecord('{{ base64_encode($record->id) }}')" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a>  -->
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
          <a class="dropdown-item" href="{{baseUrl('visa-services/edit/'.base64_encode($record->id))}}">
          <i class="tio-edit dropdown-item-icon"></i>
          Edit
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/cutoff/'.base64_encode($record->id))}}">
          <i class="tio-pages-outlined dropdown-item-icon"></i>
          Cut Off Points
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/content/'.base64_encode($record->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Contents
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/additional-information/'.base64_encode($record->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Additional Information
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($record->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Eligibility Questions
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/score-range/'.base64_encode($record->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Score Range
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}">
          <i class="tio-delete-outlined dropdown-item-icon"></i>
          Delete
          </a>
        </div>
    </div>
</td>
</tr>
@foreach($record->SubServices as $key2 => $subservice)
<tr class="subservice pl-3">
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-{{ $key }}" id="sub-{{$key2}}" type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($subservice->id) }}">
      <label class="custom-control-label" for="sub-{{$key2}}"></label>
    </div>
  </th>
  <td class="table-column-pl-2 text-primary">
      {{$subservice->name}}
  </td>
  <td class="table-column-pl-0">
    @if(!empty($subservice->CvTypeDetail))
      {{$subservice->CvTypeDetail->name}}
    @else
      <span class="text-danger">None</span>
    @endif
  </td>
  <td class="table-column-pl-0">
    {{ ucwords(str_replace("_"," ",($record->eligible_type))) }}
  </td>
  <td> 
    <!-- <a href="{{baseUrl('visa-services/edit/'.base64_encode($subservice->id))}}"><i class="tio-edit"></i></a> &nbsp; 
    <a href="javascript:;" onclick="deleteRecord('{{ base64_encode($subservice->id) }}')" data-href="{{baseUrl('visa-services/delete/'.base64_encode($subservice->id))}}"><i class="tio-delete"></i></a>  -->
    <?php 
      $index2 = randomNumber(5);
    ?>
    <div class="hs-unfold">
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action2-{{$index2}}",
            "type": "css-animation"
          }'>More  <i class="tio-chevron-down ml-1"></i>
        </a>
        <div id="action2-{{$index2}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{baseUrl('visa-services/edit/'.base64_encode($subservice->id))}}">
          <i class="tio-edit dropdown-item-icon"></i>
          Edit
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/cutoff/'.base64_encode($subservice->id))}}">
          <i class="tio-pages-outlined dropdown-item-icon"></i>
          Cut Off Points
          </a>
          <a class="dropdown-item" href="{{baseUrl('visa-services/content/'.base64_encode($subservice->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Contents
          </a>
          <!-- <a class="dropdown-item" href="{{baseUrl('visa-services/eligibility-questions/'.base64_encode($subservice->id))}}">
          <i class="tio-pages dropdown-item-icon"></i>
          Eligibility Questions
          </a> -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}">
          <i class="tio-delete-outlined dropdown-item-icon"></i>
          Delete
          </a>
        </div>
    </div>
  </td>
</tr>
@endforeach
@endforeach
@else
<tr>
  <td colspan="3" class="text-center text-danger">No records available</td>
</tr>
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