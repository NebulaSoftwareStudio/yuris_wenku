<?php
/**
 * 删除文章
 */

require "../../function.php";

$id = $_POST["id"];

session_start();
$user_info = $_SESSION["user_info"];
//获取文章信息
$book_info = select_data("select * from `article` where `ID` = '$id'");

$echo_array = [];


//检查当前登录用户是否有权更改此书籍
if($user_info["ID"] == $book_info["author"]){
    //删除图片
    if(@unlink("../../../".$book_info["image"])){
        //删除文章
        $sql = "delete from `article` where `ID` = '$id'";
        if(update_data($sql)){
            $echo_array["status"] = true;
            $echo_array["info"] = "文章 “".$book_info["title"]."” 已成功删除";
        }
        else{
            $echo_array["status"] = false;
            $echo_array["info"] = "由于数据库连接问题，文章删除失败";
        }
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = "由于图片无法删除，文章删除失败";
    }
}
else{
    $echo_array["status"] = false;
    $echo_array["info"] = "您无权进行本操作";
}


echo json_encode($echo_array);