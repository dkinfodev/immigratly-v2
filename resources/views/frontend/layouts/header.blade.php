
  <!-- ========== HEADER ========== -->
  <header id="header" class="header center-aligned-navbar header-bg-transparent header-white-nav-links-lg header-abs-top"
          data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
          }'>
    <div class="header-section">
      <div id="logoAndNav" class="container">
        <!-- Nav -->
        <nav class="js-mega-menu navbar navbar-expand-lg">
          <!-- Logo -->
          <a class="navbar-brand" href="{{ url('/') }}" aria-label="Front">
            <img src="./assets/svg/logos/logo-white.svg" alt="Logo">
          </a>
          <!-- End Logo -->
          @if(Auth::check())
          <!-- Secondary Content -->
          <div class="navbar-nav-wrap-content text-center mr-3">
            <div class="d-none d-lg-block">
              <a class="btn btn-sm btn-light transition-3d-hover" href="{{ baseUrl('/') }}" target="_blank">Go To Dashboard</a>
            </div>
          </div> 
          <div class="navbar-nav-wrap-content text-center mr-3">
            <div class="d-none d-lg-block">
              <a class="btn btn-sm btn-dark transition-3d-hover" href="{{ url('/logout') }}" target="_blank"><i class="tio-sign-out"></i> Logout</a>
            </div>
          </div> 
          @else
          <!-- Secondary Content -->
          <div class="navbar-nav-wrap-content text-center mr-3">
            <div class="d-none d-lg-block">
              <a class="btn btn-sm btn-light transition-3d-hover" href="{{url('login')}}" target="_blank">Login </a>
            </div>
          </div> 
          <!-- End Secondary Content -->
          <!-- Secondary Content -->
          <div class="navbar-nav-wrap-content text-center">
            <div class="d-none d-lg-block">
              <a class="btn btn-sm btn-light transition-3d-hover" href="{{url('signup/user')}}" target="_blank"> Signup</a>
            </div>
          </div>
          <!-- End Secondary Content -->
          @endif
          <!-- Responsive Toggle Button -->
          <button type="button" class="navbar-toggler btn btn-icon btn-sm rounded-circle"
                  aria-label="Toggle navigation"
                  aria-expanded="false"
                  aria-controls="navBar"
                  data-toggle="collapse"
                  data-target="#navBar">
            <span class="navbar-toggler-default">
              <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
              </svg>
            </span>
            <span class="navbar-toggler-toggled">
              <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
              </svg>
            </span>
          </button>
          <!-- End Responsive Toggle Button -->

          <!-- Navigation -->
          <div id="navBar" class="collapse navbar-collapse navbar-nav-wrap-collapse">
            <div class="navbar-body header-abs-top-inner">
              <ul class="navbar-nav">
                
                <!-- <li class="p-2 navbar-nav-item">
                  <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li> -->
                <li class="p-2 navbar-nav-item">
                  <a class="nav-link" href="{{ url('/professionals') }}">Professionals</a>
                </li>

                <li class="p-2 navbar-nav-item">
                  <a class="nav-link" href="{{ url('/webinars') }}">Webinars</a>
                </li>


                <li class="p-2 navbar-nav-item">
                  <a class="nav-link" href="{{ url('/articles') }}">Articles</a>
                </li>
                <!-- Pages -->
                <li class="hs-has-sub-menu navbar-nav-item">
                  <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle " href="javascript:;" aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu">Visa Services</a>

                  <!-- Pages - Submenu -->
                  <div id="pagesSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu" style="min-width: 230px;">
                    <!-- Account -->
                  
                    @foreach($visa_services as $key => $service)
                    <div class="{{count($service->SubServices) > 0?'hs-has-sub-menu':''}}">
                    
                      <a id="navLinkPages-{{$key}}" class="hs-mega-menu-invoker dropdown-item {{count($service->SubServices) > 0?'dropdown-item-toggle':''}}" href="{{url('visa-services/'.$service->slug)}}" aria-haspopup="true" aria-expanded="false" aria-controls="navSubmenuPagesAccount-{{$key}}">{{$service->name}}</a>
                      
                      <div id="navSubmenuPagesAccount-{{$key}}" class="hs-sub-menu dropdown-menu" aria-labelledby="navLinkPages-{{$key}}" style="min-width: 230px; display:{{ (count($service->SubServices) <= 0)?'none':'block' }}">
                        @foreach($service->SubServices as $subservice)
                        <!-- <a class="dropdown-item " href="{{ url('visa-services/'.$subservice->slug) }}">{{$subservice->name}}</a> -->
                        <a class="dropdown-item " href="javascript:;">{{$subservice->name}}</a>
                        @endforeach
                      </div>
                      
                      
                    </div>
                    <!-- Account -->
                    @endforeach
                    
                    <!-- Specialty -->
                  </div>
                  <!-- End Pages - Submenu -->
                </li>
                

                <!-- <li class="p-2 navbar-nav-item">
                  <a class="nav-link" href="#">Contact Us</a>
                </li> -->
           
                <li class="p-2 navbar-nav-item">
                  <a class="nav-link" href="{{ url('/discussions') }}">Discussion</a>
                </li>
                    
              </ul>
            </div>
          </div>
          <!-- End Navigation -->
        </nav>
        <!-- End Nav -->
      </div>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->