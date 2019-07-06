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

<body>
    <div class="main-content">
        <!-- Top navbar -->
        <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/">Về trang chủ</a>
                <!-- Form -->
                <!-- User -->
                <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="{{ auth()->user()->getAvatar() }}">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Xin chào!</h6>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="javascript:void(0);" class="dropdown-item"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="ni ni-user-run"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Header -->
        <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
            style="min-height: 600px; background-image: url(/storage/{{ $user->image }}); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-7 col-md-10">
                        <h1 class="display-2 text-white" style="min-width: 500px">Xin chào {{ auth()->user()->name }}
                        </h1>
                        @if(auth()->user()->id != $user->id)
                        <p class="text-white mt-0 mb-5" style="min-width: 500px">Đây là trang thông tin cá nhân của
                            {{ $user->name }}</p>
                        @else
                        <p class="text-white mt-0 mb-5" style="min-width: 500px">Chào mừng quay trở lại</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="{{ $user->image ? '/storage/'.$user->image : '/img/no-user.png' }}"
                                            class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">

                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                        <!-- <div>
                                            <span class="heading">22</span>
                                            <span class="description">Friends</span>
                                        </div>
                                        <div>
                                            <span class="heading">10</span>
                                            <span class="description">Photos</span>
                                        </div>
                                        <div>
                                            <span class="heading">89</span>
                                            <span class="description">Comments</span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3>
                                    {{ $user->name }}
                                    <span class="font-weight-light">,
                                        {{ \Carbon\Carbon::today()->diffInYears($user->birthday) }} tuổi</span>
                                </h3>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>Địa chỉ :
                                    {{ $user->address ?? 'Chưa cập nhật' }}
                                </div>
                                <div class="h5 mt-4">
                                    <i class="ni business_briefcase-24 mr-2"></i>Thành phố:
                                    {{ $user->city ?? 'Chưa cập nhật' }}
                                </div>
                                <div>
                                    <i class="ni education_hat mr-2"></i>Số điện thoại:
                                    {{ $user->phone ?? "Chưa cập nhật" }}
                                </div>
                                <hr class="my-4">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Thông tin tài khoản</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary _setting" key="0">Cài
                                        đặt</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <h6 class="heading-small text-muted mb-4">Thông tin người dùng</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="username">Tài khoản</label>
                                                <input type="text" id="input-username"
                                                    class="form-control form-control-alternative"
                                                    placeholder="Nhập tài khoản"
                                                    value="{{ old('username', $user->username) }}" name="username"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="email">Email
                                                    address</label>
                                                <input type="email" id="input-email"
                                                    class="form-control form-control-alternative"
                                                    placeholder="Nhập địa chỉ mail" name="email"
                                                    value="{{ old('email', $user->email) }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Thông tin cá nhân</h6>
                                <div class="pl-lg-4">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-first-name">Tên</label>
                                                <input type="text" id="input-first-name"
                                                    class="form-control form-control-alternative" placeholder="Nhập tên"
                                                    value="{{ old('name', $user->name) }}" name="name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-address">Địa chỉ</label>
                                                <input id="address" class="form-control form-control-alternative"
                                                    placeholder="Nhập địa chỉ"
                                                    value="{{ old('address', $user->address) }}" type="text"
                                                    name="address" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-city">City</label>
                                                <input type="text" id="input-city"
                                                    class="form-control form-control-alternative"
                                                    placeholder="Nhập tên thành phố"
                                                    value="{{ old('city', $user->city) }}" name="city" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="pl-lg-4" id="btn-func" style="display: none;">
                                    <div class="form-group focused text-right">
                                        <button class="btn btn-icon btn-3 btn-primary _cancel" type="button">
                                            <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                                            <span class="btn-inner--text">Huỷ</span>
                                        </button>

                                        <button class="btn btn-icon btn-3 btn-success _update" type="button">
                                            <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                                            <span class="btn-inner--text">Cập nhật</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            © 2018 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1"
                                target="_blank">Creative Tim</a>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md"
                                    class="nav-link" target="_blank">MIT License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>

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
    @include('components.js')
    <script>
    $(document).ready(function() {
        $(document).on('click', '._setting', function() {
            if ($(this).attr('key') == 0) {
                $(this).attr('key', 1);
                $(this).text('Huỷ');
                $('input[name="name"], input[name="address"], input[name="city"]').prop('readonly',
                    false);
                $('#btn-func').slideDown();
            } else {
                $(this).attr('key', 0);
                $(this).text('Cài đặt');
                $('input[name="name"], input[name="address"], input[name="city"]').prop('readonly',
                    true);
                $('#btn-func').slideUp();
            }
        });
    });
    </script>
</body>

</html>
