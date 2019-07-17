$(document).ready(function () {
    // Hiển thị mật khẩu
    $(document).on('click', '.show-password', function () {
        if ($(this).parent().next().attr('type') == 'password') {
            $(this).parent().next().attr('type', 'text');
            $(this).children().removeClass('fa-lock').addClass('fa-lock-open');
        } else {
            $(this).parent().next().attr('type', 'password');
            $(this).children().removeClass('fa-lock-open').addClass('fa-lock');
        }
    });

    // image box
    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload").on('change', function () {
        readURL(this);
    });
    $(".upload-button").on('click', function () {
        $(".file-upload").click();
    });

    $('.select_department').select2({
        placeholder: "Hãy chọn các phòng ban",
        pagination: {
            more: true,
        },
        ajax: {
            url: route('searchDepartment'),
            type: 'post',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (val, i) {
                        return {
                            id: val.id,
                            text: val.name == null ? `ID: ${val.id} - Chưa cập nhật tên` : val.name
                        };
                    })
                }
            }
        }
    });

    // Click vào thêm vào phòng ban
    $(document).on('click', '._add_to_department', function () {
        var ids = $('.select_department').val();
        var uid = $('.table-responsive').attr('user-id');
        if (ids.length == 0) {
            Swal.fire({
                title: 'Bạn chưa chọn phòng ban nào kìa!',
                type: 'danger',
            });
        } else {
            $.ajax({
                type: 'post',
                url: route('addToDepartment'),
                data: {
                    'uid': uid,
                    'ids': ids,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == 201) {
                        Swal.fire({
                            title: 'Opps !!!',
                            type: 'info',
                            text: 'Thêm vào thành công, nhưng nhân viên nỳ đã thuộc về các phòng ban: ' + data.data.toString() + ' nên không được thêm vào',
                            showCancelButton: false,
                        }).then((result) => {
                            if (result.value) {
                                setTimeout(function () {
                                    if ($('#htmlTableData').attr('role') != 'profile')
                                        window.location.replace(`/edit/${uid}`);
                                    window.location.replace(`/profile/${uid}`);
                                }, 300);
                            }
                        });
                    } else if (data.status == 200) {
                        Notifications(data.errorMsg);
                        setTimeout(function () {
                            if ($('#htmlTableData').attr('role') != 'profile')
                                window.location.replace(`/edit/${uid}`);
                            window.location.replace(`/profile/${uid}`);
                        }, 1000);
                    } else {
                        ErrorNotifications('Có lỗi ròi kìaaaa!!!', data.errorMsg);
                    }
                }
            });
        }
    });

    // Click vào button đá khỏi phòng ban
    $(document).on('click', '._kickout', function () {
        var uid = $('.table-responsive').attr('user-id');
        var departmentId = $(this).attr('data-id');
        var thisRow = $(this).parent().parent().parent().parent();
        console.log(thisRow);
        Swal.fire({
            title: 'Nhắc nhẹ!',
            text: 'Đá ra khỏi phòng ban này hơm?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ừm!',
            cancelButtonText: 'Không, mình ấn nhầm',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: route('kichOutFromDepartment'),
                    data: {
                        'uid': uid,
                        'departmentId': departmentId,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 200) {
                            Notifications('Đá khỏi phòng ban thành công!');
                            thisRow.remove();
                        } else {
                            ErrorNotifications('Có lỗi ròi kìaaa!', data.errorMsg);
                        }
                    }
                });
            }
        });
    });

    // Click vào button tăng cấp thành quản lý
    $(document).on('click', '._set_to_manage', function () {
        var uid = $('.table-responsive').attr('user-id');
        var departmentId = $(this).attr('data-id');
        var thisFuncBtn = $(this);
        Swal.fire({
            title: `Nhắc nhẹ !`,
            text: `Bạn có muốn tăng người này siêu cấp quản lý hong?`,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5ada0d',
            cancelButtonColor: '#f31d1d',
            confirmButtonText: 'Ừm, cho thử sức chút đi.',
            cancelButtonText: 'Hong, tiếp tục với đất diễn của mình đuy.',
        }).then((r) => {
            if (r.value) {
                $.ajax({
                    type: 'post',
                    url: route('hasManage'),
                    data: {
                        "departmentId": departmentId,
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 401) {
                            Swal.fire({
                                title: `Nhắc nhẹ !!`,
                                text: data.errorMsg + ` Bạn có muốn thế chỗ người này cho người quản lý cũ ??`,
                                type: `question`,
                                showCancelButton: true,
                                confirmButtonColor: '#5ada0d',
                                cancelButtonColor: '#f31d1d',
                                confirmButtonText: 'Oke luôn máy ơi.',
                                cancelButtonText: 'Ờm thôi, mình suy nghĩ lại rồi.',
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        type: 'post',
                                        url: route('setAsManage'),
                                        data: {
                                            "departmentId": departmentId,
                                            "userId": uid,
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data.status == 200) {
                                                thisFuncBtn.removeClass('_set_to_manage').addClass('_set_to_staff').text('Bãi thành hạ phẩm nhân viên của phòng ban');
                                                thisFuncBtn.parent().parent().parent().prev().text(data.name).attr('title', data.name);
                                                Notifications('Tăng cấp thành công');
                                            } else {
                                                ErrorNotifications('Có lỗi rồi kìa !!!', data.errorMsg);
                                            }
                                        }
                                    });
                                }
                            });
                        } else if (data.status == 200) {
                            $.ajax({
                                type: 'post',
                                url: route('setAsManage'),
                                data: {
                                    "departmentId": departmentId,
                                    "userId": uid,
                                },
                                dataType: 'json',
                                success: function (data) {
                                    if (data.status == 200) {
                                        thisFuncBtn.removeClass('_set_to_manage').addClass('_set_to_staff').text('Bãi thành hạ phẩm nhân viên của phòng ban');
                                        thisFuncBtn.parent().parent().parent().prev().text(data.name).attr('title', data.name);
                                        Notifications('Tăng cấp thành công');
                                    } else {
                                        ErrorNotifications('Có lỗi rồi kìa !!!', data.errorMsg);
                                    }
                                }
                            });
                        }
                    }
                });
            }
        });
    });

    // Click vào hạ cấp
    $(document).on('click', '._set_to_staff', function () {
        var uid = $('.table-responsive').attr('user-id');
        var departmentId = $(this).attr('data-id');
        var thisFuncBtn = $(this);
        Swal.fire({
            title: `Nhắc nhẹ !`,
            text: `Bạn có muốn hạ phẩm người này thành nhân viên trong phòng hong?`,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5ada0d',
            cancelButtonColor: '#f31d1d',
            confirmButtonText: 'Ừm, làm quản lý lâu rồi',
            cancelButtonText: 'Hong, người này còn tốt',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: route('setToStaff'),
                    data: {
                        "userId": uid,
                        "departmentId": departmentId,
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 200) {
                            thisFuncBtn.removeClass('_set_to_staff').addClass('_set_to_manage').text('Tăng cấp thành siêu cấp quản lý cho phòng này');
                            thisFuncBtn.parent().parent().parent().prev().text('Chưa có quản lý').attr('title', 'Chưa có quản lý');
                            Notifications('Hạ cấp thành công');
                        } else {
                            ErrorNotifications('Có lỗi rồi kìa !!!', data.errorMsg);
                        }
                    },
                });
            }
        });
    });
});