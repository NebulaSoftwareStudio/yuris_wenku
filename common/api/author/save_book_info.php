<?php
/**
 * 保存书籍信息
 */

require "../../function.php";

//POST data
$id = $_POST["id"];
$mode = $_POST["mode"];
$image = $_POST["image"];
$classify = $_POST["classify"];
$name = $_POST["name"];
$description = addslashes($_POST["description"]);
//session
session_start();
$user_info = $_SESSION["user_info"];

$echo_array = [];


if($mode == 'update'){
    //原基础更新
    $sql = "update `book_list` set `name` = '$name',`description`='$description',`image`='$image',`classify`='$classify' where `ID` = '$id' ";
    if(update_data($sql)){
        $echo_array["status"] = true;
        $echo_array["info"] = "书籍信息更新成功";
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = "由于数据库连接问题，书籍信息更新失败";
    }
}
else if($mode == 'delete'){
    //先检查权限
    $book_info = select_data("select * from `book_list` where `ID` = '$id'");
    if($book_info["author"] == $user_info["ID"]){
        unlink("../../../".$book_info["cover"]);
        $sql = "delete from `book_list` where `ID` = '$id'";
        if(delete_data($sql)){
            $echo_array["status"] = true;
            $echo_array["info"] = "书籍《 ".$book_info['name']." 》已删除";
        }
        else{
            $echo_array["status"] = false;
            $echo_array["info"] = "由于数据库连接问题，书籍删除失败";
        }
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = "您没有权限进行此项操作";
    }

}
else{
    //新建
    $sql = "INSERT INTO `book_list` 
(`ID`, `name`, `description`, `cover`, `author`, `time`, `classify`, `star`, `updating`, `awards`, `topic`) VALUES 
(NULL, '$name', '$description', '$image', '".$user_info["ID"]."', '".date("Y-m-d H:i:s")."', '$classify', '5.00', '1', '[]', '0')";
    if(insert_data($sql)){
        $echo_array["status"] = true;
        $echo_array["info"] = "书籍《 $name 》已完成新建";
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = "由于数据库连接问题，书籍新建失败";
    }
}


echo json_encode($echo_array);