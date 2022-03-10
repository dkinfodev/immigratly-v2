@foreach($records as $key => $record)
<tr>
  <td scope="col" class="table-column-pr-0 table-column-pl-0 pr-0 ">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" data-subdomain="{{PROFESSIONAL_DATABASE.$record->subdomain}}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    <a class="d-flex align-items-center" href="javascript:;">
      <div class="avatar avatar-soft-primary avatar-circle">
        <span class="avatar-initials">{{userInitial($record)}}</span>
      </div>
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">
          {{$record->first_name." ".$record->last_name}} 

        </span>
        <span class="d-block h5 mb-0 font-size-sm text-body">{{$record->email}}</span>
      </div>
    </a>
  </td>
  <td>
    <span class="d-block h5 text-hover-primary mb-0">{{subdomain($record->subdomain)}}</span>
      <?php
      $check_profile = checkProfileStatus($record->subdomain);
      $profile_checked = '';
      if($check_profile['status'] == 'success'){
        $professional_profile = $check_profile['professional'];
        if($professional_profile->profile_status == 0){
          echo '<span class="legend-indicator bg-danger"></span> Profile Pending';
        }else if($professional_profile->profile_status == 1){
          echo '<span class="legend-indicator bg-warning"></span> Awaiting Verification';
        }else if($professional_profile->profile_status == 2){
          $profile_checked = 'checked';
          echo '<span class="legend-indicator bg-success"></span> Profile Verified';
        }
        else{
          echo '<span class="legend-indicator bg-info"></span> Profile data not found';
        }
      }else{ ?>
        <span class="legend-indicator bg-warning"></span> Panel Not Exists
      <?php } ?>

      @if($record->panel_status == 1)
      <br>
      <span class="legend-indicator bg-success"></span>Panel Active
      @else
      <br>
      <span class="legend-indicator bg-danger"></span>Panel Inactive
      @endif

  </td>
  <!-- <td>{{$record->country_code}}{{$record->phone_no}}</td> -->
  <!-- <td>
    @if($record->panel_status == 1)
    <span class="legend-indicator bg-success"></span>Active
    @else
    <span class="legend-indicator bg-danger"></span>Inactive
    @endif
  </td> -->
  <!-- <td>
    <div class="d-flex justify-content-center align-items-center mt-5 mb-5">
      <label class="toggle-switch mx-2" for="customSwitch-{{$key}}">
        <input type="checkbox" data-id="{{ $record->id }}" onchange="changeStatus(this)" class="js-toggle-switch toggle-switch-input" id="customSwitch-{{$key}}" {{($record->panel_status == 1)?'checked':''}} >
        <span class="toggle-switch-label">
          <span class="toggle-switch-indicator"></span>
        </span>
      </label>
      @if($record->panel_status == 1)
      <span>Active</span>
      @else
      <span>Inactive</span>
      @endif
    </div>
  </td>
  <td>
      <div class="d-flex justify-content-center align-items-center mt-5 mb-5">
        <label class="toggle-switch mx-2" for="profileStatus-{{$key}}">
          <input type="checkbox" data-id="{{ $record->id }}" onchange="profileStatus(this)" class="js-toggle-switch toggle-switch-input" id="profileStatus-{{$key}}" {{ $profile_checked }} >
          <span class="toggle-switch-label">
            <span class="toggle-switch-indicator"></span>
          </span>
        </label>
        @if($profile_checked == 'checked')
        <span>Active</span>
        @else
        <span>Inactive</span>
        @endif
      </div>
  </td> -->
  <td>
    @if($check_profile['status'] == 'success')
    <a href="{{baseUrl('/professionals/view/'.base64_encode($record->id))}}"><i class="tio-visible"></i> Details</a>
    @endif
  </td>
</tr>
@endforeach
