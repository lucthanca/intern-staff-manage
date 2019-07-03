<head>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -ms-overflow-style: scrollbar;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        @-ms-viewport {
            width: device-width;
        }

        .bg-default {
            font-family: Open Sans, sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            margin: 0;
            text-align: left;
            color: #525f7f;
            background-color: #f8f9fe;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        a {
            text-decoration: none;

            color: #5e72e4;
            background-color: transparent;

            -webkit-text-decoration-skip: objects;
        }

        a:hover {
            text-decoration: none;

            color: #233dd2;
        }

        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }

        .row {
            display: flex;
            margin-right: -15px;
            margin-left: -15px;
            flex-wrap: wrap;
        }

        .col-md-6,
        .col-lg-5,
        .col-lg-auto,
        .col-xl-6,
        .col-xl-auto {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 992px) {
            .col-lg-5 {
                max-width: 41.66667%;
                flex: 0 0 41.66667%;
            }
        }

        .navbar {
            position: relative;
            display: flex;
            padding: 1rem 1rem;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .navbar>.container,
        .navbar>.container-fluid {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            font-size: 1.25rem;
            line-height: inherit;
            display: inline-block;
            margin-right: 1rem;
            padding-top: .0625rem;
            padding-bottom: .0625rem;

            white-space: nowrap;
        }

        .bg-default {
            background-color: #172b4d !important;
        }

        .d-flex {
            display: flex !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        @media (min-width: 1200px) {
            .justify-content-xl-center {
                justify-content: center !important;
            }
        }

        .mr-2,
        .mx-2 {
            margin-right: .5rem !important;
        }

        .pt-0,
        .py-0 {
            padding-top: 0 !important;
        }

        .pt-5,
        .py-5 {
            padding-top: 3rem !important;
        }

        .pb-5,
        .py-5 {
            padding-bottom: 3rem !important;
        }

        .pt-7,
        .py-7 {
            padding-top: 6rem !important;
        }

        .pb-7,
        .py-7 {
            padding-bottom: 6rem !important;
        }

        @media (min-width: 768px) {

            .pt-lg-8,
            .py-lg-8 {
                padding-top: 8rem !important;
            }

            .pb-lg-8,
            .py-lg-8 {
                padding-bottom: 8rem !important;
            }
        }

        .text-center {
            text-align: center !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-muted {
            color: #8898aa !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }

        .fill-default {
            fill: #172b4d;
        }

        .main-content {
            position: relative;
        }

        .main-content .navbar-top {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            width: 100%;
            padding-right: 0 !important;
            padding-left: 0 !important;

            background-color: transparent;
        }

        .navbar-horizontal .navbar-brand {
            font-size: .875rem;
            font-size: .875rem;
            font-weight: 600;

            letter-spacing: .05px;
            text-transform: uppercase;
        }

        .navbar-horizontal .navbar-brand img {
            height: 30px;
        }

        .navbar-horizontal .navbar-dark .navbar-brand {
            color: #fff;
        }

        .navbar-horizontal .navbar-light .navbar-brand {
            color: #32325d;
        }

        .separator {
            position: absolute;
            top: auto;
            right: 0;
            left: 0;

            overflow: hidden;

            width: 100%;
            height: 150px;

            transform: translateZ(0);
            pointer-events: none;
        }

        .separator svg {
            position: absolute;

            pointer-events: none;
        }

        .separator-top {
            top: 0;
            bottom: auto;
        }

        .separator-top svg {
            top: 0;
        }

        .separator-bottom {
            top: auto;
            bottom: 0;
        }

        .separator-bottom svg {
            bottom: 0;
        }

        .separator-inverse {
            transform: rotate(180deg);
        }

        .separator-skew {
            height: 60px;
        }

        ._link-btn {
            background: #be5519;
            border-radius: 10px;
            color: #fff;
            padding: 7px 15px;
            border: 1px solid #fff;

        }

        .button {
            display: inline-block;
            *display: inline;
            zoom: 1;
            padding: 10px 25px;
            margin: 0;
            cursor: pointer;
            border: 1px solid #bbb;
            overflow: visible;
            font: bold 13px arial, helvetica, sans-serif;
            text-decoration: none;
            white-space: nowrap;
            color: #555;

            background-color: #ddd;
            background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 1)), to(rgba(255, 255, 255, 0)));
            background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: -ms-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: -o-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));

            -webkit-transition: background-color .2s ease-out;
            -moz-transition: background-color .2s ease-out;
            -ms-transition: background-color .2s ease-out;
            -o-transition: background-color .2s ease-out;
            transition: background-color .2s ease-out;
            background-clip: padding-box;
            /* Fix bleeding */
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, .3), 0 2px 2px -1px rgba(0, 0, 0, .5), 0 1px 0 rgba(255, 255, 255, .3) inset;
            -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, .3), 0 2px 2px -1px rgba(0, 0, 0, .5), 0 1px 0 rgba(255, 255, 255, .3) inset;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .3), 0 2px 2px -1px rgba(0, 0, 0, .5), 0 1px 0 rgba(255, 255, 255, .3) inset;
            text-shadow: 0 1px 0 rgba(255, 255, 255, .9);

            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .button.green {
            background-color: #57a957;
            border-color: #57a957;
            font-variant: small-caps;
            font-size: 20px;
        }

        a:hover {
            color: #000;
        }

        a {
            color: #fff !important;
        }

        .ii a[href] {
            color: #fff !important;
        }
    </style>
</head>
<div class="bg-default">
    <div class="main-content" style="padding-top: 30px;">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-horizontal" style="padding: 30px;">
            <div class="container px-4" style="padding-bottom: 30px;">
                <a class="navbar-brand pt-0 d-flex" href="{{ asset('') }}" style="margin: 0px auto; border: 4px solid #fff;padding: 0px 10px; border-radius: 3px;">
                    <img src="{{ asset('/img/logo.png') }}" class="navbar-brand-img mr-2" alt="..." style="height: 4rem;">
                    <div class="font-weight-900" style="font-variant: small-caps; font-size: 3rem;color:#fff">| LTC</div>
                </a>
            </div>
        </nav>
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6" style="margin-top: 15px;">
                            <h1 class="text-white">Xin chào bạn {{ $user->name ?? null }}!</h1>
                            <p style="color: #ced4da !important;">Tài khoản của bạn đã được tạo bởi root.</p>
                            <!-- <a href="{{ asset('/reset-password/'.$token) }}" class="large green button">Truy cập</a> -->
                            <p style="color: #ced4da !important;margin-top: 15px;">Mật khẩu của bạn là</p>
                            <strong style="color: #ced4da !important;color:#fff !important;font-size: 30px">{{ $password }}</strong>
                            <p style="color: #ced4da !important;margin-top: 15px;">Vui lòng đổi mật khẩu lần đầu đăng nhập nhé!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
    </div>
    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row align-items-center justify-content-xl-center">
                <div class="col-xl-6">
                    <div class="copyright" style="text-align: center; color: #8898aa !important;">
                        &copy; 2019 <a href="{{ asset('') }}" class="font-weight-bold ml-1" target="_blank">LTC</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>