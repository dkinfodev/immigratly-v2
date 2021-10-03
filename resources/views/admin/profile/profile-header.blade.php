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

  <h1 class="page-title">{{ $user->first_name." ".$user->last_name  }} <i class="tio-verified tio-lg text-primary" data-toggle="tooltip" data-placement="top" title="Top endorsed"></i> <a href="{{url(roleFolder().'/edit-profile')}}"><i class="tio-edit tio-lg text-primary" data-toggle="tooltip" data-placement="top" title="Edit Profile"></i></a></h1>

  <!-- List -->
  <ul class="list-inline list-inline-m-1">
    <li class="list-inline-item">
      <i class="tio-city mr-1"></i>
      <span>Htmlstream</span>
    </li>

    <li class="list-inline-item">
      <i class="tio-poi-outlined mr-1"></i>
      <a href="#">San Francisco,</a>
      <a href="#">US</a>
    </li>

    <li class="list-inline-item">
      <i class="tio-date-range mr-1"></i>
      <span>Joined March 2017</span>
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
    <li class="nav-item">
      <a class="nav-link {{ ($active_tab == 'profile_tab')?'active':'' }}" href="{{url(roleFolder().'/profile')}}"> Profile</a>

    </li>
    <li class="nav-item">
      <a class="nav-link {{ ($active_tab == 'article_tab')?'active':'' }}" href="{{url(roleFolder().'/articles')}}">Articles</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ ($active_tab == 'event_tab')?'active':'' }}"" href="{{url(roleFolder().'/events')}}">Events <span class="badge badge-soft-dark rounded-circle ml-1">3</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ ($active_tab == 'service_tab')?'active':'' }}"" href="{{url(roleFolder().'/services')}}">Services</a>
    </li>

    
  </ul>
</div>
<!-- End Nav -->