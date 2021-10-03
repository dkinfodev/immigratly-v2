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
        <a class="dropdown-item" href="{{baseUrl('/change-password/')}}">
          <span class="text-truncate pr-2" title="change password">Change Password</span>
        </a>

        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('logout') }}">
          <span class="text-truncate pr-2 text-danger" title="Sign out">Sign out</span>
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