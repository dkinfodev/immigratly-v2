<div class="page-header">
    <div class="media mb-3">
      <!-- Avatar -->
      <div class="avatar avatar-xl avatar-4by3 mr-2">
        <img class="avatar-img" src="assets/svg/brands/guideline.svg" alt="Image Description">
      </div>
      <!-- End Avatar -->

      <div class="media-body">
        <div class="row">
          <div class="col-lg mb-3 mb-lg-0">
            <h1 class="page-header-title">{{$record->case_title}}</h1>

            <div class="row align-items-center">
              <div class="col-auto">
                <span>Professional:</span>
                <?php
                    $professional = professionalDetail($subdomain);
                ?>
                @if(!empty($professional))
                <a href="javascript:;">{{ $professional->company_name  }}</a>
                @else
                <a href="javascript:;" class="text-danger">N/A</a>
                @endif
              </div>
              <div class="col-auto">
                <div class="row align-items-center g-0">
                  <div class="col-auto">Visa Service:</div>

                  <!-- Flatpickr -->
                  <div id="projectDeadlineFlatpickr" class="js-flatpickr flatpickr-custom flatpickr-custom-borderless col input-group input-group-sm">
  
                    
                    @if(!empty($record->Service($record->VisaService->service_id)))
                    <span class="text-primary">
                       {{$record->Service($record->VisaService->service_id)->name}} 
                    </span>
                    @else
                    <span class="text-danger">
                      N/A
                    </span>
                    @endif
                  </div>
                  <!-- End Flatpickr -->
                </div>
              </div>
              @if($record->start_date != '')
              <div class="col-auto">
                <div class="row align-items-center g-0">
                  <div class="col-auto">Start date:</div>

                  <!-- Flatpickr -->
                  <div class="col input-group input-group-sm">
                    <span class="text-primary"> {{ $record->start_date }}</span>
                  </div>
                  <!-- End Flatpickr -->
                </div>
              </div>
              @endif
              @if($record->end_date != '')
              <div class="ml-3 col-auto">
                <div class="row align-items-center g-0">
                  <div class="col-auto">Due date:</div>

                  <!-- Flatpickr -->
                  <div class="col input-group input-group-sm">
                    <span class="text-primary"> {{ $record->end_date }}</span>
                  </div>
                  <!-- End Flatpickr -->
                </div>
              </div>
              @endif

              <div class="col-auto">
                <!-- Select -->
                <!-- <div class="select2-custom">
                    <select class="js-select2-custom custom-select-sm" size="1" style="opacity: 0;" id="ownerLabel"
                            data-hs-select2-options='{
                              "minimumResultsForSearch": "Infinity",
                              "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                              "dropdownAutoWidth": true,
                              "width": true
                            }'>
                      <option value="owner1" selected data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="assets/img/160x160/img6.jpg" alt="Avatar" /><span class="media-body">Mark Williams</span></span>'>Mark Williams</option>
                      <option value="owner2" data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="assets/img/160x160/img10.jpg" alt="Avatar" /><span class="media-body">Amanda Harvey</span></span>'>Amanda Harvey</option>
                      <option value="owner3" data-option-template='<span class="media align-items-center"><i class="tio-user-outlined text-body mr-2"></i><span class="media-body">Assign to owner</span></span>'>Assign to owner</option>
                    </select>
                  </div> -->
                <!-- End Select -->
              </div>
            </div>
          </div>

          <div class="col-lg-auto">
          @if(count($record->AssingedMember) > 2)
            <small class="text-cap mb-2">Team members:</small>

            <div class="d-flex">
              <!-- Avatar Group -->
              <div class="avatar-group avatar-circle mr-3">
                @foreach($record->AssingedMember as $key => $member)
                    <a class="avatar" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $member['member']['first_name']." ".$member['member']['last_name'] ?>">
                    <img class="avatar-img" src="{{ professionalProfile($member->Member->unique_id,'t',$subdomain) }}" alt="Image Description">
                    </a>
                @endforeach
                @if(count($record->AssingedMember) > 2)
                    <a class="avatar avatar-light avatar-circle" href="javascript:;" data-toggle="modal" data-target="#shareWithPeopleModal">
                    <span class="avatar-initials">+{{count($record->AssingedMember)-2 }}</span>
                    </a>
                @endif
              </div>
              <!-- End Avatar Group -->

              <!-- <a class="btn btn-icon btn-primary rounded-circle" href="javascript:;" data-toggle="modal" data-target="#shareWithPeopleModal">
                <i class="tio-share"></i>
              </a> -->
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <!-- End Media -->

    <!-- Nav -->
    <!-- Nav -->
    <div class="js-nav-scroller hs-nav-scroller-horizontal">
      <span class="hs-nav-scroller-arrow-prev" style="display: none;">
        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
          <i class="tio-chevron-left"></i>
        </a>
      </span>

      <span class="hs-nav-scroller-arrow-next" style="display: none;">
        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
          <i class="tio-chevron-right"></i>
        </a>
      </span>

      <div class="js-nav-scroller hs-nav-scroller-horizontal">
    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
        <i class="tio-chevron-left"></i>
        </a>
    </span>

    <span class="hs-nav-scroller-arrow-next" style="display: none;">
        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
        <i class="tio-chevron-right"></i>
        </a>
    </span>
    <ul class="nav nav-tabs page-header-tabs" id="projectsTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'overview'?'active':'' }}" href="{{baseUrl('cases/view/'.base64_encode($record->id))}}">Overview</a>
                                                                                                              
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'files'?'active':'' }}" href="{{baseUrl('cases/case-documents/documents/'.base64_encode($record->id))}}">Files <span
                    class="badge badge-soft-dark rounded-circle ml-1"> {{ countUnreadDocChat($case_id,$subdomain,\Auth::user()->role) }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'activity'?'active':'' }}" href="{{ baseUrl('cases/activity-logs/'.base64_encode($record->id)) }}">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'invoices'?'active':'' }}" href="{{baseUrl('cases/invoices/list/'.base64_encode($record->id))}}">Invoices</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link " href="project-teams.html">Teams</a>
        </li> -->

        <!-- <li class="nav-item">
            <a class="nav-link " href="project-settings.html">Settings</a>
        </li> -->
    </ul>
</div>
    
    </div>
    <!-- End Nav -->
  </div>
  <!-- End Page Header -->
