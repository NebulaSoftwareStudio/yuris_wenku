<?php
/**
 * 发送短信验证码
 */

require "../../function.php";
$phone = isset($_GET["phone"])?$_GET["phone"]:'';

//生成验证码
$code = create_captcha();
send_sms($phone,$code,2,'');

