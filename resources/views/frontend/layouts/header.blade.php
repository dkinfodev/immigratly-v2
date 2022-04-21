
<header id="header" class="navbar navbar-expand-lg navbar-end navbar-light ">
    <div class="navbar-top  w-100">
      <div class="container">
        <nav class="js-mega-menu navbar-nav-wrap">
          <!-- Default Logo -->
          <a class="navbar-brand" href="{{url('/')}}" aria-label="Front">
            <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
          </a>
          <!-- End Default Logo -->

          <!-- Toggler -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
            <ul class="navbar-nav">
              
              
              @if(Auth::check())
              <li class="nav-item">
               <a class="btn text-primary" href="{{ baseUrl('/') }}">Dashboard</a>
              </li>
              <li class="nav-item">
               <a class="btn text-primary" href="{{ url('/logout') }}">Logout</a>
              </li>
              @else
                @if(\Session::get("login_to") == 'admin_panel')
              <!-- Button -->
              <li class="nav-item">
               <a class="btn text-primary" href="{{ url('/signup/user') }}">User Signup</a>
              </li>

              <li class="nav-item">
                <a class="btn text-primary" href="{{ url('/signup/professional') }}">Professional Signup</a>
              </li>

              <li class="nav-item">
                <a class="btn btn-primary btn-transition" href="{{ url('/login') }}">Login</a>
              </li>
                @endif
              @endif
              @if(\Session::get("login_to") == 'admin_panel')
              <li class="nav-item">
                <a class="btn btn-dark" href="{{ url('/quick-eligibility') }}" target="_blank">Click for Quick Eligibility</a>
              </li>
              @endif

              
              
              <!-- End Button -->
            </ul>
          </div>
          <!-- End Collapse -->
        </nav>
      </div>
    </div>
    <!-- Bottombar -->
    <div class="navbar-bottom  w-100">
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

          <div id="topbarNavDropdown" class="navbar-nav-wrap-collapse collapse navbar-collapse navbar-topbar-collapse">
            <div class="navbar-toggler-wrapper">
              <div class="navbar-topbar-toggler d-flex justify-content-between align-items-center">
                <span class="navbar-toggler-text small">Topbar</span>

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#topbarNavDropdown" aria-controls="topbarNavDropdown" aria-expanded="false"
                  aria-label="Toggle navigation">
                  <i class="bi-x"></i>
                </button>
                <!-- End Toggler -->
              </div>
            </div>

            <ul class="navbar-nav" style="z-index: 999;">

              <li class="nav-item">
                 <a class="nav-link" href="{{url('/')}}" role="button">Home</a>
              </li>

              <li class="nav-item">
                 <a class="nav-link" href="{{url('/articles')}}" role="button">Articles</a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="{{url('/webinars')}}" role="button">Webinars</a>
              </li>


              <li class="nav-item">
                <a class="nav-link" href="{{url('/professionals')}}" role="button">Professionals</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{url('/discussions')}}">Discussions</a>
              </li>

            </ul>
          </div>
        </nav>
      </div>
    </div>
    <!-- End Topbar -->

</header>

    <!-- Content -->
    <section class="wrapper angled lower-start imm-dashboard-header" style="background:#e7eaf3">
      <div class="hero-shape position-absolute">
        <img src="assets/img/hero-shape-svg.svg" alt="">
      </div>
      <div class="content-top container">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
          <div class="row align-items-center">
            <div class="col">
              <div class="post-category ">
                <!-- <span href="#" class="text-reset text-user-title-type" rel="category"
                  style="color: #343f52 !important;/* background: #343f52; */padding: 0;font-size: 12px;display: inline-block;margin-bottom: 0.2rem;border-radius: 1rem;/* border: 1px solid rgba(164, 174, 198, 0.2); */">
                  </span> -->
              </div>
              <h1 class="page-header-title">
              
              @if($pageTitle != "Home Page")
              {!!$pageTitle!!}
              @endif
              
              </h1><!-- Breadcrumb -->
              <nav aria-label="breadcrumb">
                @yield("breadcrumb")
              </nav>
              <!-- End Breadcrumb -->
            </div>

            <div class="col-auto">
               @yield("header-right")
            </div>
          </div>
          <!-- End Row -->
        </div>
        <!-- End Page Header -->
      </div>
    </section>
  <!-- End Content -->


