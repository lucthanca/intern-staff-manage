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
</style>
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
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
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
                                    animation: false,
                                    customClass: {
                                        popup: 'animated swing'
                                    }
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
                    animation: false,
                    customClass: {
                        popup: 'animated wobble',
                    }
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
                    animation: false,
                    customClass: {
                        popup: 'animated tada'
                    }
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
                                        animation: false,
                                        customClass: {
                                            popup: 'animated swing'
                                        }
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
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="animate-border">
                <div class="card bg-default shadow">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="text-white mb-0">Danh sách nhân viên</h3>
                    </div>
                    <div id="htmlTableData">
                        @include('root.ajax_staff_index')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection