@extends('master')

@section('title')Quên mật khẩu
@endsection

@section('body-class')
bg-default
@endsection

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
        <a class="navbar-brand pt-0 d-flex align-items-center" href="/">
            <img src="{{ asset('/img/logo.png') }}" class="navbar-brand-img mr-2" alt="...">
            <div class="font-weight-900" style="font-variant: small-caps; font-size: 2rem;color: #f7fafc;">| LTC</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navbar items -->
            <ul class="navbar-nav ml-auto">

                <!-- <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="../index.html">
                        <i class="ni ni-planet"></i>
                        <span class="nav-link-inner--text">Dashboard</span>
                    </a>
                </li> -->

                <!-- <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="../examples/register.html">
                        <i class="ni ni-circle-08"></i>
                        <span class="nav-link-inner--text">Register</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="../examples/login.html">
                        <i class="ni ni-key-25"></i>
                        <span class="nav-link-inner--text">Login</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="../examples/profile.html">
                        <i class="ni ni-single-02"></i>
                        <span class="nav-link-inner--text">Profile</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>
<!-- Header -->
<div class="header bg-gradient-primary py-7 py-lg-8">
    <div class="container">
        <div class="header-body text-center mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Gửi yêu cầu lấy lại mật khẩu</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
            xmlns="http://www.w3.org/2000/svg">
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
                        <small>Hãy nhập địa chỉ email của bạn</small>
                    </div>
                    <form id="login-form" role="form" method="get" action="{{ route('send-reset-password-mail') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control @error('email') is-invalid @enderror pl-3" placeholder="Email"
                                    type="email" name="email" id="email" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus
                                    pattern="^[a-z][a-z0-9_\.]{2,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$"
                                    >

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">Lấy link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
