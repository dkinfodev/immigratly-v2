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
<div class="connect-apps">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Connect Apps</h1>
      </div>
    </div>
  </div>
  <!-- End Page Header -->
  <div class="row gx-2 gx-lg-3">
    <div class="col-md-4">
        <!-- Card -->
        <div class="card h-100" style="max-width: 20rem;">
          <!-- Unfold -->
          <div class="card-pinned">
            <div class="hs-unfold">
              <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                 data-hs-unfold-options='{
                   "target": "#profileDropdownEg",
                   "type": "css-animation"
                 }'>
                <i class="tio-more-vertical"></i>
              </a>

              <div id="profileDropdownEg" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <a class="dropdown-item" href="#">Share connection</a>
                <a class="dropdown-item" href="#">Block connection</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#">Delete</a>
              </div>
            </div>
          </div>
          <!-- End Unfold -->

          <!-- Body -->
          <div class="card-body text-center">
            <!-- Avatar -->
            <div class="mt-3 avatar-centered mb-3">
              <img class="img-fluid" src="assets/img/googlelogo.png" alt="Image Description">
              <span class="avatar-status avatar-sm-status avatar-status-danger"></span>
            </div>
            <!-- End Avatar -->

            <h3 class="mb-1">
              <span class="text-dark">Google Drive</span>
            </h3>
          </div>
          <!-- End Body -->

          <!-- Footer -->
          <div class="card-footer">
            <div class="row justify-content-between align-items-center">
          
              <div class="col-md-12 text-center">
                <a href="{{ baseUrl('/google-auth') }}" type="button" class="btn btn-outline-primary"><i class="tio-google-drive"></i> Connect</a>
              </div>
            </div>
          </div>
          <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
  </div>
</div>
@endsection
