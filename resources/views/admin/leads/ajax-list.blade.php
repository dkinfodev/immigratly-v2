@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
   <td scope="col" class="table-column-pl-0">
      <a class="d-flex align-items-center" href="javascript:;">
        <div class="avatar avatar-soft-primary mt-1 mr-2 avatar-circle">
          <span class="avatar-initials">{{userInitial($record)}}</span>
        </div>
         <!-- <img class="avatar" src="./assets/svg/brands/guideline.svg" alt="Image Description"> -->
         <div class="">
            <span class="d-block h5 text-hover-primary mb-0">{{$record->first_name." ".$record->last_name}}</span>
            <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record->created_at) }}</span>
            <span class="d-block font-size-sm text-body"><i class="tio-email"></i> {{$record->email}}</span>
            <span class="d-block font-size-sm text-body"><i class="tio-android-phone"></i> {{$record->country_code.$record->phone_no}}</span>
            

         </div>
         
      </a>

     

   </td>
   <!-- <td>
      <div>
        <i class="tio-email"></i> {{$record->email}}
      </div>
      <div>
        <i class="tio-android-phone"></i> {{$record->country_code.$record->phone_no}}
      </div>
   </td> -->
   <td scope="col" class="table-column-pl-0">
    @if(!empty($record->VisaService) && !empty($record->Service($record->VisaService->service_id)))
    <a class="badge badge-soft-primary p-2" href="javascript:;">{{$record->Service($record->VisaService->service_id)->name}}</a>
    @else
    <a href="javascript:;" class="badge badge-soft-danger p-2">Service Removed</a>
    @endif
   </td>
   <td scope="col" class="table-column-pl-0">
    <div class="avatar-group avatar-group-xs avatar-circle">
      <?php 
        $more_file = 0;
      ?>
      @foreach($record->AssingedMember as $key2 => $member)
        <?php 
        if($key2 > 1){
          $more_file++;
        }else{
        ?>  
        <a class="avatar js-nav-tooltip-link" href="javascript:;" data-toggle="tooltip" data-placement="top" title="{{ $member->Member->first_name." ".$member->Member->last_name }}">
          <img class="avatar-img" src="{{ professionalProfile($member->Member->unique_id,'t') }}" alt="ID">
        </a>
        <?php } ?>
      @endforeach
      @if($more_file > 0)
        <span class="avatar avatar-light js-nav-tooltip-link avatar-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $member->first_name." ".$member->last_name }}">
          <span class="avatar-initials">{{ $more_file }}+</span>
        </span>
      @endif
    </div>
  </td>
   @if($lead_type == 0 || $lead_type == 2)
   <td scope="col" class="table-column-pl-0">
      <button onclick="showPopup('<?php echo baseUrl('leads/mark-as-client/'.base64_encode($record->id)) ?>')" type="button" class="btn btn-primary btn-xs"><i class="tio-user-switch"></i> Make Client</button>
   </td>
   @endif
   <td class="table-column-pl-0" scope="col">
      <div class="hs-unfold"> 
        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
          data-hs-unfold-options='{
            "target": "#action-{{$key}}",
            "type": "css-animation"
          }'>
                More <i class="tio-chevron-down ml-1"></i>
        </a>

        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
          @if($lead_type == 0)
          <a class="dropdown-item" href="{{baseUrl('leads/edit/'.base64_encode($record->id))}}">
            <i class="tio-edit dropdown-item-icon"></i>
            Edit
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('leads/delete/'.base64_encode($record->id))}}">
            <i class="tio-delete-outlined dropdown-item-icon"></i>
            Delete
          </a> 
          @endif
          <a class="dropdown-item" href="{{ baseUrl('leads/dependants/'.$record->master_id) }}">
            <i class="tio-user dropdown-item-icon"></i> Dependants
          </a>
          <a class="dropdown-item" onclick="showPopup('{{ baseUrl('leads/assign/'.base64_encode($record->unique_id)) }}')" href="javascript:;">
            <i class="tio-edit dropdown-item-icon"></i> Assign Lead
          </a>
          @if(!empty($record->Assessments($record->unique_id)))
          <a class="dropdown-item" href="<?php echo baseUrl('leads/assessments/'.base64_encode($record->unique_id)) ?>" href="javascript:;">
            <i class="tio-pages-outlined dropdown-item-icon"></i> Assessments
          </a>
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
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
})
</script>