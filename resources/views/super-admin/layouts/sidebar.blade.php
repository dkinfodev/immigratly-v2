
<!-- Navbar -->
<div class="navbar-expand-lg navbar-light">
    <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
        <!-- Card -->
        <div class="card flex-grow-1 mb-5">
            <div class="card-body">
                <!-- Avatar -->
                <div class="d-none d-lg-block text-center mb-5">
                    <div class="avatar avatar-xxl avatar-circle mb-3">

                        <img class="avatar-status avatar-lg-status" src="assets/svg/illustrations/top-vendor.svg"
                        alt="Image Description" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Verified user">
                    </div>

                    <h4 class="card-title mb-0">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</h4>
                    <p class="card-text small mb-0">{{Auth::user()->email}}</p>
                    <div class="sign-out">
                        <a class="nav-link" href="{{ url('/logout') }}">
                            <i class="tio-sign-out"></i> Log out
                        </a>
                    </div>
                </div>
                <!-- End Avatar -->

                <!-- Nav -->
                

              <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                <!-- Dashboards -->
                <li class="navbar-vertical-aside-has-menu show">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'dashboard'){ echo "active"; } } ?>" href="{{ baseUrl('/') }}">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboard</span>
                  </a>
                </li>
                <!-- End Dashboards -->
              </ul>
              
              <ul class="nav nav-sm nav-tabs nav-vertical mb-4">  
                <span class="text-cap">Account</span>
                

                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'staff'){ echo "active"; } } ?>" href="{{ baseUrl('/staff') }}">
                    <i class="tio-group-senior nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Staff</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'users'){ echo "active"; } } ?>" href="{{ baseUrl('/user') }}">
                    <i class="tio-user-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">User</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'assessments'){ echo "active"; } } ?>" href="{{ baseUrl('/assessments') }}" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Assessments</span>
                  </a>
                </li>
                <!-- Accounts -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'professionals'){ echo "active"; } } ?>" href="{{ baseUrl('/professionals') }}">
                    <i class="tio-pages-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professionals</span>
                  </a>
                </li>
                <!-- End Pages -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'news'){ echo "active"; } } ?>" href="{{ baseUrl('/news') }}">
                    <i class="tio-feed-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">News</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'articles'){ echo "active"; } } ?>" href="{{ baseUrl('/articles') }}">
                    <i class="tio-document-text nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Articles</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'webinar'){ echo "active"; } } ?>" href="{{ baseUrl('/webinar') }}">
                    <i class="tio-globe nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Webinar</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'discussions'){ echo "active"; } } ?>" href="{{ baseUrl('/discussions') }}" data-placement="left">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Discussions</span>
                  </a>
                </li>
                <!-- <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;">
                    <i class="tio-feed-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">News</span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('news') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">News</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('news-category') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">News Category</span>
                      </a>
                    </li>
                  </ul>
                </li> -->
                <!-- Apps -->

                </ul>

              <ul class="nav nav-sm nav-tabs nav-vertical mb-4">  
                <span class="text-cap">Settings</span>

                <li class="navbar-vertical-aside-has-menu ">
                 

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'document-folder'){ echo "active"; } } ?>" href="{{ baseUrl('document-folder') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Document Folder</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'visa-services'){ echo "active"; } } ?>" href="{{ baseUrl('visa-services') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Visa Services</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'visa-service-groups'){ echo "active"; } } ?>" href="{{ baseUrl('visa-service-groups') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Visa Service Groups</span>
                      </a>
                    </li>
                    
                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'licence-bodies'){ echo "active"; } } ?>" href="{{ baseUrl('licence-bodies') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Licence Bodies</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'languages'){ echo "active"; } } ?>" href="{{ baseUrl('languages') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Languages</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'official-languages'){ echo "active"; } } ?>" href="{{ baseUrl('official-languages') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Official Languages</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'language-proficiency'){ echo "active"; } } ?>" href="{{ baseUrl('language-proficiency') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Language Proficiency</span>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'privileges'){ echo "active"; } } ?>" href="{{ baseUrl('privileges') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professional Privileges</span>
                      </a>
                    </li>

                 
                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'employee-privileges'){ echo "active"; } } ?>" href="{{ baseUrl('employee-privileges') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Employee Privileges</span>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'noc-code'){ echo "active"; } } ?>" href="{{ baseUrl('noc-code') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">NOC Code<span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'primary-degree'){ echo "active"; } } ?>" href="{{ baseUrl('primary-degree') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Primary Degree<span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'category'){ echo "active"; } } ?>" href="{{ baseUrl('categories') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Categories<span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'tags'){ echo "active"; } } ?>" href="{{ baseUrl('tags') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Tags<span>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'capture-category'){ echo "active"; } } ?>" href="{{ baseUrl('capture-category') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Capture Category<span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'cron-urls'){ echo "active"; } } ?>" href="{{ baseUrl('cron-urls') }}" data-placement="left">
                        <i class="tio-book-opened nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cron Urls<span>
                      </a>
                    </li>

                    <!-- <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('screen-capture') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Screen Capture</span>
                      </a>
                    </li> -->
                  </ul>
                </li>
            </ul>
            <!-- End Navbar Nav -->
        <div class="d-lg-none">
            <div class="dropdown-divider"></div>

            <!-- List -->
            <ul class="nav nav-sm nav-tabs nav-vertical">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}">
                        <i class="bi-box-arrow-right nav-icon"></i> Log out
                    </a>
                </li>
            </ul>
            <!-- End List -->
        </div>
        <!-- End Nav -->
    </div>
</div>
<!-- End Card -->
</div>
</div>
<!-- End Navbar -->





<!-- OLD OLD Navbar Vertical -->
<!-- OLD OLD Navbar Vertical -->
<!-- OLD OLD Navbar Vertical -->
<!-- OLD OLD Navbar Vertical -->
<!-- OLD OLD Navbar Vertical -->
<!-- OLD OLD Navbar Vertical -->
<!-- <div class="navbar-expand-lg">
    
    <button type="button" class="navbar-toggler btn btn-block btn-white mb-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu" data-toggle="collapse" data-target="#navbarVerticalNavMenu">
      <span class="d-flex justify-content-between align-items-center">
        <span class="h5 mb-0">Nav menu</span>

        <span class="navbar-toggle-default">
          <i class="tio-menu-hamburger"></i>
        </span>

        <span class="navbar-toggle-toggled">
          <i class="tio-clear"></i>
        </span>
      </span>
    </button>
  
    <aside id="navbarVerticalNavMenu" class="js-navbar-vertical-aside navbar navbar-vertical navbar-vertical-absolute navbar-vertical-detached navbar-shadow navbar-collapse collapse rounded-lg">
      <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
  
          <div class="navbar-vertical-content">
  
            <ul class="navbar-nav navbar-nav-lg nav-tabs">
               
                <li class="navbar-vertical-aside-has-menu show">
                  <a class="js-navbar-vertical-aside-menu-link nav-link active" href="{{ baseUrl('/') }}">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboard</span>
                  </a>
                </li>
               

                <li class="nav-item">
                  <small class="nav-subtitle" title="Accounts">Accounts</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/staff') }}">
                    <i class="tio-group-senior nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Staff</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/user') }}">
                    <i class="tio-user-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">User</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/assessments') }}" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Assessments</span>
                  </a>
                </li>
               
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/professionals') }}">
                    <i class="tio-pages-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professionals</span>
                  </a>
                </li>
               
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/news') }}">
                    <i class="tio-feed-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">News</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/articles') }}">
                    <i class="tio-document-text nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Articles</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/webinar') }}">
                    <i class="tio-globe nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Webinar</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/discussions') }}" data-placement="left">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Discussions</span>
                  </a>
                </li>
                
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;">
                    <i class="tio-settings nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Settings</span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('document-folder') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Document Folder</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('visa-services') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Visa Services</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('visa-service-groups') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Visa Service Groups</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('licence-bodies') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Licence Bodies</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('languages') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Languages</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('official-languages') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Official Languages</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('language-proficiency') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Language Proficiency</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('privileges') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Professional Privileges</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('employee-privileges') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Employee Privileges</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('noc-code') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">NOC Code</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('primary-degree') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Primary Degree</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('categories') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Categories</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('tags') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Tags</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('capture-category') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Capture Category</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('cron-urls') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Cron Urls</span>
                      </a>
                    </li>
                
                  </ul>
                </li>
            </ul>
  
          </div>
  

  
          <div class="navbar-vertical-footer">
            <ul class="navbar-vertical-footer-list">
              <li class="navbar-vertical-footer-list-item">
  
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
                      data-hs-unfold-options='{
                      "target": "#styleSwitcherDropdown",
                      "type": "css-animation",
                      "animationIn": "fadeInRight",
                      "animationOut": "fadeOutRight",
                      "hasOverlay": true,
                      "smartPositionOff": true
                      }'>
                    <i class="tio-tune"></i>
                  </a>
                </div>
  
              </li>

              <li class="navbar-vertical-footer-list-item">
  
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
                      data-hs-unfold-options='{
                      "target": "#otherLinksDropdown",
                      "type": "css-animation",
                      "animationIn": "slideInDown",
                      "hideOnScroll": true
                      }'>
                    <i class="tio-help-outlined"></i>
                  </a>

                  <div id="otherLinksDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                    <span class="dropdown-header">Help</span>
                    <a class="dropdown-item" href="#">
                      <i class="tio-book-outlined dropdown-item-icon"></i>
                      <span class="text-truncate pr-2" title="Resources &amp; tutorials">Resources &amp; tutorials</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="tio-command-key dropdown-item-icon"></i>
                      <span class="text-truncate pr-2" title="Keyboard shortcuts">Keyboard shortcuts</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="tio-alt dropdown-item-icon"></i>
                      <span class="text-truncate pr-2" title="Connect other apps">Connect other apps</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="tio-gift dropdown-item-icon"></i>
                      <span class="text-truncate pr-2" title="What's new?">What's new?</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-header">Contacts</span>
                    <a class="dropdown-item" href="#">
                      <i class="tio-chat-outlined dropdown-item-icon"></i>
                      <span class="text-truncate pr-2" title="Contact support">Contact support</span>
                    </a>
                  </div>
                </div>
  
              </li>

              <li class="navbar-vertical-footer-list-item">
  
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
                      data-hs-unfold-options='{
                      "target": "#languageDropdown",
                      "type": "css-animation",
                      "animationIn": "slideInDown",
                      "hideOnScroll": true
                      }'>
                    <img class="avatar avatar-xss avatar-circle" src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="United States Flag">
                  </a>

                  <div id="languageDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                    <span class="dropdown-header">Select language</span>
                    <a class="dropdown-item" href="#">
                      <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Flag">
                      <span class="text-truncate pr-2" title="English">English (US)</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/gb.svg" alt="Flag">
                      <span class="text-truncate pr-2" title="English">English (UK)</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/de.svg" alt="Flag">
                      <span class="text-truncate pr-2" title="Deutsch">Deutsch</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/dk.svg" alt="Flag">
                      <span class="text-truncate pr-2" title="Dansk">Dansk</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/it.svg" alt="Flag">
                      <span class="text-truncate pr-2" title="Italiano">Italiano</span>
                    </a>
                    <a class="dropdown-item" href="#">
                      <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/cn.svg" alt="Flag">
                      <span class="text-truncate pr-2" title="中文 (繁體)">中文 (繁體)</span>
                    </a>
                  </div>
                </div>
  
              </li>
            </ul>
          </div>
  
        </div>
      </div>
    </aside>
  </div> -->
  
