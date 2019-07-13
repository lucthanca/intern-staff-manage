<?php

$connect = mysqli_connect('localhost', 'root', 'vadu@ltc', 'staff_manage');
if (!$connect) {
    echo 'Server disconnected';
    die();
}

$firstName = array("Lạc", "Độc Cô", "Bạch", "Tề", "Tử", "Cố", "Sở", "Hạ", "Lục", "Hàn", "Triệu", "Lý", "Hoàng", "Liễu", "Mạc");
$middleName = array("Vi", "Kỳ", "Thiên", "Thần", "Nhược", "Y", "Ngưng", "Vô", "Tịnh", "Tử", "Tiểu");
$lastName = array("Nhi", "Dương", "Tuyết", "Nguyệt", "Nguyện", "Ninh", "Bình", "Minh", "Doanh", "Khả", "Khuê", "Ngôn", "Ca", "Tâm", "Ngạn", "Phong", "Đình", "Viễn", "Dung", "Như", "Huệ", "Diệp", "Giai", "Phi", "Vân", "Ly", "Tịch", "Quân", "Cảnh", "Du", "Giang", "Phàm");

$diaChi = array("An Giang", "Kon Tum", "Bà Rịa – Vũng Tàu", "Lai Châu", "Bắc Giang", "Lâm Đồng", "Bắc Kạn", "Lạng Sơn", "Bạc Liêu", "Lào Cai", "Bắc Ninh", "Long An", "Bến Tre", "Nam Định", "Bình Định", "Nghệ An", "Bình Dương", "Ninh Bình", "Bình Phước", "Ninh Thuận", "Bình Thuận", "Phú Thọ", "Cà Mau", "Phú Yên", "Cần Thơ", "Quảng Bình", "Cao Bằng", "Quảng Nam", "Đà Nẵng", "Quảng Ngãi", "Đắk Lắk", "Quảng Ninh", "Đắk Nông", "Quảng Trị", "Điện Biên", "Sóc Trăng", "Đồng Nai", "Sơn La", "Đồng Tháp", "Tây Ninh", "Gia Lai", "Thái Bình", "Hà Giang", "Thái Nguyên", "Hà Nam", "Thanh Hóa", "Hà Nội", "Thừa Thiên Huế", "Hà Tĩnh", "Tiền Giang", "Hải Dương", "TP Hồ Chí Minh", "Hải Phòng", "Trà Vinh", "Hậu Giang", "Tuyên Quang", "Hòa Bình", "Vĩnh Long", "Hưng Yên", "Vĩnh Phúc", "Khánh Hòa", "Yên Bái", "Kiên Giang");

function getPhoneNum()
{
    return rand(0, 9);
}

function convert_vi_to_en($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
    return $str;
}
for ($i = 1; $i <= 1000; $i++) {

    $rand_fn = array_rand($firstName, 1);
    $rand_mn = array_rand($middleName, 1);
    $rand_ln = array_rand($lastName, 1);

    $username = strtolower(convert_vi_to_en($lastName[$rand_ln])) . "." . strtolower(convert_vi_to_en($firstName[$rand_fn])) . strtolower(convert_vi_to_en($middleName[$rand_mn]));
    $email = strtolower(convert_vi_to_en($lastName[$rand_ln])) . "." . strtolower(convert_vi_to_en($firstName[$rand_fn])) . strtolower(convert_vi_to_en($middleName[$rand_mn])) . "@vadu.com";
    // $email = strtolower(convert_vi_to_en($lastName[$rand_ln])) . "." . substr(strtolower(convert_vi_to_en($firstName[$rand_fn])), 0, 1) . substr(strtolower(convert_vi_to_en($middleName[$rand_mn])), 0, 1) . "@vadu.com";
    $password = password_hash('1', PASSWORD_BCRYPT);
    $name = $firstName[$rand_fn] . " " . $middleName[$rand_mn] . " " . $lastName[$rand_ln];
    $city = $diaChi[array_rand($diaChi, 1)];
    $phone = '0' . getPhoneNum() . getPhoneNum() . getPhoneNum() . getPhoneNum() . getPhoneNum() . getPhoneNum() . getPhoneNum() . getPhoneNum() . getPhoneNum();

    $insertQuery = "INSERT INTO users (`id`, `username`, `email`, `password`, `logged_flag`, `role`, `name`, `birthday`, `address`, `city`, `image`, `phone`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '$username', '$email', '$password', '0', '0', '$name', NULL, NULL, '$city', NULL, '$phone', NULL, NULL, NULL, NULL)";
    mysqli_query($connect, "set NAMES 'utf8'");
    $result =  mysqli_query($connect, $insertQuery);
    if ($result) {
        echo 'thành công' . ' record ' . $i . '<br />';
    } else {
        echo 'thất bại record' . $name . '-' . $email . '<br />';
    }
}
