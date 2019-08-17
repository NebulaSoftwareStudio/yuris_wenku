<?php
/**
 * 保存文章
 */


//id="+id+"&title="+article_title+"&description="+article_description+"&content="+article_content+
//            "&book_id="+article_book_id+"&image="+article_image
require "../../function.php";
session_start();
$user_info = $_SESSION["user_info"];

$id = $_POST["id"];
$article_title = clean_input_string($_POST["title"]);
$article_description = clean_input_string($_POST["description"]);
$article_content = clean_input_string($_POST["content"]);
$book_id = $_POST["book_id"];
$book_info = select_data("select * from `book_list` where `ID` = '$book_id'");
$article_image = $_POST["image"];

$time = date("Y-m-d H:i:s");
$echo_array = [];

//检查是在原文章基础上更新还是新建文章
if($id == ''){
    //新建文章
    $sql = "INSERT INTO `article` 
(`ID`, `title`, `description`, `image`, `time`, `author`, `content`, `classify`, `book`, `view`, `publish`) VALUES 
(NULL, '$article_title', '$article_description', '$article_image', '$time', '".$user_info["ID"]."', '$article_content', '".$book_info["classify"]."', '$book_id', '0', '0')";
    if(insert_data($sql)){
        $echo_array["status"] = true;
        $echo_array["info"] = '新建文章成功';
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = '由于数据库连接问题，文章新建失败。';
    }
}
else{
    //覆盖文章
    $sql = "update `article` set `title`='$article_title',`description`='$article_description',
`content`='$article_content',`image`='$article_image',`book`='$book_id',`classify`='".$book_info["classify"]."' where `ID` = '$id'  ";
    if(update_data($sql)){
        $echo_array["status"] = true;
        $echo_array["info"] = '文章更新成功';
    }
    else{
        $echo_array["status"] = false;
        $echo_array["info"] = '由于数据库连接问题，文章更新失败。';
    }
}


echo json_encode($echo_array);
