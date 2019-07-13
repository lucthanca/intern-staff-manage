<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>@yield('title')</title>

    @include('components.css')
    <style>
        /* Loadding div */
        .ltc-loading {
            position: fixed;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: rgba(51, 51, 51, 0.7);
            z-index: 10;
        }

        .ltc-loading {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* loadding component */
        .lds-default {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px;
        }

        .lds-default div {
            position: absolute;
            width: 5px;
            height: 5px;
            background: #fff;
            border-radius: 50%;
            animation: lds-default 1.2s linear infinite;
        }

        .lds-default div:nth-child(1) {
            animation-delay: 0s;
            top: 29px;
            left: 53px;
        }

        .lds-default div:nth-child(2) {
            animation-delay: -0.1s;
            top: 18px;
            left: 50px;
        }

        .lds-default div:nth-child(3) {
            animation-delay: -0.2s;
            top: 9px;
            left: 41px;
        }

        .lds-default div:nth-child(4) {
            animation-delay: -0.3s;
            top: 6px;
            left: 29px;
        }

        .lds-default div:nth-child(5) {
            animation-delay: -0.4s;
            top: 9px;
            left: 18px;
        }

        .lds-default div:nth-child(6) {
            animation-delay: -0.5s;
            top: 18px;
            left: 9px;
        }

        .lds-default div:nth-child(7) {
            animation-delay: -0.6s;
            top: 29px;
            left: 6px;
        }

        .lds-default div:nth-child(8) {
            animation-delay: -0.7s;
            top: 41px;
            left: 9px;
        }

        .lds-default div:nth-child(9) {
            animation-delay: -0.8s;
            top: 50px;
            left: 18px;
        }

        .lds-default div:nth-child(10) {
            animation-delay: -0.9s;
            top: 53px;
            left: 29px;
        }

        .lds-default div:nth-child(11) {
            animation-delay: -1s;
            top: 50px;
            left: 41px;
        }

        .lds-default div:nth-child(12) {
            animation-delay: -1.1s;
            top: 41px;
            left: 50px;
        }

        @keyframes lds-default {

            0%,
            20%,
            80%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }
        }
    </style>
</head>

<body class="@yield('body-class')">
    @guest

    @if (Route::has('register'))
    <div class="main-content">
        @include('components.content')
    </div>
    @endif
    @else
    @if(auth()->user()->logged_flag!=0 && auth()->user()->logged_flag!=-1)
    @include('components.nav')
    @endif
    <div class="main-content">
        @include('components.content')
    </div>

    @endguest

    <div class="ltc-loading" style="display: none;">
        <div class="lds-default">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    @include('errors.errorModal')
    @include('components.js')
</body>

</html>