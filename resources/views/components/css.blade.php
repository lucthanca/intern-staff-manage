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
<!-- define fa5 -->
<style>
    @font-face {
        font-family: FontAwesome5;
        src: url(./assets/vendor/@fortawesome/fontawesome-free/webfonts/fa-regular-400.ttf) format('ttf'),
            url(./assets/vendor/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2) format('woff2'),
            url(./assets/vendor/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff) format('woff');
    }
</style>
@yield('css')