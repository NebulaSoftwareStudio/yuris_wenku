<?php
/**
 * Yuris 文库文章阅读器
 * （ kitoko 版本 ）
 * Created by Hanawa Hinata
 * Edit use PhpStorm
 */



?>



<!-- 诶诶诶诶琪……啊！（HR啦） -->
<!-- 对我们的页面感兴趣嘛？Yuris文库实际上是个开源项目啦~前往Github可以搜索到哦 -->
<!-- 想加入我们吗？注册一个NES Club账户吧，求你啦。 -->
<!-- 看页面很不顺眼？那就加入我们的开发团队吧~ 我们需要几个前端工程师和一个Android开发工程师，有游戏开发经验优先哦~ -->
<!-- 有意向的话欢迎您发送简历到 bainesing@nebula-soft.com ，祝您生活愉快~ -->
<!DOCTYPE html>
<html lang="zh-rcn">
<head>
    <meta charset="UTF-8">

    <!--SEO-->
    <title><?php echo $article_info["title"]; ?> - Kitoko预览版阅读器 - 欢迎访问Yuris文库 | 于繁星之下</title>
    <meta name="Description" content="Yuris文库是一个小说与故事分享网站，站内文章与书籍资源由用户上传。">
    <meta name="Keywords" content="Yuris文库,文库">
    <meta name="author" content="Nebula Software Studio & Yuris Studio">
    <meta name="revised" content="Hanawa Hinata 2019/04/09">
    <meta name="generator" content="PhpStorm">

    <!--视口属性，用于自适应-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="favicon.ico">

    <!-- CSS 外联样式 -->
    <link rel="stylesheet" href="assets/css/kitoko_reader.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">



</head>
<body>

<!--********************************上部菜单*****************************************-->
<div id="top_menu" class="top_menu_hide" style="display: none;">

</div>


<!--********************************主要文章内容*****************************************-->
<div class="main_content" id="main_content">
    <h1><?php echo $article_info["title"]; ?></h1>
    <div class="info_box">
        <div class="hr"></div>
        <small><?php echo $author_info["nick_name"]; ?>于 <?php echo $article_info["time"]; ?> 发表在 <a href="topic.php?cid=<?php echo $article_info["book"]; ?>"><?php echo $book_info["name"]; ?> </a>
        </small>
        <br>
        <small>文章总计 <?php echo $article_content_length; ?> 字，阅读全文大概需要 <?php echo $article_read_time; ?> 分钟。</small>
    </div>
    <div class="article_content">
        <?php echo $article_info["content"]; ?>
    </div>
</div>




<!--********************************下部菜单*****************************************-->
<div id="bottom_menu" class="bottom_menu_hide" style="display: none;">

    <div class="content">
        <i class="fa fa-arrow-left float_left" onclick=""></i>

        <i class="fa fa-arrow-right float_right"></i>
        <div class="progress float_center">
            <div class="control_dot" id="control_dot"></div>
            <div class="progress_bar" id="play-progress" onclick="change_reading_progress(this)"></div>
            <div class="progressed_bar" id="progressed_bar"></div>
        </div>
    </div>

</div>



<!--********************************其他悬浮内容*****************************************-->
<div id="scroll_to_start" class="hide_content" onclick="scroll_to_start()"><i class="fa fa-arrow-right"></i></div>

<div id="pre_loader">
    <div class="content">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>

</div>


<!--********************************旧版本IE兼容性提示*****************************************-->
<!--[if lt IE 9]>
<div class="ie-warning">
    <h1>很抱歉</h1>
    <p>您正在使用 Internet Explorer 的过旧版本，请升级您的浏览器<br/>至下列任一版本后方可访问Yuris文库。</p>
    <div class="ie-warning__inner">
        <ul class="ie-warning__download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="img/browsers/chrome.png" alt="">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="img/browsers/firefox.png" alt="">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="img/browsers/opera.png" alt="">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="img/browsers/safari.png" alt="">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="img/browsers/ie.png" alt="">
                    <div>IE (New)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>为您造成不便，我们深表歉意！</p>
</div>
<![endif]-->

<!-- Javascript -->

<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>

<script src="assets/js/kitoko_reader.js"></script>

</body>
</html>
