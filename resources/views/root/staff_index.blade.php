@extends('master')

@section('title')Danh sách nhân viên
@endsection
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('assets/plugins/awesome-bootstrap-checkbox.css') }}">
<style type="text/css">
    .table td {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }

    ._export_to_excel:hover {}
</style>
<link rel="stylesheet" href="{{ asset('/assets/plugins/loading.io/loading.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/loading.io/loading-btn.css') }}">
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // root.destroy
        $(document).on('click', '._deleteA_Staff', function() {
            // lấy ra page num để truyueenf vào controller để khi xoá xong ko bị về trang 1
            var page = $('#htmlTableData .table-responsive').attr('page');
            // Lấy id
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Nhắc nhẹ?',
                text: "Bạn có muốn xoá nhân viên này không?!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ừm!',
                cancelButtonText: 'Không, mình ấn nhầm',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        url: route('root.deleteA'),
                        data: {
                            "id": id,
                            "page": page,
                        },
                        dataType: "json",
                        success: function(data) {
                            // Kiểm tra thnafh công hay shi bai
                            if (data.status == 'failed') {
                                Swal.fire({
                                    title: 'Oppps! Hình như có lỗi mất rồi !',
                                });
                            } else {
                                topRightNotifications('Xoá thành công!');
                            }
                            // Load lại bảng dữ liệu với tham số là page hiện tại được đẩy ra từ controller
                            loadTable(data.page);
                        }
                    });
                }
            })
        });

        // Xoá nhiều nhân viên
        $(document).on('click', '._btn_delete_multi_staff', function() {
            // lấy ra page num để truyueenf vào controller để khi xoá xong ko bị về trang 1
            var page = $('#htmlTableData .table-responsive').attr('page');
            // mảng id
            var ids = [];
            // Duyệt từng checkbox được check rồi đưa vào mảng id
            $.each($('.chkbox:checked'), function() {
                ids.push($(this).attr('data-id'));
            });
            if (ids.length == 0) {
                Swal.fire({
                    title: 'Hãy chọn ít nhất 1 bản ghi để mà thao tác nha !',
                    type: "info",
                });
            } else {
                Swal.fire({
                    title: 'Nhắc nhẹ?',
                    text: "Bạn có muốn xoá các nhân viên này không?!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ừm!',
                    cancelButtonText: 'Không, mình ấn nhầm',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: route('multiDelete'),
                            data: {
                                "ids": ids,
                                "page": page,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data.status == 'failed') {
                                    Swal.fire({
                                        title: 'Oppps! Hình như có lỗi mất rồi !',
                                    });
                                } else {
                                    var er = data.errors;
                                    topRightNotifications(
                                        `Xoá thành công! Nhưng có id chưa xoá đc : ${er.toString()}`
                                    );
                                }
                                // Load lại dữ liệu a
                                loadTable(data.page);
                            }
                        });
                    }
                });
            }
        });

        // Click vào số trang
        $(document).on('click', '.pagination .page-item a', function(e) {
            e.preventDefault();
            // Lấy page cần truy nhập
            var page = $(this).attr('href').split('page=')[1];
            $.ajax({
                type: "get",
                url: route('ajaxLoadStaff'),
                data: {
                    "page": page,
                },
                dataType: "json",
                success: function(data) {
                    $('#htmlTableData').html(data.html)
                }
            });
        });

        // Xuất danh sách nhân viên
        $(document).on('click', '._export_to_excel', function() {
            Swal.fire({
                title: `Nhắc nhẹ !!`,
                text: `Bạn có muốn xuất danh sách toàn bộ nhân viên này hơm`,
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5ada0d',
                cancelButtonColor: '#f31d1d',
                confirmButtonText: 'Ừm',
                cancelButtonText: 'Hong',
            }).then((result) => {
                if (result.value) {
                    window.location.replace(route('exportStaff'));
                }
            });
        });

/**
 * Tìm kiếm phòng ban
 */
$(document).on('change paste keyup', '._staff_search', function () {
    // lấy ra page num để truyueenf vào controller để khi xoá xong ko bị về trang 1
    var page = $('#htmlTableData .table-responsive').attr('page');
    // 
    // Hiển thị loading ****
    $(document).ajaxStart(function () {
        $('.ltc-loading').css({
            "display": "none",
        });
        $('._staff_search_loading').css({
            "display": "block",
        });
    });
    //
    $(document).ajaxStop(function () {
        $('.ltc-loading').css({
            "display": "none",
        });
        $('._staff_search_loading').css({
            "display": "none",
        });
    });
    // hết ******************
    //
    var departmentName = $(this).val();
    $.ajax({
        type: 'post',
        url: route('searchStaff'),
        data: {
            'type': 1,
            'name': departmentName,
            "page": page,
        },
        dataType: 'json',
        success: function (data) {
            $('#htmlTableData').html(data.html);
        },
    });
});
$('._staff_search').focus(function () {
    $(this).parent().parent().parent().css({
        "max-width": "36.66667%",
    });
}).blur(function () {
    $(this).parent().parent().parent().css({
        "max-width": "16.66667%",
    });
});
    });
    // Thông báo góc phải
    function topRightNotifications(string) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            type: 'success',
            title: string,
        })
    }
    // fetch dữ liệu lên bảng
    function loadTable(page) {
        $.ajax({
            type: "get",
            url: route('ajaxLoadStaff'),
            data: {
                "page": page,
            },
            dataType: "json",
            success: function(data) {
                $('#htmlTableData').html(data.html)
            }
        });
    }
</script>
@endsection

@section('content')

<!-- Dark table -->
<div class="container-fluid mt-3">

    <div class="row">
        <div class="col">
            <a href="/new-staff/" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Thêm nhân viên</a>
            <a href="javascript:void(0);" class="btn btn-outline-danger _btn_delete_multi_staff"><i class="fas fa-plus-circle"></i> Xoá tập thể nhân viên</a>
            <a href="javascript:void(0);" class="btn btn-outline-info _btn_reset_multi_staff"><i class="fas fa-plus-circle"></i> Khôi phục mật khẩu</a>
            <a href="javascript:void(0);" class="btn btn-outline-info _export_to_excel"><i class="fas fa-file-excel    "></i> Xuất danh sách nhân viên</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card bg-default shadow">
                <div class="card-header bg-transparent border-2 pb-5 d-flex">
                    <h3 class="text-white mb-0">Danh sách nhân viên</h3>
                    <div class="col-md-2" style="position: absolute; right: 0; transition: max-width .3s ease-out">
                            <div class="form-group">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                                    </div>
                                    <input class="form-control _staff_search" placeholder="Tìm nhân viên" type="text" style="padding-left: 10px;">
                                    <div class="input-group-prepend _staff_search_loading" style="display: none;">
                                        <span class="input-group-text" style="border-left: none; border-radius: .375rem; border-top-left-radius: 0; border-bottom-left-radius: 0;"><i class="ld ld-ring ld-spin-fast" style="font-size:1.5em"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div id="htmlTableData">
                    @include('root.ajax_staff_index')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection