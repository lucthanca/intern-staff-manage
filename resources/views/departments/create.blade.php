@extends('master')
@section('title')Thêm phòng ban
@endsection
@section('css')
<style>
    .ct-title {
        margin-bottom: 1.5rem;
        padding-left: 1.25rem;
        border-left: 2px solid #5e72e4;
    }
</style>
@endsection
@section('content')

<div class="container-fluid mt-3 pb-5">
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="ct-page-title">
                <h1 class="ct-title" id="content">Thêm phòng ban mới</h1>
            </div>
            <form action="{{ route('department.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card bg-secondary shadow border-0">

                            <div class="card-body px-lg-12 py-lg-12">

                                <div class="box-title mb-3">
                                    <h1 class="title"> Thông tin phòng ban</h1>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-alternative mb-3">
                                        <label for="name" class="text-danger">*</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <input name="name" class="form-control" placeholder="Nhập tên phòng ban" type="text" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                    <div style="font-size: 0.75rem; color: #f5365c; text-shadow: 0px 0px 3px #f5365ca6">
                                        <strong><span style="text-decoration: underline;">Chú ý:
                                            </span>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Mô tả về phòng ban</label>
                                    <textarea rows="4" class="form-control form-control-alternative" placeholder="Nhập mô tả..." name="description">{{ old('description') }}</textarea>
                                </div>
                                <span>(<span class="text-danger">*</span>) : Bắt buộc nhoé</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 pt-3 text-center">
                        <a class="btn btn-secondary" href="/department/"> Trở lại</a>
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