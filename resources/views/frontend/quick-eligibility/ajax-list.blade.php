@if(count($records) > 0)
@foreach($records as $key => $record)
<!-- End Col -->
<div class="col-12 mb-5">
  <!-- Card -->
  <div class="card card-bordered h-100 imm-specific-program-list p-3">
    <!-- Card Body -->

    <div class="imm-specific-program-list-header">
      <a href="javacript:;">{{$record->VisaGroup->ProgramType->name}}</a>
    </div>



    <div class="imm-specific-program-list-body mb-2 ">
      <div class="row align-items-center">


        <div class="col-12">
          <h4 class="card-title mb-2">
            <a class="text-dark" href="javascript:;">{{$record->VisaService->name}}</a><span class="imm-specific-program-score-status">Score based</span>
          </h4>
          <div class="imm-self-assessment-container">
            <div class="row">
              <div class="col-12">
                <div class="d-flex">

                  <img class="me-2" src="./assets/img/checked.svg" alt="" style="width:18px">
                  <p>{{$record->VisaGroup->group_title}}</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- End Row -->

    </div>
    <!-- End Card Body -->

    <!-- Card Footer -->
    <div class="imm-specific-program-list-footer">
      <div class="row align-items-center">
        <div class="col-5"> </div>
        <div class="col-4">
        @if($record->VisaService->eligible_type == 'group_eligible')
            <a href="{{baseUrl('quick-eligibility/g/'.$record->VisaService->unique_id)}}" class="btn btn-info btn-sm w-100">
          @else
            <a href="{{baseUrl('quick-eligibility/check/'.$record->VisaService->unique_id)}}" class="btn btn-info btn-sm w-100">
          @endif
          Start self-assessment
        </a>
          
        </div>
        <div class="col-3">
          <button type="button" class="btn btn-outline-secondary btn-sm w-100">Learn more</button>
        </div>
      </div>
    </div>
    <!-- End Card Footer -->
  </div>
  <!-- End Card -->
</div>
{{--<tr>
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
            <a class="dropdown-item" href="{{baseUrl('quick-eligibility/g/'.$record->unique_id)}}">
          @else
            <a class="dropdown-item" href="{{baseUrl('quick-eligibility/check/'.$record->unique_id)}}">
          @endif
          <i class="tio-checkmark-square dropdown-item-icon"></i>
              Check Eligibility
          </a>
          <a class="dropdown-item" href="{{baseUrl('quick-eligibility/score/'.$record->unique_id)}}">
          <i class="tio-cube dropdown-item-icon"></i>
            Check Score
          </a>
          
        </div>
    </div>
</td>
</tr> --}}

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