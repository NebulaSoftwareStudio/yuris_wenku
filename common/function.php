<?php
/**
 * 主函数库
 * User: abstergo
 * Date: 2019/3/28
 * Time: 21:04
 */

//引入SDK
require "sdk/tencent_sms/index.php";

use Qcloud\Sms\SmsSingleSender;

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

/**
 * 对输入数据进行清洗
 */
function clean_input_string($string)
{
    $keywords = ["and", "select", "update", "chr", "delete", "from", "insert", "mid", "master", "set", "=", "like", "or", ";", "'", '"'];
    //字符串替换
    for ($i = 0; $i < sizeof($keywords); $i++) {
        $string = str_replace($keywords[$i], "*", $string);
    }
    return $string;
}


/**
 * 发送短信（腾讯云）
 */

function send_sms($phone_num, $code, $min, $mode)
{
    // 短信应用 SDK AppID
    $appid = ******;
    // 短信应用 SDK AppKey
    $appkey = "******";
    // 需要发送短信的手机号码
    $phoneNumbers = [$phone_num];
    // 短信模板 ID，需要在短信控制台中申请
    $templateId = ******;  // NOTE: 这里的模板 ID`7839`只是示例，真实的模板 ID 需要在短信控制台中申请
    $smsSign = "******"; // NOTE: 签名参数使用的是`签名内容`，而不是`签名ID`。这里的签名"腾讯云"只是示例，真实的签名需要在短信控制台申请

    if ($mode == 'useful') {
        try {
            $ssender = new SmsSingleSender($appid, $appkey);
            $result = $ssender->send(0, "86", $phoneNumbers[0],
                "【******】您的验证码是: $code", "", "");
            $rsp = json_decode($result,true);
            echo $result;
        } catch (\Exception $e) {
            var_dump($e);
        }
    } else {
        try {
            $ssender = new SmsSingleSender($appid, $appkey);
            $params = [$code, $min];
            $result = $ssender->sendWithParam("86", $phoneNumbers[0], $templateId,
                $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result, true);
            echo $result;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

}


/**
 * 生成验证码字符串
 */
function create_captcha()
{
    $char_len = 6;    //初始化码值的长度
    //生成码值数组,不需要0，避免与字母o冲突
    $char = array_merge(/*range('A','Z'), range('a','z'),*/
        range(1, 9));

    //随机获取$char_len个码值的键
    $rand_keys = array_rand($char, $char_len);

    //判断当码值长度为1时，将其放入数组中
    if ($char_len == 1) {
        $rand_keys = array($rand_keys);
    }

    //打乱随机获取的码值键的数组
    shuffle($rand_keys);

    //根据键获取对应的码值，并拼接成字符串
    $code = '';
    foreach ($rand_keys as $key) {
        $code .= $char[$key];
    }

    return $code;
}

