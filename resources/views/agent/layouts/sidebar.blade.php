<!-- Navbar -->
<div class="navbar-expand-lg navbar-light">
    <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
        <!-- Card -->
        <div class="card flex-grow-1 mb-5">
            <div class="card-body">
                <!-- Avatar -->
                <div class="d-none d-lg-block text-center mb-5">
                    <div class="avatar avatar-xxl avatar-circle mb-3">
                        <img class="avatar-img" src="{{ agentProfile() }}" alt="Image Description">
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
                <ul class="nav nav-sm nav-tabs nav-vertical mb-4">  
                    <span class="text-cap">Account</span>
                    

                    <li class="navbar-vertical-aside-has-menu ">
                    <a class="js-navbar-vertical-aside-menu-link nav-link <?php if(isset($activeTab)){ if($activeTab == 'staff'){ echo "active"; } } ?>" href="{{ baseUrl('/staff') }}">
                        <i class="tio-group-senior nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Staff</span>
                    </a>
                    </li>
              

                </ul>
            </div>
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Navbar -->
