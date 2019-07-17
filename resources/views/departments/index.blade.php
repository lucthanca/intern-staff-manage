@extends('master')
@section('title')Danh sách phòng ban
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/plugins/loading.io/loading.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/loading.io/loading-btn.css') }}">
<link rel="stylesheet" href="{{ asset('/css/card.css') }}">
<style>
    .toggle {
        background-color: #c87f8a;
        text-align: center;
        height: 32px;
        width: 32px;
        border-radius: 50%;
        position: absolute;
        margin: auto;
        top: 5px;
        right: 5px;
        z-index: 2;
    }

    .fa-plus {
        font-size: 16px;
        color: white;
        display: block;
        margin-top: 8px;
        transition: 0.7s;
    }

    .menu {
        background-color: white;
        height: 100px;
        width: 100px;
        transform: scale(2);
        border-radius: 50%;
        border-style: double;
        border-color: #c87f8a;
        position: absolute;
        margin: auto;
        top: -100%;
        right: -100%;
        z-index: 1;
        transition: 0.2s;
    }

    #menu a {
        display: inline-block;
        position: absolute;
        font-size: 12px;
        color: #BBBBBB;
        transition: color .3s;
    }

    #menu ._edit {
        top: 64%;
        left: 25%;
        color: green;
    }

    #menu ._edit:hover {
        color: #01a501;
    }

    #menu ._delete {
        top: 75%;
        left: 50%;
        color: red;
    }

    #menu ._delete:hover {
        color: #ff4f4f;
    }

    #menu ._show {
        top: 43%;
        left: 12%;
        color: #e8a02f;
    }
</style>
<style>
._department_search::placeholder {
    color: #ed776d;
}
._department_search:focus::placeholder {
    color: #e9746ac2;
}
</style>
@endsection

@section('content')

<!-- Dark table -->
<div class="container-fluid mt-3">
    <div class="row">
        @if(auth()->user()->role === 1)
            <div class="col">
                <a href="/new-department/" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Thêm phòng ban</a>
                <!-- <a href="javascript:void(0);" class="btn btn-outline-danger _btn_delete_multi_department"><i class="fas fa-plus-circle"></i> Xoá phòng ban</a> -->
            </div>
        @endif
    </div>
    <div class="row mt-3">
        <div class="col">
            @if(auth()->user()->role == 1 && $departments->count() == 0)
                <div class="card bg-default shadow">
                    <div class="card-container">
                        <h1 style="color: #4a5871 !important; text-align: center; padding: 250px 0; font-size: 35px;">
                            Chưa có phòng ban nào cả! <br />
                            <i class="fas fa-building mt-5" style="font-size: 100px;"></i>
                        </h1>
                    </div>
                </div>
            @elseif(auth()->user()->role != 1 && auth()->user()->departments->count() == 0)
                <div class="card bg-default shadow">
                    <div class="card-container">
                        <h1 style="color: #4a5871 !important; text-align: center; padding: 250px 0; font-size: 35px;">
                            Bạn vẫn chưa được xếp vào phòng ban nào! <br />
                            <i class="fas fa-building mt-5" style="font-size: 100px;"></i>
                        </h1>
                    </div>
                </div>
            @else
                <div class="card bg-default shadow">
                    <div class="card-header bg-transparent pb-5 border-1 d-flex">
                        @if(auth()->user()->role == 1)
                            <h3 class="text-white mb-0">Danh sách các phòng ban</h3>
                        @else
                            <h3 class="text-white mb-0">Danh sách các phòng ban bạn thuộc về</h3>
                        @endif
                        <div class="col-md-2" style="position: absolute; right: 0; transition: max-width .3s ease-out">
                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="color: #e9746a;"><i class="ni ni-zoom-split-in"></i></span>
                                    </div>
                                    <input id="_department_search" class="form-control _department_search" placeholder="Tìm phòng ban" type="text" name="departmentName" style="color: #ed776d; padding-left: 10px;">
                                    <div class="input-group-prepend _department_search_loading" style="display: none;">
                                        <span class="input-group-text" style="color: #e9746a; border-left: none; border-radius: .375rem; border-top-left-radius: 0; border-bottom-left-radius: 0;"><i class="ld ld-ring ld-spin-fast" style="font-size:1.5em"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="htmlTableData">
                        @include('departments.departmentList')
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('departmentJs')
<script src="{{ asset('/js/department.js') }}"></script>
@endsection