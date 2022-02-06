@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    <a class="d-flex align-items-center" href="#">
      @if($record->profile_image != '' &&  file_exists(professionalDir().'/profile/'.$record->profile_image))
      <img class="avatar" src="{{ professionalProfile($record->unique_id,'t')}}" alt="Profile Image">
      @else
      <div class="avatar avatar-soft-primary avatar-circle">
        <span class="avatar-initials">{{userInitial($record)}}</span>
      </div>
      @endif
      
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->first_name." ".$record->last_name}}</span>
        <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record->created_at) }}</span>
        <span class="d-block  font-size-sm text-body">{{$record->email}}</span>
        <span class="d-block  font-size-sm text-body"> {{$record->country_code}}{{$record->phone_no}}</span>
       
      </div>
    </a>
  </td>
  <!-- <td>
    <div class="d-flex">
      {{$record->email}}
    </div>
  </td>

  <td>
    <div class="d-flex">
      {{$record->country_code}}{{$record->phone_no}}
    </div>
  </td> -->


  <td>
    <div class="d-flex">
      {{$record->role}}
    </div>
  </td>
  <td>
    
    @if($record->is_active=='1')
    <span class="badge badge-soft-primary p-2"> Active </span>
    @else
    <span class="badge badge-soft-danger p-2"> Inactive </span>
    @endif
  </td>
  
  <td>
    <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>

      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('staff/edit/'.base64_encode($record->id))}}">Edit</a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{baseUrl('staff/change-password/'.base64_encode($record->id))}}">Change Password</a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('staff/delete/'.base64_encode($record->id))}}">Delete</a> 
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