<?php
/**
 * 根据ID获取 book info
 */

require "../../function.php";

$id = $_POST["id"];
$book_info =  select_data("select * from `book_list` where `ID` = '$id'");
$book_info["classify_name"] = select_data("select * from `book_classify` where `ID` = '".$book_info["classify"]."'")["name"];
echo json_encode($book_info);