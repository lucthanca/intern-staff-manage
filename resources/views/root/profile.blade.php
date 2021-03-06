<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @routes
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>{{ auth()->user()->name ?? 'Chưa cập nhật tên' }} - Trang cá nhân</title>

    @include('components.css')
    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2/select2.min.css') }}">
    <style>
        /* Image box */

        .image-box .input-group {
            box-shadow: none !important;
        }

        .avatar-wrapper {
            position: relative;
            height: 256px;
            width: 256px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 1px 1px 15px -5px black;
            transition: all .3s ease;
            cursor: pointer;
            margin: 0 auto;
        }

        .avatar-wrapper:hover {
            transform: scale(1.1);
        }

        .avatar-wrapper:hover .profile-pic {
            opacity: .5;
        }

        .avatar-wrapper .profile-pic {
            height: 100%;
            max-width: 100% !important;
            top: 30%;
            transition: all .3s ease;
        }

        .avatar-wrapper .profile-pic:after {
            font-family: 'Font Awesome 5 Free';
            content: "\f007";
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            font-size: 62.5px;
            background: #ecf0f1;
            color: #34495e;
            text-align: center;
        }

        .avatar-wrapper .upload-button {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
        }

        .avatar-wrapper .upload-button .fa-arrow-circle-up {
            position: absolute;
            font-size: 270px;
            top: -8.5px;
            left: -8.5px;
            text-align: center;
            opacity: 0;
            transition: all .3s ease;
            color: #34495e;
        }

        .avatar-wrapper .upload-button:hover .fa-arrow-circle-up {
            opacity: .9;
        }
    </style>
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

        .rotate-center {
            -webkit-animation: rotate-center .6s linear infinite both;
            animation: rotate-center .6s linear infinite both
        }

        /* ----------------------------------------------
 * Generated by Animista on 2019-7-8 9:35:10
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

        @-webkit-keyframes rotate-center {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @keyframes rotate-center {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        /* Hover vào avatar */

        .card-profile-image a span {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            background: #0000001c;
            min-width: 180px;
            min-height: 180px;
            border-radius: 50%;
            left: 50%;
            bottom: -180px;
            transform: translate(-50%, -30%);
            z-index: 9;
            text-align: center;
            font-size: 35px;
            color: #0000001c;
            opacity: 0;
            transition: opacity .3s ease-in-out;
        }

        .card-profile-image a:hover span {
            opacity: 1;
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
                        <a class="nav-link pr-0" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="{{ auth()->user()->getAvatar() }}">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold user-name">{{ auth()->user()->name }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Xin chào!</h6>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="/profile/{{ auth()->user()->id }}" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>Trang cá nhân</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="javascript:void(0);" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="ni ni-user-run"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Header -->
        <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(/storage/{{ $user->image }}); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-7 col-md-10">
                        <h1 class="display-2 text-white welcome-user" style="min-width: 500px">Xin chào {{ auth()->user()->name }}
                        </h1>
                        @if(auth()->user()->id != $user->id)
                        <p class="text-white mt-0 mb-5 welcome-user-root" style="min-width: 500px">Đây là trang thông tin cá nhân của
                            {{ $user->name ?? '.....ờm thì xin lỗi người này chưa cập nhật tên :))' }}</p>
                        @else
                        <p class="text-white mt-0 mb-5 welcome-user-des" style="min-width: 500px">Chào mừng quay trở lại
                            {{ auth()->user()->name ?? 'Cái người chưa cập nhật tên này -.-' }}</p>
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
                                    <a href="javascript:void(0);">
                                        @if(auth()->user()->role == 1 || auth()->user()->id == $user->id)
                                        <span data-toggle="modal" data-target="#modal-form">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        @endif
                                        <img src="{{ $user->image ? '/storage/'.$user->image : '/img/no-user.png' }}" class="rounded-circle">
                                    </a>
                                    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card bg-secondary shadow border-0">
                                                        <div class="card-header bg-transparent pb-5">
                                                            <div class="text-muted text-center mt-2 mb-3"><small>Cập
                                                                    nhật ảnh</small></div>
                                                        </div>
                                                        <div class="card-body px-lg-5 py-lg-5" style="position: relative; min-height: 300px;">
                                                            <form action="{{ route('updateAvatar') }}" method="post" id="form-avatar-data" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                                <div class="form-group image-box">
                                                                    <div class="input-group input-group-alternative">
                                                                        <div class="avatar-wrapper">
                                                                            <img class="profile-pic" src="{{ $user->getAvatar() }}" />
                                                                            <div class="upload-button">
                                                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                                                            </div>
                                                                            <input class="file-upload" name="image" id="mediaFile" class="form-control" placeholder="Tải ảnh đại diện" type="file" accept="image/*" value="{{ old('image') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-center">
                                                                    <button type="submit" class="btn btn-primary my-4 _updateAvatar">
                                                                        Cập nhật ảnh</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="text-center info">
                                <h3>
                                    {{ $user->name ?? 'Chưa cập nhật tên' }}
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
                    <div class="card bg-secondary shadow mt-3">
                        <div class="card-header bg-transparent border-0">
                            <div class="box-title">
                                <h3 class="title mb-0">Danh sách phòng ban</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div role="profile" id="htmlTableData" style="background-color: #f5f7f9;
                                                            border: 1px solid #e6ecf1;
                                                            padding: 1.25rem;
                                                            border-radius: .25rem;">
                                @include('root.ajax_user_department')
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
                                @if(auth()->user()->role == 1 || auth()->user()->id == $user->id)
                                <div class="col-4 text-right">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary {{ auth()->user()->role == 1 ? '_root_edit' : '_edit' }}" key="0" title="Sửa thông tin">Sửa</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="" id="form-data">
                                <input type="hidden" name="id" value='{{ $user->id }}'>
                                @csrf
                                <h6 class="heading-small text-muted mb-4">Thông tin người dùng</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="username">Tài khoản</label>
                                                <input type="text" id="username" class="form-control form-control-alternative" placeholder="Nhập tài khoản" value="{{ old('username', $user->username) }}" name="username" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="email">Email
                                                    address</label>
                                                <input type="email" id="email" class="form-control form-control-alternative" placeholder="Nhập địa chỉ mail" name="email" value="{{ old('email', $user->email) }}" readonly>
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
                                                <label class="form-control-label" for="name">Tên <span class="text-danger">*</span></label>
                                                <input type="text" id="input-first-name" class="form-control form-control-alternative" placeholder="Nhập tên" value="{{ old('name', $user->name) }}" name="name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="address">Địa chỉ</label>
                                                <input id="address" class="form-control form-control-alternative" placeholder="Nhập địa chỉ" value="{{ old('address', $user->address) }}" type="text" name="address" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="city">Thành phố
                                                    <span class="text-danger">*
                                                    </span>
                                                </label>

                                                <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="Nhập tên thành phố" value="{{ old('city', $user->city) }}" name="city" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="city">Ngày sinh
                                                    <span class="text-danger">*
                                                    </span>
                                                </label>

                                                <input type="text" id="input-city" class="form-control form-control-alternative datepicker" placeholder="Chọn ngày sinh" value="{{ old('birthday', $user->birthday) }}" name="birthday" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="city">Số điện thoại
                                                    <span class="text-danger">*
                                                    </span>
                                                </label>

                                                <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="Nhập số điện thoại" pattern="((\+84|84|0)[9|3])+([0-9]{8})\b" value="{{ old('phone', $user->phone) }}" name="phone" readonly>
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

                                        <button class="btn btn-icon btn-3 btn-success _update" type="button" data-id="{{ auth()->user()->role == 1 ? $user->id : auth()->user()->id }}">
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
                            © 2018 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
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
<!-- Modal -->
<div class="modal fade" id="_add_to_department_modal" tabindex="-1" role="dialog" aria-labelledby="_add_to_department_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="_add_staff_to_department_modal_Label">Thêm vào phòng ban</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Chọn phòng ban</label>
                        <select class="form-control select_department" multiple="multiple" data-placeholder="Chọn phòng ban" style="width: 100%;" name="ids" data-id="{{ $user->id }}">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary _add_to_department">Thêm</button>
            </div>
        </div>
    </div>
</div>
    @include('errors.errorModal')
    @include('components.js')
    <script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/js/root.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Hiển thị loading ****
            $(document).ajaxStart(function() {
                console.log('start');
                // Huỷ của js chính
                $('.ltc-loading').css({
                    "display": "none",
                    // Hiện button loading
                });
                $('._update').children().children().removeClass('ni ni-check-bold').addClass(
                    'fa fa-spinner fa-spin');
            });
            //
            $(document).ajaxStop(function() {
                console.log('stop');
                // Bỏ loading
                $('._update').children().children().removeClass('fa fa-spinner fa-spin').addClass(
                    'ni ni-check-bold');
            });
            // hết ******************
            //
            // Khi click vào nút sửa chô user thường
            $(document).on('click', '._edit', function() {
                if ($(this).attr('key') == 0) {
                    $(this).attr('key', 1);
                    $(this).text('').html(`<i class="fas fa-times-circle"></i>`).addClass(`rotate-center`)
                        .attr('title', 'Đóng');
                    $('input[name="name"], input[name="address"], input[name="city"], input[name="phone"]')
                        .prop('readonly',false);
                    $('#btn-func').slideDown();
                } else {
                    cancelUpdate($('._edit'));
                }
            });
            // Khi click vào nút sửa chô root
            $(document).on('click', '._root_edit', function() {
                if ($(this).attr('key') == 0) {
                    $(this).attr('key', 1);
                    $(this).text('').html(`<i class="fas fa-times-circle"></i>`).addClass(`rotate-center`).attr('title', 'Đóng');
                    $('input[name="email"], input[name="username"], input[name="name"], input[name="address"], input[name="city"], input[name="phone"]').prop('readonly', false);
                    $('#btn-func').slideDown();
                } else {
                    cancelUpdate($('._root_edit'));
                }
            });
            // Ấn vào button huỷ
            $(document).on('click', '._cancel', function() {
                cancelUpdate({{ auth()->user()->role == 1 ? '$(`._root_edit`)' : '$(`._edit`)' }});
            });
            // Ấn vào button cập nhật
            $(document).on('click', '._update', function() {
                var formData = $('#form-data').serialize();
                $.ajax({
                    type: "post",
                    url: route('updateNameAddressBirthdayAndPhone'),
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        /**
                         * Nếu phát sinh lỗi
                         */
                        if (data.msg) {
                            Swal.fire({
                                title: data.msg,
                                type: 'error',
                            });
                        } else {
                            var info = $('.info');
                            fillInfo(info, data.user);
                            cancelUpdate({{ auth()->user()->role == 1 ? '$(`._root_edit`)' : '$(`._edit`)' }});
                        }
                    }
                });
            });
        });

        // Image box
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".file-upload").on('change', function() {
            readURL(this);
        });
        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });
        // ./ Image box

        function cancelUpdate(selector) {
            selector.attr('key', 0).text('Sửa').removeClass(`rotate-center`).attr('title', 'Sửa thông tin');;
            $(`{{ auth()->user()->role == 1 ? 'input[name=email], input[name=username],' : null }}input[name="name"], input[name="address"], input[name="city"], input[name="phone"]`).prop('readonly',
                true);
            $('#btn-func').slideUp();
        }

        // Điền lại thông tin
        function fillInfo(info, data) {
            var html = `
        <h3>
            ${data.name == null ? 'Chưa cập nhật tên': data.name}
            <span class="font-weight-light">,
            ${calculateAge(data.birthday)} tuổi
            </span>
        </h3>
        <div class="h5 font-weight-300">
            <i class="ni location_pin mr-2"></i>Địa chỉ :
            ${data.address == null ? 'Chưa cập nhật' : data.address}
        </div>
        <div class="h5 mt-4">
            <i class="ni business_briefcase-24 mr-2"></i>Thành phố:
            ${data.city == null ? 'Chưa cập nhật' : data.city}
        </div>
        <div>
            <i class="ni education_hat mr-2"></i>Số điện thoại:
            ${data.phone == null ? 'Chưa cập nhật' : data.phone}
        </div>
        <hr class="my-4">
            `;
            info.html(html); {{ auth()->user()->role != 1 ? '$(`.welcome-user`).text(`Xin chào ${data.name}`);$(`.welcome-user-des`).text(`Chào mừng quay trở lại ${data.name == null ? `cái tên chưa cập nhật tên này` : data.name}`);$(`.user-name`).text(data.name);' : '$(`.welcome-user-root`).text(`Đây là trang thông tin cá nhân của ${data.name == null ? `cái tên chưa cập nhật tên này` : data.name}`);' }}
        }
        // Tính tuổi 
        function calculateAge(birthday) {
            var now = new Date();
            var past = new Date(birthday);
            var nowYear = now.getFullYear();
            var pastYear = past.getFullYear();
            var age = nowYear - pastYear;
            return age;
        }
    </script>
</body>
</html>