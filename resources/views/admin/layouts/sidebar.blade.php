<!-- Navbar -->
<div class="navbar-expand-lg navbar-light">
    <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
        <!-- Card -->
        <div class="card flex-grow-1 mb-5">
            <div class="card-body">
                <!-- Avatar -->
                <div class="d-none d-lg-block text-center mb-5">
                    <div class="avatar avatar-xxl avatar-circle mb-3">
                        <img class="avatar-img" src="{{ professionalProfile() }}" alt="Image Description">
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
          
            <!-- Navbar Nav -->
             
          <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
          <!-- Dashboards -->
          
          </ul>

          
          <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
            <li class="navbar-vertical-aside-has-menu show">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'dashboard'){ echo "active"; } } ?>" href="{{ baseUrl('/') }}">
                <i class="tio-home-vs-1-outlined nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
              </a>
            </li>

            @if(profession_profile())
            
            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'services'){ echo "active"; } } ?>" href="{{ baseUrl('/services') }}">
                <i class="tio-pages-outlined nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Services</span>
              </a>
            </li>
            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'assessments'){ echo "active"; } } ?>" href="{{ baseUrl('/assessments') }}">
                <i class="tio-pages-outlined nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Assessments</span>
                @if(unreadAssessment(\Session::get('subdomain')) > 0)
                <span class="badge badge-danger">{{unreadAssessment(\Session::get('subdomain'))}}</span>
                @endif
              </a>
            </li>
            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'locations'){ echo "active"; } } ?>" href="{{ baseUrl('/locations') }}">
                <i class="tio-globe nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Locations</span>
              </a>
            </li>
            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'appointment-types'){ echo "active"; } } ?>" href="{{ baseUrl('/appointment-types') }}">
                <i class="tio-book-opened nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Appointment Type</span>
              </a>
            </li>

            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'time-duration'){ echo "active"; } } ?>" href="{{ baseUrl('/time-duration') }}">
                <i class="tio-book-opened nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Time Duration</span>
              </a>
            </li>

            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'booked-appointment'){ echo "active"; } } ?>" href="{{ baseUrl('/booked-appointments') }}">
                <i class="tio-book-opened nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Booked Appointments</span>
              </a>
            </li>

            <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'event'){ echo "active"; } } ?>" href="{{ baseUrl('/event') }}">
                <i class="tio-book-opened nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Events</span>
              </a>
            </li>
            <!-- <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'appointment-schedule'){ echo "active"; } } ?>" href="{{ baseUrl('/appointment/set-schedule') }}">
                <i class="tio-book-opened nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Appointment Schedule</span>
              </a>
            </li> -->
          </ul>


         <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
            <span class="text-cap">Leads</span>   
            <li class="navbar-vertical-aside-has-menu">
              <a class="nav-link <?php if(isset($activeTab)){ if($activeTab == 'leads'){ echo "active"; } } ?>" href="{{ baseUrl('/leads') }}">
                  <i class="tio-pages-outlined nav-icon"></i>
                <span class="text-truncate">New Leads</span>
              </a>
            </li>
            <li class="navbar-vertical-aside-has-menu">
              <a class="nav-link <?php if(isset($activeTab)){ if($activeTab == 'leads-as-clients'){ echo "active"; } } ?>" href="{{ baseUrl('/leads/clients') }}">
                  <i class="tio-pages-outlined nav-icon"></i>
                <span class="text-truncate">Leads as client</span>
              </a>
            </li>
        </ul>

        <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
            <span class="text-cap">Cases</span>   
            
            
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'cases'){ echo "active"; } } ?>" href="{{ baseUrl('/cases') }}">
              <i class="tio-book-opened nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases</span>
            </a>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'global_stages'){ echo "active"; } } ?>" href="{{ baseUrl('/global-stages') }}">
              <i class="tio-book-opened nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Global Stages</span>
            </a>
          </li>
          <li class="navbar-vertical-aside-has-menu">
              <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'global-forms'){ echo "active"; } } ?>" href="{{ baseUrl('/global-forms') }}">
                <i class="tio-book-opened nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Forms</span>
              </a>
            </li>
          <!-- <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/articles') }}">
              <i class="tio-document-text nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Articles</span>
            </a>
          </li> -->
          <li class="nav-item">
              <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'messages'){ echo "active"; } } ?>" href="<?php echo baseUrl('/messages-center') ?>" data-placement="left">
                  <i class="tio-comment-text-outlined nav-icon"></i>
                  <span
                      class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Messages</span>
              </a>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'webinar'){ echo "active"; } } ?>" href="{{ baseUrl('/webinar') }}">
              <i class="tio-globe nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Webinar</span>
            </a>
          </li>

          
          
          
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'staff'){ echo "active"; } } ?>" href="{{ baseUrl('staff') }}">
              <i class="tio-user nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Staff</span>
            </a>
          </li>

          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'role-privileges'){ echo "active"; } } ?>" href="{{ baseUrl('role-privileges') }}">
              <i class="tio-lock nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Role Privileges</span>
            </a>
          </li>


          <!-- <li class="navbar-vertical-aside-has-menu ">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;">
              <i class="tio-apps nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Settings</span>
            </a>

            <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
              <li class="nav-item">
                <a class="nav-link " href="{{ baseUrl('/connect-apps') }}">
                  <span class="tio-circle nav-indicator-icon"></span>
                  <span class="text-truncate">Connect Apps</span>
                </a>
              </li>
            </ul>
          </li> -->

          @endif
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







