<?php
/**
 * 主函数库
 * User: abstergo
 * Date: 2019/3/28
 * Time: 21:04
 */


/**
 * get database connect function
 */
function getConnect()
{
    $connect = mysqli_connect('localhost', 'root', '******') or mysqli_error();
    mysqli_set_charset($connect, 'utf8');
    $db = mysqli_select_db($connect, 'wenku') or exit("数据库在连接时出现问题，可能是设定的数据库不存在。");
    return $connect;
}

/**
 * 选择单条数据
 */
function select_data($sql)
{
    //获取数据库连接
    $conn = getConnect();
    //提交查询，并接受返回值
    $link = mysqli_query($conn, $sql);
    $res = mysqli_fetch_array($link);
    return $res;
}

/**
 * 选择多条数据
 */
function select_more_data($sql)
{
    //获取数据库连接
    $conn = getConnect();
    //提交查询，并接受返回值
    $link = mysqli_query($conn, $sql);
    while ($rs = mysqli_fetch_array($link)) {
        $res[] = $rs;
    }
    return $res;
}


/**
 * 更新数据
 */
function update_data($sql)
{
    $conn = getConnect();
    $rs = mysqli_query($conn, $sql);
    return $rs;
}

/**
 * 插入数据
 */
function insert_data($sql)
{
    $conn = getConnect();
    $rs = mysqli_query($conn, $sql);
    return $rs;
}


/**
 * 删除数据
 */
function delete_data($sql)
{
    $conn = getConnect();
    $rs = mysqli_query($conn, $sql);
    return $rs;
}

