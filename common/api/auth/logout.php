<?php
/**
 * 登出
 */

session_start();

unset($_SESSION["user_info"]);
unset($_SESSION["sign_in_status"]);

echo "success";