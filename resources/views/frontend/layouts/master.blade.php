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
    <link rel="stylesheet" href="assets/css/theme.min.css">

    <link rel="stylesheet" href="assets/vendor/toastr/toastr.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/sweetalert2/sweetalert2.min.css">
    <!-- <link rel="stylesheet" href="assets/front/vendor/tom-select/dist/css/tom-select.bootstrap5.css"> -->
    <link rel="stylesheet" href="assets/front/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/icon-set/style.css">
    <link rel="stylesheet" href="assets/front/css/front.css">
    <link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />

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
                        <li>
                            <a class="nav-link" href="{{ url('/signup/user') }}">User Signup</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/signup/professional') }}">Professional Signup</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ url('/quick-eligibility') }}" class="nav-link text-primary">Click for Quick Eligibility</a>
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
                <a class="navbar-brand" href="{{ url('/') }}" aria-label="Front">
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
        <div class="container-fluid position-relative zi-2">
            <div class="container">
                @yield('content')
             </div>
        </div>
    </main>
    <!-- ========== FOOTER ========== -->
    <footer class="bg-dark">
        <div class="container pb-1 pb-lg-5">
            <div class="row content-space-t-2">
                <div class="col-lg-3 mb-7 mb-lg-0">
                    <!-- Logo -->
                    <div class="mb-5">
                        <a class="navbar-brand" href="{{ url('/') }}" aria-label="Space">
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
    
  <script>
    $(document).on('ready', function () {

      initSelect();

      // INITIALIZATION OF UNFOLD
      // =======================================================
      // $('.js-hs-action').each(function () {
      //   var unfold = new HSUnfold($(this)).init();
      // });
      // $(".js-hs-unfold-invoker").click(function(){
      //     $(this).next(".hs-unfold-content").fadeToggle();
      // });
      
      $('[data-toggle="tooltip"]').tooltip();
      $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
      // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
      // =======================================================
      var sidebar = $('.js-navbar-vertical-aside').hsSideNav();

              // INITIALIZATION OF FILE ATTACH
        // =======================================================


        
        // INITIALIZATION OF SELECT2
        // =======================================================
        // $('.js-select2-custom').each(function () {
        //   var select2 = $.HSCore.components.HSSelect2.init($(this));
        // });


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

    @yield("javascript")
</body>

</html>