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
            <!-- Navbar Nav -->
            <ul class="navbar-nav navbar-nav-lg nav-tabs">
                <!-- Dashboards -->
                <li class="navbar-vertical-aside-has-menu show">
                  <a class="js-navbar-vertical-aside-menu-link nav-link active" href="{{ baseUrl('/') }}" title="Dashboards">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
                  </a>
                </li>
                <!-- End Dashboards -->

                <li class="nav-item">
                  <small class="nav-subtitle" title="Pages">Pages</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                @if(role_permission('leads','view-leads'))
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/leads') }}">
                    <i class="tio-apps nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Leads</span>
                  </a>
                </li>
                @endif
                @if(role_permission('cases','view-cases'))
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/cases') }}">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases</span>
                  </a>
                </li>
                @endif
              </ul>
            <!-- End Navbar Nav -->
          </div>
          <!-- End Content -->

          <!-- Footer -->
          <div class="navbar-vertical-footer">
            <ul class="navbar-vertical-footer-list">
              <li class="navbar-vertical-footer-list-item">
                <!-- Unfold -->
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
                <!-- End Unfold -->
              </li>

              <li class="navbar-vertical-footer-list-item">
                <!-- Other Links -->
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
                <!-- End Other Links -->
              </li>

              <li class="navbar-vertical-footer-list-item">
                <!-- Language -->
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
                <!-- End Language -->
              </li>
            </ul>
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </aside>
  </div>
  <!-- End Navbar Vertical -->