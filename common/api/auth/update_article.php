<?php
/**
 * 更新文章
 */

require "../../function.php";

$id = $_POST["id"];
$item = $_POST["item"];
$value = $_POST["value"];

session_start();
$user_info = $_SESSION["user_info"];

$echo_array = [];

//获取文章信息
$book_info = select_data("select * from `book_list` where `ID` = '$id'");
//检查当前登录用户是否有权更改此书籍
if($user_info["ID"] == $book_info["author"]){
    //更新文章
    $value = $value=='false'?0:1;
    $sql = "update `book_list` set `$item`='$value' where `ID` = '$id'";
    if(update_data($sql)){
        $echo_array["status"] = true;
        $echo_array["info"] = "书籍更新成功！";
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = "由于数据库连接问题，书籍更新失败";
    }
}
else{
    $echo_array["status"] = false;
    $echo_array["info"] = "您无权进行本操作";
}


echo json_encode($echo_array);