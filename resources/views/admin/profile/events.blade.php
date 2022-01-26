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

<!-- Content -->
      <div class="content container-fluid">
        <div class="row justify-content-lg-center">
          <div class="col-lg-10">
            
            @include(roleFolder().".profile.profile-header")

            <!-- Filter -->
            <div class="row align-items-center mb-5">
              <div class="col">
                <h3 class="mb-0">8 projects</h3>
              </div>

              <div class="col-auto">
                <!-- Nav -->
                <ul class="nav nav-segment" id="projectsTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="grid-tab" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="true" title="Column view">
                      <i class="tio-column-view-outlined"></i>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false" title="List view">
                      <i class="tio-agenda-view-outlined"></i>
                    </a>
                  </li>
                </ul>
                <!-- End Nav -->
              </div>
            </div>
            <!-- End Filter -->

             <!-- Tab Content -->
            <div class="tab-content" id="projectsTabContent">
              <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                <div class="row row-cols-1 row-cols-md-2">
                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <div class="card-progress-wrap">
                        <!-- Progress -->
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress -->
                      </div>

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-secondary p-2">To do</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown8",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown8" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <img class="avatar avatar-lg" src="./assets/svg/brands/google-webdev.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Webdev</h2>

                          <span class="font-size-sm">Updated 2 hours ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                              <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                              <span class="avatar-initials">B</span>
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                              <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Adam Keep">
                              <span class="avatar-initials">A</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">19</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">33</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">10</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-primary p-2">In progress</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown1",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown1" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <img class="avatar avatar-lg" src="./assets/svg/brands/spec.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Get a complete store audit</h2>

                          <span class="font-size-sm">Updated 1 day ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                              <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="David Harrison">
                              <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Antony Taylor">
                              <span class="avatar-initials">A</span>
                            </a>
                            <a class="avatar avatar-soft-info" href="#" data-toggle="tooltip" data-placement="top" title="Sara Iwens">
                              <span class="avatar-initials">S</span>
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                              <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-light avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                              <span class="avatar-initials">+3</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">4</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">8</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">18</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-success p-2">Completed</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown6",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown6" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <img class="avatar avatar-lg" src="./assets/svg/brands/capsule.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Build stronger customer relationships</h2>

                          <span class="font-size-sm">Updated 1 day ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Amanda Harvey">
                              <img class="avatar-img" src="./assets/img/160x160/img10.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="David Harrison">
                              <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-info" href="#" data-toggle="tooltip" data-placement="top" title="Lisa Iston">
                              <span class="avatar-initials">L</span>
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Sam Kart">
                              <img class="avatar-img" src="./assets/img/160x160/img4.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Zack Ins">
                              <span class="avatar-initials">Z</span>
                            </a>
                            <a class="avatar avatar-light avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="Lewis Clarke, Chris Mathew and 3 more">
                              <span class="avatar-initials">+5</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">7</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">7</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">0</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-primary p-2">In progress</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown2",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown2" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <img class="avatar avatar-lg" src="./assets/svg/brands/prosperops.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Cloud computing</h2>

                          <span class="font-size-sm">Updated 2 days ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                              <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                              <span class="avatar-initials">B</span>
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Linda Bates">
                              <img class="avatar-img" src="./assets/img/160x160/img8.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                              <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">4</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">8</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">30</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 59%" aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-primary p-2">In progress</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown4",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown4" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <img class="avatar avatar-lg" src="./assets/svg/brands/mailchimp.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Update subscription method</h2>

                          <span class="font-size-sm">Updated 2 days ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                              <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                              <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Adam Keep">
                              <span class="avatar-initials">A</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">25</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">30</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">20</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-secondary p-2">To do</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown7",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown7" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <span class="avatar avatar-lg avatar-soft-info avatar-circle">
                            <span class="avatar-initials">I</span>
                          </span>
                          <!-- End Avatar -->
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Improve social banners</h2>

                          <span class="font-size-sm">Updated 1 week ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                              <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-info" href="#" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                              <span class="avatar-initials">B</span>
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                              <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Sam Kart">
                              <img class="avatar-img" src="./assets/img/160x160/img4.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-primary" href="#" data-toggle="tooltip" data-placement="top" title="Daniel Cs.">
                              <span class="avatar-initials">D</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">9</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">16</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">21</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-success p-2">Completed</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown3",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown3" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <img class="avatar avatar-lg" src="./assets/svg/brands/figma.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Create a new theme</h2>

                          <span class="font-size-sm">Updated 1 week ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                              <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                              <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Zack Ins">
                              <span class="avatar-initials">Z</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">7</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">7</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">0</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-hover-shadow text-center h-100">
                      <!-- Progress -->
                      <div class="card-progress-wrap">
                        <div class="progress card-progress">
                          <div class="progress-bar" role="progressbar" style="width: 77%" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!-- End Progress -->

                      <!-- Body -->
                      <div class="card-body">
                        <div class="row align-items-center text-left mb-4">
                          <div class="col">
                            <span class="badge badge-soft-primary p-2">In progress</span>
                          </div>

                          <div class="col-auto">
                            <!-- Unfold -->
                            <div class="hs-unfold card-unfold">
                              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                 data-hs-unfold-options='{
                                   "target": "#projectsGridDropdown5",
                                   "type": "css-animation"
                                 }'>
                                <i class="tio-more-vertical"></i>
                              </a>

                              <div id="projectsGridDropdown5" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <a class="dropdown-item" href="#">Rename project </a>
                                <a class="dropdown-item" href="#">Add to favorites</a>
                                <a class="dropdown-item" href="#">Archive project</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete</a>
                              </div>
                            </div>
                            <!-- End Unfold -->
                          </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                          <!-- Avatar -->
                          <span class="avatar avatar-lg avatar-soft-dark avatar-circle">
                            <span class="avatar-initials">N</span>
                          </span>
                          <!-- End Avatar -->
                        </div>

                        <div class="mb-4">
                          <h2 class="mb-1">Notifications</h2>

                          <span class="font-size-sm">Updated 1 week ago</span>
                        </div>

                        <small class="card-subtitle">Members</small>

                        <div class="d-flex justify-content-center">
                          <!-- Avatar Group -->
                          <div class="avatar-group avatar-group-sm avatar-circle z-index-2">
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Sam Kart">
                              <img class="avatar-img" src="./assets/img/160x160/img4.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-danger" href="#" data-toggle="tooltip" data-placement="top" title="Teresa Eyker">
                              <span class="avatar-initials">T</span>
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Amanda Harvey">
                              <img class="avatar-img" src="./assets/img/160x160/img10.jpg" alt="Image Description">
                            </a>
                            <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="David Harrison">
                              <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                            </a>
                            <a class="avatar avatar-soft-warning" href="#" data-toggle="tooltip" data-placement="top" title="Olivier L.">
                              <span class="avatar-initials">O</span>
                            </a>
                            <a class="avatar avatar-light avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="Brian Halligan, Rachel Doe and 7 more">
                              <span class="avatar-initials">+9</span>
                            </a>
                          </div>
                          <!-- End Avatar Group -->
                        </div>

                        <a class="stretched-link" href="#"></a>
                      </div>
                      <!-- End Body -->

                      <!-- Footer -->
                      <div class="card-footer">
                        <!-- Stats -->
                        <div class="row">
                          <div class="col">
                            <span class="h4">9</span>
                            <span class="d-block font-size-sm">Tasks</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">16</span>
                            <span class="d-block font-size-sm">Completed</span>
                          </div>

                          <div class="col column-divider">
                            <span class="h4">21</span>
                            <span class="d-block font-size-sm">Days left</span>
                          </div>
                        </div>
                        <!-- End Stats -->
                      </div>
                      <!-- End Footer -->
                    </div>
                    <!-- End Card -->
                  </div>
                </div>
                <!-- End Row -->
              </div>

              <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                <div class="row row-cols-1">
                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <img class="avatar mr-3 mr-lg-4" src="./assets/svg/brands/google-webdev.svg" alt="Image Description">

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-secondary p-2 mb-2">To do</span>

                              <h3 class="mb-1">Webdev</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                                  <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                                  <span class="avatar-initials">B</span>
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                                  <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Adam Keep">
                                  <span class="avatar-initials">A</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown1",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown1" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">2 hours ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">19</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">33</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">10</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <img class="avatar mr-3 mr-lg-4" src="./assets/svg/brands/spec.svg" alt="Image Description">

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-primary p-2 mb-2">In progress</span>

                              <h3 class="mb-1">Get a complete store audit</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                                  <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-info" href="#" data-toggle="tooltip" data-placement="top" title="Sara Iwens">
                                  <span class="avatar-initials">S</span>
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                                  <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-light avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                                  <span class="avatar-initials">+5</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown2",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown2" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">1 day ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">4</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">8</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">18</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <img class="avatar mr-3 mr-lg-4" src="./assets/svg/brands/capsule.svg" alt="Image Description">

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-success p-2 mb-2">Completed</span>

                              <h3 class="mb-1">Build stronger customer relationships</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Amanda Harvey">
                                  <img class="avatar-img" src="./assets/img/160x160/img10.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="David Harrison">
                                  <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Zack Ins">
                                  <span class="avatar-initials">Z</span>
                                </a>
                                <a class="avatar avatar-light avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="Lewis Clarke, Chris Mathew and 3 more">
                                  <span class="avatar-initials">+5</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown3",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown3" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">1 day ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">7</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">7</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">0</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <img class="avatar mr-3 mr-lg-4" src="./assets/svg/brands/prosperops.svg" alt="Image Description">

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-primary p-2 mb-2">In progress</span>

                              <h3 class="mb-1">Cloud computing</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                                  <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Bob Bardly">
                                  <span class="avatar-initials">B</span>
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Linda Bates">
                                  <img class="avatar-img" src="./assets/img/160x160/img8.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                                  <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown4",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown4" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">2 hours ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">4</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">8</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">30</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <img class="avatar mr-3 mr-lg-4" src="./assets/svg/brands/mailchimp.svg" alt="Image Description">

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-primary p-2 mb-2">In progress</span>

                              <h3 class="mb-1">Update subscription method</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                                  <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                                  <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Adam Keep">
                                  <span class="avatar-initials">A</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown5",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown5" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">2 days ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">25</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">30</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">20</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar" role="progressbar" style="width: 59%" aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <span class="avatar avatar-soft-info avatar-circle mr-3 mr-lg-4">
                          <span class="avatar-initials">I</span>
                        </span>
                        <!-- End Avatar -->

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-secondary p-2 mb-2">To do</span>

                              <h3 class="mb-1">Improve social banners</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                                  <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                                  <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Sam Kart">
                                  <img class="avatar-img" src="./assets/img/160x160/img4.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-primary" href="#" data-toggle="tooltip" data-placement="top" title="Daniel Cs.">
                                  <span class="avatar-initials">D</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown6",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown6" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">1 week ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">9</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">16</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">21</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <img class="avatar mr-3 mr-lg-4" src="./assets/svg/brands/figma.svg" alt="Image Description">

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-success p-2 mb-2">Completed</span>

                              <h3 class="mb-1">Create a new theme</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
                                  <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
                                  <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-dark" href="#" data-toggle="tooltip" data-placement="top" title="Zack Ins">
                                  <span class="avatar-initials">Z</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown7",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown7" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">1 week ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">7</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">7</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">0</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>

                  <div class="col mb-3 mb-lg-5">
                    <!-- Card -->
                    <div class="card card-body">
                      <div class="media">
                        <!-- Avatar -->
                        <span class="avatar avatar-soft-dark avatar-circle mr-3 mr-lg-4">
                          <span class="avatar-initials">N</span>
                        </span>
                        <!-- End Avatar -->

                        <div class="media-body">
                          <div class="row align-items-sm-center">
                            <div class="col">
                              <span class="badge badge-soft-primary p-2 mb-2">In progress</span>

                              <h3 class="mb-1">Notifications</h3>
                            </div>

                            <div class="col-md-3 d-none d-md-flex justify-content-md-end ml-n3">
                              <!-- Avatar Group -->
                              <div class="avatar-group avatar-group-sm avatar-circle">
                                <a class="avatar avatar-soft-danger" href="#" data-toggle="tooltip" data-placement="top" title="Teresa Eyker">
                                  <span class="avatar-initials">T</span>
                                </a>
                                <a class="avatar" href="#" data-toggle="tooltip" data-placement="top" title="Amanda Harvey">
                                  <img class="avatar-img" src="./assets/img/160x160/img10.jpg" alt="Image Description">
                                </a>
                                <a class="avatar avatar-soft-warning" href="#" data-toggle="tooltip" data-placement="top" title="Olivier L.">
                                  <span class="avatar-initials">O</span>
                                </a>
                                <a class="avatar avatar-light avatar-circle" href="#" data-toggle="tooltip" data-placement="top" title="Brian Halligan, Rachel Doe and 7 more">
                                  <span class="avatar-initials">+9</span>
                                </a>
                              </div>
                              <!-- End Avatar Group -->
                            </div>

                            <div class="col-auto">
                              <!-- Unfold -->
                              <div class="hs-unfold card-unfold">
                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                                   data-hs-unfold-options='{
                                     "target": "#projectsListDropdown8",
                                     "type": "css-animation"
                                   }'>
                                  <i class="tio-more-vertical"></i>
                                </a>

                                <div id="projectsListDropdown8" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                  <a class="dropdown-item" href="#">Rename project </a>
                                  <a class="dropdown-item" href="#">Add to favorites</a>
                                  <a class="dropdown-item" href="#">Archive project</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </div>
                              <!-- End Unfold -->
                            </div>
                          </div>
                          <!-- End Row -->

                          <!-- Stats -->
                          <ul class="list-inline">
                            <li class="list-inline-item">
                              <span class="font-size-sm">Updated:</span>
                              <span class="font-weight-bold text-dark">1 week ago</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Tasks:</span>
                              <span class="font-weight-bold text-dark">9</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Completed:</span>
                              <span class="font-weight-bold text-dark">16</span>
                            </li>

                            <li class="list-inline-item">
                              <span class="font-size-sm">Days left:</span>
                              <span class="font-weight-bold text-dark">21</span>
                            </li>
                          </ul>
                          <!-- End Stats -->

                          <!-- Progress -->
                          <div class="progress card-progress">
                            <div class="progress-bar" role="progressbar" style="width: 77%" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <!-- End Progress -->

                          <a class="stretched-link" href="#"></a>
                        </div>
                      </div>
                    </div>
                    <!-- End Card -->
                  </div>
                </div>
                <!-- End Row -->
              </div>
            </div>
            <!-- End Tab Content -->

          </div>
        </div>
      </div>
            
@endsection
