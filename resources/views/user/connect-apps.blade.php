@extends('layouts.master')

@section('pageheader')
<!-- Content -->
<div class="">
    <div class="content container" style="height: 25rem;">
        <!-- Page Header -->
        <div class="page-header page-header-light page-header-reset">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">Connect Apps</h1>
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

  <div class="row gx-2 gx-lg-3">
    <div class="col-md-4">
        <!-- Card -->
        <div class="card h-100" style="max-width: 20rem;">

          <!-- Body -->
          <div class="card-body text-center">
          @if($user_detail->google_drive_auth != '')
            <div class="hs-unfold float-right">
              <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                 data-hs-unfold-options='{
                   "target": "#action-1",
                   "type": "css-animation"
                 }'>
                      <i class="tio-settings ml-1"></i>
              </a>
              <div id="action-1" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{baseUrl('/connect-apps/unlink/google')}}">
                 <i class="tio-adjust dropdown-item-icon"></i>
                 Unlink Account
                </a>
                <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('connect-apps/google-setting') ?>')">
                 <i class="tio-pages-outlined dropdown-item-icon"></i>
                 Backup Settings
                </a>
              </div>
            </div>
          @endif
          <div class="clearfix"></div>
            <div class="app-icon">
              <i class="tio-google-drive"></i>
            </div>
            <h3 class="mb-1">
              <span class="text-dark">Google Drive</span>
            </h3>
            @if($user_detail->google_drive_auth != '')
              <?php
                $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
                if(isset($google_drive_auth['user_email'])){
              ?>
            <div class="mb-3">
              <i class="tio-online mr-1"></i>
              <span>{{$google_drive_auth['user_email']}}</span>
            </div>
              <?php } ?>
            @endif
          </div>
          <!-- End Body -->

          <!-- Footer -->
          <div class="card-footer">
            @if($user_detail->google_drive_auth != '')
            <div class="row justify-content-between align-items-center text-center">
              <div class="col-12 py-1">
                <a href="javascript:;" type="button" class="btn btn-primary"><i class="tio-done mr-1"></i> Connected</a>
              </div>
            </div>
            @else
            <div class="row justify-content-between align-items-center">
              <div class="col-md-12 text-center">
                <a href="{{ baseUrl('/connect-apps/google-auth') }}" type="button" class="btn btn-outline-primary"><i class="tio-user-add mr-1"></i> Connect</a>
              </div>
            </div>
            @endif
          </div>
          <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
    <div class="col-md-4">
        <!-- Card -->
        <div class="card h-100" style="max-width: 20rem;">

          <!-- Body -->
          
          <div class="card-body text-center">
          @if($user_detail->dropbox_auth != '')
            <div class="hs-unfold float-right">
              <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                 data-hs-unfold-options='{
                   "target": "#action-2",
                   "type": "css-animation"
                 }'>
                      <i class="tio-settings ml-1"></i>
              </a>
              <div id="action-2" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{baseUrl('/connect-apps/unlink/dropbox')}}">
                 <i class="tio-adjust dropdown-item-icon"></i>
                 Unlink Account
                </a>
                <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('connect-apps/dropbox-setting') ?>')">
                 <i class="tio-pages-outlined dropdown-item-icon"></i>
                 Backup Settings
                </a>
              </div>
            </div>
          @endif
            <div class="clearfix"></div>
            <div class="app-icon">
              <i class="tio-dropbox"></i>
            </div>
            <h3 class="mb-1">
              <span class="text-dark">Dropbox</span>
            </h3>
            @if($user_detail->dropbox_auth != '')
              <?php
                $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
                if(isset($dropbox_auth['user_email'])){
              ?>
            <div class="mb-3">
              <i class="tio-online mr-1"></i>
              <span>{{$dropbox_auth['user_email']}}</span>
            </div>
              <?php } ?>
            @endif
          </div>
          <!-- End Body -->

          <!-- Footer -->
          <div class="card-footer">
            @if($user_detail->dropbox_auth != '')
            <div class="row justify-content-between align-items-center text-center">
             

              <div class="col-12 py-1">
                <a href="javascript:;" type="button" class="btn btn-primary"><i class="tio-done mr-1"></i> Connected</a>
              </div>
            </div>
            @else
            <div class="row justify-content-between align-items-center">
              <div class="col-md-12 text-center">
                <a href="{{ baseUrl('/connect-apps/dropbox-auth') }}" type="button" class="btn btn-outline-primary"><i class="tio-user-add mr-1"></i> Connect</a>
              </div>
            </div>
            @endif
          </div>
          <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
  $(document).on('ready', function () {
    
    $('.js-hs-action').each(function () {
      var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
  });
</script>
@endsection