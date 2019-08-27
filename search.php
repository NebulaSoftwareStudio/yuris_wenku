<?php
/**
 * 检索功能
 */

require "common/function.php";

//获取关键词
$keywords_string = '';
if(isset($_GET["d_s"])&&$_GET["d_s"] != ''){
    $keywords_string = $_GET["d_s"];
}
else if(isset($_GET["m_s"])&&$_GET["m_s"] != ''){
    $keywords_string = $_GET["m_s"];
}

if($keywords_string!=''){
    //分词
    $keywords = explode(" ",$keywords_string);
}

//组合搜索SQL语句
$search_book_sql = "select * from `book_list` where ";
for($i=0;$i<sizeof($keywords);$i++){
    $search_book_sql .= "`name` like '%".$keywords[$i]."%' and ";
}
$search_book_sql .= " `publish` = '1' order by `time` desc";


$search_article_sql = "select * from `article` where ";
for($i=0;$i<sizeof($keywords);$i++){
    $search_article_sql .= "`title` like '%".$keywords[$i]."%' and ";
}
$search_article_sql .= "`publish` = '1' order by `time` desc";

//echo $search_article_sql;
//echo $search_book_sql;

$book_list = @select_more_data($search_book_sql);
//获取额外内容
for ($i = 0; $i < sizeof($book_list); $i++) {
    //获取书籍信息
    $book_list[$i]["book_info"] = select_data("select * from `book_list` where `ID` = '" . $book_list[$i]["ID"] . "'");
    //获取作者信息
    $book_list[$i]["author_info"] = select_data("select * from `user_account` where `ID` = '" . $book_list[$i]["author"] . "'");
    //获取该文集的最新更新文章的更新时间
    $book_list[$i]["update_time"] = select_data("select `time` from `article` where `book` = '" . $book_list[$i]["ID"] . "' and `publish` = 1 order by `time` desc")["time"];
}

$article_list = @select_more_data($search_article_sql);
//获取额外内容
for ($i = 0; $i < sizeof($article_list); $i++) {
    //获取所属文集信息
    $article_list[$i]["book_info"] = select_data("select * from `book_list` where `ID` = '" . $article_list[$i]["book"] . "'");
    //获取作者信息
    $article_list[$i]["author_info"] = select_data("select * from `user_account` where `ID` = '" . $article_list[$i]["author"] . "'");
}

require "theme/model/head.html";
require "theme/model/menu.html";

?>

    <section class="section" style="overflow: hidden;">
        <div class="container">

            <div class="container" style="margin-bottom: 20px">
                <h2>"<?php echo $keywords_string; ?>" 的书籍搜索结果</h2>
            </div>


            <div class="row listings-grid">
                <?php for ($i = 0; $i < sizeof($book_list); $i++) { ?>
                    <!--第<?php echo $i; ?>个热门-->

                    <div class="col-sm-4 col-md-4">
                        <div class="listings-grid__item">
                            <a href="topic.php?cid=<?php echo $book_list[$i]["ID"]; ?>">
                                <div class="listings-grid__main">
                                    <img src="<?php echo $book_list[$i]["cover"]; ?>"
                                         alt="<?php echo $book_list[$i]["name"]; ?>">
                                    <div class="listings-grid__price">
                                        最近更新于<?php echo date("Y年m月d日", strtotime($book_list[$i]["update_time"])); ?></div>
                                </div>

                                <div class="listings-grid__body">
                                    <small><?php echo $book_list[$i]["author_info"]["nick_name"] ?> 著</small>
                                    <h5><?php echo $book_list[$i]["name"]; ?></h5>
                                </div>

                                <ul class="listings-grid__attrs">
                                    <li>
                                        <div class="rmd-rate"
                                             data-rate-value="<?php echo $book_list[$i]["book_info"]["star"] ?>"
                                             data-rate-readonly="true"></div>
                                    </li>
                                    <li><?php echo $book_list[$i]["book_info"]["star"] ?>分</li>
                                    <!--<li><i class="listings-grid__icon listings-grid__icon&#45;&#45;parking"></i> 02</li>-->
                                </ul>
                            </a>

                            <div class="actions listings-grid__favorite">
                                <div class="actions__toggle" title="收藏">
                                    <input type="checkbox">
                                    <i class="zmdi zmdi-star-outline"></i>
                                    <i class="zmdi zmdi-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>


            <!--********************************输出主要内容*****************************************-->

            <div class="row">
                <div class="col-md-8 col-sm-7">

                    <div class="container" style="margin-bottom: 20px">
                        <h2>"<?php echo $keywords_string; ?>" 的文章搜索结果</h2>
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



                </div>


                <!--********************************右侧栏*****************************************-->
                <aside class="col-md-4 col-sm-5">
                    <div class="container" style="margin-bottom: 20px;width: 100%;">
                        <h2>&nbsp;</h2>
                    </div>

                    <?php require "theme/model/https.php"; ?>

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