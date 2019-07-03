@extends('master')

@section('content')

<!-- Navbar -->
<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
        <a class="navbar-brand pt-0 d-flex align-items-center" href="/">
            <img src="{{ asset('/img/logo.png') }}" class="navbar-brand-img mr-2" alt="...">
            <div class="font-weight-900" style="font-variant: small-caps; font-size: 2rem;color: #f7fafc;">| LTC</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="/">
                            <img src="{{ asset('../assets/img/brand/blue.png') }}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navbar items -->
            @if(Auth::user() && Auth::user()->role != 1)
            <ul class="navbar-nav ml-auto">
                <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="{{ asset('../assets/img/theme/profile.png') }}">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->username }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Chào mừng {{ Auth::user()->username }}
                                    <</h6> </div> <div class="dropdown-divider">
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="ni ni-user-run"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </ul>
            @endif
        </div>
    </div>
</nav>
<!-- Header -->
<div class="header bg-gradient-primary py-5">
    <div class="container">
        <div class="header-body text-center mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    @if(Auth::user() && Auth::user()->role != 1)
                        <h1 class="text-white py-sm-5">Xin chào - {{ auth()->user()->name }}</h1>
                        @if($status == 0)
                            <p class="text-lead text-light">Lần đầu đăng nhập, bạn hãy vui lòng cập nhật lại mật khẩu của bạn để có thể sử dụng phun chức năng.</p>
                        @else
                            <p class="text-lead text-light">Bạn có yêu cầu khôi phục mật khẩu từ root, vui lòng cập nhật lại mật khẩu của bạn để có thể sử dụng phun chức năng.</p>
                        @endif
                    @else
                        <h1 class="text-white py-3">Xin chào bạn nhaaaaaa!</h1>
                        <p class="text-lead text-light py-5">Bạn có yêu cầu khôi phục mật khẩu từ root, vui lòng cập nhật lại mật khẩu của bạn để có thể sử dụng phun chức năng.</p>
                    @endif
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
<div class="container mt--8 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>hãy cập nhật mật khẩu mới</small>
                    </div>
                    <form role="form" method="post" action="{{ $status == 0  ? route('resetPasswordFirst') : route('resetAPswd') }}">
                        @csrf
                        <input type="hidden" name = "token" value="{{ $token ?? null }}">
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu mới" type="password" name="password" id="password" value="" required autocomplete="new-password" autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control @error('password') is-invalid @enderror" placeholder="Xác nhận lại mật khẩu" type="password" name="password_confirmation" id="password-confirm" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('body-class')
bg-default
@endsection