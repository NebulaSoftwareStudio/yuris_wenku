<?php
/**
 * 上传文章内图片
 */

session_start();
$user_account = $_SESSION["user_info"]["name"];
//生成时间戳，防止同名图片被覆盖
$time = time();

//设置目录
$dir = iconv("UTF-8", "GBK", "../../../upload/images/content/$user_account/");
//检查目录是否存在，不存在则创建目录
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

//检查图片是否上传成功
if ($_FILES["file"]["error"] > 0) {
    echo '{"status": "error","msg":"文件服务器错误'.json_encode($_FILES["file"]).'"}';
} else {
    if(isset($_FILES["file"]["tmp_name"])&&$_FILES["file"]["tmp_name"]!=''){
        //获取文件后缀名及文件MIME类型
        $type = strrchr($_FILES["file"]["name"], '.');
        $mime = $_FILES["file"]["type"];
        //获取文件大小
        $file_size = $_FILES['file']['size'];
        $file_size = round($file_size/1048576,2)."Mb";
        //保存文件到云端
        move_uploaded_file($_FILES["file"]["tmp_name"], "../../../upload/images/content/$user_account/".$time.$type);
        $url = "upload/images/content/$user_account/".$time.$type;
        //获取文件原始类型
        $type = str_replace(".","",$type);
        echo $url;
    }
    else{
        echo '上传失败。';
    }
}
