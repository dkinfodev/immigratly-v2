@extends('layouts.master')
@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{$pageTitle}}</h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
    </div>
</div>
<!-- End Content -->
@endsection
@section('content')

 <div class="page-header">
          <div class="row align-items-end mb-3">
            <div class="col-sm">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-no-gutter">
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a></li>
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Project</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Activity</li>
                </ol>
              </nav>

              <h1 class="page-header-title">Activity</h1>
            </div>
          </div>
          <!-- End Row -->

          <!-- Nav -->
          <!-- Nav -->
          <div class="js-nav-scroller hs-nav-scroller-horizontal">
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

            <ul class="nav nav-tabs page-header-tabs" id="projectsTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link " href="project.html">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="project-files.html">Files <span class="badge badge-soft-dark rounded-circle ml-1">3</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="project-activity.html">Activity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="project-teams.html">Teams</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="project-settings.html">Settings</a>
              </li>
            </ul>
          </div>
          <!-- End Nav -->
        </div>
        <!-- End Page Header -->

        <div class="row justify-content-lg-center">
          <div class="col-lg-9">
            <!-- Alert -->
            <div class="alert alert-soft-dark mb-5 mb-lg-7" role="alert">
              <div class="media align-items-center">
                <img class="avatar avatar-xl mr-3" src="./assets/svg/illustrations/yelling-reverse.svg" alt="Image Description">

                <div class="media-body">
                  <h3 class="alert-heading mb-1">Attention!</h3>
                  <p class="mb-0">Hi! This project is due for an update. The last update was published 2 days ago.</p>
                </div>
              </div>
            </div>
            <!-- End Alert -->

            <!-- Step -->
            <ul class="step">
              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <small class="step-divider">Today</small>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <div class="step-avatar">
                    <img class="step-avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                  </div>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">Iana Robinson</a>
                    </h5>

                    <p class="font-size-sm">Uploaded weekly reports to the task <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i></a></p>

                    <ul class="list-group">
                      <!-- List Item -->
                      <li class="list-group-item list-group-item-light">
                        <div class="row gx-1">
                          <div class="col">
                            <div class="media">
                              <span class="mt-1 mr-2">
                                <img class="avatar avatar-xs" src="./assets/svg/brands/excel.svg" alt="Image Description">
                              </span>
                              <div class="media-body text-truncate">
                                <span class="d-block font-size-sm text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                                <small class="d-block text-muted">12kb</small>
                              </div>
                            </div>
                          </div>
                          <div class="col">
                            <div class="media">
                              <span class="mt-1 mr-2">
                                <img class="avatar avatar-xs" src="./assets/svg/brands/word.svg" alt="Image Description">
                              </span>
                              <div class="media-body text-truncate">
                                <span class="d-block font-size-sm text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                                <small class="d-block text-muted">4kb</small>
                              </div>
                            </div>
                          </div>
                          <div class="col">
                            <div class="media">
                              <span class="mt-1 mr-2">
                                <img class="avatar avatar-xs" src="./assets/svg/brands/word.svg" alt="Image Description">
                              </span>
                              <div class="media-body text-truncate">
                                <span class="d-block font-size-sm text-dark text-truncate" title="monthly-reports.xls">monthly-reports.xls</span>
                                <small class="d-block text-muted">8kb</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- End List Item -->
                    </ul>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-soft-dark">B</span>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">Bob Dean</a>
                    </h5>

                    <p class="font-size-sm">Marked project status as <span class="badge badge-soft-primary badge-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <small class="step-divider">Yesterday</small>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <div class="step-avatar">
                    <img class="step-avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                  </div>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">David Harrison</a>
                    </h5>

                    <p class="font-size-sm">Added 5 new card styles to <a href="#">Payments</a></p>

                    <ul class="list-group">
                      <!-- List Item -->
                      <li class="list-group-item list-group-item-light">
                        <div class="row gx-1">
                          <div class="col">
                            <img class="img-fluid rounded" src="./assets/svg/illustrations/card-1.svg" alt="Image Description">
                          </div>
                          <div class="col">
                            <img class="img-fluid rounded" src="./assets/svg/illustrations/card-2.svg" alt="Image Description">
                          </div>
                          <div class="col">
                            <img class="img-fluid rounded" src="./assets/svg/illustrations/card-3.svg" alt="Image Description">
                          </div>
                          <div class="col">
                            <img class="img-fluid rounded" src="./assets/svg/illustrations/card-4.svg" alt="Image Description">
                          </div>
                          <div class="col">
                            <img class="img-fluid rounded" src="./assets/svg/illustrations/card-5.svg" alt="Image Description">
                          </div>
                          <div class="col-auto align-self-center">
                            <div class="text-center">
                              <a href="#">+2</a>
                            </div>
                          </div>
                        </div>
                      </li>
                      <!-- List Item -->
                    </ul>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-soft-info">D</span>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">David Lidell</a>
                    </h5>

                    <p class="font-size-sm">Added a new member to Front Dashboard</p>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <div class="step-avatar">
                    <img class="step-avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                  </div>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">Rachel King</a>
                    </h5>

                    <p class="font-size-sm">Earned a "Top endorsed" <i class="tio-verified text-primary"></i> badge</p>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <small class="step-divider">Last week</small>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <div class="step-avatar">
                    <img class="step-avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                  </div>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">Mark Williams</a>
                    </h5>

                    <p class="font-size-sm">Attached two files.</p>

                    <ul class="list-group list-group-sm">
                      <!-- List Item -->
                      <li class="list-group-item list-group-item-light">
                        <div class="media">
                          <i class="tio-attachment-diagonal mt-1 mr-2"></i>
                          <div class="media-body text-truncate">
                            <span class="d-block text-dark text-truncate">Requirements.figma</span>
                            <small class="d-block">8mb</small>
                          </div>
                        </div>
                      </li>
                      <!-- End List Item -->

                      <!-- List Item -->
                      <li class="list-group-item list-group-item-light">
                        <div class="media">
                          <i class="tio-attachment-diagonal mt-1 mr-2"></i>
                          <div class="media-body text-truncate">
                            <span class="d-block text-dark text-truncate">Requirements.sketch</span>
                            <small class="d-block">4mb</small>
                          </div>
                        </div>
                      </li>
                      <!-- End List Item -->
                    </ul>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->

              <!-- Step Item -->
              <li class="step-item">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-soft-primary">C</span>

                  <div class="step-content">
                    <h5 class="mb-1">
                      <a class="text-dark" href="#">Costa Quinn</a>
                    </h5>

                    <p class="font-size-sm">Marked project status as <span class="badge badge-soft-primary badge-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>
                  </div>
                </div>
              </li>
              <!-- End Step Item -->
            </ul>
            <!-- End Step -->

            <!-- Footer -->
            <a class="btn btn-block btn-white" href="javascript:;">
              <i class="tio-refresh mr-1"></i> Load more activities
            </a>
            <!-- End Footer -->
          </div>
        </div>
        <!-- End Row -->
@endsection

@section('javascript')
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script>
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
  $(document).on('ready', function () {
    
    $('.js-hs-action').each(function () {
      var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    // var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
  });
</script>
@endsection