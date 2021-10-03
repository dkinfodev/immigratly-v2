  <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
          <div class="navbar-vertical-footer-offset">
            <div class="navbar-brand-wrapper justify-content-between">
              <!-- Logo -->
                <a class="navbar-brand" href="./index.html" aria-label="Front">
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
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboard</span>
                  </a>
                </li>
                <!-- End Dashboards -->

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
                <!-- Accounts -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/professionals') }}">
                    <i class="tio-pages-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professionals</span>
                  </a>
                </li>
                <!-- End Pages -->
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
                    <!-- <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('screen-capture') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Screen Capture</span>
                      </a>
                    </li> -->
                  </ul>
                </li>
                <!-- End Apps -->
                
              </ul>
            </div>
            <!-- End Content -->

          </div>
        </div>
      </aside>