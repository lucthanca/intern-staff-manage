/**
 * Xoá phòng ban
 */
$(document).on('click', '._delete', function () {
    var id = $(this).attr('data-id');
    var thisCard = $(this).parent().parent().parent().parent().parent('.card-container');
    Swal.fire({
        title: 'Nhắc nhẹ ?',
        text: "Bạn có muốn xoá phòng ban này này?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ừm!',
        cancelButtonText: 'Không, mình ăn nhầm',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: route('department.deleteADepartment'),
                data: {
                    'id': id,
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == 'success') {
                        Notifications('Xoá phòng ban thành công !');
                        thisCard.remove();
                    } else if (data.status == 'somethings') {
                        ErrorNotifications('Opps!', ' Có lỗi gì ý');
                    } else {
                        ErrorNotifications('Opps!', 'Không tìm thấy phòng ban này là sao ta!');
                    }
                }
            });
        }
    });

});

$(document).ready(function () {
    var departmentId = $('.select_staff').attr('data-id');
    // Khởi tạo select2
    var selectedStaff = $('.select_staff');
    if (selectedStaff.is(`.select_staff`)) {
        selectedStaff.select2({
            placeholder: "Hãy chọn các nhân viên",
            pagination: {
                more: true,
            },
            ajax: {
                url: route('searchStaff'),
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
                            /**
                             * Nếu data có root thì ko thêm vào list
                             */
                            return val.role != 1 ? {
                                id: val.id,
                                text: val.name == null ? `ID: ${val.id} - Chưa cập nhật tên` : val.name
                            } : null;
                        })
                    }
                }
            }
        });
    }

    // click vào menu toggle
    $(document).on('click', '#toggle', function () {
        var status = $(this).attr('status');
        if (status == 1) {
            $(this).attr('status', 0);
            $(this).children().css({
                'transform': 'rotate(0deg)',
            });
            $(this).parent().next().css({
                'top': '-100%',
                'right': '-100%'
            });
        } else {
            $(this).attr('status', 1);
            $(this).children().css({
                'transform': 'rotate(45deg)',
            });
            $(this).parent().next().css({
                'top': '-15%',
                'right': '-10%'
            });
        }
    });

    /**
     * Click vào button thêm nhân viên
     */
    $(document).on('click', '._add_staff_to_department', function () {
        var ids = $('.select_staff').val();
        if (ids.length == 0) {
            Swal.fire({
                title: `Hãy chọn ít nhất 1 nhân viên để thêm, không thêm thì ấn đóng chứ đừng ấn thêm.`,
                type: `info`,
            });
        }
        $.ajax({
            type: "post",
            url: route('department.addStaffToDepartment'),
            data: {
                "departmentId": departmentId,
                "ids": ids,
            },
            dataType: "json",
            success: function (data) {
                if (data.status == 403) {
                    ErrorNotifications('Cảnh báo !!!!', data.errorMsg);
                } else if (data.status == 3) {
                    ErrorNotifications('Opps !', `Các nhân viên này đều đã có trong phòng ban này ròiiiii!`);
                } else if (data.status == 1) {
                    window.location.replace(`/department/${departmentId}`);
                } else if (data.status == 0) {
                    ErrorNotifications('Opps !', data.errorMsg);
                } else {
                    Swal.fire({
                        title: 'Nhắc nhẹ !?',
                        text: `Nhân viên: ${data.data.toString()} đã có trong phòng ban`,
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    }).then((result) => {
                        if (result.value) {
                            setTimeout(function () {
                                window.location.replace(`/department/${departmentId}`);
                            }, 300);
                        }
                    });
                }
            }
        });
    });

    /**
     * Click vào nút đá tập thể nhân viên khỏi phòng ban
     */
    $(document).on('click', '._kich_multi_staff', function () {
        var ids = [];
        $.each($('.chkbox:checked'), function () {
            ids.push($(this).attr('data-id'));
        });
        if (ids.length == 0) {
            Swal.fire({
                title: `Hãy chọn ít nhất một người để thao tác.`,
                type: `info`,
                confirmButtonText: `Ò`,
            });
        } else {
            Swal.fire({
                title: `Nhắc nhẹ`,
                text: `Bạn có muốn đá mấy người này ra khỏi phòng này hơm?`,
                type: `question`,
                showCancelButton: true,
                confirmButtonColor: '#5ada0d',
                cancelButtonColor: '#f31d1d',
                confirmButtonText: 'Đá luôn máy êi!',
                cancelButtonText: 'Hong, mình ấn nhầm đấy.',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'post',
                        url: route('multiKick'),
                        data: {
                            'departmentId': departmentId,
                            'ids': ids,
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 200) {
                                Notifications('Đá tập thể thành công rùi');
                                setTimeout(function () {
                                    window.location.replace(`/department/${departmentId}`);
                                }, 3000);
                            } else if (data.status == 555) {
                                Swal.fire({
                                    title: 'Nhắc nhẹ !?',
                                    text: data.errorMsg + `: ${data.data.toString()}`,
                                    type: 'warning',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'OK!'
                                }).then((result) => {
                                    if (result.value) {
                                        setTimeout(function () {
                                            window.location.replace(`/department/${departmentId}`);
                                        }, 300);
                                    }
                                });
                            } else {
                                ErrorNotifications('Có lỗi rồi kìaaaaa !!', data.errorMsg);
                            }
                        }
                    });
                }
            });
        }
    });

    /**
     * Đá 1 nhần viên
     */
    $(document).on('click', '._kick_Staff', function () {
        var userId = $(this).attr('user-id');
        console.log(userId + '.' + departmentId);
        Swal.fire({
            title: `Nhắc nhẹ !`,
            text: `Bạn có muốn đá nhân viên này ra khỏi phòng ban hong?`,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5ada0d',
            cancelButtonColor: '#f31d1d',
            confirmButtonText: 'Ừm, cho hắn ra đảo đi',
            cancelButtonText: 'Hong, mình ấn nhầm',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: route('kickAStaff'),
                    data: {
                        "departmentId": departmentId,
                        "userId": userId,
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 200)
                            Notifications(`Đá nhân viên khỏi phòng ban thành công`);
                        else
                            ErrorNotifications('Có lỗi kìa !!', data.errorMsg);
                    }
                });
            }
        });
    });

    /**
     * Hạ cấp thành nhân viên
     */
    $(document).on('click', '._set_as_staff', function () {
        var thisUser = $(this);
        var userId = $(this).attr('user-id');
        Swal.fire({
            title: `Nhắc nhẹ !`,
            text: `Bạn có muốn hạ phẩm người này thành nhân viên hong?`,
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
                        "userId": userId,
                        "departmentId": departmentId,
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 200) {
                            // Reset lại các menu của nhân viên
                            thisUser.parent().parent().parent().prev().attr('title', 'Nhân viên').text(`Nhân viên`);
                            thisUser.addClass(`_set_as_manage`);
                            thisUser.removeClass(`_set_as_staff`);
                            thisUser.text(`Tăng thành siêu cấp quản lý`);
                            Notifications('Hạ cấp thành công');
                        } else {
                            ErrorNotifications('Có lỗi rồi kìa !!!', data.errorMsg);
                        }
                    },
                });
            }
        });
    });

    /**
     * Tăng thành siêu cấp quản lý
     */
    $(document).on('click', '._set_as_manage', function () {
        var userId = $(this).next().next().attr('data-id');
        var thisUser = $(this);
        Swal.fire({
            title: `Nhắc nhẹ !`,
            text: `Bạn có muốn tăng người này siêu cấp quản lý hong?`,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5ada0d',
            cancelButtonColor: '#f31d1d',
            confirmButtonText: 'Ừm, cho thử sức chút đi.',
            cancelButtonText: 'Hong, tiếp tục với đất diễn của mình đuy.',
        }).then((result) => {
            if (result.value) {
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
                                            "userId": userId,
                                        },
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data.status == 200) {
                                                // Tìm xem đối tượng đang là quản ở ở đâu sau đó chuyển menu về của nhân viên
                                                $.each($('td[role="permission"]'), function () {
                                                    console.log($(this));
                                                    if ($(this).attr('title') == 'Quản lý') {
                                                        $(this).attr('title', 'Nhân viên').text(`Nhân viên`);
                                                        $(this).next().children().children('.dropdown-menu')
                                                            .children(`._set_as_staff`)
                                                            .removeClass(`_set_as_staff`)
                                                            .addClass('_set_as_manage')
                                                            .text(`Tăng thành siêu cấp quản lý`);
                                                    }
                                                });
                                                // reset menu của quản lý
                                                thisUser.parent().parent().parent().prev().attr('title', 'Quản lý').text(`Quản lý`);
                                                thisUser.addClass(`_set_as_staff`);
                                                thisUser.removeClass(`_set_as_manage`);
                                                thisUser.text(`Bãi thành hạ phẩm nhân viên`);
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
                                type: "post",
                                url: route('setAsManage'),
                                data: {
                                    "departmentId": departmentId,
                                    'userId': userId,
                                },
                                dataType: "json",
                                success: function (data) {
                                    if (data.status == 200) {
                                        // reset menu của quản lý
                                        thisUser.parent().parent().parent().prev().attr('title', 'Quản lý').text(`Quản lý`);
                                        thisUser.addClass(`_set_as_staff`);
                                        thisUser.removeClass(`_set_as_manage`);
                                        thisUser.text(`Bãi thành hạ phẩm nhân viên`);
                                        Notifications('Tăng cấp thành công');
                                    } else {
                                        ErrorNotifications('Có lỗi rồi kìa !!!', data.errorMsg);
                                    }
                                }
                            });
                        } else {
                            ErrorNotifications('Có lỗi rồi kìa !!!', data.errorMsg);
                        }
                    }
                });
            }
        });
    });

    /**
     * Xuất ra file excel
     */
    $(document).on('click', '._export_to_excel', function () {
        Swal.fire({
            title: `Nhắc nhẹ !!`,
            text: `Bạn có muốn xuất danh sách toàn bộ nhân viên trong phòng này hơm`,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5ada0d',
            cancelButtonColor: '#f31d1d',
            confirmButtonText: 'Ừm',
            cancelButtonText: 'Hong',
        }).then((result) => {
            if (result.value) {
                window.location.replace(`/exportStaffFromDepartment/${departmentId}`);
            }
        });
    });
});