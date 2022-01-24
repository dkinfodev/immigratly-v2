<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <base href="{{ url('/') }}/" />
  <!-- Title -->
  <title>{{ companyName() }}</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="./favicon.ico">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="assets/vendor/icon-set/style.css">
  <link rel="stylesheet" href="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
  <link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="assets/vendor/@yaireo/tagify/dist/tagify.css">
  <link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
  <link rel="stylesheet" href="assets/vendor/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
  <!-- CSS Front Template -->
  <link rel="stylesheet" href="assets/css/theme.min-old.css">
  <!-- <link rel="stylesheet" href="assets/vendor/toastr/toastr.css"> -->
  <link rel="stylesheet" type="text/css" href="assets/vendor/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  @yield('style')
    <script>
    var BASEURL = "{{ baseUrl('/') }}";
    var SITEURL = "{{ url('/') }}";
    var csrf_token = "{{ csrf_token() }}";
    </script>
</head>
<body class="bg-light">
  <div class="loader">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
    <h4 class="text-danger">Loading...</h4>
  </div>
  <!-- Search Form -->
  <div id="searchDropdown" class="hs-unfold-content dropdown-unfold search-fullwidth d-md-none">
    <form class="input-group input-group-merge input-group-borderless">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="tio-search"></i>
        </div>
      </div>

      <input class="form-control rounded-0" type="search" placeholder="Search in front" aria-label="Search in front">

      <div class="input-group-append">
        <div class="input-group-text">
          <div class="hs-unfold">
            <a class="js-hs-unfold-invoker" href="javascript:;"
               data-hs-unfold-options='{
                 "target": "#searchDropdown",
                 "type": "css-animation",
                 "animationIn": "fadeIn",
                 "hasOverlay": "rgba(46, 52, 81, 0.1)",
                 "closeBreakpoint": "md"
               }'>
              <i class="tio-clear tio-lg"></i>
            </a>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- End Search Form -->

  <!-- ========== HEADER ========== -->
  @include(roleFolder().'.layouts.header')
  
  <!-- ========== END HEADER ========== -->

 <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main" class="main">
    @yield("pageheader")
    <!-- Content -->
    <!-- Content -->
    <div class="content container" style="margin-top: -20rem;">
      @include(roleFolder().'.layouts.sidebar')
    <!-- Sidebar Detached Content -->
      <div class="sidebar-detached-content mt-3 mt-lg-0">
       <div class="">
          <div class="content p-0 container-fluid">
            @yield("content")
          </div>
        </div>
      </div>
    </div>
    
    <!-- End Content -->

  </main>
  <div class="modal fade" id="popupModal" tabindex="-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  </div>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- ========== SECONDARY CONTENTS ========== -->
  <!-- Keyboard Shortcuts -->
  <div id="keyboardShortcutsSidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card">
      <div class="card-header">
        <h4 class="card-header-title">Keyboard shortcuts</h4>

        <!-- Toggle Button -->
        <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
           data-hs-unfold-options='{
              "target": "#keyboardShortcutsSidebar",
              "type": "css-animation",
              "animationIn": "fadeInRight",
              "animationOut": "fadeOutRight",
              "hasOverlay": true,
              "smartPositionOff": true
             }'>
          <i class="tio-clear tio-lg"></i>
        </a>
        <!-- End Toggle Button -->
      </div>

      <!-- Body -->
      <div class="card-body sidebar-body sidebar-scrollbar">
        <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
          <div class="list-group-item">
            <h5 class="mb-1">Formatting</h5>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span class="font-weight-bold">Bold</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">b</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <em>italic</em>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">i</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <u>Underline</u>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">u</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <s>Strikethrough</s>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Alt</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">s</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span class="small">Small text</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">s</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <mark>Highlight</mark>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">e</kbd>
              </div>
            </div>
          </div>
        </div>

        <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
          <div class="list-group-item">
            <h5 class="mb-1">Insert</h5>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Mention person <a href="#">(@Brian)</a></span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">@</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Link to doc <a href="#">(+Meeting notes)</a></span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">+</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <a href="#">#hashtag</a>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">#hashtag</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Date</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">/date</kbd>
                <kbd class="d-inline-block mb-1">Space</kbd>
                <kbd class="d-inline-block mb-1">/datetime</kbd>
                <kbd class="d-inline-block mb-1">/datetime</kbd>
                <kbd class="d-inline-block mb-1">Space</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Time</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">/time</kbd>
                <kbd class="d-inline-block mb-1">Space</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Note box</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">/note</kbd>
                <kbd class="d-inline-block mb-1">Enter</kbd>
                <kbd class="d-inline-block mb-1">/note red</kbd>
                <kbd class="d-inline-block mb-1">/note red</kbd>
                <kbd class="d-inline-block mb-1">Enter</kbd>
              </div>
            </div>
          </div>
        </div>

        <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
          <div class="list-group-item">
            <h5 class="mb-1">Editing</h5>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Find and replace</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">r</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Find next</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">n</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Find previous</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">p</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Indent</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Tab</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Un-indent</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Tab</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Move line up</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1"><i class="tio-arrow-large-upward-outlined"></i></kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Move line down</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1"><i class="tio-arrow-large-downward-outlined font-size-sm"></i></kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Add a comment</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Alt</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">m</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Undo</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">z</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Redo</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">y</kbd>
              </div>
            </div>
          </div>
        </div>

        <div class="list-group list-group-sm list-group-flush list-group-no-gutters">
          <div class="list-group-item">
            <h5 class="mb-1">Application</h5>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Create new doc</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Alt</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">n</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Present</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">p</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Share</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">s</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Search docs</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">o</kbd>
              </div>
            </div>
          </div>
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-5">
                <span>Keyboard shortcuts</span>
              </div>
              <div class="col-7 text-right">
                <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd class="d-inline-block mb-1">/</kbd>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Body -->
    </div>
  </div>
  <!-- End Keyboard Shortcuts -->

  <!-- Activity -->
  <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card">
      <div class="card-header">
        <h4 class="card-header-title">Activity stream</h4>

        <!-- Toggle Button -->
        <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
           data-hs-unfold-options='{
            "target": "#activitySidebar",
            "type": "css-animation",
            "animationIn": "fadeInRight",
            "animationOut": "fadeOutRight",
            "hasOverlay": true,
            "smartPositionOff": true
           }'>
          <i class="tio-clear tio-lg"></i>
        </a>
        <!-- End Toggle Button -->
      </div>

      <!-- Body -->
      <div class="card-body sidebar-body sidebar-scrollbar">
        <!-- Step -->
        <ul class="step step-icon-sm step-avatar-sm">
          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
              <div class="step-avatar">
                <img class="step-avatar-img" src="assets/img/160x160/img9.jpg" alt="Image Description">
              </div>

              <div class="step-content">
                <h5 class="mb-1">Iana Robinson</h5>

                <p class="font-size-sm mb-1">Added 2 files to task <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fd-7</a></p>

                <ul class="list-group list-group-sm">
                  <!-- List Item -->
                  <li class="list-group-item list-group-item-light">
                    <div class="row gx-1">
                      <div class="col-6">
                        <div class="media">
                            <span class="mt-1 mr-2">
                              <img class="avatar avatar-xs" src="assets/svg/brands/excel.svg" alt="Image Description">
                            </span>
                          <div class="media-body text-truncate">
                            <span class="d-block font-size-sm text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                            <small class="d-block text-muted">12kb</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="media">
                            <span class="mt-1 mr-2">
                              <img class="avatar avatar-xs" src="assets/svg/brands/word.svg" alt="Image Description">
                            </span>
                          <div class="media-body text-truncate">
                            <span class="d-block font-size-sm text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                            <small class="d-block text-muted">4kb</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <!-- End List Item -->
                </ul>

                <small class="text-muted text-uppercase">Now</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->

          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
              <span class="step-icon step-icon-soft-dark">B</span>

              <div class="step-content">
                <h5 class="mb-1">Bob Dean</h5>

                <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fr-6</a> as <span class="badge badge-soft-success badge-pill"><span class="legend-indicator bg-success"></span>"Completed"</span></p>

                <small class="text-muted text-uppercase">Today</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->

          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
              <div class="step-avatar">
                <img class="step-avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
              </div>

              <div class="step-content">
                <h5 class="h5 mb-1">Crane</h5>

                <p class="font-size-sm mb-1">Added 5 card to <a href="#">Payments</a></p>

                <ul class="list-group list-group-sm">
                  <li class="list-group-item list-group-item-light">
                    <div class="row gx-1">
                      <div class="col">
                        <img class="img-fluid rounded ie-sidebar-activity-img" src="assets/svg/illustrations/card-1.svg" alt="Image Description">
                      </div>
                      <div class="col">
                        <img class="img-fluid rounded ie-sidebar-activity-img" src="assets/svg/illustrations/card-2.svg" alt="Image Description">
                      </div>
                      <div class="col">
                        <img class="img-fluid rounded ie-sidebar-activity-img" src="assets/svg/illustrations/card-3.svg" alt="Image Description">
                      </div>
                      <div class="col-auto align-self-center">
                        <div class="text-center">
                          <a href="#">+2</a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>

                <small class="text-muted text-uppercase">May 12</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->

          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
              <span class="step-icon step-icon-soft-info">D</span>

              <div class="step-content">
                <h5 class="mb-1">David Lidell</h5>

                <p class="font-size-sm mb-1">Added a new member to Front Dashboard</p>

                <small class="text-muted text-uppercase">May 15</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->

          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
              <div class="step-avatar">
                <img class="step-avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
              </div>

              <div class="step-content">
                <h5 class="mb-1">Rachel King</h5>

                <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fr-3</a> as <span class="badge badge-soft-success badge-pill"><span class="legend-indicator bg-success"></span>"Completed"</span></p>

                <small class="text-muted text-uppercase">Apr 29</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->

          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
              <div class="step-avatar">
                <img class="step-avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
              </div>

              <div class="step-content">
                <h5 class="mb-1">Finch Hoot</h5>

                <p class="font-size-sm mb-1">Earned a "Top endorsed" <i class="tio-verified text-primary"></i> badge</p>

                <small class="text-muted text-uppercase">Apr 06</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->

          <!-- Step Item -->
          <li class="step-item">
            <div class="step-content-wrapper">
                <span class="step-icon step-icon-soft-primary">
                  <i class="tio-user"></i>
                </span>

              <div class="step-content">
                <h5 class="mb-1">Project status updated</h5>

                <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fr-3</a> as <span class="badge badge-soft-primary badge-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>

                <small class="text-muted text-uppercase">Feb 10</small>
              </div>
            </div>
          </li>
          <!-- End Step Item -->
        </ul>
        <!-- End Step -->

        <a class="btn btn-block btn-white" href="javascript:;">View all <i class="tio-chevron-right"></i></a>
      </div>
      <!-- End Body -->
    </div>
  </div>
  <!-- End Activity -->

  <!-- Welcome Message Modal -->
  <div class="modal fade" id="welcomeMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <!-- Header -->
        <div class="modal-close">
          <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
            <i class="tio-clear tio-lg"></i>
          </button>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="modal-body p-sm-5">
          <div class="text-center">
            <div class="w-75 w-sm-50 mx-auto mb-4">
              <img class="img-fluid" src="assets/svg/illustrations/graphs.svg" alt="Image Description">
            </div>

            <h4 class="h1">Welcome to Front</h4>

            <p>We're happy to see you in our community.</p>
          </div>
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="modal-footer d-block text-center py-sm-5">
          <small class="text-cap mb-4">Trusted by the world's best teams</small>

          <div class="w-85 mx-auto">
            <div class="row justify-content-between">
              <div class="col">
                <img class="img-fluid ie-welcome-brands" src="assets/svg/brands/gitlab-gray.svg" alt="Image Description">
              </div>
              <div class="col">
                <img class="img-fluid ie-welcome-brands" src="assets/svg/brands/fitbit-gray.svg" alt="Image Description">
              </div>
              <div class="col">
                <img class="img-fluid ie-welcome-brands" src="assets/svg/brands/flow-xo-gray.svg" alt="Image Description">
              </div>
              <div class="col">
                <img class="img-fluid ie-welcome-brands" src="assets/svg/brands/layar-gray.svg" alt="Image Description">
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>
  <div id="successToast" class="toast notificationToast successToast" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
    <div class="toast-header">
      <!-- <img class="avatar avatar-sm avatar-circle mr-2" src="../assets/img/160x160/img4.jpg" alt="Image description"> -->
      <!-- <div class="avatar avatar-circle bg-secondary">
        <i class="tio-done"></i>
      </div> -->
      <h5 class="mb-0">Success</h5>
      <!-- <small class="ml-auto">11 mins ago</small> -->
      <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
        <i class="tio-clear" aria-hidden="true"></i>
      </button>
    </div>
    <div class="toast-body">
      
    </div>
  </div>
  <div id="warningToast" class="toast notificationToast warningToast" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
    <div class="toast-header">
      <!-- <img class="avatar avatar-sm avatar-circle mr-2" src="../assets/img/160x160/img4.jpg" alt="Image description"> -->
      <!-- <div class="avatar avatar-circle bg-secondary">
        <i class="tio-done"></i>
      </div> -->
      <h5 class="mb-0">Warning</h5>
      <!-- <small class="ml-auto">11 mins ago</small> -->
      <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
        <i class="tio-clear" aria-hidden="true"></i>
      </button>
    </div>
    <div class="toast-body">
      
    </div>
  </div>
<div id="errorToast" class="toast notificationToast errorToast" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
  <div class="toast-header">
    <!-- <img class="avatar avatar-sm avatar-circle mr-2" src="../assets/img/160x160/img4.jpg" alt="Image description"> -->
    <!-- <div class="avatar avatar-circle bg-secondary">
      <i class="tio-warning"></i>
    </div> -->
    <h5 class="mb-0">Warning</h5>
    <!-- <small class="ml-auto">11 mins ago</small> -->
    <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
      <i class="tio-clear" aria-hidden="true"></i>
    </button>
  </div>
  <div class="toast-body">
    
  </div>
</div>
  <!-- End Welcome Message Modal -->
  <!-- ========== END SECONDARY CONTENTS ========== -->


  <!-- JS Global Compulsory  -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
  <script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
  <script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
  <script src="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
  <script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
  <script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
  <script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
  <!-- <script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script> -->
  <script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
  <script src="assets/vendor/quill/dist/quill.min.js"></script>
  <script src="assets/vendor/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
  <script src="assets/vendor/@yaireo/tagify/dist/tagify.min.js"></script>
  <script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="assets/vendor/datatables.net.extensions/select/select.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="assets/vendor/jszip/dist/jszip.min.js"></script>
  <script src="assets/vendor/pdfmake/build/pdfmake.min.js"></script>
  <script src="assets/vendor/pdfmake/build/vfs_fonts.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>
  <!-- <script src="assets/vendor/toastr/toastr.min.js"></script> -->
  <script src="assets/vendor/ckeditor/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- JS Front -->
  <script src="assets/js/theme.min.js"></script>
  <script src="assets/js/theme-custom.js"></script>

  <!-- JS Plugins Init. -->
  <script>
    initSelect();
    $(document).on('ready', function () {
      // INITIALIZATION OF UNFOLD
      // =======================================================
      $('.js-hs-unfold-invoker').each(function () {
        var unfold = new HSUnfold($(this)).init();
      });
      $('[data-toggle="tooltip"]').tooltip();
      $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
 // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
      // =======================================================
      var sidebar = $('.js-navbar-vertical-aside').hsSideNav();

              // INITIALIZATION OF FILE ATTACH
        // =======================================================


        
        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
          var select2 = $.HSCore.components.HSSelect2.init($(this));
        });


      // INITIALIZATION OF MEGA MENU
      // =======================================================
      var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
        // eventType: 'click',
        desktop: {
          position: 'left'
        }
      }).init();
    });

    function showPopup(url,method='get',paramters = {}){
        $.ajax({
            url: url+"?_token="+csrf_token,
            dataType:'json',
            type:method,
            data:paramters,
            beforeSend:function(){
                showLoader();
                $("#popupModal").html('');
            },
            success: function (result) {
                hideLoader();
                if(result.status == true){
                    $("#popupModal").html(result.contents);
                    $("#popupModal").modal("show");
                }else{
                    if(result.message != undefined){
                        errorMessage(result.message);
                    }else{
                        errorMessage("No Modal Data found");    
                    }
                }
            },
            error:function(){
                hideLoader();
                internalError();
            }
        });
      }
    
    function closeModal(){
        $("#popupModal").html('');
        $("#popupModal").modal("hide");
    }
  </script>

  <!-- IE Support -->
  <script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="assets/vendor/babel-polyfill/polyfill.min.js"><\/script>');
  </script>
  @yield('javascript')
</body>
</html>