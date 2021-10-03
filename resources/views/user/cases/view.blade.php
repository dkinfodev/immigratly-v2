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
<!-- Page Header -->
<div class="page-header">
    <div class="media mb-3">
      <!-- Avatar -->
      <div class="avatar avatar-xl avatar-4by3 mr-2">
        <img class="avatar-img" src="assets/dashboard/svg/brands/guideline.svg" alt="Image Description">
      </div>
      <!-- End Avatar -->

      <div class="media-body">
        <div class="row">
          <div class="col-lg mb-3 mb-lg-0">
            <h1 class="page-header-title">Cloud computing web service</h1>

            <div class="row align-items-center">
              <div class="col-auto">
                <span>Client:</span>
                <a href="#">Htmlstream</a>
              </div>

              <div class="col-auto">
                <div class="row align-items-center g-0">
                  <div class="col-auto">Due date:</div>

                  <!-- Flatpickr -->
                  <div id="projectDeadlineFlatpickr" class="js-flatpickr flatpickr-custom flatpickr-custom-borderless col input-group input-group-sm"
                        data-hs-flatpickr-options='{
                          "appendTo": "#projectDeadlineFlatpickr",
                          "dateFormat": "d/m/Y",
                          "wrap": true
                        }'>
                    <input type="text" class="flatpickr-custom-form-control form-control" placeholder="Select dates" data-input value="29/06/2020">
                    <div class="input-group-append" data-toggle>
                      <div class="input-group-text">
                        <i class="tio-chevron-down"></i>
                      </div>
                    </div>
                  </div>
                  <!-- End Flatpickr -->
                </div>
              </div>

              <div class="col-auto">
                <!-- Select -->
                <div class="select2-custom">
                  <select class="js-select2-custom custom-select-sm" size="1" style="opacity: 0;" id="ownerLabel"
                          data-hs-select2-options='{
                            "minimumResultsForSearch": "Infinity",
                            "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                            "dropdownAutoWidth": true,
                            "width": true
                          }'>
                    <option value="owner1" selected data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="assets/dashboard/img/160x160/img6.jpg" alt="Avatar" /><span class="media-body">Mark Williams</span></span>'>Mark Williams</option>
                    <option value="owner2" data-option-template='<span class="media align-items-center"><img class="avatar avatar-xss avatar-circle mr-2" src="assets/dashboard/img/160x160/img10.jpg" alt="Avatar" /><span class="media-body">Amanda Harvey</span></span>'>Amanda Harvey</option>
                    <option value="owner3" data-option-template='<span class="media align-items-center"><i class="tio-user-outlined text-body mr-2"></i><span class="media-body">Assign to owner</span></span>'>Assign to owner</option>
                  </select>
                  </div>
                <!-- End Select -->
              </div>
            </div>
          </div>

          <div class="col-lg-auto">
            <small class="text-cap mb-2">Team members:</small>

            <div class="d-flex">
              <!-- Avatar Group -->
              <div class="avatar-group avatar-circle mr-3">
                <a class="avatar" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="Amanda Harvey">
                  <img class="avatar-img" src="assets/dashboard/img/160x160/img10.jpg" alt="Image Description">
                </a>
                <a class="avatar" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="Linda Bates">
                  <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                </a>
                <a class="avatar avatar-soft-info" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="#digitalmarketing">
                  <span class="avatar-initials">
                    <i class="tio-group-senior"></i>
                  </span>
                </a>
                <a class="avatar" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="David Harrison">
                  <img class="avatar-img" src="assets/dashboard/img/160x160/img3.jpg" alt="Image Description">
                </a>
                <a class="avatar avatar-soft-dark" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="Antony Taylor">
                  <span class="avatar-initials">A</span>
                </a>

                <a class="avatar avatar-light avatar-circle" href="javascript:;" data-toggle="modal" data-target="#shareWithPeopleModal">
                  <span class="avatar-initials">+2</span>
                </a>
              </div>
              <!-- End Avatar Group -->

              <a class="btn btn-icon btn-primary rounded-circle" href="javascript:;" data-toggle="modal" data-target="#shareWithPeopleModal">
                <i class="tio-share"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Media -->

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
          <a class="nav-link active" href="03-master-user-case-view.html">Overview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="03-master-user-folder-view.html">Files <span class="badge badge-soft-dark rounded-circle ml-1">3</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="project-activity.html">Activity</a>
        </li> <li class="nav-item">
          <a class="nav-link " href="02-master-user-container-invoice-view.html">Invoice</a>
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

  <!-- Stats -->
  <div class="row">
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-6">
      <!-- Card -->
      <div class="card card-sm">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <!-- Media -->
              <div class="media">
                <i class="tio-receipt-outlined nav-icon"></i>

                <div class="media-body">
                  <h4 class="mb-1">Spent</h4>
                  <span class="d-block">-$71,431.00 USD</span>
                </div>
              </div>
              <!-- End Media -->
            </div>

            <div class="col-auto">
              <!-- Circle -->
              <div class="js-circle"
                    data-hs-circles-options='{
                      "value": 54,
                      "maxValue": 100,
                      "duration": 2000,
                      "isViewportInit": true,
                      "colors": ["#e7eaf3", "#377dff"],
                      "radius": 25,
                      "width": 3,
                      "fgStrokeLinecap": "round",
                      "textFontSize": 14,
                      "additionalText": "%",
                      "textClass": "circle-custom-text",
                      "textColor": "#377dff"
                    }'></div>
              <!-- End Circle -->
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-6">
      <!-- Card -->
      <div class="card card-sm">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <!-- Media -->
              <div class="media">
                <i class="tio-chart-bar-1 nav-icon"></i>

                <div class="media-body">
                  <h4 class="mb-1">Progress</h4>
                  <span class="font-size-sm text-success">
                    <i class="tio-trending-up"></i> 1.7%
                  </span>
                </div>
              </div>
              <!-- End Media -->
            </div>

            <div class="col-auto">
              <!-- Circle -->
              <div class="js-circle"
                    data-hs-circles-options='{
                      "value": 80,
                      "maxValue": 100,
                      "duration": 2000,
                      "isViewportInit": true,
                      "colors": ["#e7eaf3", "#377dff"],
                      "radius": 25,
                      "width": 3,
                      "fgStrokeLinecap": "round",
                      "textFontSize": 14,
                      "additionalText": "%",
                      "textClass": "circle-custom-text",
                      "textColor": "#377dff"
                    }'></div>
              <!-- End Circle -->
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-6">
      <!-- Card -->
      <div class="card card-sm">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <!-- Media -->
              <div class="media">
                <i class="tio-checkmark-circle-outlined nav-icon"></i>

                <div class="media-body">
                  <h4 class="mb-1">Tasks closed</h4>
                  <span class="d-block">79 <span class="badge badge-soft-dark badge-pill ml-1">+4 today</span></span>
                </div>
              </div>
              <!-- End Media -->
            </div>

            <div class="col-auto">
              <!-- Circle -->
              <div class="js-circle"
                    data-hs-circles-options='{
                      "value": 67,
                      "maxValue": 100,
                      "duration": 2000,
                      "isViewportInit": true,
                      "colors": ["#e7eaf3", "#377dff"],
                      "radius": 25,
                      "width": 3,
                      "fgStrokeLinecap": "round",
                      "textFontSize": 14,
                      "additionalText": "%",
                      "textClass": "circle-custom-text",
                      "textColor": "#377dff"
                    }'></div>
              <!-- End Circle -->
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-6">
      <!-- Card -->
      <div class="card card-sm">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <!-- Media -->
              <div class="media">
                <i class="tio-award-outlined nav-icon"></i>

                <div class="media-body">
                  <h4 class="mb-1">Goals</h4>
                  <span class="d-block">41/100</span>
                </div>
              </div>
              <!-- End Media -->
            </div>

            <div class="col-auto">
              <!-- Circle -->
              <div class="js-circle"
                    data-hs-circles-options='{
                      "value": 41,
                      "maxValue": 100,
                      "duration": 2000,
                      "isViewportInit": true,
                      "colors": ["#e7eaf3", "#377dff"],
                      "radius": 25,
                      "width": 3,
                      "fgStrokeLinecap": "round",
                      "textFontSize": 14,
                      "additionalText": "%",
                      "textClass": "circle-custom-text",
                      "textColor": "#377dff"
                    }'></div>
              <!-- End Circle -->
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>
  </div>
  <!-- End Stats -->

  <!-- Card -->
  <div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
      <h6 class="card-subtitle mb-0">Project budget: <span class="h3 ml-sm-2">$150,000.00 USD</span></h6>

      <!-- Unfold -->
      <div class="hs-unfold">
        <a class="js-hs-unfold-invoker btn btn-white dropdown-toggle" href="javascript:;"
            data-hs-unfold-options='{
              "target": "#usersExportDropdown",
              "type": "css-animation"
            }'>
          <i class="tio-download-to mr-1"></i> Export
        </a>

        <div id="usersExportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
          <span class="dropdown-header">Options</span>
          <a id="export-copy" class="dropdown-item" href="javascript:;">
            <img class="avatar avatar-xss avatar-4by3 mr-2" src="assets/dashboard/svg/illustrations/copy.svg" alt="Image Description">
            Copy
          </a>
          <a id="export-print" class="dropdown-item" href="javascript:;">
            <img class="avatar avatar-xss avatar-4by3 mr-2" src="assets/dashboard/svg/illustrations/print.svg" alt="Image Description">
            Print
          </a>
          <div class="dropdown-divider"></div>
          <span class="dropdown-header">Download options</span>
          <a id="export-excel" class="dropdown-item" href="javascript:;">
            <img class="avatar avatar-xss avatar-4by3 mr-2" src="assets/dashboard/svg/brands/excel.svg" alt="Image Description">
            Excel
          </a>
          <a id="export-csv" class="dropdown-item" href="javascript:;">
            <img class="avatar avatar-xss avatar-4by3 mr-2" src="assets/dashboard/svg/components/placeholder-csv-format.svg" alt="Image Description">
            .CSV
          </a>
          <a id="export-pdf" class="dropdown-item" href="javascript:;">
            <img class="avatar avatar-xss avatar-4by3 mr-2" src="assets/dashboard/svg/brands/pdf.svg" alt="Image Description">
            PDF
          </a>
        </div>
      </div>
      <!-- End Unfold -->
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
      <!-- Bar Chart -->
      <div class="chartjs-custom" style="height: 18rem;">
        <canvas class="js-chart"
                data-hs-chartjs-options='{
                  "type": "line",
                  "data": {
                      "labels": ["Feb","Jan","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                      "datasets": [{
                      "data": [18,51,60,38,88,50,40,52,88,80,60,70],
                      "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                      "borderColor": "#377dff",
                      "borderWidth": 2,
                      "pointRadius": 0,
                      "pointBorderColor": "#fff",
                      "pointBackgroundColor": "#377dff",
                      "pointHoverRadius": 0,
                      "hoverBorderColor": "#fff",
                      "hoverBackgroundColor": "#377dff"
                    },
                    {
                      "data": [27,38,60,77,40,50,49,29,42,27,42,50],
                      "backgroundColor": ["rgba(0, 201, 219, 0)", "rgba(255, 255, 255, 0)"],
                      "borderColor": "#00c9db",
                      "borderWidth": 2,
                      "pointRadius": 0,
                      "pointBorderColor": "#fff",
                      "pointBackgroundColor": "#00c9db",
                      "pointHoverRadius": 0,
                      "hoverBorderColor": "#fff",
                      "hoverBackgroundColor": "#00c9db"
                    }]
                  },
                  "options": {
                    "gradientPosition": {"y1": 200},
                      "scales": {
                        "yAxes": [{
                          "gridLines": {
                            "color": "#e7eaf3",
                            "drawBorder": false,
                            "zeroLineColor": "#e7eaf3"
                          },
                          "ticks": {
                            "min": 0,
                            "max": 100,
                            "stepSize": 20,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 10,
                            "postfix": "k"
                          }
                        }],
                        "xAxes": [{
                          "gridLines": {
                            "display": false,
                            "drawBorder": false
                          },
                          "ticks": {
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 5
                          }
                        }]
                    },
                    "tooltips": {
                      "prefix": "$",
                      "postfix": "k",
                      "hasIndicator": true,
                      "mode": "index",
                      "intersect": false,
                      "lineMode": true,
                      "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                    },
                    "hover": {
                      "mode": "nearest",
                      "intersect": true
                    }
                  }
                }'>
        </canvas>
      </div>
      <!-- End Bar Chart -->
    </div>
    <!-- End Body -->
  </div>
  <!-- End Card -->

  <div class="row">
    <div class="col-lg-5 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header">
          <h4 class="card-header-title">Expenses</h4>

          <!-- Nav -->
          <ul class="nav nav-segment" id="expensesTab" role="tablist">
            <li class="nav-item" data-toggle="chart" data-datasets="0" data-trigger="click" data-action="toggle">
              <a class="nav-link active" href="javascript:;" data-toggle="tab">This week</a>
            </li>
            <li class="nav-item" data-toggle="chart" data-datasets="1" data-trigger="click" data-action="toggle">
              <a class="nav-link" href="javascript:;" data-toggle="tab">Last week</a>
            </li>
          </ul>
          <!-- End Nav -->
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body">
          <!-- Pie Chart -->
          <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
            <canvas id="updatingData"
                    data-hs-chartjs-options='{
                      "type": "doughnut",
                      "data": {
                        "labels": ["USD", "USD", "USD"],
                        "datasets": [{
                          "backgroundColor": ["#377dff", "#00c9db", "#e7eaf3"],
                          "borderWidth": 5,
                          "hoverBorderColor": "#fff"
                        }]
                      },
                      "options": {
                        "cutoutPercentage": 80,
                        "tooltips": {
                          "postfix": "k",
                          "hasIndicator": true,
                          "mode": "index",
                          "intersect": false
                        },
                        "hover": {
                          "mode": "nearest",
                          "intersect": true
                        }
                      }
                    }'></canvas>
          </div>
          <!-- End Pie Chart -->

          <!-- Legend Indicators -->
          <div class="row justify-content-center">
            <div class="col-auto mb-3 mb-sm-0">
              <span class="card-title h4">$2,332.00</span>
              <span class="legend-indicator bg-primary"></span> Marketing
            </div>

            <div class="col-auto mb-3 mb-sm-0">
              <span class="card-title h4">$10,452.00</span>
              <span class="legend-indicator bg-info"></span> Bills
            </div>

            <div class="col-auto">
              <span class="card-title h4">$56,856.00</span>
              <span class="legend-indicator"></span> Others
            </div>
          </div>
          <!-- End Legend Indicators -->
        </div>
        <!-- End Body -->
      </div>
      <!-- End Card -->
    </div>

    <div class="col-lg-7 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <!-- Header -->
        <div class="card-header">
          <h4 class="card-header-title">Events</h4>

          <!-- Nav -->
          <ul class="nav nav-segment" id="eventsTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="this-week-tab" data-toggle="tab" href="#this-week" role="tab">
                This week
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="next-week-tab" data-toggle="tab" href="#next-week" role="tab">
                Next week
              </a>
            </li>
          </ul>
          <!-- End Nav -->
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body card-body-height">
          <!-- Tab Content -->
          <div class="tab-content" id="eventsTabContent">
            <div class="tab-pane fade show active" id="this-week" role="tabpanel" aria-labelledby="this-week-tab">
              <!-- Card -->
              <a class="card card-border-left border-left-primary shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">12:00 - 03:00 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Weekly overview</h5>
                      <small class="text-body">24 May, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img3.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark">
                          <span class="avatar-initials">A</span>
                        </span>
                        <span class="avatar avatar-soft-info">
                          <span class="avatar-initials">S</span>
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->

              <hr>

              <!-- Card -->
              <a class="card card-border-left border-left-info shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">04:30 - 04:50 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Project tasks</h5>
                      <small class="text-body">25 May, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img6.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img7.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-danger">
                          <span class="avatar-initials">A</span>
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->

              <hr>

              <!-- Card -->
              <a class="card card-border-left border-left-danger shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">12:00 - 03:00 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Monthly reports</h5>
                      <small class="text-body">27 May, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark">
                          <span class="avatar-initials">B</span>
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img8.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->

              <hr>

              <!-- Card -->
              <a class="card card-border-left border-left-warning shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">02:00 - 03:00 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Monthly reports to the client</h5>
                      <small class="text-body">29 May, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark">
                          <span class="avatar-initials">B</span>
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img8.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->
            </div>

            <div class="tab-pane fade" id="next-week" role="tabpanel" aria-labelledby="next-week-tab">
              <!-- Card -->
              <a class="card card-border-left border-left-info shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">04:30 - 04:50 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Project tasks</h5>
                      <small class="text-body">30 May, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img6.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img7.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-danger">
                          <span class="avatar-initials">A</span>
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->

              <hr>

              <!-- Card -->
              <a class="card card-border-left border-left-primary shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">12:00 - 03:00 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Weekly overview</h5>
                      <small class="text-body">1 June, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img3.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark">
                          <span class="avatar-initials">A</span>
                        </span>
                        <span class="avatar avatar-soft-info">
                          <span class="avatar-initials">S</span>
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->

              <hr>

              <!-- Card -->
              <a class="card card-border-left border-left-warning shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">02:00 - 03:00 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Monthly reports to the client</h5>
                      <small class="text-body">2 June, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark">
                          <span class="avatar-initials">B</span>
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img8.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->

              <hr>

              <!-- Card -->
              <a class="card card-border-left border-left-danger shadow-none rounded-0" href="#">
                <div class="card-body py-0">
                  <div class="row">
                    <div class="col-sm mb-2 mb-sm-0">
                      <h2 class="font-weight-normal mb-1">12:00 - 03:00 <small class="font-size-sm text-body text-uppercase">pm</small></h2>
                      <h5 class="text-hover-primary mb-0">Monthly reports</h5>
                      <small class="text-body">4 June, 2020</small>
                    </div>

                    <div class="col-sm-auto align-self-sm-end">
                      <!-- Avatar Group -->
                      <div class="avatar-group avatar-group-sm avatar-circle">
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark">
                          <span class="avatar-initials">B</span>
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img8.jpg" alt="Image Description">
                        </span>
                        <span class="avatar">
                          <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                      </div>
                      <!-- End Avatar Group -->
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </a>
              <!-- End Card -->
            </div>
          </div>
          <!-- End Tab Content -->
        </div>
        <!-- End Body -->
      </div>
      <!-- End Card -->
    </div>
  </div>
  <!-- End Row -->

  <!-- Card -->
  <div class="card overflow-hidden">
    <!-- Header -->
    <div class="card-header">
      <h4 class="card-header-title">Hours spent <i class="tio-verified text-primary" data-toggle="tooltip" data-placement="top" title="This report is based on 100% of sessions."></i></h4>

      <!-- Daterangepicker -->
      <button id="js-daterangepicker-predefined" class="btn btn-sm btn-ghost-secondary dropdown-toggle">
        <i class="tio-date-range"></i>
        <span class="js-daterangepicker-predefined-preview ml-1"></span>
      </button>
      <!-- End Daterangepicker -->
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
      <!-- Matrix Chart -->
      <div class="table-responsive">
        <div class="chartjs-matrix-custom mb-3" style="min-width: 100%; width: 700px;">
          <canvas class="js-chart-matrix"
                  data-hs-chartjs-options='{
                "options": {
                  "matrixBackgroundColor": {
                      "color": "#377dff",
                      "accent": 50,
                      "additionToValue": 2
                  },
                  "matrixLegend": {
                    "container": "#matrixLegend"
                  }
                }
              }'></canvas>
        </div>
      </div>
      <!-- End Matrix Chart -->

      <!-- Matrix Legend -->
      <ul id="matrixLegend" class="mb-0"></ul>
    </div>
    <!-- End Body -->

    <hr class="my-0">

    <div class="row">
      <div class="col-lg-4">
        <!-- Body -->
        <div class="card-body card-body-centered bg-light h-100 text-center">
          <img class="avatar avatar-xl avatar-4by3" src="assets/dashboard/svg/illustrations/chat.svg" alt="Image Description">
          <span class="display-3 d-block text-dark">256.4</span>

          <span class="d-block">
            &mdash; Total hours
            <span class="badge badge-soft-dark badge-pill ml-1">+7 today</span>
          </span>
        </div>
        <!-- End Body -->
      </div>

      <div class="col-lg-8">
        <!-- Body -->
        <div class="card-body card-body-height">
          <ul class="list-group list-group-flush list-group-no-gutters">
            <!-- List Item -->
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-12 col-sm mb-3 mb-sm-0">
                  <a class="media align-items-center" href="user-profile.html">
                    <div class="avatar avatar-sm avatar-circle mr-2">
                      <img class="avatar-img" src="assets/dashboard/img/160x160/img10.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 text-hover-primary mb-0">Amanda Harvey</span>
                    </div>
                  </a>
                </div>
                <div class="col">
                  <small class="text-cap">Days</small>
                  <span class="font-weight-bold text-dark">38</span>
                </div>
                <div class="col">
                  <small class="text-cap">Hours</small>
                  <span class="font-weight-bold text-dark">45:12</span>
                </div>
                <div class="col">
                  <small class="text-cap">Tasks</small>
                  <span class="font-weight-bold text-dark">35</span>
                </div>
              </div>
            </li>
            <!-- End List Item -->

            <!-- List Item -->
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-12 col-sm mb-3 mb-sm-0">
                  <a class="media align-items-center" href="user-profile.html">
                    <div class="avatar avatar-sm avatar-soft-info avatar-circle mr-2">
                      <span class="avatar-initials">S</span>
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 text-hover-primary mb-0">Sara Iwens</span>
                    </div>
                  </a>
                </div>
                <div class="col">
                  <small class="text-cap">Days</small>
                  <span class="font-weight-bold text-dark">15</span>
                </div>
                <div class="col">
                  <small class="text-cap">Hours</small>
                  <span class="font-weight-bold text-dark">24:06</span>
                </div>
                <div class="col">
                  <small class="text-cap">Tasks</small>
                  <span class="font-weight-bold text-dark">31</span>
                </div>
              </div>
            </li>
            <!-- End List Item -->

            <!-- List Item -->
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-12 col-sm mb-3 mb-sm-0">
                  <a class="media align-items-center" href="user-profile.html">
                    <div class="avatar avatar-sm avatar-circle mr-2">
                      <img class="avatar-img" src="assets/dashboard/img/160x160/img3.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 text-hover-primary mb-0">David Harrison</span>
                    </div>
                  </a>
                </div>
                <div class="col">
                  <small class="text-cap">Days</small>
                  <span class="font-weight-bold text-dark">22</span>
                </div>
                <div class="col">
                  <small class="text-cap">Hours</small>
                  <span class="font-weight-bold text-dark">67:38</span>
                </div>
                <div class="col">
                  <small class="text-cap">Tasks</small>
                  <span class="font-weight-bold text-dark">76</span>
                </div>
              </div>
            </li>
            <!-- End List Item -->

            <!-- List Item -->
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-12 col-sm mb-3 mb-sm-0">
                  <a class="media align-items-center" href="user-profile.html">
                    <div class="avatar avatar-sm avatar-circle mr-2">
                      <img class="avatar-img" src="assets/dashboard/img/160x160/img9.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 text-hover-primary mb-0">Ella Lauda</span>
                    </div>
                  </a>
                </div>
                <div class="col">
                  <small class="text-cap">Days</small>
                  <span class="font-weight-bold text-dark">35</span>
                </div>
                <div class="col">
                  <small class="text-cap">Hours</small>
                  <span class="font-weight-bold text-dark">53:31</span>
                </div>
                <div class="col">
                  <small class="text-cap">Tasks</small>
                  <span class="font-weight-bold text-dark">42</span>
                </div>
              </div>
            </li>
            <!-- End List Item -->

            <!-- List Item -->
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-12 col-sm mb-3 mb-sm-0">
                  <a class="media align-items-center" href="user-profile.html">
                    <div class="avatar avatar-sm avatar-soft-dark avatar-circle mr-2">
                      <span class="avatar-initials">B</span>
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 text-hover-primary mb-0">Bob Dean</span>
                    </div>
                  </a>
                </div>
                <div class="col">
                  <small class="text-cap">Days</small>
                  <span class="font-weight-bold text-dark">5</span>
                </div>
                <div class="col">
                  <small class="text-cap">Hours</small>
                  <span class="font-weight-bold text-dark">15:38</span>
                </div>
                <div class="col">
                  <small class="text-cap">Tasks</small>
                  <span class="font-weight-bold text-dark">21</span>
                </div>
              </div>
            </li>
            <!-- End List Item -->

            <!-- List Item -->
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-12 col-sm mb-3 mb-sm-0">
                  <a class="media align-items-center" href="user-profile.html">
                    <div class="avatar avatar-sm avatar-circle mr-2">
                      <img class="avatar-img" src="assets/dashboard/img/160x160/img8.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 text-hover-primary mb-0">Linda Bates</span>
                    </div>
                  </a>
                </div>
                <div class="col">
                  <small class="text-cap">Days</small>
                  <span class="font-weight-bold text-dark">14</span>
                </div>
                <div class="col">
                  <small class="text-cap">Hours</small>
                  <span class="font-weight-bold text-dark">16:29</span>
                </div>
                <div class="col">
                  <small class="text-cap">Tasks</small>
                  <span class="font-weight-bold text-dark">9</span>
                </div>
              </div>
            </li>
            <!-- End List Item -->
          </ul>
        </div>
        <!-- End Body -->
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Card -->
@endsection

@section('javascript')
<!-- JS Implementing Plugins -->
<script src="assets/dashboard/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/dashboard/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/dashboard/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/dashboard/vendor/list.js/dist/list.min.js"></script>
<script src="assets/dashboard/vendor/prism/prism.js"></script>
<script src="assets/dashboard/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/dashboard/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->
<script type="text/javascript">
// initEditor("description"); 
$(document).on('ready', function () {
  $("#client_id").change(function(){
    if($(this).val() != ''){
      var text = $("#client_id").find("option:selected").text();
      $("#client_name_text").html(text.trim());
    }else{
      $("#client_name_text").html('');
    }
  });
  $("[name=case_title]").change(function(){
    if($(this).val() != ''){
      $("#case_title_text").html($(this).val());
    }else{
      $("#case_title_text").html('');
    }
  });
  $("[name=start_date]").change(function(){
    if($(this).val() != ''){
      $("#start_date_text").html($(this).val());
    }else{
      $("#start_date_text").html('');
    }
  });
  $("[name=end_date]").change(function(){
    if($(this).val() != ''){
      $("#end_date_text").html($(this).val());
    }else{
      $("#end_date_text").html('');
    }
  });
  $("#visa_service_id").change(function(){
    if($(this).val() != ''){
      var text = $("#visa_service_id").find("option:selected").text();
      $("#visa_service_text").html(text.trim());
    }else{
      $("#visa_service_text").html('');
    }
  });
  $("#assign_teams").change(function(){
    if($("#assign_teams").val() != ''){
      var html = '';
      $("#assign_staff_list").show();
      $(".staff").remove();
      $("#assign_teams").find("option:selected").each(function(){
          var text = $(this).attr('data-name');
          var role = $(this).attr('data-role');

          html +='<li class="text-left staff">';
          html +='<a class="nav-link media" href="javascript:;">';
          html +='<i class="tio-group-senior nav-icon text-dark"></i>';
          html +='<span class="media-body">';
          html +='<span class="d-block text-dark">'+text.trim()+'</span>';
          html +='<small class="d-block text-muted">'+role+'</small>';
          html +='</span></a></li>';
      });
      $("#assign_staff_list ul").append(html);
    }else{
      $("#assign_staff_list").hide();
      $("#assign_staff_list .staff").remove();
    }
  });
  $('#start_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('#end_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });
  $('.js-step-form').each(function () {
     var stepForm = new HSStepForm($(this), {
       validate: function(){
       },
       finish: function() {
        
       }
     }).init();
   });
});
function stateList(country_id,id){
    $.ajax({
        url:"{{ url('states') }}",
        data:{
          country_id:country_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
           $("#city").html('');
        },
        success:function(response){
          if(response.status == true){
            $("#"+id).html(response.options);
          } 
        },
        error:function(){
           
        }
    });
}
function cityList(state_id,id){
    $.ajax({
        url:"{{ url('cities') }}",
        data:{
          state_id:state_id
        },
        dataType:"json",
        beforeSend:function(){
           $("#"+id).html('');
        },
        success:function(response){
          if(response.status == true){
            $("#"+id).html(response.options);
          } 
        },
        error:function(){
           
        }
    });
}
</script>

@endsection