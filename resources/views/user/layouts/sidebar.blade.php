<!-- Navbar -->
<div class="navbar-expand-lg navbar-light">
    <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
        <!-- Card -->
        <div class="card flex-grow-1 mb-5">
            <div class="card-body">
                <!-- Avatar -->
                <div class="d-none d-lg-block text-center mb-5">
                    <div class="avatar avatar-xxl avatar-circle mb-3">
                        <img class="avatar-img" src="{{ userProfile() }}" alt="Image Description">
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
                    <li class="navbar-vertical-aside-has-menu show">
                        <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'dashboard'){ echo "active"; } } ?>" href="{{ baseUrl('/') }}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
                        </a>
                    </li>

                    
                    <li class="navbar-vertical-aside-has-menu show">
                        <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'edit-profile'){ echo "active"; } } ?>" href="{{ baseUrl('/edit-profile') }}">
                            <i class="tio-user nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Edit Profile</span>
                        </a>
                    </li>
                    <li class="navbar-vertical-aside-has-menu show">
                        <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'change-password'){ echo "active"; } } ?>" href="{{ baseUrl('/change-password') }}">
                            <i class="tio-lock nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Change Password</span>
                        </a>
                    </li>
                </ul>
                    <!-- End Dashboards -->
                    <!-- Personal -->
                    @if(Auth::user()->UserDetail->profile_complete == 1)
                     
                  <span class="text-cap">Account</span>
                  <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                    <li class="nav-item ">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'dependants'){ echo "active"; } } ?>" href="{{ baseUrl('/dependants') }}"
                            data-placement="left">
                            <i class="tio-user nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dependants</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'documents'){ echo "active"; } } ?>" href="{{ baseUrl('/documents') }}"
                            data-placement="left">
                            <i class="tio-documents nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My
                                Documents</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'manage-cv'){ echo "active"; } } ?>" href="{{ baseUrl('/cv') }}" data-placement="left">
                            <i class="tio-documents nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Manage
                                CV</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'cases'){ echo "active"; } } ?>" href="{{ baseUrl('/cases') }}" data-placement="left">
                            <i class="tio-documents nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'my-cases'){ echo "active"; } } ?>" href="{{ baseUrl('/my-cases') }}" data-placement="left">
                            <i class="tio-documents nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My Cases</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'notes'){ echo "active"; } } ?>" href="{{ baseUrl('/notes') }}" data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My
                                Notes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'chat-groups'){ echo "active"; } } ?>" href="{{ baseUrl('/chat-groups')  }}"
                            data-placement="left">
                            <i class="tio-book-opened nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Chat
                                Groups </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'activities'){ echo "active"; } } ?>" href="javascript:;" data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">All
                                Activities</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'booked-appointments'){ echo "active"; } } ?>" href="{{ baseUrl('/booked-appointments') }}" data-placement="left">
                            <i class="tio-calendar nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Booked
                                Appointments</span>
                        </a>
                    </li>
                    <!-- End Personal -->

                    <!-- Professionals -->
                  </ul>
                        <span class="text-cap">Assessments</span>
                  <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                    <!--<li class="nav-item">-->
                    <!--  <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">-->
                    <!--    <i class="tio-account-square nav-icon"></i>-->
                    <!--    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Self Assessments</span>-->
                    <!--  </a>-->
                    <!--</li>-->
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'assessments'){ echo "active"; } } ?>" href="{{ baseUrl('/assessments') }}"
                            data-placement="left">
                            <i class="tio-comment-text-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Paid
                                Assessments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'eligibility-check'){ echo "active"; } } ?>" href="{{ baseUrl('/eligibility-check') }}"
                            data-placement="left">
                            <i class="tio-verified-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Eligibility
                                Check</span>
                        </a>
                    </li>
                    </ul>
                        <span class="text-cap">Notification and messages</span>
                    <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                      <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'notifications'){ echo "active"; } } ?>" href="{{baseUrl('notifications')}}"
                            data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'messages'){ echo "active"; } } ?>" href="<?php echo baseUrl('/messages-center') ?>"
                            data-placement="left">
                            <i class="tio-comment-text-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'tasks'){ echo "active"; } } ?>" href="{{ baseUrl('/tasks') }}" data-placement="left">
                            <i class="tio-comment-text-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Pending
                                Tasks</span>
                        </a>
                    </li>


                  </ul>
                        <span class="text-cap">News and Feed</span>
                        <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professional
                                feed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                            <i class="tio-comment-text-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest
                                News</span>
                        </a>
                    </li>

</ul>
                        <span class="text-cap">Articles</span>
                        <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest
                                Articles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                            <i class="tio-comment-text-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Bookmarked
                                Articles</span>
                        </a>
                    </li>

</ul>
                        <span class="text-cap">Webinar</span>
                        <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest
                                Webinar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
                            <i class="tio-comment-text-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My
                                webinar</span>
                        </a>
                    </li>

</ul>
                        <span class="text-cap">Settings</span>
                        <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                    <li class="nav-item">
                        <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'connect-apps'){ echo "active"; } } ?>" href="{{ baseUrl('/connect-apps') }}"
                            data-placement="left">
                            <i class="tio-account-square nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Connect
                                Apps</span>
                        </a>
                    </li>
                    @endif
                </ul>

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
{{--<!-- Navbar Vertical -->
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
            <ul class="navbar-nav navbar-nav-lg card-navbar-nav">
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
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/dependants') }}" data-placement="left">
        <i class="tio-user nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dependants</span>
    </a>
</li>
<li class="nav-item ">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/documents') }}" data-placement="left">
        <i class="tio-documents nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My
            Documents</span>
    </a>
</li>
<li class="nav-item ">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/cv') }}" data-placement="left">
        <i class="tio-documents nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Manage
            CV</span>
    </a>
</li>
<li class="nav-item ">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/cases') }}" data-placement="left">
        <i class="tio-documents nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases</span>
    </a>
</li>


<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/notes') }}" data-placement="left">
        <i class="tio-account-square nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My
            Notes</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/chat-groups') }}" data-placement="left">
        <i class="tio-book-opened nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Chat
            Groups</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-account-square nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">All
            Activities</span>
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
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Paid
            Assessments</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/eligibility-check') }}" data-placement="left">
        <i class="tio-verified-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Eligibility
            Check</span>
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
    <a class="js-nav-tooltip-link nav-link" href="<?php echo baseUrl('/messages-center') ?>" data-placement="left">
        <i class="tio-comment-text-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Messages</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/tasks') }}" data-placement="left">
        <i class="tio-comment-text-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Pending
            Tasks</span>
    </a>
</li>


<li class="nav-item">
    <small class="nav-subtitle" title="Professionals">News and Feed</small>
    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-account-square nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professional
            feed</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-comment-text-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest
            News</span>
    </a>
</li>

<li class="nav-item">
    <small class="nav-subtitle" title="Professionals">Articles</small>
    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-account-square nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest
            Articles</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-comment-text-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Bookmarked
            Articles</span>
    </a>
</li>

<li class="nav-item">
    <small class="nav-subtitle" title="Professionals">Webinar</small>
    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-account-square nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Latest
            Webinar</span>
    </a>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="javascript:;" data-placement="left">
        <i class="tio-comment-text-outlined nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My
            webinar</span>
    </a>
</li>

<li class="nav-item">
    <small class="nav-subtitle" title="Professionals">Settings</small>
    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
</li>
<li class="nav-item">
    <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/connect-apps') }}" data-placement="left">
        <i class="tio-account-square nav-icon"></i>
        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Connect
            Apps</span>
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

                <div id="otherLinksDropdown"
                    class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                    <span class="dropdown-header">Help</span>
                    <a class="dropdown-item" href="#">
                        <i class="tio-book-outlined dropdown-item-icon"></i>
                        <span class="text-truncate pr-2" title="Resources &amp; tutorials">Resources &amp;
                            tutorials</span>
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
                    <img class="avatar avatar-xss avatar-circle" src="assets/vendor/flag-icon-css/flags/1x1/us.svg"
                        alt="United States Flag">
                </a>

                <div id="languageDropdown"
                    class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                    <span class="dropdown-header">Select language</span>
                    <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2"
                            src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="English">English (US)</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2"
                            src="assets/vendor/flag-icon-css/flags/1x1/gb.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="English">English (UK)</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2"
                            src="assets/vendor/flag-icon-css/flags/1x1/de.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="Deutsch">Deutsch</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2"
                            src="assets/vendor/flag-icon-css/flags/1x1/dk.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="Dansk">Dansk</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2"
                            src="assets/vendor/flag-icon-css/flags/1x1/it.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="Italiano">Italiano</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2"
                            src="assets/vendor/flag-icon-css/flags/1x1/cn.svg" alt="Flag">
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
--}}