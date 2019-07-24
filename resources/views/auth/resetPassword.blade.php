@extends('master')
@section('title')Khôi phục mật khẩu
@endsection
@section('content')

<!-- Navbar -->
<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
        <a class="navbar-brand pt-0 d-flex align-items-center" href="/">
            <img src="{{ asset('/img/logo.png') }}" class="navbar-brand-img mr-2" alt="...">
            <div class="font-weight-900" style="font-variant: small-caps; font-size: 2rem;color: #f7fafc;">| LTC</div>
        </a>
    </div>
</nav>
<!-- Header -->
<div class="header bg-gradient-primary py-5">
    <div class="container">
        <div class="header-body text-center mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white py-3">Khôi phục mật khẩu</h1>                
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
                        <small>Hãy cập nhật mật khẩu mới</small>
                    </div>
                    <form role="form" method="post" action="{{ route('resetAPswd') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token ?? null }}">
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