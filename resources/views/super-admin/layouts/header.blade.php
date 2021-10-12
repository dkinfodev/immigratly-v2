<header id="header" class="navbar navbar-expand-lg navbar-bordered flex-lg-column px-0">
    <div class="navbar-dark w-100">
      <div class="container">
        <div class="navbar-nav-wrap">
          <div class="navbar-brand-wrapper">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}" aria-label="Front">
              <img class="navbar-brand-logo" src="assets/svg/logos/logo-white.svg" alt="Logo">
            </a>
            <!-- End Logo -->
          </div>

          <div class="navbar-nav-wrap-content-left">
            
          </div>

          <!-- Secondary Content -->
          <div class="navbar-nav-wrap-content-right">
            <!-- Navbar -->
            <ul class="navbar-nav align-items-center flex-row">
              <li class="nav-item d-lg-none">
                <!-- Search Trigger -->
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle" href="javascript:;"
                     data-hs-unfold-options='{
                       "target": "#searchDropdown",
                       "type": "css-animation",
                       "animationIn": "fadeIn",
                       "hasOverlay": "rgba(46, 52, 81, 0.1)",
                       "closeBreakpoint": "md"
                     }'>
                    <i class="tio-search"></i>
                  </a>
                </div>
                <!-- End Search Trigger -->
              </li>

              <li class="nav-item d-none d-sm-inline-block">
                <!-- Notification -->
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle" href="javascript:;"
                     data-hs-unfold-options='{
                       "target": "#notificationNavbarDropdown",
                       "type": "css-animation"
                     }'>
                    <i class="tio-notifications-on-outlined"></i>
                    <span class="btn-status btn-sm-status btn-status-danger"></span>
                  </a>

                  <div id="notificationNavbarDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu" style="width: 25rem;">
                    <!-- Header -->
                    <div class="card-header">
                      <span class="card-title h4">Notifications</span>

                      <!-- Unfold -->
                      <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                           data-hs-unfold-options='{
                             "target": "#notificationSettingsOneDropdown",
                             "type": "css-animation"
                           }'>
                          <i class="tio-more-vertical"></i>
                        </a>
                        <div id="notificationSettingsOneDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                          <span class="dropdown-header">Settings</span>
                          <a class="dropdown-item" href="#">
                            <i class="tio-archive dropdown-item-icon"></i> Archive all
                          </a>
                          <a class="dropdown-item" href="#">
                            <i class="tio-all-done dropdown-item-icon"></i> Mark all as read
                          </a>
                          <a class="dropdown-item" href="#">
                            <i class="tio-toggle-off dropdown-item-icon"></i> Disable notifications
                          </a>
                          <a class="dropdown-item" href="#">
                            <i class="tio-gift dropdown-item-icon"></i> What's new?
                          </a>
                          <div class="dropdown-divider"></div>
                          <span class="dropdown-header">Feedback</span>
                          <a class="dropdown-item" href="#">
                            <i class="tio-chat-outlined dropdown-item-icon"></i> Report
                          </a>
                        </div>
                      </div>
                      <!-- End Unfold -->
                    </div>
                    <!-- End Header -->

                    <!-- Nav -->
                    <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="notificationNavOne-tab" data-toggle="tab" href="#notificationNavOne" role="tab" aria-controls="notificationNavOne" aria-selected="true">Messages (3)</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="notificationNavTwo-tab" data-toggle="tab" href="#notificationNavTwo" role="tab" aria-controls="notificationNavTwo" aria-selected="false">Archived</a>
                      </li>
                    </ul>
                    <!-- End Nav -->

                    <!-- Body -->
                    <div class="card-body-height">
                      <!-- Tab Content -->
                      <div class="tab-content" id="notificationTabContent">
                        <div class="tab-pane fade show active" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">
                          <ul class="list-group list-group-flush navbar-card-list-group">
                          @foreach(chatNotifications() as $notification)
                            <li class="list-group-item custom-checkbox-list-wrapper">
                              <div class="row">
                                <div class="col-auto position-static">
                                  <div class="d-flex align-items-center">
                                    <div class="custom-control custom-checkbox custom-checkbox-list">
                                      <input type="checkbox" class="custom-control-input" id="notificationCheck1" checked>
                                      <label class="custom-control-label" for="notificationCheck1"></label>
                                      <span class="custom-checkbox-list-stretched-bg"></span>
                                    </div>
                                    <div class="avatar avatar-sm avatar-circle">
                                      <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="">
                                    </div>
                                  </div>
                                </div>
                                <div class="col ml-n3">
                                  <span class="card-title h5">{{$notification->title}}</span>
                                  <p class="card-text font-size-sm">{{$notification->comment}} <span class="badge badge-success">Review</span></p>
                                </div>
                                <small class="col-auto text-muted text-cap">{{dateFormat($notification->created_at)}}</small>
                              </div>
                              @if($notification->url != '')
                              <a class="stretched-link" href="{{url('/view-notification/'.base64_encode($notification->id))}}"></a>
                              @endif
                            </li>
                            <!-- End Item -->
                            @endforeach
                          </ul>
                        </div>

                        <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel" aria-labelledby="notificationNavTwo-tab">
                          <ul class="list-group list-group-flush navbar-card-list-group">
                          @foreach(otherNotifications() as $notification)
                          <li class="list-group-item custom-checkbox-list-wrapper">
                            <div class="row">
                              <div class="col-auto position-static">
                                <div class="d-flex align-items-center">
                                  <div class="custom-control custom-checkbox custom-checkbox-list">
                                    <input type="checkbox" class="custom-control-input" id="notificationCheck1" checked>
                                    <label class="custom-control-label" for="notificationCheck1"></label>
                                    <span class="custom-checkbox-list-stretched-bg"></span>
                                  </div>
                                  <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="">
                                  </div>
                                </div>
                              </div>
                              <div class="col ml-n3">
                                <span class="card-title h5">{{$notification->title}}</span>
                                <p class="card-text font-size-sm">{{$notification->comment}} <span class="badge badge-success">Review</span></p>
                              </div>
                              <small class="col-auto text-muted text-cap">{{dateFormat($notification->created_at)}}</small>
                            </div>
                            @if($notification->url != '')
                            <a class="stretched-link" href="{{url('/view-notification/'.base64_encode($notification->id))}}"></a>
                            @endif
                          </li>
                          <!-- End Item -->
                          @endforeach
                          </ul>
                        </div>
                      </div>
                      <!-- End Tab Content -->
                    </div>
                    <!-- End Body -->

                    <!-- Card Footer -->
                    <a class="card-footer text-center" href="#">
                      View all notifications
                      <i class="tio-chevron-right"></i>
                    </a>
                    <!-- End Card Footer -->
                  </div>
                </div>
                <!-- End Notification -->
              </li>


              <li class="nav-item d-none d-sm-inline-block">
                <!-- Activity -->
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-light rounded-circle" href="javascript:;"
                     data-hs-unfold-options='{
                      "target": "#activitySidebar",
                      "type": "css-animation",
                      "animationIn": "fadeInRight",
                      "animationOut": "fadeOutRight",
                      "hasOverlay": true,
                      "smartPositionOff": true
                     }'>
                    <i class="tio-voice-line"></i>
                  </a>
                </div>
                <!-- Activity -->
              </li>

              <li class="nav-item">
                <!-- Account -->
                <div class="hs-unfold">
                  <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                     data-hs-unfold-options='{
                       "target": "#accountNavbarDropdown",
                       "type": "css-animation"
                     }'>
                    <div class="avatar avatar-sm avatar-circle">
                      <img class="avatar-img" src="{{ userProfile('','t') }}" alt="">
                      <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                    </div>
                  </a>

                  <div id="accountNavbarDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account" style="width: 16rem;">
                    <div class="dropdown-item-text">
                      <div class="media align-items-center">
                        <div class="avatar avatar-sm avatar-circle mr-2">
                          <img class="avatar-img" src="{{ userProfile('','t') }}" alt="Image Description">
                        </div>
                        <div class="media-body">
                            <span class="card-title h5">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</span>
                            <span class="card-text">{{Auth::user()->email}}</span>
                        </div>
                      </div>
                    </div>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{baseUrl('edit-profile')}}">
                      <span class="text-truncate pr-2" title="Edit Profile">Edit Profile</span>
                    </a>
                    
                    <a class="dropdown-item" href="{{baseUrl('change-password')}}">
                      <span class="text-truncate pr-2" title="Change Password">Change Password</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ url('logout') }}">
                      <span class="text-truncate pr-2 text-danger" title="Sign out">Sign out</span>
                    </a>
                  </div>
                </div>
                <!-- End Account -->
              </li>

              <li class="nav-item">
                <!-- Toggle -->
                <button type="button" class="navbar-toggler btn btn-ghost-light rounded-circle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarNavMenu" data-toggle="collapse" data-target="#navbarNavMenu">
                  <i class="tio-menu-hamburger"></i>
                </button>
                <!-- End Toggle -->
              </li>
            </ul>
            <!-- End Navbar -->
          </div>
          <!-- End Secondary Content -->
        </div>
      </div>
    </div>

    <div class="container">
      <nav class="js-mega-menu flex-grow-1">
        <!-- Navbar -->
        <div class="navbar-nav-wrap-navbar collapse navbar-collapse" id="navbarNavMenu">
          <div class="navbar-body">
            <ul class="navbar-nav flex-grow-1">
              <!-- Dashboards -->
              <li class="hs-has-sub-menu navbar-nav-item">
                <a id="dashboardsDropdown" class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-labelledby="navLinkDashboardsDropdown">
                  <i class="tio-home-vs-1-outlined nav-icon"></i> Dashboards
                </a>

                <!-- Dropdown -->
                <ul id="navLinkDashboardsDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="dashboardsDropdown" style="min-width: 16rem;">
                  <li>
                    <a class="dropdown-item" href="{{ url('/') }}">
                      <span class="tio-circle nav-indicator-icon"></span> Default
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="./dashboard-alternative.html">
                      <span class="tio-circle nav-indicator-icon"></span> Alternative
                    </a>
                  </li>
                </ul>
                <!-- End Dropdown -->
              </li>
              <!-- End Dashboards -->

              <!-- Pages -->
              <li class="hs-has-sub-menu navbar-nav-item">
                <a id="pagesDropdown" class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-labelledby="navLinkPagesDropdown">
                  <i class="tio-pages-outlined nav-icon"></i> Pages
                </a>

                <!-- Dropdown -->
                <ul id="navLinkPagesDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdown" style="min-width: 16rem;">
                  <!-- Users -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownUsers" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownUsers">
                      <span class="tio-circle nav-indicator-icon"></span> Users
                    </a>

                    <ul id="navLinkPagesDropdownUsers" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownUsers" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./users.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Overview
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./users-leaderboard.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Leaderboard
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./users-add-user.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Add User <span class="badge badge-info badge-pill ml-1">Hot</span>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Users -->

                  <!-- User Profile -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownUserProfile" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownUserProfile">
                      <span class="tio-circle nav-indicator-icon"></span> User Profile <span class="badge badge-primary badge-pill ml-2">5</span>
                    </a>

                    <ul id="navLinkPagesDropdownUserProfile" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownUserProfile" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./user-profile.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Profile
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./user-profile-teams.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Teams
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./user-profile-projects.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Projects
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./user-profile-connections.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Connections
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./user-profile-my-profile.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> My Profile
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End User Profile -->

                  <!-- Account -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownAccount" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownAccount">
                      <span class="tio-circle nav-indicator-icon"></span> Account
                    </a>

                    <ul id="navLinkPagesDropdownAccount" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownAccount" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./account-settings.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Settings
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./account-billing.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Billing
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./account-invoice.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Invoice
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./account-api-keys.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> API Keys
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Account -->

                  <!-- E-commerce -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownEcommerce" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownEcommerce">
                      <span class="tio-circle nav-indicator-icon"></span> E-commerce
                    </a>

                    <ul id="navLinkPagesDropdownEcommerce" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownEcommerce" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./ecommerce.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Overview
                        </a>
                      </li>

                      <li class="hs-has-sub-menu navbar-nav-item">
                        <a id="pagesDropdownEcommerceSublevel" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownEcommerceProducts">
                          <span class="tio-circle nav-indicator-icon"></span> E-commerce
                        </a>

                        <ul id="navLinkPagesDropdownEcommerceProducts" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownEcommerceSublevel" style="min-width: 16rem;">
                          <li>
                            <a class="dropdown-item" href="./ecommerce-products.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Products
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="./ecommerce-product-details.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Product Details
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="./ecommerce-add-product.html">
                              <span class="tio-circle nav-indicator-icon"></span> Add Product
                            </a>
                          </li>
                        </ul>
                      </li>

                      <li class="hs-has-sub-menu navbar-nav-item">
                        <a id="pagesDropdownEcommerceSublevel" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownEcommerceOrders">
                          <span class="tio-circle nav-indicator-icon"></span> Orders
                        </a>

                        <ul id="navLinkPagesDropdownEcommerceOrders" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownEcommerceSublevel" style="min-width: 16rem;">
                          <li>
                            <a class="dropdown-item" href="./ecommerce-orders.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Orders
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="./ecommerce-order-details.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Order Details
                            </a>
                          </li>
                        </ul>
                      </li>

                      <li class="hs-has-sub-menu navbar-nav-item">
                        <a id="pagesDropdownEcommerceSublevel" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownEcommerceCustomers">
                          <span class="tio-circle nav-indicator-icon"></span> Customers
                        </a>

                        <ul id="navLinkPagesDropdownEcommerceCustomers" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownEcommerceSublevel" style="min-width: 16rem;">
                          <li>
                            <a class="dropdown-item" href="./ecommerce-customers.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Customers
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="./ecommerce-customer-details.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Customer Details
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="./ecommerce-add-customers.html">
                              <span class="tio-circle-outlined nav-indicator-icon"></span> Add Customers
                            </a>
                          </li>
                        </ul>
                      </li>

                      <li>
                        <a class="dropdown-item" href="./ecommerce-manage-reviews.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Manage Reviews
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./ecommerce-checkout.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Checkout
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End E-commerce -->

                  <!-- Projects -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownProjects" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownProjects">
                      <span class="tio-circle nav-indicator-icon"></span> Projects
                    </a>

                    <ul id="navLinkPagesDropdownProjects" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownProjects" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./projects.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Overview
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./projects-timeline.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Timeline
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Projects -->

                  <!-- Project -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownProject" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownProject">
                      <span class="tio-circle nav-indicator-icon"></span> Project
                    </a>

                    <ul id="navLinkPagesDropdownProject" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownProject" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./project.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Overview
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./project-files.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Files <span class="badge badge-info badge-pill ml-1">Hot</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./project-activity.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Activity
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./project-teams.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Teams
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./project-settings.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Settings
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Project -->

                  <li class="navbar-nav-item">
                    <a class="dropdown-item" href="./referrals.html">
                      <span class="tio-circle nav-indicator-icon"></span> Referrals
                    </a>
                  </li>

                  <li class="dropdown-divider"></li>

                  <!-- Signin -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownSignin" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownSignin">
                      <span class="tio-circle nav-indicator-icon"></span> Sign In
                    </a>

                    <ul id="navLinkPagesDropdownSignin" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownSignin" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./authentication-signin-basic.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Basic
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./authentication-signin-cover.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Cover
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Signin -->

                  <!-- Signup -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownSignup" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownSignup">
                      <span class="tio-circle nav-indicator-icon"></span> Sign Up
                    </a>

                    <ul id="navLinkPagesDropdownSignup" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownSignup" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./authentication-signup-basic.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Basic
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./authentication-signup-cover.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Cover
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Signup -->

                  <!-- Reset Password -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownResetPassword" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownResetPassword">
                      <span class="tio-circle nav-indicator-icon"></span> Reset Password
                    </a>

                    <ul id="navLinkPagesDropdownResetPassword" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownResetPassword" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./authentication-reset-password-basic.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Basic
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./authentication-reset-password-cover.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Cover
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Reset Password -->

                  <!-- Email Verification -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdownEmailVerification" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdownEmailVerification">
                      <span class="tio-circle nav-indicator-icon"></span> Email Verification
                    </a>

                    <ul id="navLinkPagesDropdownEmailVerification" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdownEmailVerification" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./authentication-email-verification-basic.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Basic
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./authentication-email-verification-cover.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Cover
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End Email Verification -->

                  <!-- 2-step Verification -->
                  <li class="hs-has-sub-menu navbar-nav-item">
                    <a id="pagesDropdown2StepVerification" class="hs-mega-menu-invoker dropdown-item dropdown-item-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-controls="navLinkPagesDropdown2StepVerification">
                      <span class="tio-circle nav-indicator-icon"></span> 2-step Verification
                    </a>

                    <ul id="navLinkPagesDropdown2StepVerification" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="pagesDropdown2StepVerification" style="min-width: 16rem;">
                      <li>
                        <a class="dropdown-item" href="./authentication-two-step-verification-basic.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Basic
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="./authentication-two-step-verification-cover.html">
                          <span class="tio-circle-outlined nav-indicator-icon"></span> Cover
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- End 2-step Verification -->

                  <li class="dropdown-divider"></li>

                  <!-- Welcome Page -->
                  <li class="navbar-nav-item">
                    <a class="dropdown-item" href="./error-404.html">
                      <span class="tio-circle nav-indicator-icon"></span> Error 404
                    </a>
                  </li>
                  <!-- ENd Welcome Page -->

                  <!-- Welcome Page -->
                  <li class="navbar-nav-item">
                    <a class="dropdown-item" href="./error-500.html">
                      <span class="tio-circle nav-indicator-icon"></span> Error 500
                    </a>
                  </li>
                  <!-- ENd Welcome Page -->

                  <li class="dropdown-divider"></li>

                  <!-- Welcome Page -->
                  <li class="navbar-nav-item">
                    <a class="dropdown-item" href="./welcome-page.html">
                      <span class="tio-circle nav-indicator-icon"></span> Welcome Page
                    </a>
                  </li>
                  <!-- ENd Welcome Page -->
                </ul>
                <!-- End Dropdown -->
              </li>
              <!-- End Pages -->

              <!-- Documentation -->
              <li class="hs-has-sub-menu navbar-nav-item">
                <a id="appsNavDropdown" class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-labelledby="navLinkappsNavDropdown">
                  <i class="tio-apps nav-icon"></i> Apps
                </a>

                <!-- Dropdown -->
                <ul id="navLinkappsNavDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="appsNavDropdown" style="min-width: 16rem;">
                  <li>
                    <a class="dropdown-item" href="./apps-kanban.html">
                      <span class="tio-circle nav-indicator-icon"></span> Kanban
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="./apps-calendar.html">
                      <span class="tio-circle nav-indicator-icon"></span> Calendar <span class="badge badge-info badge-pill ml-1">New</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="./apps-invoice-generator.html">
                      <span class="tio-circle nav-indicator-icon"></span> Invoice Generator
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="./apps-file-manager.html">
                      <span class="tio-circle nav-indicator-icon"></span> File Manager
                    </a>
                  </li>
                </ul>
                <!-- End Dropdown -->
              </li>
              <!-- End Documentation -->

              <!-- Layouts -->
              <li class="navbar-nav-item">
                <a class="navbar-nav-link nav-link" href="./layouts/layouts.html">
                  <i class="tio-dashboard-vs-outlined nav-icon"></i> Layouts
                </a>
              </li>
              <!-- End Layouts -->

              <!-- Documentation -->
              <li class="hs-has-sub-menu navbar-nav-item">
                <a id="documentationDropdown" class="hs-mega-menu-invoker navbar-nav-link nav-link nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-labelledby="navLinkDocumentationDropdown">
                  <i class="tio-book-opened nav-icon"></i> Docs
                </a>

                <!-- Dropdown -->
                <ul id="navLinkDocumentationDropdown" class="hs-sub-menu dropdown-menu dropdown-menu-lg" aria-labelledby="documentationDropdown" style="min-width: 16rem;">
                  <li>
                    <a class="dropdown-item" href="./documentation/index.html">
                      <span class="tio-circle nav-indicator-icon"></span> Documentation <span class="badge badge-primary badge-pill ml-1">v1.0</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="./documentation/alerts.html">
                      <span class="tio-circle nav-indicator-icon"></span> Components
                    </a>
                  </li>
                </ul>
                <!-- End Dropdown -->
              </li>
              <!-- End Documentation -->
            </ul>

          </div>
        </div>
        <!-- End Navbar -->
      </nav>
    </div>
  </header>

