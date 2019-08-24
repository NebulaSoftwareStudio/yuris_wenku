<?php
/**
 * 列表
 */

require "common/function.php";

require "theme/model/head.html";
require "theme/model/menu.html";

$classify = $_GET["cid"];
//获取 page 信息
$page = isset($_GET["page"])?$_GET["page"]:0;
$start = $page * 10;

//获取 classify 信息
$classify_info = select_data("select * from `book_classify` where `ID` = '$classify'");

//获取文章
$article_list = @select_more_data("select * from `article` where `publish` = 1 and `classify` = '$classify' order by `time` desc limit $start,10");
//获取额外内容
for ($i = 0; $i < sizeof($article_list); $i++) {
    //获取所属文集信息
    $article_list[$i]["book_info"] = select_data("select * from `book_list` where `ID` = '" . $article_list[$i]["book"] . "'");
    //获取作者信息
    $article_list[$i]["author_info"] = select_data("select * from `user_account` where `ID` = '" . $article_list[$i]["author"] . "'");
}


//获取该分类文章总数
$article_count = select_data("select count(*) as `count` from `article` where `publish` = 1 and `classify` = '$classify'")["count"];
$book_count = select_data("select count(*) as `count` from `book_list` where `classify` = '$classify'")["count"];

//计算页码
$max_page = $article_count < 10 ? 0 : (int)($article_count / 10);

//获取热门文章
$hot_article = select_more_data("select * from `article` where `publish` = 1 order by `view` desc limit 0,5");



?>

<section class="section" style="overflow: hidden;">
    <div class="container">



        <!--********************************输出主要内容*****************************************-->

        <div class="row">
            <div class="col-md-8 col-sm-7">

                <div class="container" style="margin-bottom: 20px">
                    <h2>您正在浏览分类 “<?php echo $classify_info["name"]; ?>” 下的章节</h2>
                </div>

                <!-- 每页10条文章 -->
                <?php for ($i = 0; $i < sizeof($article_list); $i++) { ?>
                    <a href="article.php?id=<?php echo $article_list[$i]["ID"] ?>">
                        <article class="card">
                            <?php if ($article_list[$i]["image"] != '') { ?>
                                <!-- 文章图片 -->
                                <div class="card__img" style="max-height: 300px;overflow: hidden;">
                                    <img src="<?php echo $article_list[$i]["image"] ?>"
                                         alt="<?php echo $article_list[$i]["title"] ?>">
                                </div>
                            <?php } ?>

                            <div class="article_header">
                                <h2><?php echo $article_list[$i]["title"] ?></h2>
                            </div>
                            <div class="article_body">
                                <p><?php echo $article_list[$i]["description"] ?></p>
                                <button class="btn btn-sm btn-primary">阅读更多&nbsp;&nbsp;<i class="zmdi zmdi-open-in-new"></i></button>
                            </div>
                            <div class="article_info">
                                <p>作者：<?php echo $article_list[$i]["author_info"]["nick_name"] ?></p>
                                <p>发表于：<?php echo date("Y年m月d日", strtotime($article_list[$i]["time"])); ?></p>
                                <p>该章收录于《<?php echo $article_list[$i]["book_info"]["name"]; ?>》篇目</p>
                            </div>
                        </article>
                    </a>
                <?php } ?>

                <!--使用PHP动态输出底部页码-->

                <nav class="text-center">
                    <ul class="pagination">
                        <li><a href="./">始</a></li>
                        <?php if ($page > 0) { ?>
                            <li>
                                <a href="?page=<?php echo $page-1; ?>" aria-label="Previous">
                                    <i class="zmdi zmdi-chevron-right"></i>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="disabled">
                                <a aria-label="Previous">
                                    <i class="zmdi zmdi-chevron-left"></i>
                                </a>
                            </li>
                        <?php } ?>
                        <?php for ($i = 0; $i < $max_page + 1; $i++) { ?>
                            <li class='<?php echo ($page == $i) ? "active" : "" ?>'>
                                <a href="?page=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
                            </li>
                        <?php } ?>
                        <!--                        <li class="disabled"><a>···</a></li>-->
                        <?php if ($page + 1 <= $max_page) { ?>
                            <li>
                                <a href="?page=<?php echo $page+1; ?>" aria-label="Previous">
                                    <i class="zmdi zmdi-chevron-right"></i>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="disabled">
                                <a aria-label="Previous">
                                    <i class="zmdi zmdi-chevron-right"></i>
                                </a>
                            </li>
                        <?php } ?>
                        <li><a href="?page=<?php echo $max_page; ?>">终</a></li>
                    </ul>
                </nav>


            </div>


            <!--********************************右侧栏*****************************************-->
            <aside class="col-md-4 col-sm-5 hidden-xs">
                <div class="container" style="margin-bottom: 20px;width: 100%;">
                    <h2>&nbsp;</h2>
                </div>

                <?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "on") { ?>
                    <div class="card subscribe mdc-bg-green-600 text-left">
                        <h2 class="text-left">您目前正使用HTTPS加密方式访问Yuris文库</h2>
                        <small class="text-left">如非必要，请尽量使用HTTPS加密方式访问Yuris文库。使用未加密的方式进行访问将增加页面被篡改的可能。</small>
                    </div>
                <?php } else { ?>
                    <div class="card subscribe mdc-bg-red-600">
                        <h2 class="text-left">您未使用HTTPS方式访问Yuris文库</h2>
                        <small class="text-left">如非必要，请尽量使用HTTPS加密方式访问Yuris文库。使用未加密的方式进行访问将增加页面被篡改的可能。</small>
                    </div>
                <?php } ?>


                <!--文库统计-->
                <div class="card tags-list">
                    <div class="card__header">
                        <h2>文库统计</h2>
                        <small>分类 <?php echo $classify_info["name"]; ?> 发表内容总计</small>
                    </div>
                    <div class="card__body">
                        <div>文章发表总计：<?php echo $article_count; ?>篇目</div>
                        <div>书籍创建总计：<?php echo $book_count; ?>条目</div>
                    </div>
                </div>


                <!--热门文章-->
                <div class="card">
                    <div class="card__header">
                        <h2>热门文章</h2>
                        <small>近期在Yuris文库中的热门内容</small>
                    </div>

                    <div class="list-group">

                        <?php for ($i = 0; $i < sizeof($hot_article); $i++) { ?>
                            <a href="article.php?id=<?php echo $hot_article[$i]["ID"] ?>"
                               class="list-group-item media">
                                <div class="pull-left" style="max-height: 45px;overflow: hidden;">
                                    <img src="<?php echo $hot_article[$i]["image"] ?>"
                                         alt="<?php echo $hot_article[$i]["title"] ?>" class="list-group__img"
                                         width="65">
                                </div>
                                <div class="media-body list-group__text">
                                    <strong><?php echo $hot_article[$i]["title"] ?></strong>
                                    <small><?php echo $hot_article[$i]["description"] ?></small>
                                </div>
                            </a>
                        <?php } ?>

                        <div class="p-10"></div>
                    </div>
                </div>


                <?php if (!isset($_COOKIE["use_cookies"])) {
                    require "theme/model/cookie.html";
                } ?>


            </aside>


        </div>



    </div>
</section>

<?php
require "theme/model/footer.html";

?>


