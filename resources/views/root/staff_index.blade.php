@extends('master')

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
    // root.destroy
    $(document).ready(function() {
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
                            // Load lại bảng dữ liệu với tham số là page hiện tại được đẩy ra từ controller
                            loadTable(data.page);
                            topRightNotifications('Xoá thành công!');
                        }
                    });
                }
            })
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
            <a href="/new-staff/" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Thêm nhân
                viên</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
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
@endsection