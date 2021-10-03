  <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
          <div class="navbar-vertical-footer-offset">
            <div class="navbar-brand-wrapper justify-content-between">
              <!-- Logo -->
                <a class="navbar-brand" href="./index.html" aria-label="Front">
                  <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
                  <img class="navbar-brand-logo-mini" src="assets/svg/logos/logo-short.svg" alt="Logo">
                </a>

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
                <!-- Personal -->
                @if(Auth::user()->UserDetail->profile_complete == 1)
                <li class="nav-item">
                  <small class="nav-subtitle" title="Personal">Personal</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                
                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/documents') }}" data-placement="left">
                    <i class="tio-documents nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My Documents</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/cv') }}" data-placement="left">
                    <i class="tio-documents nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Manage CV</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/cases') }}" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My Cases</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/invoices') }}" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My Invoices</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/notes') }}" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My Notes</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/chat-groups') }}" data-placement="left">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Chat Groups</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">All Activities</span>
                  </a>
                </li>
                <!-- End Personal -->

                <!-- Professionals -->
                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">Assessments</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <!--<li class="nav-item">-->
                <!--  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">-->
                <!--    <i class="tio-account-square nav-icon"></i>-->
                <!--    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Self Assessments</span>-->
                <!--  </a>-->
                <!--</li>-->
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/assessments') }}" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Paid Assessments</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/eligibility-check') }}" data-placement="left">
                    <i class="tio-verified-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Eligibility Check</span>
                  </a>
                </li>
                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">Notification and messages</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{baseUrl('notifications')}}" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Notifications</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Messages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/tasks') }}" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Pending Tasks</span>
                  </a>
                </li>


                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">News and Feed</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professional feed</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest News</span>
                  </a>
                </li>

                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">Articles</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest Articles</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Bookmarked Articles</span>
                  </a>
                </li>

                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">Webinar</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest Webinar</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My webinar</span>
                  </a>
                </li>
                
                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">Settings</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/connect-apps') }}" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Connect Apps</span>
                  </a>
                </li>
               @endif

              </ul>
            </div>
            <!-- End Content -->
          </div>
        </div>
      </aside>