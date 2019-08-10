<?php
/**
 * 首页索引
 * User: abstergo
 * Date: 2019/3/28
 * Time: 21:05
 */

require "common/function.php";

//引入头部及菜单
require "theme/model/head.html";
require "theme/model/menu.html";
//require "theme/model/theme_demo.html";

//获取专题推荐
$topic_list = select_more_data("select * from `topic` order by `time` desc limit 0,3");
//获取额外内容
for ($i = 0; $i < sizeof($topic_list); $i++) {
    //获取书籍信息
    $topic_list[$i]["book_info"] = select_data("select * from `book_list` where `ID` = '" . $topic_list[$i]["book_id"] . "'");
    //获取作者信息
    $topic_list[$i]["author_info"] = select_data("select * from `user_account` where `ID` = '" . $topic_list[$i]["author_id"] . "'");
}

//计算页数
$page = isset($_GET["page"]) ? $_GET["page"] : 0;
$article_index = $page * 10;

//获取最新文章
$article_list = select_more_data("select * from `article` order by `time` desc limit $article_index,10");
//获取额外内容
for ($i = 0; $i < sizeof($article_list); $i++) {
    //获取所属文集信息
    $article_list[$i]["book_info"] = select_data("select * from `book_list` where `ID` = '" . $article_list[$i]["book"] . "'");
    //获取作者信息
    $article_list[$i]["author_info"] = select_data("select * from `user_account` where `ID` = '" . $article_list[$i]["author"] . "'");
}

//获取热门文章
$hot_article = select_more_data("select * from `article` order by `view` desc limit 0,5");


?>

<section class="section" style="overflow: hidden;">
    <div class="container">


        <!--<header class="section__title">-->
        <!--<h2>这是标题</h2>-->
        <!--<small>这是小标题</small>-->
        <!--</header>-->


        <!-- banner -->
        <link rel="stylesheet" href="assets/css/swiper.min.css">
        <style>
            .swiper-container {
                width: 100%;
                height: 400px;
                /*background: #3F51B5;*/
                margin: -40px auto -40px auto;
            }
            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;
                /* Center slide text vertically */
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
                overflow: hidden;
            }
            .swiper-slide a img {
                height: 400px;
            }
            @media (max-width: 991px){
                .swiper-container {
                    width: 100%;
                    height: 200px;
                    /*background: #3F51B5;*/
                    margin: -40px auto -10px auto;
                }
                .swiper-slide a img {
                    height: 200px;
                }
            }

        </style>
        <div class="index_banner" style="position: relative;">
            <div id="banner" class="swiper-container " >
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <a href="javascript:" rel="6"
                           target="_blank"
                           title="vr">
                            <img src="assets/image/banner/index/wenku_banner1.jpg"
                                 alt="vr">
                        </a>
                    </div>


                    <div class="swiper-slide">
                        <a href="javascript:" rel="6"
                           target="_blank"
                           title="vr">
                            <img src="assets/image/banner/index/wenku_banner2.jpg"
                                 alt="vr">
                        </a>
                    </div>

                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>


            </div>
            <!-- Add Arrows -->
            <div class=" slick-next slick-arrow" style="right: -100px;"></div>
            <div class=" slick-prev slick-arrow" style="left: -100px;"></div>
        </div>


        <!-- Initialize Swiper -->
        <script src="assets/js/swiper.min.js"></script>
        <script>

            var swiper = new Swiper('#banner', {
                slidesPerView: 1,
                spaceBetween: 0,
                autoplay: true,
                // effect: 'coverflow',
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.slick-next',
                    prevEl: '.slick-prev',
                },
            });

        </script>


        <!--推荐文集专题-->

        <!--如果这不是主页,输出栏目标题-->
        <!--如果这个栏目没有内容-->
        <div class="container" style="margin-bottom: 20px">
            <h2>Yuris文库专题文集</h2>
        </div>


        <div class="row listings-grid">
            <?php for ($i = 0; $i < sizeof($topic_list); $i++) { ?>
                <!--第<?php echo $i; ?>个热门-->

                <div class="col-sm-4 col-md-4">
                    <div class="listings-grid__item">
                        <a href="topic.php?cid=<?php echo $topic_list[$i]["book_id"]; ?>">
                            <div class="listings-grid__main">
                                <img src="<?php echo $topic_list[$i]["image"]; ?>"
                                     alt="<?php echo $topic_list[$i]["name"]; ?>">
                                <div class="listings-grid__price">
                                    推荐提交于<?php echo date("Y年m月d日", strtotime($topic_list[$i]["time"])); ?></div>
                            </div>

                            <div class="listings-grid__body">
                                <small><?php echo $topic_list[$i]["author_info"]["nick_name"] ?> 著</small>
                                <h5><?php echo $topic_list[$i]["name"]; ?></h5>
                            </div>

                            <ul class="listings-grid__attrs">
                                <li>
                                    <div class="rmd-rate"
                                         data-rate-value="<?php echo $topic_list[$i]["book_info"]["star"] ?>"
                                         data-rate-readonly="true"></div>
                                </li>
                                <li><?php echo $topic_list[$i]["book_info"]["star"] ?>分</li>
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
                    <h2> Yuris文库近期发表</h2>
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

                            <div class="card__header">
                                <h2 style="font-size: 25px;"><?php echo $article_list[$i]["title"] ?></h2>
                                <small><?php echo $article_list[$i]["author_info"]["nick_name"] ?>
                                    于<?php echo date("Y年m月d日", strtotime($article_list[$i]["time"])); ?>
                                    发表在《<?php echo $article_list[$i]["book_info"]["name"]; ?>》
                                </small>
                            </div>
                            <div class="card__body">
                                <p style="color: #353535;"><?php echo $article_list[$i]["description"] ?></p>
                                <div class="blog-more">
                                    阅读更多...
                                </div>
                            </div>
                        </article>
                    </a>
                <?php } ?>

                <!--使用PHP动态输出底部页码-->

                <nav class="text-center">
                    <ul class="pagination">
                        <li><a>始</a></li>
                        <li><a><i class="zmdi zmdi-chevron-left"></i></a></li>
                        <li class='active'><a href="?page=1">1</a></li>
                        <li><a href="?page=2">2</a></li>
                        <li class="disabled"><a>···</a></li>
                        <li><a href="?page=4">5</a></li>
                        <li><a href="?page=2" aria-label="Previous"><i class="zmdi zmdi-chevron-right"></i></a>
                        </li>
                        <li><a href="?page=4">终</a></li>
                    </ul>
                </nav>


            </div>


            <!--********************************右侧栏*****************************************-->
            <aside class="col-md-4 col-sm-5 hidden-xs">

                <div class="container" style="margin-bottom: 20px;width: 100%;">
                    <h2>&nbsp;</h2>
                </div>

                <!--本分类中的栏目-->
                <div class="card tags-list">
                    <div class="card__header">
                        <h2>本分类中的栏目</h2>
                        <small>本分类有以下几个栏目</small>
                    </div>
                    <div class="card__body">
                        <!--动态输出-->
                        <a href="list.php?cid=1" class="tags-list__item" title="小说作品"> # 小说作品</a>
                        <a href="list.php?cid=2" class="tags-list__item" title="文档"> # 文档</a>
                        <a href="list.php?cid=4" class="tags-list__item" title="Yuris月刊"> # Yuris月刊</a>
                        <a href="list.php?cid=21" class="tags-list__item" title="公告"> # 公告</a>
                        <a href="list.php?cid=25" class="tags-list__item" title="专题"> # 专题</a>
                        <a href="list.php?cid=32" class="tags-list__item" title="讨论版"> # 讨论版</a>
                        <!--动态输出结束-->
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



