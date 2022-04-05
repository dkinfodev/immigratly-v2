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
            <h1 class="page-header-title">{{$record['case_title']}}</h1>

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
                  <div id="projectDeadlineFlatpickr" class="mr-3 col input-group input-group-sm">
                   
                    @if(!empty($record['MainService']))
                    <span class="text-primary">
                       {{$record['MainService']['name']}} 
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
              @if($record['start_date'] != '')
              <div class="col-auto">
                <div class="row align-items-center g-0">
                  <div class="col-auto">Start date:</div>

                  <!-- Flatpickr -->
                  <div id="projectDeadlineFlatpickr" class="mr-3 col input-group input-group-sm">
                    <span class="text-primary"> {{ $record['start_date'] }}</span>
                  </div>
                  <!-- End Flatpickr -->
                </div>
              </div>
              @endif
              @if($record['end_date'] != '')
              <div class="col-auto">
                <div class="row align-items-center g-0">
                  <div class="col-auto">Due date:</div>

                  <!-- Flatpickr -->
                  <div id="projectDeadlineFlatpickr" class="mr-3 col input-group input-group-sm">
                    <span class="text-primary"> {{ $record['end_date'] }}</span>
                  </div>
                  <!-- End Flatpickr -->
                </div>
              </div>
              @endif

              <div class="col-auto">
              </div>
            </div>
          </div>

          <div class="col-lg-auto">
          @if(count($record['assinged_member']) > 2)
            <small class="text-cap mb-2">Team members:</small>

            <div class="d-flex">
              <!-- Avatar Group -->
              <div class="avatar-group avatar-circle mr-3">
                @foreach($record['assinged_member'] as $key => $member)
                    <a class="avatar" href="javascript:;" data-toggle="tooltip" data-placement="top" title="<?php echo $member['member']['first_name']." ".$member['member']['last_name'] ?>">
                    <img class="avatar-img" src="{{ professionalProfile($member['member']['unique_id'],'t',$subdomain) }}" alt="Image Description">
                    </a>
                @endforeach
                @if(count($record['assinged_member']) > 2)
                    <a class="avatar avatar-light avatar-circle" href="javascript:;" data-toggle="modal" data-target="#shareWithPeopleModal">
                    <span class="avatar-initials">+{{count($record['assinged_member'])-2 }}</span>
                    </a>
                @endif
              </div>
              
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
            <a class="nav-link {{isset($active_nav) && $active_nav == 'overview'?'active':'' }}" href="{{baseUrl('cases/view/'.$subdomain.'/'.$record['unique_id'])}}">Overview</a>                                                                                             
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'files'?'active':'' }}" href="{{baseUrl('cases/documents/'.$subdomain.'/'.$record['unique_id'])}}">Files 
            <span class="badge badge-soft-dark rounded-circle ml-1"> {{ countUnreadDocChat($case_id,$subdomain,"client") }} </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'stages'?'active':'' }}" href="{{baseUrl('cases/stages/'.$subdomain.'/'.$record['unique_id'])}}">Stages </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'activity'?'active':'' }} " href="{{baseUrl('cases/activity/'.$subdomain.'/'.$record['unique_id'])}}">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'invoices'?'active':'' }}" href="{{baseUrl('cases/'.$subdomain.'/invoices/list/'.$record['unique_id'])}}">
            Invoice
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($active_nav) && $active_nav == 'dependants'?'active':'' }}" href="{{baseUrl('cases/dependants/'.$subdomain.'/'.$record['unique_id'])}}">
            Dependants
            </a>
        </li>
    </ul>
</div>
    
    </div>
    <!-- End Nav -->
  </div>
  <!-- End Page Header -->
