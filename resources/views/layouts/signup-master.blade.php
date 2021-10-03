<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="{{ url('/') }}/" />
    <!-- Title -->
    <title>Immigratly</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/vendor/icon-set/style.css">
    <link rel="stylesheet" href="assets/vendor/select2/dist/css/select2.min.css">

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="assets/css/theme.min.css">
    <link rel="stylesheet" href="assets/vendor/toastr/toastr.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    @yield('style')
  </head>

  <body class="d-flex align-items-center min-h-100">

    @yield("content")

    <!-- JS Global Compulsory  -->
    <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
    <script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/vendor/toastr/toastr.min.js"></script>
    <!-- JS Front -->
    <script src="assets/js/theme.min.js"></script>
    <script src="assets/js/theme-custom.js"></script>
    <div class="loader">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
      <h4 class="text-danger">Loading...</h4>
    </div>
    <!-- JS Plugins Init. -->
    <script>
      $(document).on('ready', function () {
        // initialization of Show Password
        $('.js-toggle-password').each(function () {
          new HSTogglePassword(this).init()
        });

        // initialization of form validation
        $('.js-validate').each(function() {
          // $.HSCore.components.HSValidation.init($(this), {
          //   rules: {
          //     confirmPassword: {
          //       equalTo: '#signupSrPassword'
          //     }
          //   }
          // });
        });

        // initialization of select2
        $('.js-select2-custom').each(function () {
          var select2 = $.HSCore.components.HSSelect2.init($(this));
        });
      });
    </script>


    @yield('javascript')
  </body>
</html>