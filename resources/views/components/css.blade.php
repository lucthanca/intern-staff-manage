@routes
<!-- Favicon -->
<link href="{{ asset('./assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<!-- Icons -->
<link href="{{ asset('./assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
<link href="{{ asset('./assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<!-- Argon CSS -->
<link type="text/css" href="{{ asset('./assets/css/argon.css?v=1.0.0') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('./assets/css/argon.min.css?v=1.0.0') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('./assets/plugins/animate.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('/css/ltc.css') }}">
@yield('css')