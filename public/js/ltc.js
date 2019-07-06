$(document).ready(function () {
    // 
    // Hiển thị loading ****
    $(document).ajaxStart(function () {
        console.log('start');
        $('.ltc-loading').css({
            "display": "flex",
        });
    });
    //
    $(document).ajaxStop(function () {
        console.log('stop');
        $('.ltc-loading').css({
            "display": "none",
        });
    });
    // hết ******************
    //
    // chọn tất cả **************
    $(document).on('change', '#checkboxAll', function () {
        console.log(1);
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
});
