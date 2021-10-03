<!-- ========== HEADER ========== -->

<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
<div class="navbar-nav-wrap">
<div class="navbar-brand-wrapper">
<!-- Logo -->
<a class="navbar-brand" href="{{ baseUrl('/') }}" aria-label="Front">
  <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
  <img class="navbar-brand-logo-mini" src="assets/svg/logos/logo-short.svg" alt="Logo">
</a>
<!-- End Logo -->
</div>

<div class="navbar-nav-wrap-content-left">
<!-- Navbar Vertical Toggle -->
<button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
  <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip" data-placement="right" title="Collapse"></i>
  <i class="tio-last-page navbar-vertical-aside-toggle-full-align" data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-toggle="tooltip" data-placement="right" title="Expand"></i>
</button>
<!-- End Navbar Vertical Toggle -->

</div>

<!-- Secondary Content -->
<div class="navbar-nav-wrap-content-right">
<!-- Navbar -->
<ul class="navbar-nav align-items-center flex-row">
  <!-- <li class="nav-item d-none d-sm-inline-block">
    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" data-toggle="tooltip" data-placement="top" title="Add reminder notes" onclick="showPopup('<?php echo baseUrl('add-reminder-note') ?>')">
      <i class="tio-calendar"></i> 
    </a>
  </li> -->
  <li class="nav-item d-md-none">
    <!-- Search Trigger -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#searchDropdown",
           "type": "css-animation",
           "animationIn": "fadeIn",
           "hasOverlay": "rgba(46, 52, 81, 0.1)",
           "closeBreakpoint": "md"
         }'>
        <i class="tio-search"></i>
      </a>
    </div>
    <!-- End Search Trigger -->
  </li>

  <li class="nav-item d-none d-sm-inline-block">
    <!-- Notification -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#notificationDropdown",
           "type": "css-animation"
         }'>
        <i class="tio-notifications-on-outlined"></i>
        <span class="btn-status btn-sm-status btn-status-danger"></span>
      </a>

      <div id="notificationDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu" style="width: 25rem;">
        <!-- Header -->
        <div class="card-header">
          <span class="card-title h4">Notifications</span>

        </div>
        <!-- End Header -->

        <!-- Nav -->
        <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="notificationNavOne-tab" data-toggle="tab" href="#notificationNavOne" role="tab" aria-controls="notificationNavOne" aria-selected="true">Messages ({{count(chatNotifications())}})</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="notificationNavTwo-tab" data-toggle="tab" href="#notificationNavTwo" role="tab" aria-controls="notificationNavTwo" aria-selected="false">Other ({{count(otherNotifications())}})</a>
          </li>
        </ul>
        <!-- End Nav -->

        <!-- Body -->
        <div class="card-body-height">
          <!-- Tab Content -->
          <div class="tab-content" id="notificationTabContent">
            <div class="tab-pane fade show active" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">
              <ul class="list-group list-group-flush navbar-card-list-group">
                <!-- Item -->
                @foreach(chatNotifications() as $notification)
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck1" checked>
                          <label class="custom-control-label" for="notificationCheck1"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">{{$notification->title}}</span>
                      <p class="card-text font-size-sm">{{$notification->comment}} <span class="badge badge-success">Review</span></p>
                    </div>
                    <small class="col-auto text-muted text-cap">{{dateFormat($notification->created_at)}}</small>
                  </div>
                  @if($notification->url != '')
                   <a class="stretched-link" href="{{url('/view-notification/'.base64_encode($notification->id))}}"></a>
                  @endif
                </li>
                <!-- End Item -->
                @endforeach
                
              </ul>
            </div>

            <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel" aria-labelledby="notificationNavTwo-tab">
              <ul class="list-group list-group-flush navbar-card-list-group">
                @foreach(otherNotifications() as $notification)
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck1" checked>
                          <label class="custom-control-label" for="notificationCheck1"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">{{$notification->title}}</span>
                      <p class="card-text font-size-sm">{{$notification->comment}} <span class="badge badge-success">Review</span></p>
                    </div>
                    <small class="col-auto text-muted text-cap">{{dateFormat($notification->created_at)}}</small>
                  </div>
                  @if($notification->url != '')
                   <a class="stretched-link" href="{{url('/view-notification/'.base64_encode($notification->id))}}"></a>
                  @endif
                </li>
                <!-- End Item -->
                @endforeach
                
              </ul>
            </div>
          </div>
          <!-- End Tab Content -->
        </div>
        <!-- End Body -->

        <!-- Card Footer -->
        <a class="card-footer text-center" href="{{baseUrl('notifications')}}">
          View all notifications
          <i class="tio-chevron-right"></i>
        </a>
        <!-- End Card Footer -->
      </div>
    </div>
    <!-- End Notification -->
  </li>


  <li class="nav-item d-none d-sm-inline-block">
    <!-- Activity -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
         onclick="fetchReminderNotes()"
         data-hs-unfold-options='{
          "target": "#reminderNotesSidebar",
          "type": "css-animation",
          "animationIn": "fadeInRight",
          "animationOut": "fadeOutRight",
          "hasOverlay": true,
          "smartPositionOff": true
         }'>
        <i class="tio-calendar"></i>
      </a>
    </div>
    <!-- Activity -->
  </li>

  <li class="nav-item">
    <!-- Account -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#accountNavbarDropdown",
           "type": "css-animation"
         }'>
        <div class="avatar avatar-sm avatar-circle">
          <img class="avatar-img" src="{{professionalProfile()}}" alt="Image Description">
          <span class="avatar-status avatar-sm-status avatar-status-success"></span>
        </div>
      </a>

      <div id="accountNavbarDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account" style="width: 16rem;">
        <div class="dropdown-item">
          <div class="media align-items-center">
            <div class="avatar avatar-sm avatar-circle mr-2">
              <img class="avatar-img" src="{{professionalProfile('','t')}}" alt="Image Description">
            </div>
            <div class="media-body">
              <span class="card-title h5">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</span>
              <span class="card-text">{{Auth::user()->email}}</span>
            </div>
          </div>
        </div>

        <div class="dropdown-divider"></div>


        <a class="dropdown-item" href="{{ baseUrl('/edit-profile') }}">
          <span class="text-truncate pr-2">Profile &amp; account</span>
        </a>
        <a class="dropdown-item" href="{{baseUrl('staff')}}">
          <span class="text-truncate pr-2">Manage Staffs</span>
        </a>
        <a class="dropdown-item" href="{{baseUrl('role-privileges')}}">
          <span class="text-truncate pr-2">Role Privileges</span>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('logout') }}">
          <span class="text-truncate pr-2 text-danger">Sign out</span>
        </a>
      </div>
    </div>
    <!-- End Account -->
  </li>
</ul>
<!-- End Navbar -->
</div>
<!-- End Secondary Content -->
</div>
</header>
