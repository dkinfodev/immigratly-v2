@extends('layouts.master')
@section('breadcrumb')
<!-- Content -->
<ol class="breadcrumb breadcrumb-no-gutter">
  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
</ol>
<!-- End Content -->
@endsection
@section('content')

 <div class="content container-fluid">
        <div class="row justify-content-lg-center">
          <div class="col-lg-10">
            <!-- Profile Cover -->
            <div class="profile-cover">
              <div class="profile-cover-img-wrapper">
                <img class="profile-cover-img" src="./assets/img/1920x400/img1.jpg" alt="Image Description">
              </div>
            </div>
            <!-- End Profile Cover -->

            <!-- Profile Header -->
            <div class="text-center mb-5">
              <!-- Avatar -->
              <div class="avatar avatar-xxl avatar-circle avatar-border-lg profile-cover-avatar">
                <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                <span class="avatar-status avatar-status-success"></span>
              </div>
              <!-- End Avatar -->

              <h1 class="page-title">{{$admin['first_name']}} {{$admin['last_name']}}<i class="tio-verified tio-lg text-primary" data-toggle="tooltip" data-placement="top" title="Top endorsed"></i></h1>

              <!-- List -->
              <ul class="list-inline list-inline-m-1">
                <li class="list-inline-item">
                  <i class="tio-city mr-1"></i>
                  <span>{{$company['company_name']}}</span>
                </li>

                <li class="list-inline-item">
                  <i class="tio-poi-outlined mr-1"></i>
                  <a href="#">{{$company['address']}},</a> 
                  <a href="#">{{getCityName($company['city_id'])}},</a> 
                  <a href="#">{{getStateName($company['state_id'])}},</a> 
                  <a href="#">{{getCountryName($company['country_id'])}}</a>
                </li>

                <li class="list-inline-item">
                  <i class="tio-date-range mr-1"></i>
                  <span>{{date('d-M-Y',strtotime($company['created_at']))}}</span>
                </li>
              </ul>
              <!-- End List -->
            </div>
            <!-- End Profile Header -->

            <!-- Nav -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal mb-5">
              <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                  <i class="tio-chevron-left"></i>
                </a>
              </span>

              <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                  <i class="tio-chevron-right"></i>
                </a>
              </span>

              <ul class="nav nav-tabs align-items-center">
                <!--<li class="nav-item">
                  <a class="nav-link active" href="user-profile.html">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="user-profile-teams.html">Teams</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="user-profile-projects.html">Projects <span class="badge badge-soft-dark rounded-circle ml-1">3</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="user-profile-connections.html">Connections</a>
                </li>-->

                <!--<li class="nav-item ml-auto">
                  <a class="btn btn-sm btn-white mr-2" href="#">
                    <i class="tio-user-add mr-1"></i> Connect
                  </a>

                  <a class="btn btn-icon btn-sm btn-white mr-2" href="#">
                    <i class="tio-format-points mr-1"></i>
                  </a>

                  
                  <div class="hs-unfold hs-nav-scroller-unfold">
                    <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white" href="javascript:;"
                       data-hs-unfold-options='{
                         "target": "#profileDropdown",
                         "type": "css-animation"
                       }'>
                      <i class="tio-more-vertical"></i>
                    </a>

                    <div id="profileDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">
                      <span class="dropdown-header">Settings</span>

                      <a class="dropdown-item" href="#">
                        <i class="tio-share dropdown-item-icon"></i>
                        Share profile
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="tio-blocked dropdown-item-icon"></i>
                        Block page and profile
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="tio-info-outined dropdown-item-icon"></i>
                        Suggest edits
                      </a>

                      <div class="dropdown-divider"></div>

                      <span class="dropdown-header">Feedback</span>

                      <a class="dropdown-item" href="#">
                        <i class="tio-report-outlined dropdown-item-icon"></i>
                        Report
                      </a>
                    </div>
                  </div>
                  
                </li>-->
              </ul>
            </div>
            <!-- End Nav -->

            <div class="row">
              <div class="col-lg-4">
                
                <!-- Sticky Block Start Point -->
               

                <!-- Card -->
                <div class="js-sticky-block card mb-3 mb-lg-5">
                  <!-- Header -->
                  <div class="card-header">
                    <h5 class="card-header-title">Profile</h5>
                  </div>
                  <!-- End Header -->

                  <!-- Body -->
                  <div class="card-body">
                    <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                      <li class="py-0">
                        <small class="card-subtitle">About</small>
                      </li>

                      <li>
                        <i class="tio-user-outlined nav-icon"></i>
                        {{$admin['first_name']}} {{$admin['last_name']}}
                      </li>
                      <li>
                        <i class="tio-briefcase-outlined nav-icon"></i>
                        {{$company['website_url']}}
                        
                      </li>
                      <li>
                        <i class="tio-city nav-icon"></i>
                        {{$company['company_name']}}
                      </li>

                      <li class="pt-2 pb-0">
                        <small class="card-subtitle">Contacts</small>
                      </li>

                      <li>
                        <i class="tio-online nav-icon"></i>
                        {{$company['email']}}
                      </li>
                      <li>
                        <i class="tio-android-phone-vs nav-icon"></i>
                        {{$company['phone_no']}}
                      </li>

                      <!--
                      <li class="pt-2 pb-0">
                        <small class="card-subtitle">Teams</small>
                      </li>

                      <li>
                        <i class="tio-group-equal nav-icon"></i>
                        Member of 7 teams
                      </li>
                      <li>
                        <i class="tio-briefcase-outlined nav-icon"></i>
                        Working on 8 projects
                      </li>-->
                    </ul>
                  </div>
                  <!-- End Body -->
                </div>
                <!-- End Card -->
              </div>

              <div class="col-lg-8">
                
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                  <!-- Header -->
                  <div class="card-header">
                    <h5 class="card-header-title">Services</h5>

                  </div>
                  <!-- End Header -->

                  <!-- Table -->
                  <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                      <thead class="thead-light">
                        <tr>
                          <th>Services</th>
                          <th style="width: 40%;">Price</th>
                        </tr>
                      </thead>

                      <tbody>
                        
                        @foreach($services as $key=>$service)
                        <tr>
                          <td>
                            <div class="d-flex">
                              <span class="avatar avatar-xs avatar-soft-dark avatar-circle">
                                <span class="avatar-initials">U</span>
                              </span>
                              <div class="ml-3">
                                <h5 class="mb-0">{{$service['service_info']['name']}}</h5>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">{{$service['price']}}</span>
                              
                            </div>
                          </td>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                  <!-- End Table -->

                  
                </div>
                <!-- End Card -->

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
              </div>
            </div>
            <!-- End Row -->
          </div>
        </div>
        <!-- End Row -->
      </div>
      <!-- End Content -->
@endsection