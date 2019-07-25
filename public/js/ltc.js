$(document).ready(function () {
    // 
    // Hiển thị loading ****
    $(document).ajaxStart(function () {
        console.log('ajax start');
        $('.ltc-loading').css({
            "display": "flex",
        });
    });
    //
    $(document).ajaxStop(function () {
        console.log('ajax stop');
        $('.ltc-loading').css({
            "display": "none",
        });
    });
    // hết ******************
    //
    // chọn tất cả **************
    $(document).on('change', '#checkboxAll', function () {
        if ($(this).is(':checked')) {
            $.each($('.chkbox'), function () {
                $(this).prop('checked', true);
            });
        } else {
            $.each($('.chkbox'), function () {
                $(this).prop('checked', false);
            });
        }
    });
    // listen checkbox change
    $(document).on('change', '.chkbox', function () {
        if ($(this).is(':checked')) {
            var id = $(this).attr('data-id');
            $.post(route('pushToIdSession'), {id: id});
        } else {
            console.log('unchecked');
        }
    });

    // Click nút clode modal
    $(document).on('click', '._close-modal', function () {
        $('#modal-notification').fadeOut();
    });

    // Khôi phục mật khẩu 1 nhân viên
    $(document).on('click', '._resetPassword', function (e) {
        e.preventDefault();
        var thisBtn = $(this);
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Nhắc nhẹ?',
            text: "Bạn có muốn khôi phục mật khẩu cho nhân viên này không?!",
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
                    url: route('sendEmailReset'),
                    data: {
                        "id": id,
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 'false') {
                            Swal.fire({
                                title: 'Hình như có lỗi gì đó nha !',
                            });
                        } else {
                            var htmlStr = `<span style="color: #ff2e2e; text-shadow: 0px 0px 10px #ff3737eb;"><i class="fas fa-exclamation-circle"></i>&nbsp;Reset mật khẩu</span>`;
                            thisBtn.parent().parent().parent().parent().children('td[role="status"]').html(htmlStr);
                            topRightNotifications('Đã gửi mail đến người dùng có id = ' + id);
                        }
                    }
                });
            }
        });

    });
    // ./************* */
    // Khôi phục mật khẩu nhiều nhân viên
    $(document).on('click', '._btn_reset_multi_staff', function () {
        // Mảng id
        var ids = [];
        // Duyệt từng checkbox được check rồi đưa vào mảng id
        $.each($('.chkbox:checked'), function () {
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
                text: "Bạn có muốn khôi phục mật khẩu cho các nhân viên này không?!",
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
                        url: route('sendMultiEmailReset'),
                        data: {
                            "ids": ids,
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 'false') {
                                Swal.fire({
                                    title: 'Hình như có lỗi gì đó nha !',
                                });
                            } else {
                                var er = data.errors;
                                if (er.length == 0) {
                                    topRightNotifications('Đã gửi mail đến người dùng');
                                } else {
                                    var htmlStr = `<span style="color: #ff2e2e; text-shadow: 0px 0px 10px #ff3737eb;"><i class="fas fa-exclamation-circle"></i>&nbsp;Reset mật khẩu</span>`;
                                    $.each($('.chkbox:checked'), function () {
                                        console.log($(this).parent().parent().parent().children('td[role="status"]').html(htmlStr));
                                    });
                                    topRightNotifications('Đã gửi mail đến người dùng! Nhưng có lỗi khi gửi đến các người dùng : ' + er.toString());
                                }
                            }
                        }
                    });
                }
            });
        }
    });
});

// Thông báo lỗi 
function ErrorNotifications(errorTitle, errorContent) {
    Swal.fire({
        type: 'error',
        title: errorTitle,
        text: errorContent,
    });
}

// thông báo góc phải màn hình
function Notifications(notiString) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        type: 'success',
        title: notiString
    })
}
