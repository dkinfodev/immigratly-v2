<!-- Search Form -->
<div id="searchDropdown" class="hs-unfold-content dropdown-unfold search-fullwidth d-md-none">
<form class="input-group input-group-merge input-group-borderless">
<div class="input-group-prepend">
<div class="input-group-text">
<i class="tio-search"></i>
</div>
</div>

<input class="form-control rounded-0" type="search" placeholder="Search in front" aria-label="Search in front">

<div class="input-group-append">
<div class="input-group-text">
<div class="hs-unfold">
  <a class="js-hs-unfold-invoker" href="javascript:;"
     data-hs-unfold-options='{
       "target": "#searchDropdown",
       "type": "css-animation",
       "animationIn": "fadeIn",
       "hasOverlay": "rgba(46, 52, 81, 0.1)",
       "closeBreakpoint": "md"
     }'>
    <i class="tio-clear tio-lg"></i>
  </a>
</div>
</div>
</div>
</form>
</div>
<!-- End Search Form -->

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

<!-- Search Form -->
<div class="d-none d-md-block">
  <form class="position-relative">
    <!-- Input Group -->
    <div class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="tio-search"></i>
        </div>
      </div>
      <input type="search" class="js-form-search form-control" placeholder="Search in front" aria-label="Search in front"
             data-hs-form-search-options='{
               "clearIcon": "#clearSearchResultsIcon",
               "dropMenuElement": "#searchDropdownMenu",
               "dropMenuOffset": 20,
               "toggleIconOnFocus": true,
               "activeClass": "focus"
             }'>
      <a class="input-group-append" href="javascript:;">
        <span class="input-group-text">
          <i id="clearSearchResultsIcon" class="tio-clear" style="display: none;"></i>
        </span>
      </a>
    </div>
    <!-- End Input Group -->

    <!-- Card Search Content -->
    <div id="searchDropdownMenu" class="hs-form-search-menu-content card dropdown-menu dropdown-card overflow-hidden">
      <!-- Body -->
      <div class="card-body-height py-3">
        <small class="dropdown-header mb-n2">Recent searches</small>

        <div class="dropdown-item bg-transparent text-wrap my-2">
          <span class="h4 mr-1">
            <a class="btn btn-xs btn-soft-dark btn-pill" href="./index.html">
              Gulp <i class="tio-search ml-1"></i>
            </a>
          </span>
          <span class="h4">
            <a class="btn btn-xs btn-soft-dark btn-pill" href="./index.html">
              Notification panel <i class="tio-search ml-1"></i>
            </a>
          </span>
        </div>

        <div class="dropdown-divider my-3"></div>

        <small class="dropdown-header mb-n2">Tutorials</small>

        <a class="dropdown-item my-2" href="./index.html">
          <div class="media align-items-center">
            <span class="icon icon-xs icon-soft-dark icon-circle mr-2">
              <i class="tio-tune"></i>
            </span>

            <div class="media-body text-truncate">
              <span>How to set up Gulp?</span>
            </div>
          </div>
        </a>

        <a class="dropdown-item my-2" href="./index.html">
          <div class="media align-items-center">
            <span class="icon icon-xs icon-soft-dark icon-circle mr-2">
              <i class="tio-paint-bucket"></i>
            </span>

            <div class="media-body text-truncate">
              <span>How to change theme color?</span>
            </div>
          </div>
        </a>

        <div class="dropdown-divider my-3"></div>

        <small class="dropdown-header mb-n2">Members</small>

        <a class="dropdown-item my-2" href="./index.html">
          <div class="media align-items-center">
            <img class="avatar avatar-xs avatar-circle mr-2" src="assets/img/160x160/img10.jpg" alt="Image Description">
            <div class="media-body text-truncate">
              <span>Amanda Harvey <i class="tio-verified text-primary" data-toggle="tooltip" data-placement="top" title="Top endorsed"></i></span>
            </div>
          </div>
        </a>

        <a class="dropdown-item my-2" href="./index.html">
          <div class="media align-items-center">
            <img class="avatar avatar-xs avatar-circle mr-2" src="assets/img/160x160/img3.jpg" alt="Image Description">
            <div class="media-body text-truncate">
              <span>David Harrison</span>
            </div>
          </div>
        </a>

        <a class="dropdown-item my-2" href="./index.html">
          <div class="media align-items-center">
            <div class="avatar avatar-xs avatar-soft-info avatar-circle mr-2">
              <span class="avatar-initials">A</span>
            </div>
            <div class="media-body text-truncate">
              <span>Anne Richard</span>
            </div>
          </div>
        </a>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <a class="card-footer text-center" href="./index.html">
        See all results
        <i class="tio-chevron-right"></i>
      </a>
      <!-- End Footer -->
    </div>
    <!-- End Card Search Content -->
  </form>
</div>
<!-- End Search Form -->
</div>

<!-- Secondary Content -->
<div class="navbar-nav-wrap-content-right">
<!-- Navbar -->
<ul class="navbar-nav align-items-center flex-row">
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
  @if(role_permission('global-module','top-notifications'))
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
  @endif
  <li class="nav-item d-none d-sm-inline-block">
    <!-- Apps -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#appsDropdown",
           "type": "css-animation"
         }'>
        <i class="tio-menu-vs-outlined"></i>
      </a>

      <div id="appsDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu" style="width: 25rem;">
        <!-- Header -->
        <div class="card-header">
          <span class="card-title h4">Web apps &amp; services</span>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body card-body-height">
          <!-- Nav -->
          <div class="nav nav-pills flex-column">
            <a class="nav-link" href="#">
              <div class="media align-items-center">
                <span class="mr-3">
                  <img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/atlassian.svg" alt="Image Description">
                </span>
                <div class="media-body text-truncate">
                  <span class="h5 mb-0">Atlassian</span>
                  <span class="d-block font-size-sm text-body">Security and control across Cloud</span>
                </div>
              </div>
            </a>

            <a class="nav-link" href="#">
              <div class="media align-items-center">
                <span class="mr-3">
                  <img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/slack.svg" alt="Image Description">
                </span>
                <div class="media-body text-truncate">
                  <span class="h5 mb-0">Slack <span class="badge badge-primary badge-pill text-uppercase ml-1">Try</span></span>
                  <span class="d-block font-size-sm text-body">Email collaboration software</span>
                </div>
              </div>
            </a>

            <a class="nav-link" href="#">
              <div class="media align-items-center">
                <span class="mr-3">
                  <img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/google-webdev.svg" alt="Image Description">
                </span>
                <div class="media-body text-truncate">
                  <span class="h5 mb-0">Google webdev</span>
                  <span class="d-block font-size-sm text-body">Work involved in developing a website</span>
                </div>
              </div>
            </a>

            <a class="nav-link" href="#">
              <div class="media align-items-center">
                <span class="mr-3">
                  <img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/frontapp.svg" alt="Image Description">
                </span>
                <div class="media-body text-truncate">
                  <span class="h5 mb-0">Frontapp</span>
                  <span class="d-block font-size-sm text-body">The inbox for teams</span>
                </div>
              </div>
            </a>

            <a class="nav-link" href="#">
              <div class="media align-items-center">
                <span class="mr-3">
                  <img class="avatar avatar-xs avatar-4by3" src="assets/svg/illustrations/review-rating-shield.svg" alt="Image Description">
                </span>
                <div class="media-body text-truncate">
                  <span class="h5 mb-0">HS Support</span>
                  <span class="d-block font-size-sm text-body">Customer service and support</span>
                </div>
              </div>
            </a>

            <a class="nav-link" href="#">
              <div class="media align-items-center">
                <span class="avatar avatar-xs avatar-soft-dark mr-3">
                  <span class="avatar-initials"><i class="tio-apps"></i></span>
                </span>
                <div class="media-body text-truncate">
                  <span class="h5 mb-0">More Front products</span>
                  <span class="d-block font-size-sm text-body">Check out more HS products</span>
                </div>
              </div>
            </a>
          </div>
          <!-- End Nav -->
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <a class="card-footer text-center" href="#">
          View all apps
          <i class="tio-chevron-right"></i>
        </a>
        <!-- End Footer -->
      </div>
    </div>
    <!-- End Apps -->
  </li>

  <li class="nav-item d-none d-sm-inline-block">
    <!-- Activity -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
         data-hs-unfold-options='{
          "target": "#activitySidebar",
          "type": "css-animation",
          "animationIn": "fadeInRight",
          "animationOut": "fadeOutRight",
          "hasOverlay": true,
          "smartPositionOff": true
         }'>
        <i class="tio-voice-line"></i>
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
          <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
          <span class="avatar-status avatar-sm-status avatar-status-success"></span>
        </div>
      </a>

      <div id="accountNavbarDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account" style="width: 16rem;">
        <div class="dropdown-item">
          <div class="media align-items-center">
            <div class="avatar avatar-sm avatar-circle mr-2">
              <img class="avatar-img" src="assets/img/160x160/img6.jpg" alt="Image Description">
            </div>
            <div class="media-body">
              <span class="card-title h5">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</span>
              <span class="card-text">{{Auth::user()->email}}</span>
            </div>
          </div>
        </div>


        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{baseUrl('edit-profile')}}">
          <span class="text-truncate pr-2" title="Edit profile">Edit Profile</span>
        </a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{baseUrl('/change-password/')}}">
          <span class="text-truncate pr-2" title="change password">Change Password</span>
        </a>

        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('logout') }}">
          <span class="text-truncate pr-2" title="Sign out">Sign out</span>
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