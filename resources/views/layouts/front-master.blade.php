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
  <link rel="shortcut icon" href="assets/img/favicon.ico">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<!-- CSS Implementing Plugins -->
<link rel="stylesheet" href="assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/vendor/icon-set/style.css">
<link rel="stylesheet" href="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
<link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="assets/vendor/@yaireo/tagify/dist/tagify.css">
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
<link rel="stylesheet" href="assets/vendor/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
<!-- CSS Front Template -->
<link rel="stylesheet" href="assets/css/theme.min.css">
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



<body>
<div class="loader">
<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
    <span class="sr-only"></span>
</div>
<h4 class="text-danger">Loading...</h4>
</div>

  <!-- ========== HEADER ========== -->
  <!-- @include(roleFolder().'.layouts.header')   -->
  <!-- ========== END HEADER ========== -->


  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main" class="bg-light mt-lg-n3">

    <!-- Content -->
    <div class="container content-space-1 content-space-t-lg-0 content-space-b-lg-2   imm-dashboard-content">
      <div class="row">


        <div class="col-lg-12">
            @yield("content")
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
    <!-- End Content -->
  </main>
  <!-- ========== END MAIN CONTENT ========== -->
  <div class="modal fade imm-addeducation-modal" id="popupModal" tabindex="-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  </div>
  <!-- ========== FOOTER ========== -->
  <footer class="bg-dark">
    <div class="container pb-1 pb-lg-5">
      <div class="row content-space-t-2">
        <div class="col-lg-3 mb-7 mb-lg-0">
          <!-- Logo -->
          <div class="mb-5">
            <a class="navbar-brand" href="index.html" aria-label="Space">
              <img class="navbar-brand-logo" src="assets/svg/logos/logo-white.svg" alt="Image Description">
            </a>
          </div>
          <!-- End Logo -->

          <!-- List -->
          <ul class="list-unstyled list-py-1">
            <li><a class="link-sm link-light" href="#"><i class="bi-geo-alt-fill me-1"></i> 153 Williamson Plaza,
                Maggieberg</a></li>
            <li><a class="link-sm link-light" href="tel:1-062-109-9222"><i class="bi-telephone-inbound-fill me-1"></i>
                +1 (062) 109-9222</a></li>
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
            <li><a class="link-sm link-light" href="#">Customers <i class="bi-box-arrow-up-right small ms-1"></i></a>
            </li>
            <li><a class="link-sm link-light" href="#">Hire us</a></li>
          </ul>
          <!-- End List -->
        </div>
        <!-- End Col -->

        <div class="col-sm mb-7 mb-sm-0">
          <h5 class="text-white mb-3">Features</h5>

          <!-- List -->
          <ul class="list-unstyled list-py-1 mb-0">
            <li><a class="link-sm link-light" href="#">Press <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
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
            <li><a class="link-sm link-light" href="#"><i class="bi-question-circle-fill me-1"></i> Help</a></li>
            <li><a class="link-sm link-light" href="#"><i class="bi-person-circle me-1"></i> Your Account</a></li>
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
                <button type="button" class="btn btn-soft-light btn-xs dropdown-toggle" id="footerSelectLanguage"
                  data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                  <span class="d-flex align-items-center">
                    <img class="avatar avatar-xss avatar-circle me-2"
                      src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Image description" width="16" />
                    <span>English (US)</span>
                  </span>
                </button>

                <div class="dropdown-menu" aria-labelledby="footerSelectLanguage">
                  <a class="dropdown-item d-flex align-items-center active" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2"
                      src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Image description" width="16" />
                    <span>English (US)</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2"
                      src="assets/vendor/flag-icon-css/flags/1x1/de.svg" alt="Image description" width="16" />
                    <span>Deutsch</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2"
                      src="assets/vendor/flag-icon-css/flags/1x1/es.svg" alt="Image description" width="16" />
                    <span>Español</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2"
                      src="assets/vendor/flag-icon-css/flags/1x1/cn.svg" alt="Image description" width="16" />
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
          authorised service providers may use cookies for storing information to help provide you with a better, faster
          and safer experience and for marketing purposes.</p>
      </div>
      <!-- End Copyright -->
    </div>
  </footer>

  <!-- ========== END FOOTER ========== -->

  <!-- ========== SECONDARY CONTENTS ========== -->


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

  <!-- IE Support -->
  <script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="assets/vendor/babel-polyfill/polyfill.min.js"><\/script>');
  </script>
  @yield('javascript')
</body>

</html>