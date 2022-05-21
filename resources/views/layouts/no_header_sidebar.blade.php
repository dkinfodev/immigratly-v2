<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{ url('/') }}/assets/vendor/php-form-builder/drag-n-drop-form-builder/" />
    <!-- Title -->
    <title>{{ companyName() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://www.phpformbuilder.pro/documentation/assets/stylesheets/drag-and-drop.min.css">
    <link rel="stylesheet" href="assets/css/icomoon.min.css">
    <link rel="stylesheet" href="https://www.phpformbuilder.pro/documentation/assets/stylesheets/bootstrap.min.css">
    @yield('style')

    <script>
    var BASEURL = "{{ baseUrl('/') }}";
    var SITEURL = "{{ url('/') }}";
    var csrf_token = "{{ csrf_token() }}";
    </script>
  </head>
  <body>

    @yield("content")
<?php echo $form_preview ?>
    @yield("javascript")
  </body>
</html>