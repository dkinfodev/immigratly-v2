<!-- Navbar Vertical -->
<div class="navbar-expand-lg">
    <!-- Navbar Toggle -->
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
    <!-- End Navbar Toggle -->

    <aside id="navbarVerticalNavMenu" class="js-navbar-vertical-aside navbar navbar-vertical navbar-vertical-absolute navbar-vertical-detached navbar-shadow navbar-collapse collapse rounded-lg">
      <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
          <!-- Content -->
          <div class="navbar-vertical-content">
          <ul class="navbar-nav navbar-nav-lg nav-tabs">
          <!-- Dashboards -->
          <li class="navbar-vertical-aside-has-menu show">
            <a class="js-navbar-vertical-aside-menu-link nav-link active" href="{{ baseUrl('/') }}">
              <i class="tio-home-vs-1-outlined nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
            </a>
          </li>
          <!-- End Dashboards -->
          @if(profession_profile())
          <li class="nav-item">
            <small class="nav-subtitle" title="Pages">Pages</small>
            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/services') }}">
              <i class="tio-pages-outlined nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Services</span>
            </a>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/assessments') }}">
              <i class="tio-pages-outlined nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Assessments</span>
              @if(unreadAssessment(\Session::get('subdomain')) > 0)
              <span class="badge badge-danger">{{unreadAssessment(\Session::get('subdomain'))}}</span>
              @endif
            </a>
          </li>
          <li class="navbar-vertical-aside-has-menu ">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;">
              <i class="tio-apps nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Leads</span>
            </a>

            <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
              <li class="nav-item">
                <a class="nav-link " href="{{ baseUrl('/leads') }}">
                  <span class="tio-circle nav-indicator-icon"></span>
                  <span class="text-truncate">New Leads</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ baseUrl('/leads/clients') }}">
                  <span class="tio-circle nav-indicator-icon"></span>
                  <span class="text-truncate">Leads as client</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/cases') }}">
              <i class="tio-book-opened nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases</span>
            </a>
          </li>
          <!-- <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/articles') }}">
              <i class="tio-document-text nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Articles</span>
            </a>
          </li> -->
          <li class="nav-item">
              <a class="js-nav-tooltip-link nav-link" href="<?php echo baseUrl('/messages-center') ?>" data-placement="left">
                  <i class="tio-comment-text-outlined nav-icon"></i>
                  <span
                      class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Messages</span>
              </a>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/webinar') }}">
              <i class="tio-globe nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Webinar</span>
            </a>
          </li>

          <li class="nav-item">
            <small class="nav-subtitle" title="Pages">Settings</small>
            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
          </li>
          
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/working-schedules') }}">
              <i class="tio-book-opened nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Working Schedules</span>
            </a>
          </li>
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('staff') }}">
              <i class="tio-user nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Staff</span>
            </a>
          </li>

          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('role-privileges') }}">
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
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </aside>
  </div>
  <!-- End Navbar Vertical -->
