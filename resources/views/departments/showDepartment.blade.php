@extends('master')
@section('title')Danh sách phòng ban
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/plugins/select2/select2.min.css') }}">
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
        transition: 0.7s;
    }

    #menu a {
        display: inline-block;
        position: absolute;
        font-size: 15px;
        color: #BBBBBB;
        transition: color .3s;
    }

    #menu ._edit {
        top: 48%;
        left: 16%;
        color: green;
    }

    #menu ._edit:hover {
        color: #01a501;
    }

    #menu ._delete {
        top: 71%;
        left: 38%;
        color: red;
    }

    #menu ._delete:hover {
        color: #ff4f4f;
    }

    .empty-area {
        background: #e5e5e575;
        border-radius: 7px;
        box-shadow: 5px 10px 20px 0px rgba(0, 0, 0, .4);
        padding: 300px 30px;
        text-align: center;
        margin-top: 15px;
    }
</style>
@endsection

@section('content')

<!-- Dark table -->
<div class="container-fluid mt-3">

    <div class="row">
        @if(auth()->user()->role === 1)
            <div class="col">
                <a href="javascript:void(0);" class="btn btn-outline-primary _show_modal_add_staff_to_department" data-toggle="modal" data-target="#_add_staff_to_department_modal"><i class="fas fa-plus-circle"></i> Thêm nhân viên</a>
                <a href="javascript:void(0);" class="btn btn-outline-danger _kich_multi_staff"><i class="fas fa-plus-circle"></i> Đá tập thể</a>
                <a href="javascript:void(0);" class="btn btn-outline-info _btn_reset_multi_staff"><i class="fas fa-plus-circle"></i> Khôi phục mật khẩu tập thể</a>
                <a href="javascript:void(0);" class="btn btn-outline-info _export_to_excel"><i class="fas fa-file-excel    "></i> Xuất danh sách nhân viên trong phòng</a>
            </div>
        @else 
            <div class="col">
                <a href="javascript:void(0);" class="btn btn-outline-info _export_to_excel"><i class="fas fa-file-excel    "></i> Xuất danh sách nhân viên trong phòng</a>
            </div>
        @endif
    </div>
    @if ($department->users->count() == 0)
        <div class="row">
            <div class="col-md-12 col-lg-12 empty-area">
                <h1 class="display-3">Hiện chửa có nhân viên nào trong phòng này cả, hãy thêm vào đi nè!</h1><br>
                <h1><i class="far fa-meh"></i></h1>
            </div>
        </div>
    @else
        <div class="row mt-3">
            <div class="col">
                <div class="animate-border">
                    <div class="card bg-default shadow">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="text-white mb-0">Danh sách nhân viên trong phòng ban</h3>
                        </div>
                        <div id="htmlTableData">
                            @include('departments.ajax_departmentListStaff')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="_add_staff_to_department_modal" tabindex="-1" role="dialog" aria-labelledby="_add_staff_to_department_modal_Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="_add_staff_to_department_modal_Label">Thêm nhân viên vào phòng ban</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Chọn nhân viên</label>
                        <select class="form-control select_staff" multiple="multiple" data-placeholder="Chọn nhân viên" style="width: 100%;" name="ids" data-id="{{ $department->id }}">

                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary _add_staff_to_department">Thêm</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('departmentJs')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/js/department.js') }}"></script>
@endsection