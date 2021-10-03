@extends('layouts.master')

@section('content')

<!-- Content -->
      <div class="content container-fluid">
        <div class="row justify-content-lg-center">
          <div class="col-lg-10">
            
            @include(roleFolder().".profile.profile-header")

             <div class="card mb-3 mb-lg-5">
                
                  <div class="card-header">
                    <h5 class="card-header-title">Projects</h5>

                    
                    <div class="hs-unfold">
                      <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                         data-hs-unfold-options='{
                           "target": "#projectReportDropdown",
                           "type": "css-animation"
                         }'>
                        <i class="tio-more-vertical"></i>
                      </a>

                      <div id="projectReportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">
                        <span class="dropdown-header">Settings</span>

                        <a class="dropdown-item" href="#">
                          <i class="tio-share dropdown-item-icon"></i>
                          Share connections
                        </a>
                        <a class="dropdown-item" href="#">
                          <i class="tio-info-outined dropdown-item-icon"></i>
                          Suggest edits
                        </a>

                        <div class="dropdown-divider"></div>

                        <span class="dropdown-header">Feedback</span>

                        <a class="dropdown-item" href="#">
                          <i class="tio-chat-outlined dropdown-item-icon"></i>
                          Report
                        </a>
                      </div>
                    </div>
                  
                  </div>
                  <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                      <thead class="thead-light">
                        <tr>
                          <th>Project</th>
                          <th style="width: 40%;">Progress</th>
                          <th class="table-column-right-aligned">Hours spent</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="d-flex">
                              <span class="avatar avatar-xs avatar-soft-dark avatar-circle">
                                <span class="avatar-initials">U</span>
                              </span>
                              <div class="ml-3">
                                <h5 class="mb-0">UI/UX</h5>
                                <small>Updated 2 hours ago</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">0%</span>
                              <div class="progress table-progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </td>
                          <td class="table-column-right-aligned">4:25</td>
                        </tr>

                        <tr>
                          <td>
                            <div class="d-flex">
                              <img class="avatar avatar-xs" src="./assets/svg/brands/spec.svg" alt="Image Description">
                              <div class="ml-3">
                                <h5 class="mb-0">Get a complete audit store</h5>
                                <small>Updated 1 day ago</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">45%</span>
                              <div class="progress table-progress">
                                <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </td>
                          <td class="table-column-right-aligned">18:42</td>
                        </tr>

                        <tr>
                          <td>
                            <div class="d-flex">
                              <img class="avatar avatar-xs" src="./assets/svg/brands/capsule.svg" alt="Image Description">
                              <div class="ml-3">
                                <h5 class="mb-0">Build stronger customer relationships</h5>
                                <small>Updated 2 days ago</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">59%</span>
                              <div class="progress table-progress">
                                <div class="progress-bar" role="progressbar" style="width: 59%" aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </td>
                          <td class="table-column-right-aligned">9:01</td>
                        </tr>

                        <tr>
                          <td>
                            <div class="d-flex">
                              <img class="avatar avatar-xs" src="./assets/svg/brands/mailchimp.svg" alt="Image Description">
                              <div class="ml-3">
                                <h5 class="mb-0">Update subscription method</h5>
                                <small>Updated 2 days ago</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">57%</span>
                              <div class="progress table-progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </td>
                          <td class="table-column-right-aligned">0:37</td>
                        </tr>

                        <tr>
                          <td>
                            <div class="d-flex">
                              <img class="avatar avatar-xs" src="./assets/svg/brands/figma.svg" alt="Image Description">
                              <div class="ml-3">
                                <h5 class="mb-0">Create a new theme</h5>
                                <small>Updated 1 week ago</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">100%</span>
                              <div class="progress table-progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </td>
                          <td class="table-column-right-aligned">24:12</td>
                        </tr>

                        <tr>
                          <td>
                            <div class="d-flex">
                              <span class="avatar avatar-xs avatar-soft-info avatar-circle">
                                <span class="avatar-initials">I</span>
                              </span>
                              <div class="ml-3">
                                <h5 class="mb-0">Improve social banners</h5>
                                <small>Updated 1 week ago</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <span class="mr-3">0%</span>
                              <div class="progress table-progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </td>
                          <td class="table-column-right-aligned">8:08</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <a class="card-footer text-center" href="projects.html">
                    View all projects <i class="tio-chevron-right"></i>
                  </a>
                  
                </div>
                

          </div>
        </div>
        <!-- End Row -->
      </div>
      <!-- End Content -->

@endsection
