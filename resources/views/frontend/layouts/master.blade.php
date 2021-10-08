<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Careers | Front - Multipurpose Responsive Template</title>
    <base href="{{ url('/') }}/" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/front/vendor/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/front/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
    
    
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="assets/front/css/theme.min.css">

    <link rel="stylesheet" href="assets/vendor/toastr/toastr.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/front/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
    <link rel="stylesheet" href="assets/front/css/front.css">
    <script>
    var BASEURL = "{{ baseUrl('/') }}";
    var SITEURL = "{{ url('/') }}";
    var csrf_token = "{{ csrf_token() }}";
    </script>
</head>

<body>
    <!-- ========== HEADER ========== -->
    <header id="header" class="navbar navbar-expand-lg navbar-end navbar-absolute-top navbar-light navbar-show-hide"
        data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
          }'>
        <!-- Topbar -->
        <div class="container navbar-topbar">
            <nav class="js-mega-menu navbar-nav-wrap">
                <!-- Toggler -->
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#topbarNavDropdown" aria-controls="topbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="d-flex justify-content-between align-items-center small">
                        <span class="navbar-toggler-text">Topbar</span>

                        <span class="navbar-toggler-default">
                            <i class="bi-chevron-down ms-2"></i>
                        </span>
                        <span class="navbar-toggler-toggled">
                            <i class="bi-chevron-up ms-2"></i>
                        </span>
                    </span>
                </button>
                <!-- End Toggler -->

                <div id="topbarNavDropdown"
                    class="navbar-nav-wrap-collapse collapse navbar-collapse navbar-topbar-collapse">
                    <div class="navbar-toggler-wrapper">
                        <div class="navbar-topbar-toggler d-flex justify-content-between align-items-center">
                            <span class="navbar-toggler-text small">Topbar</span>

                            <!-- Toggler -->
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#topbarNavDropdown" aria-controls="topbarNavDropdown"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <i class="bi-x"></i>
                            </button>
                            <!-- End Toggler -->
                        </div>
                    </div>

                    <ul class="navbar-nav">
                        <!-- Demos -->
                        <li class="hs-has-mega-menu nav-item">
                            <a id="demosMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle active"
                                aria-current="page" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Demos</a>

                            <!-- Mega Menu -->
                            <div class="hs-mega-menu dropdown-menu w-100" aria-labelledby="demosMegaMenu"
                                style="min-width: 40rem;">
                                <!-- Promo -->
                                <div class="navbar-dropdown-menu-promo">
                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link active" href="./index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M15.6 5.59998L20.9 10.9C21.3 11.3 21.3 11.9 20.9 12.3L17.6 15.6L11.6 9.59998L15.6 5.59998ZM2.3 12.3L7.59999 17.6L11.6 13.6L5.59999 7.59998L2.3 10.9C1.9 11.3 1.9 11.9 2.3 12.3Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3"
                                                                d="M17.6 15.6L12.3 20.9C11.9 21.3 11.3 21.3 10.9 20.9L7.59998 17.6L13.6 11.6L17.6 15.6ZM10.9 2.3L5.59998 7.6L9.59998 11.6L15.6 5.6L12.3 2.3C11.9 1.9 11.3 1.9 10.9 2.3Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">Main</span>
                                                    <p class="navbar-dropdown-menu-media-desc">Over 60 corporate,
                                                        agency, portfolio, account and many more pages.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->

                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link "
                                            href="./demo-real-estate/index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.5 3C5.67157 3 5 3.67157 5 4.5V6H3.5C2.67157 6 2 6.67157 2 7.5C2 8.32843 2.67157 9 3.5 9H5V19.5C5 20.3284 5.67157 21 6.5 21C7.32843 21 8 20.3284 8 19.5V9H20.5C21.3284 9 22 8.32843 22 7.5C22 6.67157 21.3284 6 20.5 6H8V4.5C8 3.67157 7.32843 3 6.5 3Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M20.5 11H10V17.5C10 18.3284 10.6716 19 11.5 19H15.5C17.3546 19 19.0277 18.2233 20.2119 16.9775C20.1436 16.9922 20.0727 17 20 17C19.4477 17 19 16.5523 19 16V13C19 12.4477 19.4477 12 20 12C20.5523 12 21 12.4477 21 13V15.9657C21.6334 14.9626 22 13.7741 22 12.5C22 11.6716 21.3284 11 20.5 11Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">Real Estate</span>
                                                    <p class="navbar-dropdown-menu-media-desc">Find the latest homes for
                                                        sale, real estate market data.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->

                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link " href="./demo-jobs/index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                                fill="#035A4B" />
                                                            <path
                                                                d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">Jobs <span
                                                            class="badge bg-success rounded-pill ms-1">Hot</span></span>
                                                    <p class="navbar-dropdown-menu-media-desc">Search millions of jobs
                                                        online to find the next step in your career.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->
                                </div>
                                <!-- End Promo -->

                                <!-- Promo -->
                                <div class="navbar-dropdown-menu-promo">
                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link " href="./demo-course/index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M20 19H4C2.9 19 2 18.1 2 17H22C22 18.1 21.1 19 20 19Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3"
                                                                d="M20 5H4C3.4 5 3 5.4 3 6V17H21V6C21 5.4 20.6 5 20 5Z"
                                                                fill="#035A4B" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M14.9167 6.83334H9.91666C9.18899 6.83334 8.66666 7.37744 8.66666 8.08334V13.9167C8.66666 14.6226 9.18899 15.1667 9.91666 15.1667H14.9167C15.1841 15.1667 15.3333 15.0112 15.3333 14.75V14.3333H10.3333C10.1032 14.3333 9.91665 14.1468 9.91665 13.9167C9.91665 13.6866 10.1032 13.5 10.3333 13.5H15.3333V7.25001C15.3333 6.9888 15.1841 6.83334 14.9167 6.83334Z"
                                                                fill="#035A4B" />
                                                            <mask id="mask0" mask-type="alpha"
                                                                maskUnits="userSpaceOnUse" x="8" y="6" width="8"
                                                                height="10">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M14.9167 6.83334H9.91666C9.18899 6.83334 8.66666 7.37744 8.66666 8.08334V13.9167C8.66666 14.6226 9.18899 15.1667 9.91666 15.1667H14.9167C15.1841 15.1667 15.3333 15.0112 15.3333 14.75V14.3333H10.3333C10.1032 14.3333 9.91665 14.1468 9.91665 13.9167C9.91665 13.6866 10.1032 13.5 10.3333 13.5H15.3333V7.25001C15.3333 6.9888 15.1841 6.83334 14.9167 6.83334Z"
                                                                    fill="white" />
                                                            </mask>
                                                            <g mask="url(#mask0)">
                                                            </g>
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">Course <span
                                                            class="badge bg-success rounded-pill ms-1">Hot</span></span>
                                                    <p class="navbar-dropdown-menu-media-desc">Learn on your schedule.
                                                        An online learning and teaching demo.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->

                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link " href="./demo-shop/index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M20 22H4C3.4 22 3 21.6 3 21V2H21V21C21 21.6 20.6 22 20 22Z"
                                                                fill="#035A4B" />
                                                            <path
                                                                d="M12 14C9.2 14 7 11.8 7 9V5C7 4.4 7.4 4 8 4C8.6 4 9 4.4 9 5V9C9 10.7 10.3 12 12 12C13.7 12 15 10.7 15 9V5C15 4.4 15.4 4 16 4C16.6 4 17 4.4 17 5V9C17 11.8 14.8 14 12 14Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">E-Commerce</span>
                                                    <p class="navbar-dropdown-menu-media-desc">Choose an online store
                                                        &amp; get your business online today!</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->

                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link "
                                            href="./demo-app-marketplace/index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3"
                                                                d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3"
                                                                d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3"
                                                                d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3" d="M14 4H10V10H14V4Z" fill="#035A4B" />
                                                            <path opacity="0.3" d="M17 4H20L22 10H18L17 4Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="#035A4B" />
                                                            <path
                                                                d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">App
                                                        Marketplace</span>
                                                    <p class="navbar-dropdown-menu-media-desc">Find apps and integrates
                                                        seamlessly with popular apps.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->
                                </div>
                                <!-- End Promo -->

                                <!-- Promo -->
                                <div class="navbar-dropdown-menu-promo">
                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link " href="./demo-help-desk/index.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M22.1671 18.1421C22.4827 18.4577 23.0222 18.2331 23.0206 17.7868L23.0039 13.1053V5.52632C23.0039 4.13107 21.8729 3 20.4776 3H8.68815C7.2929 3 6.16183 4.13107 6.16183 5.52632V9H13C14.6568 9 16 10.3431 16 12V15.6316H19.6565L22.1671 18.1421Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M1.98508 18V13C1.98508 11.8954 2.88051 11 3.98508 11H11.9851C13.0896 11 13.9851 11.8954 13.9851 13V18C13.9851 19.1046 13.0896 20 11.9851 20H4.10081L2.85695 21.1905C2.53895 21.4949 2.01123 21.2695 2.01123 20.8293V18.3243C1.99402 18.2187 1.98508 18.1104 1.98508 18ZM5.99999 14.5C5.99999 14.2239 6.22385 14 6.49999 14H11.5C11.7761 14 12 14.2239 12 14.5C12 14.7761 11.7761 15 11.5 15H6.49999C6.22385 15 5.99999 14.7761 5.99999 14.5ZM9.49999 16C9.22385 16 8.99999 16.2239 8.99999 16.5C8.99999 16.7761 9.22385 17 9.49999 17H11.5C11.7761 17 12 16.7761 12 16.5C12 16.2239 11.7761 16 11.5 16H9.49999Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">Help Desk</span>
                                                    <p class="navbar-dropdown-menu-media-desc">A customer service demo
                                                        that helps you balance customer needs.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->

                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                        <!-- Promo Link -->
                                        <a class="navbar-dropdown-menu-promo-link"
                                            href="https://htmlstream.com/contact-us" target="_blank">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <span class="svg-icon svg-icon-sm text-primary">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M12 17C16.4183 17 20 13.4183 20 9C20 4.58172 16.4183 1 12 1C7.58172 1 4 4.58172 4 9C4 13.4183 7.58172 17 12 17Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.53819 9L10.568 19.3624L11.976 18.8149L13.3745 19.3674L17.4703 9H6.53819ZM9.46188 11H14.5298L11.9759 17.4645L9.46188 11Z"
                                                                fill="#035A4B" />
                                                            <path opacity="0.3"
                                                                d="M10 22H14V22C14 23.1046 13.1046 24 12 24V24C10.8954 24 10 23.1046 10 22V22Z"
                                                                fill="#035A4B" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8 17C8 16.4477 8.44772 16 9 16H15C15.5523 16 16 16.4477 16 17C16 17.5523 15.5523 18 15 18C15.5523 18 16 18.4477 16 19C16 19.5523 15.5523 20 15 20C15.5523 20 16 20.4477 16 21C16 21.5523 15.5523 22 15 22H9C8.44772 22 8 21.5523 8 21C8 20.4477 8.44772 20 9 20C8.44772 20 8 19.5523 8 19C8 18.4477 8.44772 18 9 18C8.44772 18 8 17.5523 8 17Z"
                                                                fill="#035A4B" />
                                                        </svg>

                                                    </span>
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <span class="navbar-dropdown-menu-media-title">New demo
                                                        ideas?</span>
                                                    <p class="navbar-dropdown-menu-media-desc">
                                                        Send us your suggestions <i
                                                            class="bi-box-arrow-up-right ms-1"></i>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- End Promo Link -->
                                    </div>
                                    <!-- End Promo Item -->

                                    <!-- Promo Item -->
                                    <div class="navbar-dropdown-menu-promo-item">
                                    </div>
                                    <!-- End Promo Item -->
                                </div>
                                <!-- End Promo -->
                            </div>
                            <!-- End Mega Menu -->
                        </li>
                        <!-- End Demos -->

                        <!-- Docs -->
                        <li class="hs-has-mega-menu nav-item" data-hs-mega-menu-item-options='{
                  "desktop": {
                    "maxWidth": "20rem"
                  }
                }'>
                            <a id="docsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">Docs</a>

                            <!-- Mega Menu -->
                            <div class="hs-mega-menu hs-position-right dropdown-menu" aria-labelledby="docsMegaMenu"
                                style="min-width: 20rem;">
                                <!-- Link -->
                                <a class="navbar-dropdown-menu-media-link" href="./documentation/index.html">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <span class="svg-icon svg-icon-sm text-primary">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M4.85714 1H11.7364C12.0911 1 12.4343 1.12568 12.7051 1.35474L17.4687 5.38394C17.8057 5.66895 18 6.08788 18 6.5292V19.0833C18 20.8739 17.9796 21 16.1429 21H4.85714C3.02045 21 3 20.8739 3 19.0833V2.91667C3 1.12612 3.02045 1 4.85714 1ZM7 13C7 12.4477 7.44772 12 8 12H15C15.5523 12 16 12.4477 16 13C16 13.5523 15.5523 14 15 14H8C7.44772 14 7 13.5523 7 13ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H11C11.5523 18 12 17.5523 12 17C12 16.4477 11.5523 16 11 16H8Z"
                                                        fill="#035A4B" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M6.85714 3H14.7364C15.0911 3 15.4343 3.12568 15.7051 3.35474L20.4687 7.38394C20.8057 7.66895 21 8.08788 21 8.5292V21.0833C21 22.8739 20.9796 23 19.1429 23H6.85714C5.02045 23 5 22.8739 5 21.0833V4.91667C5 3.12612 5.02045 3 6.85714 3ZM7 13C7 12.4477 7.44772 12 8 12H15C15.5523 12 16 12.4477 16 13C16 13.5523 15.5523 14 15 14H8C7.44772 14 7 13.5523 7 13ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H11C11.5523 18 12 17.5523 12 17C12 16.4477 11.5523 16 11 16H8Z"
                                                        fill="#035A4B" />
                                                </svg>

                                            </span>
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <span class="navbar-dropdown-menu-media-title">Documentation <span
                                                    class="badge bg-primary rounded-pill ms-1">v4.0</span></span>
                                            <p class="navbar-dropdown-menu-media-desc">Development guides for building
                                                projects with Space</p>
                                        </div>
                                    </div>
                                </a>
                                <!-- End Link -->

                                <div class="dropdown-divider"></div>

                                <!-- Link -->
                                <a class="navbar-dropdown-menu-media-link" href="./snippets/index.html">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <span class="svg-icon svg-icon-sm text-primary">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M21 2H13C12.4 2 12 2.4 12 3V13C12 13.6 12.4 14 13 14H21C21.6 14 22 13.6 22 13V3C22 2.4 21.6 2 21 2ZM15.7 8L14 10.1V5.80005L15.7 8ZM15.1 4H18.9L17 6.40002L15.1 4ZM17 9.59998L18.9 12H15.1L17 9.59998ZM18.3 8L20 5.90002V10.2L18.3 8ZM9 2H3C2.4 2 2 2.4 2 3V21C2 21.6 2.4 22 3 22H9C9.6 22 10 21.6 10 21V3C10 2.4 9.6 2 9 2ZM4.89999 12L4 14.8V9.09998L4.89999 12ZM4.39999 4H7.60001L6 8.80005L4.39999 4ZM6 15.2L7.60001 20H4.39999L6 15.2ZM7.10001 12L8 9.19995V14.9L7.10001 12Z"
                                                        fill="#035A4B" />
                                                    <path
                                                        d="M21 18H13C12.4 18 12 17.6 12 17C12 16.4 12.4 16 13 16H21C21.6 16 22 16.4 22 17C22 17.6 21.6 18 21 18ZM19 21C19 20.4 18.6 20 18 20H13C12.4 20 12 20.4 12 21C12 21.6 12.4 22 13 22H18C18.6 22 19 21.6 19 21Z"
                                                        fill="#035A4B" />
                                                </svg>

                                            </span>
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <span class="navbar-dropdown-menu-media-title">Snippets</span>
                                            <p class="navbar-dropdown-menu-media-desc">Move quickly with
                                                copy-to-clipboard feature</p>
                                        </div>
                                    </div>
                                </a>
                                <!-- End Link -->
                            </div>
                            <!-- End Mega Menu -->
                        </li>
                        <!-- End Docs -->
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End Topbar -->

        <div class="container">
            <nav class="js-mega-menu navbar-nav-wrap">
                <!-- Default Logo -->
                <a class="navbar-brand" href="./index.html" aria-label="Front">
                    <img class="navbar-brand-logo" src="assets/front/svg/logos/logo.svg" alt="Logo">
                </a>
                <!-- End Default Logo -->

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-default">
                        <i class="bi-list"></i>
                    </span>
                    <span class="navbar-toggler-toggled">
                        <i class="bi-x"></i>
                    </span>
                </button>
                <!-- End Toggler -->

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <div class="navbar-absolute-top-scroller">
                        <ul class="navbar-nav">
                            <!-- Landings -->
                            <li class="hs-has-mega-menu nav-item">
                                <a id="landingsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle "
                                    aria-current="page" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Landings</a>

                                <!-- Mega Menu -->
                                <div class="hs-mega-menu dropdown-menu w-100" aria-labelledby="landingsMegaMenu"
                                    style="min-width: 30rem;">
                                    <div class="row">
                                        <div class="col-lg-6 d-none d-lg-block">
                                            <!-- Banner Image -->
                                            <div class="navbar-dropdown-menu-banner"
                                                style="background-image: url(assets/front/svg/components/shape-3.svg);">
                                                <div class="navbar-dropdown-menu-banner-content">
                                                    <div class="mb-4">
                                                        <span class="h2 d-block">Branding Works</span>
                                                        <p>Experience a level of our quality in both design &amp;
                                                            customization works.</p>
                                                    </div>
                                                    <a class="btn btn-primary btn-transition" href="#">Learn more <i
                                                            class="bi-chevron-right small"></i></a>
                                                </div>
                                            </div>
                                            <!-- End Banner Image -->
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-lg-6">
                                            <div class="navbar-dropdown-menu-inner">
                                                <div class="row">
                                                    <div class="col-sm mb-3 mb-sm-0">
                                                        <span class="dropdown-header">Classic</span>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-corporate.html">Corporate</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-analytics.html">Analytics <span
                                                                class="badge bg-primary rounded-pill ms-1">Hot</span></a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-studio.html">Studio</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-marketing.html">Marketing</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-advertisement.html">Advertisement</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-consulting.html">Consulting</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-portfolio.html">Portfolio</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-software.html">Software</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-classic-business.html">Business</a>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm">
                                                        <div class="mb-3">
                                                            <span class="dropdown-header">App</span>
                                                            <a class="dropdown-item "
                                                                href="./landing-app-ui-kit.html">UI Kit</a>
                                                            <a class="dropdown-item "
                                                                href="./landing-app-saas.html">SaaS</a>
                                                            <a class="dropdown-item "
                                                                href="./landing-app-workflow.html">Workflow</a>
                                                            <a class="dropdown-item "
                                                                href="./landing-app-payment.html">Payment</a>
                                                            <a class="dropdown-item "
                                                                href="./landing-app-tool.html">Tool</a>
                                                        </div>

                                                        <span class="dropdown-header">Onepage</span>
                                                        <a class="dropdown-item "
                                                            href="./landing-onepage-corporate.html">Corporate</a>
                                                        <a class="dropdown-item "
                                                            href="./landing-onepage-saas.html">SaaS <span
                                                                class="badge bg-primary rounded-pill ms-1">Hot</span></a>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Landings -->

                            <!-- Company -->
                            <li class="hs-has-sub-menu nav-item">
                                <a id="companyMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle active"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Company</a>

                                <!-- Mega Menu -->
                                <div class="hs-sub-menu dropdown-menu" aria-labelledby="companyMegaMenu"
                                    style="min-width: 14rem;">
                                    <a class="dropdown-item " href="./page-about.html">About</a>
                                    <a class="dropdown-item " href="./page-services.html">Services</a>
                                    <a class="dropdown-item " href="./page-customer-stories.html">Customer Stories</a>
                                    <a class="dropdown-item " href="./page-customer-story.html">Customer Story</a>
                                    <a class="dropdown-item active" href="./page-careers.html">Careers</a>
                                    <a class="dropdown-item " href="./page-careers-overview.html">Careers Overview</a>
                                    <a class="dropdown-item " href="./page-hire-us.html">Hire Us</a>
                                    <a class="dropdown-item " href="./page-pricing.html">Pricing</a>
                                    <a class="dropdown-item " href="./page-contacts-agency.html">Contacts: Agency</a>
                                    <a class="dropdown-item " href="./page-contacts-startup.html">Contacts: Startup</a>
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Company -->

                            <!-- Account -->
                            <li class="hs-has-sub-menu nav-item">
                                <a id="accountMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>

                                <!-- Mega Menu -->
                                <div class="hs-sub-menu dropdown-menu" aria-labelledby="accountMegaMenu"
                                    style="min-width: 14rem;">
                                    <!-- Authentication -->
                                    <div class="hs-has-sub-menu nav-item">
                                        <a id="authenticationMegaMenu"
                                            class="hs-mega-menu-invoker dropdown-item dropdown-toggle " href="#"
                                            role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">Authentication</a>

                                        <div class="hs-sub-menu dropdown-menu" aria-labelledby="authenticationMegaMenu"
                                            style="min-width: 14rem;">
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#signupModal">Signup Modal</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item " href="./page-login.html">Login</a>
                                            <a class="dropdown-item " href="./page-signup.html">Signup</a>
                                            <a class="dropdown-item " href="./page-reset-password.html">Reset
                                                Password</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item " href="./page-login-simple.html">Login Simple</a>
                                            <a class="dropdown-item " href="./page-signup-simple.html">Signup Simple</a>
                                            <a class="dropdown-item " href="./page-reset-password-simple.html">Reset
                                                Password Simple</a>
                                        </div>
                                    </div>
                                    <!-- End Authentication -->

                                    <a class="dropdown-item " href="./account-overview.html">Personal Info</a>
                                    <a class="dropdown-item " href="./account-security.html">Security</a>
                                    <a class="dropdown-item " href="./account-notifications.html">Notifications</a>
                                    <a class="dropdown-item " href="./account-preferences.html">Preferences</a>
                                    <a class="dropdown-item " href="./account-orders.html">Orders</a>
                                    <a class="dropdown-item " href="./account-wishlist.html">Wishlist</a>
                                    <a class="dropdown-item " href="./account-payments.html">Payments</a>
                                    <a class="dropdown-item " href="./account-address.html">Address</a>
                                    <a class="dropdown-item " href="./account-teams.html">Teams</a>
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Account -->

                            <!-- Pages -->
                            <li class="hs-has-sub-menu nav-item">
                                <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                                <!-- Mega Menu -->
                                <div class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu"
                                    style="min-width: 14rem;">
                                    <a class="dropdown-item " href="./page-faq.html">FAQ</a>
                                    <a class="dropdown-item " href="./page-terms.html">Terms &amp; Conditions</a>
                                    <a class="dropdown-item " href="./page-privacy.html">Privacy &amp; Policy</a>
                                    <a class="dropdown-item " href="./page-coming-soon.html">Coming Soon</a>
                                    <a class="dropdown-item " href="./page-maintenance-mode.html">Maintenance Mode</a>
                                    <a class="dropdown-item " href="./page-status.html">Status</a>
                                    <a class="dropdown-item " href="./page-invoice.html">Invoice</a>
                                    <a class="dropdown-item " href="./page-error-404.html">Error 404</a>
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Pages -->

                            <!-- Blog -->
                            <li class="hs-has-sub-menu nav-item">
                                <a id="blogMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>

                                <!-- Mega Menu -->
                                <div class="hs-sub-menu dropdown-menu" aria-labelledby="blogMegaMenu"
                                    style="min-width: 14rem;">
                                    <a class="dropdown-item " href="./blog-journal.html">Journal</a>
                                    <a class="dropdown-item " href="./blog-metro.html">Metro</a>
                                    <a class="dropdown-item " href="./blog-newsroom.html">Newsroom</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item " href="./blog-article.html">Article</a>
                                    <a class="dropdown-item " href="./blog-author-profile.html">Author Profile</a>
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Blog -->

                            <!-- Portfolio -->
                            <li class="hs-has-sub-menu nav-item">
                                <a id="portfolioMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle "
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Portfolio</a>

                                <!-- Mega Menu -->
                                <div class="hs-sub-menu dropdown-menu" aria-labelledby="portfolioMegaMenu"
                                    style="min-width: 14rem;">
                                    <a class="dropdown-item " href="./portfolio-grid.html">Grid</a>
                                    <a class="dropdown-item " href="./portfolio-product-article.html">Product
                                        Article</a>
                                    <a class="dropdown-item " href="./portfolio-case-studies-branding.html">Case
                                        Studies: Branding</a>
                                    <a class="dropdown-item " href="./portfolio-case-studies-product.html">Case Studies:
                                        Product</a>
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Portfolio -->

                            <!-- Button -->
                            <li class="nav-item">
                                <a class="btn btn-primary btn-transition"
                                    href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/"
                                    target="_blank">Buy now</a>
                            </li>
                            <!-- End Button -->
                        </ul>
                    </div>
                </div>
                <!-- End Collapse -->
            </nav>
        </div>
    </header>

    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <div class="container-fluid content-space-t-3 content-space-t-lg-5 position-relative zi-2">
          @yield('content')
        </div>
    </main>
    <!-- ========== FOOTER ========== -->
    <footer class="bg-dark">
        <div class="container pb-1 pb-lg-5">
            <div class="row content-space-t-2">
                <div class="col-lg-3 mb-7 mb-lg-0">
                    <!-- Logo -->
                    <div class="mb-5">
                        <a class="navbar-brand" href="./index.html" aria-label="Space">
                            <img class="navbar-brand-logo" src="assets/front/svg/logos/logo-white.svg"
                                alt="Image Description">
                        </a>
                    </div>
                    <!-- End Logo -->

                    <!-- List -->
                    <ul class="list-unstyled list-py-1">
                        <li><a class="link-sm link-light" href="#"><i class="bi-geo-alt-fill me-1"></i> 153 Williamson
                                Plaza, Maggieberg</a></li>
                        <li><a class="link-sm link-light" href="tel:1-062-109-9222"><i
                                    class="bi-telephone-inbound-fill me-1"></i> +1 (062) 109-9222</a></li>
                    </ul>
                    <!-- End List -->

                </div>
                <!-- End Col -->

                <div class="col-sm mb-7 mb-sm-0">
                    <h5 class="text-white mb-3">Company</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-0">
                        <li><a class="link-sm link-light" href="#">About</a></li>
                        <li><a class="link-sm link-light" href="#">Careers <span
                                    class="badge bg-warning text-dark rounded-pill ms-1">We're hiring</span></a></li>
                        <li><a class="link-sm link-light" href="#">Blog</a></li>
                        <li><a class="link-sm link-light" href="#">Customers <i
                                    class="bi-box-arrow-up-right small ms-1"></i></a></li>
                        <li><a class="link-sm link-light" href="#">Hire us</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->

                <div class="col-sm mb-7 mb-sm-0">
                    <h5 class="text-white mb-3">Features</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-0">
                        <li><a class="link-sm link-light" href="#">Press <i
                                    class="bi-box-arrow-up-right small ms-1"></i></a></li>
                        <li><a class="link-sm link-light" href="#">Release Notes</a></li>
                        <li><a class="link-sm link-light" href="#">Integrations</a></li>
                        <li><a class="link-sm link-light" href="#">Pricing</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->

                <div class="col-sm">
                    <h5 class="text-white mb-3">Documentation</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-0">
                        <li><a class="link-sm link-light" href="#">Support</a></li>
                        <li><a class="link-sm link-light" href="#">Docs</a></li>
                        <li><a class="link-sm link-light" href="#">Status</a></li>
                        <li><a class="link-sm link-light" href="#">API Reference</a></li>
                        <li><a class="link-sm link-light" href="#">Tech Requirements</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->

                <div class="col-sm">
                    <h5 class="text-white mb-3">Resources</h5>

                    <!-- List -->
                    <ul class="list-unstyled list-py-1 mb-5">
                        <li><a class="link-sm link-light" href="#"><i class="bi-question-circle-fill me-1"></i> Help</a>
                        </li>
                        <li><a class="link-sm link-light" href="#"><i class="bi-person-circle me-1"></i> Your
                                Account</a></li>
                    </ul>
                    <!-- End List -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->

            <div class="border-top border-white-10 my-7"></div>

            <div class="row mb-7">
                <div class="col-sm mb-3 mb-sm-0">
                    <!-- Socials -->
                    <ul class="list-inline list-separator list-separator-light mb-0">
                        <li class="list-inline-item">
                            <a class="link-sm link-light" href="#">Privacy &amp; Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-sm link-light" href="#">Terms</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="link-sm link-light" href="#">Site Map</a>
                        </li>
                    </ul>
                    <!-- End Socials -->
                </div>

                <div class="col-sm-auto">
                    <!-- Socials -->
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-facebook"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-google"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-twitter"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                                <i class="bi-github"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <!-- Button Group -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-soft-light btn-xs dropdown-toggle"
                                    id="footerSelectLanguage" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-dropdown-animation>
                                    <span class="d-flex align-items-center">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/us.svg"
                                            alt="Image description" width="16" />
                                        <span>English (US)</span>
                                    </span>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="footerSelectLanguage">
                                    <a class="dropdown-item d-flex align-items-center active" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/us.svg"
                                            alt="Image description" width="16" />
                                        <span>English (US)</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/de.svg"
                                            alt="Image description" width="16" />
                                        <span>Deutsch</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/es.svg"
                                            alt="Image description" width="16" />
                                        <span>Español</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="assets/front/vendor/flag-icon-css/flags/1x1/cn.svg"
                                            alt="Image description" width="16" />
                                        <span>中文 (繁體)</span>
                                    </a>
                                </div>
                            </div>
                            <!-- End Button Group -->
                        </li>
                    </ul>
                    <!-- End Socials -->
                </div>
            </div>

            <!-- Copyright -->
            <div class="w-md-85 text-lg-center mx-lg-auto">
                <p class="text-white-50 small">&copy; Front. 2021 Htmlstream. All rights reserved.</p>
                <p class="text-white-50 small">When you visit or interact with our sites, services or tools, we or our
                    authorised service providers may use cookies for storing information to help provide you with a
                    better, faster and safer experience and for marketing purposes.</p>
            </div>
            <!-- End Copyright -->
        </div>
    </footer>

    <!-- ========== END FOOTER ========== -->

    <!-- ========== SECONDARY CONTENTS ========== -->
    <!-- Sign Up -->
    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-close">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="modal-body">
                    <!-- Log in -->
                    <div id="signupModalFormLogin" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Log in</h2>
                            <p>Don't have an account yet?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormSignup",
                         "groupName": "idForm"
                       }'>Sign up</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <div class="d-grid gap-2">
                            <a class="btn btn-white btn-lg" href="#">
                                <span class="d-flex justify-content-center align-items-center">
                                    <img class="avatar avatar-xss me-2" src="assets/front/svg/brands/google-icon.svg"
                                        alt="Image Description">
                                    Log in with Google
                                </span>
                            </a>

                            <a class="js-animation-link btn btn-primary btn-lg" href="#" data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormLoginWithEmail",
                       "groupName": "idForm"
                     }'>Log in with Email</a>
                        </div>
                    </div>
                    <!-- End Log in -->

                    <!-- Log in with Modal -->
                    <div id="signupModalFormLoginWithEmail" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Log in</h2>
                            <p>Don't have an account yet?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormSignup",
                         "groupName": "idForm"
                       }'>Sign up</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <form class="js-validate needs-validation" novalidate>
                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label" for="signupModalFormLoginEmail">Your email</label>
                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="signupModalFormLoginEmail" placeholder="email@site.com"
                                    aria-label="email@site.com" required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label" for="signupModalFormLoginPassword">Password</label>

                                    <a class="js-animation-link form-label-link" href="javascript:;"
                                        data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormResetPassword",
                       "groupName": "idForm"
                     }'>Forgot Password?</a>
                                </div>

                                <input type="password" class="form-control form-control-lg" name="password"
                                    id="signupModalFormLoginPassword" placeholder="8+ characters required"
                                    aria-label="8+ characters required" required minlength="8">
                                <span class="invalid-feedback">Please enter a valid password.</span>
                            </div>
                            <!-- End Form -->

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary form-control-lg">Log in</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Log in with Modal -->

                    <!-- Sign up -->
                    <div id="signupModalFormSignup">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Sign up</h2>
                            <p>Already have an account?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>Log in</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <div class="d-grid gap-3">
                            <a class="btn btn-white btn-lg" href="#">
                                <span class="d-flex justify-content-center align-items-center">
                                    <img class="avatar avatar-xss me-2" src="assets/front/svg/brands/google-icon.svg"
                                        alt="Image Description">
                                    Sign up with Google
                                </span>
                            </a>

                            <a class="js-animation-link btn btn-primary btn-lg" href="#" data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormSignupWithEmail",
                       "groupName": "idForm"
                     }'>Sign up with Email</a>

                            <div class="text-center">
                                <p class="small mb-0">By continuing you agree to our <a href="#">Terms and
                                        Conditions</a></p>
                            </div>
                        </div>
                    </div>
                    <!-- End Sign up -->

                    <!-- Sign up with Modal -->
                    <div id="signupModalFormSignupWithEmail" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Sign up</h2>
                            <p>Already have an account?
                                <a class="js-animation-link link" href="javascript:;" role="button"
                                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>Log in</a>
                            </p>
                        </div>
                        <!-- End Heading -->

                        <form class="js-validate need-validate" novalidate>
                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label" for="signupModalFormSignupEmail">Your email</label>
                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="signupModalFormSignupEmail" placeholder="email@site.com"
                                    aria-label="email@site.com" required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-3">
                                <label class="form-label" for="signupModalFormSignupPassword">Password</label>
                                <input type="password" class="form-control form-control-lg" name="password"
                                    id="signupModalFormSignupPassword" placeholder="8+ characters required"
                                    aria-label="8+ characters required" required>
                                <span class="invalid-feedback">Your password is invalid. Please try again.</span>
                            </div>
                            <!-- End Form -->

                            <!-- Form -->
                            <div class="mb-3" data-hs-validation-validate-class>
                                <label class="form-label" for="signupModalFormSignupConfirmPassword">Confirm
                                    password</label>
                                <input type="password" class="form-control form-control-lg" name="confirmPassword"
                                    id="signupModalFormSignupConfirmPassword" placeholder="8+ characters required"
                                    aria-label="8+ characters required" required
                                    data-hs-validation-equal-field="#signupModalFormSignupPassword">
                                <span class="invalid-feedback">Password does not match the confirm password.</span>
                            </div>
                            <!-- End Form -->

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary form-control-lg">Sign up</button>
                            </div>

                            <div class="text-center">
                                <p class="small mb-0">By continuing you agree to our <a href="#">Terms and
                                        Conditions</a></p>
                            </div>
                        </form>
                    </div>
                    <!-- End Sign up with Modal -->

                    <!-- Reset Password -->
                    <div id="signupModalFormResetPassword" style="display: none; opacity: 0;">
                        <!-- Heading -->
                        <div class="text-center mb-7">
                            <h2>Forgot password?</h2>
                            <p>Enter the email address you used when you joined and we'll send you instructions to reset
                                your password.</p>
                        </div>
                        <!-- En dHeading -->

                        <form class="js-validate need-validate" novalidate>
                            <div class="mb-3">
                                <!-- Form -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label" for="signupModalFormResetPasswordEmail" tabindex="0">Your
                                        email</label>

                                    <a class="js-animation-link form-label-link" href="javascript:;"
                                        data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>
                                        <i class="bi-chevron-left small"></i> Back to Log in
                                    </a>
                                </div>

                                <input type="email" class="form-control form-control-lg" name="email"
                                    id="signupModalFormResetPasswordEmail" tabindex="1"
                                    placeholder="Enter your email address" aria-label="Enter your email address"
                                    required>
                                <span class="invalid-feedback">Please enter a valid email address.</span>
                                <!-- End Form -->
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary form-control-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Reset Password -->
                </div>
                <!-- End Body -->

                <!-- Footer -->
                <div class="modal-footer d-block text-center py-sm-5">
                    <small class="text-cap mb-4">Trusted by the world's best teams</small>

                    <div class="w-85 mx-auto">
                        <div class="row justify-content-between">
                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/gitlab-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->

                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/fitbit-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->

                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/flow-xo-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->

                            <div class="col">
                                <img class="img-fluid" src="assets/front/svg/brands/layar-gray.svg" alt="Logo">
                            </div>
                            <!-- End Col -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </div>

    <!-- Go To -->
    <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;" data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'>
        <i class="bi-chevron-up"></i>
    </a>
    <!-- ========== END SECONDARY CONTENTS ========== -->
    
    <!-- JS Global Compulsory  -->
    <script src="assets/front/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JS Implementing Plugins -->
    <script src="assets/front/vendor/hs-header/dist/hs-header.min.js"></script>
    <script src="assets/front/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
    <script src="assets/front/vendor/hs-show-animation/dist/hs-show-animation.min.js"></script>
    <script src="assets/front/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
    <script src="assets/front/vendor/hs-video-player/dist/hs-video-player.min.js"></script>
    <!-- JS Implementing Plugins -->
    
    <script src="assets/vendor/jquery/dist/jquery.min.js"></script>

    <script src="assets/vendor/toastr/toastr.min.js"></script>
    <script src="assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/front/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
    <!-- JS Front -->
    <script src="assets/front/js/theme.min.js"></script>
    <script src="assets/js/theme-custom.js"></script>

    <script>
      // (function() {
      //   // INITIALIZATION OF HEADER
      //   // =======================================================
      //   new HSHeader('#header').init()


      //   // INITIALIZATION OF MEGA MENU
      //   // =======================================================
      //   new HSMegaMenu('.js-mega-menu', {
      //       desktop: {
      //         position: 'left'
      //       }
      //     })


      //   // INITIALIZATION OF SHOW ANIMATIONS
      //   // =======================================================
      //   new HSShowAnimation('.js-animation-link')

      //   // INITIALIZATION OF BOOTSTRAP DROPDOWN
      //   // =======================================================
      //   HSBsDropdown.init()


      //   // INITIALIZATION OF GO TO
      //   // =======================================================
      //   new HSGoTo('.js-go-to')

      // })()
    </script>

    @yield("javascript")
</body>

</html>