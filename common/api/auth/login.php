<?php
/**
 * 登录
 */

require "../../function.php";
session_start();

//echo json_encode($_POST);
$code = isset($_SESSION["captcha_code"])?$_SESSION["captcha_code"]:' ';
$user_name = @clean_input_string($_POST["user_name"]);
$password = @hash('sha256',$_POST["password"],false);
$auth_code = @$_POST["captcha"];

$echo_array = [];


//先检查code是否正确
if($code == $auth_code){
    //检查用户名是否存在
    $user_info = @select_more_data("select * from `user_account` where `name` = '$user_name'");
    if(sizeof($user_info)>0){
        //检查密码
        if($user_info[0]["password"] == $password){
            //使用SESSION记录登录状态
            $_SESSION["user_info"] = $user_info[0];
            $_SESSION["sign_in_status"] = true;
            $echo_array["status"] = true;
            $echo_array["info"] = $user_info[0]["nick_name"].'，欢迎回来';
        }
        else{
            $echo_array["status"] = false;
            $echo_array["info"] = '用户名与密码不匹配';
        }
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = '用户不存在，请注册';
    }
}
else{
    $echo_array["status"] = false;
    $echo_array["info"] = '验证码不正确';
    unset($_SESSION["captcha_code"]);
}


echo json_encode($echo_array);