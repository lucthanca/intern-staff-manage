@extends('master')

@section('title')Thêm mới nhân viên
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/plugins/select2/select2.min.css') }}">
<style>
    .ct-page-title {
        margin-bottom: 1.5rem;
        padding-left: 1.25rem;
        border-left: 2px solid #5e72e4;
    }

    .box-title .title {
        font-size: 1.25rem;
        color: #979fa7;
    }

    /* Image box */

    .image-box {
        position: absolute;
        top: -10%;
        right: 10%;
    }

    .image-box .input-group {
        box-shadow: none !important;
    }

    .avatar-wrapper {
        position: relative;
        height: 100px;
        width: 100px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 1px 1px 15px -5px black;
        transition: all .3s ease;
        cursor: pointer;
    }

    .avatar-wrapper:hover {
        transform: scale(1.25);
    }

    .avatar-wrapper:hover .profile-pic {
        opacity: .5;
    }

    .avatar-wrapper .profile-pic {
        height: 100%;
        width: 100%;
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
        font-size: 117px;
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

    .select2-container--default .select2-selection--multiple {
        padding: .625rem .75rem;
        transition: box-shadow .15s ease;
        border: 0;
        box-shadow: 0 1px 3px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-dropdown {
        top: -5px;
        border: 0;
        box-shadow: 0 1px 3px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);
    }
</style>

@endsection

@section('content')

<div class="container-fluid mt-3 pb-5">
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="ct-page-title">
                <h1 class="ct-title" id="content">Thêm nhân viên mới</h1>
            </div>
            <form role="form" method="post" action="{{ route('root.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-5 col-md-12">
                        <div class="card bg-secondary shadow border-0">
                            <div class="card-body px-lg-5 py-lg-5">
                                <div class="box-title mb-3">
                                    <h1 class="title"> Tài khoản</h1>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                        </div>
                                        <input name="username" class="form-control" placeholder="Tài khoản" type="text" value="{{ old('username') }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="color: red;"><i class="ni ni-atom"></i></span>
                                        </div>
                                    </div>
                                    @error('username')
                                    <div style="font-size: 0.75rem; color: #f5365c; text-shadow: 0px 0px 3px #f5365ca6">
                                        <strong><span style="text-decoration: underline;">Chú ý:
                                            </span>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input pattern="^[a-z][a-z0-9_\.]{2,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$" name="email" class="form-control" placeholder="Email" type="email" value="{{ old('email') }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="color: red;"><i class="ni ni-atom"></i></span>
                                        </div>
                                    </div>
                                    <small id="helpId" class="form-text text-muted pl-3 pr-3 text-light-blue"> &rsaquo;
                                        Email bắt đầu bằng chữ cái từ 3 đến 32 ký tự, tên miền có thể là cấp 1 hoặc cấp
                                        2</small>
                                    @error('email')
                                    <div style="font-size: 0.75rem; color: #f5365c; text-shadow: 0px 0px 3px #f5365ca6">
                                        <strong><span style="text-decoration: underline;">Chú ý:
                                            </span>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text show-password"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input name="password" class="form-control" placeholder="Mật khẩu" type="password" value="{{ $randomPassword }}" readonly>
                                    </div>
                                    @error('password')
                                    <div style="font-size: 0.75rem; color: #f5365c; text-shadow: 0px 0px 3px #f5365ca6">
                                        <strong><span style="text-decoration: underline;">Chú ý:
                                            </span>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 px-lg-5 mb-3 text-left">
                                <strong>(<span style="color: red;"><i class="ni ni-atom"></i></span>) : bắt buộc nhoé!</strong>
                            </div>
                        </div>
                        <div class="card bg-secondary shadow border-0 mt-3">
                            <div class="card-body px-lg-5 py-lg-5">
                                <div class="box-title mb-3">
                                    <h1 class="title"> Phòng ban</h1>
                                </div>

                                <div class="form-group">
                                    <select class="form-control select_department" multiple="multiple" data-placeholder="Chọn phòng ban" style="width: 100%;" name="departments[]">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12">
                        <div class="card bg-secondary shadow border-0">

                            <div class="card-body px-lg-5 py-lg-5">

                                <div class="box-title mb-3">
                                    <h1 class="title"> Thông tin cá nhân</h1>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                        </div>
                                        <input name="name" class="form-control" placeholder="Họ tên" type="text" value="{{ old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input readonly name="birthday" class="form-control datepicker" placeholder="Chọn ngày sinh" type="text" value="{{ old('birthday') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
                                        </div>
                                        <input name="address" class="form-control" placeholder="Địa chỉ nhà" type="text" value="{{ old('address') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-city    "></i></span>
                                        </div>
                                        <input name="city" class="form-control" placeholder="Thành phố" type="text" value="{{ old('city') }}">
                                    </div>
                                </div>

                                <div class="form-group image-box">
                                    <div class="input-group input-group-alternative">
                                        <div class="avatar-wrapper">
                                            <img class="profile-pic" src="" />
                                            <div class="upload-button">
                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                            </div>
                                            <input class="file-upload" name="image" id="mediaFile" class="form-control" placeholder="Tải ảnh đại diện" type="file" accept="image/*" value="{{ old('image') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-square    "></i></span>
                                        </div>
                                        <input name="phone" class="form-control" placeholder="Điện thoại" type="text" value="{{ old('phone') }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 pt-3 text-center">
                        <a class="btn btn-secondary" href="/staff/"> Trở lại</a>
                        <button class="btn btn-icon btn-3 btn-primary" type="submit">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text"> Thêm</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('departmentJs')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/js/root.js') }}"></script>
@endsection