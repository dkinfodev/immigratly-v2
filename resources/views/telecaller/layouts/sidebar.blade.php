
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
          
            <!-- Navbar Nav -->
             <ul class="nav nav-sm nav-tabs nav-vertical mb-4">
                <!-- Dashboards -->
                <!-- <li class="navbar-vertical-aside-has-menu show">
                  <a class="js-navbar-vertical-aside-menu-link nav-link active" href="{{ baseUrl('/') }}" title="Dashboards">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
                  </a>
                </li> -->
                <!-- End Dashboards -->

                @if(role_permission('leads','view-leads'))
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'leads'){ echo "active"; } } ?>" href="{{ baseUrl('/leads') }}">
                    <i class="tio-apps nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Leads</span>
                  </a>
                </li>
                @endif
                @if(role_permission('cases','view-cases'))
                <li class="navbar-vertical-aside-has-menu">
                  <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'cases'){ echo "active"; } } ?>" href="{{ baseUrl('/cases') }}">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases</span>
                  </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="js-nav-tooltip-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'messages'){ echo "active"; } } ?>" href="<?php echo baseUrl('/messages-center') ?>" data-placement="left">
                        <i class="tio-comment-text-outlined nav-icon"></i>
                        <span
                            class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Messages</span>
                    </a>
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






