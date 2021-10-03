<aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
  <div class="navbar-vertical-container">
    <div class="navbar-vertical-footer-offset">
      <div class="navbar-brand-wrapper justify-content-between">
        <!-- Logo -->
          <a class="navbar-brand" href="{{ baseUrl('/') }}" aria-label="Front">
            <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
            <img class="navbar-brand-logo-mini" src="assets/svg/logos/logo-short.svg" alt="Logo">
          </a>
        
        <!-- End Logo -->

        <!-- Navbar Vertical Toggle -->
        <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
          <i class="tio-clear tio-lg"></i>
        </button>
        <!-- End Navbar Vertical Toggle -->
      </div>

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
          <li class="navbar-vertical-aside-has-menu">
            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/webinar') }}">
              <i class="tio-globe nav-icon"></i>
              <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Webinar</span>
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
      <!-- End Content -->

    </div>
  </div>
</aside>