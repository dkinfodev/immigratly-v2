@foreach($records as $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="row-checkbox custom-control-input" id="usersDataCheck1">
      <label class="custom-control-label" for="usersDataCheck1"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    <a class="d-flex align-items-center" href="./user-profile.html">
      <div class="avatar avatar-soft-primary avatar-circle">
        <span class="avatar-initials">{{userInitial($record)}}</span>
      </div>
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->first_name." ".$record->last_name}}</span>
        <span class="d-block font-size-sm text-body">{{$record->subdomain.domain()}}</span>
      </div>
    </a>
  </td>
  <td>
    <span class="d-block h5 mb-0">{{$record->email}}</span>
  </td>
  <td>{{$record->country_code}}{{$record->phone_no}}</td>
  <td>
    @if($record->panel_status == '1')
      <span class="legend-indicator bg-success"></span>Active
    @else
      <span class="legend-indicator bg-warning"></span>Inactive
    @endif
  </td>
  <td>
    <div id="editUserPopover">
      <a class="btn btn-sm btn-warning" onclick="showPopup('<?php echo baseUrl('professionals/create-panel/'.base64_encode($record->id)) ?>')" href="javascript:;">
        <i class="tio-pages-outlined nav-icon"></i> Create Panel
      </a>
    </div>
    <!-- <div class="d-flex justify-content-center align-items-center mb-5">
      <label class="toggle-switch mx-2" for="customSwitch">
        <input type="checkbox" class="js-toggle-switch toggle-switch-input" id="customSwitch" checked
               data-hs-toggle-switch-options='{
                 "targetSelector": "#pricingCount1, #pricingCount2, #pricingCount3"
               }'>
        <span class="toggle-switch-label">
          <span class="toggle-switch-indicator"></span>
        </span>
      </label>
      <span>Annual</span>
    </div> -->
  </td>
</tr>
@endforeach
