<?php
/**
 * 用户注册
 */

require "../../function.php";
session_start();

//echo json_encode($_POST);
$code = isset($_SESSION["captcha_code"])?$_SESSION["captcha_code"]:' ';
$user_name = $_POST["user_name"];
$email = $_POST["email"];
$password = @hash('sha256',$_POST["password"],false);
$auth_code = @$_POST["captcha"];

$echo_array = [];


//先检查code是否正确
if($code == $auth_code){
    //检查用户名是否存在
    $user_info = @select_more_data("select * from `user_account` where `name` = '$user_name'");
    if(sizeof($user_info)>0){
        $echo_array["status"] = false;
        $echo_array["info"] = '很抱歉，该用户名已被占用';
    }
    else{
        $sql = "INSERT INTO `user_account` 
(`ID`, `name`, `icon`, `time`, `nick_name`, `sign`, `password`, `identification`, `identification_info`, `description`, `pro`, `twitter`, `email`) VALUES 
(NULL, '$user_name', 'assets/image/icon/user/default.jpg', '".date("Y-m-d H:i:s")."', '$user_name', 'TA什么都没说。', '$password', '0', '', '', '0', '', '$email')";
        if(insert_data($sql)){
            $echo_array["status"] = true;
            $echo_array["info"] = $user_name.'注册成功。请刷新页面后登录。';
        }
        else{
            $echo_array["status"] = false;
            $echo_array["info"] = '验证码不正确';
        }
    }
}
else{
    $echo_array["status"] = false;
    $echo_array["info"] = '验证码不正确';
    unset($_SESSION["captcha_code"]);
}


echo json_encode($echo_array);