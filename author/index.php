<?php
/**
 * 控制台
 */

require "../common/function.php";

session_start();



//检查是否登录，没有登录就跳转到登录/注册页面
if(isset($_SESSION["sign_in_status"])){
    $user_info = $_SESSION["user_info"];
    if(isset($user_info["locked"])&&$user_info["locked"]===true){
        //锁屏状态
        require "theme/model/lock_screen.php";
    }
    else{
        //已登录，检查目前在哪个功能页面
        $pid = isset($_GET["pid"])?$_GET["pid"]:0;
        switch ($pid){
            case 0:$page_title = '主页';break;
            case 1:$page_title = '书籍管理-内容管理';break;
            case 2:$page_title = '文章管理-内容管理';break;
            case 3:$page_title = '新建或编辑文章-内容管理';break;
            case 4:$page_title = '站内信';break;
            case 5:$page_title = '基础资料与公开设置-个人资料';break;
            case 6:$page_title = '账户绑定';break;
            case 7:$page_title = '密码';break;
            case 8:$page_title = '财务管理';break;
            default:$page_title = '主页';
        }
        require "theme/model/head.html";
        require "theme/model/menu.html";

        switch ($pid){
            case 0:require "theme/content/index.php";break;
            default:require "theme/content/pid$pid.php";
        }


        require "theme/model/dashboard_footer.html";
        require "theme/model/foot.html";
    }
}
else{
    echo '<script>window.location.assign("../login.php")</script>';
}