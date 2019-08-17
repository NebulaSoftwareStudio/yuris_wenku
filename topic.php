<?php
/**
 * 专题页
 * User: Hanawa Hinata
 * Date: 2019/6/13
 * Time: 16:21
 */

require "common/function.php";


if (isset($_GET["cid"])) {
    //获取专题（书籍）信息
    $id = $_GET["cid"];
    $book_info = select_data("select * from `book_list` where `ID` = '$id'");
    $book_info["author_info"] = select_data("select * from `user_account` where `ID` = '" . $book_info["author"] . "'");

    //计算页数
    $page = isset($_GET["page"]) ? $_GET["page"] : 0;
    $article_index = $page * 10;
    //获取书籍下的文章
    $article_list = @select_more_data("select * from `article` where `book` = '" . $book_info["ID"] . "' and `publish` = 1 order by `time` desc limit $article_index,10");
    //获取额外内容
    for ($i = 0; $i < sizeof($article_list); $i++) {
        //获取所属文集信息
        $article_list[$i]["book_info"] = $book_info;
        //获取作者信息
        $article_list[$i]["author_info"] = select_data("select * from `user_account` where `ID` = '" . $article_list[$i]["author"] . "'");
    }

    //获取评论
    $review_list = @select_more_data("select * from `review` where `book_id` = '$id' order by `time` desc limit 0,2; ");
    //获取额外内容
    for ($i = 0; $i < sizeof($review_list); $i++) {
        //获取用户信息
        $review_list[$i]["user_info"] = select_data("select * from `user_account` where `ID` = '" . $review_list[$i]["uid"] . "'");
    }

    //获取热门文章
    $hot_article = select_more_data("select * from `article` where `publish` = 1 order by `view` desc limit 0,5");

    if (!isset($_GET["mode"]) || $_GET["mode"] != 'list') {
        $page_title = '专题：《' . $book_info["name"] . '》 - ';
        //引入头部及菜单
        require "theme/model/head.html";
        require "theme/model/menu.html";


        ?>

        <section class="section">
            <div class="container">


                <div class="row">
                    <div class="col-md-8 col-sm-7">


                        <!--                        <h1 style="margin-bottom: 20px">-->
                        <?php //echo $book_info["name"] ?><!--</h1>-->


                        <div class="card mortgage__item"
                             style="background-image: url('<?php echo $book_info["cover"] ?>'); background-position: bottom; background-size: cover;  background-color: black; color:#ffffff;">
                            <div class="mortgage__header media" style="background-color: rgba(0, 0, 0, 0.4);">
                                <div class="pull-left mortgage__logo"
                                     style="background-image: url('<?php echo $book_info["cover"] ?>'); background-position: bottom; background-size: cover;  background-color: black; color:#ffffff;">
                                    <div style="width: 80px;height: 80px;"></div>
                                </div>
                                <div class="media-body mortgage__name">
                                    <strong style="color:#ffffff"><?php echo $book_info["name"] ?></strong>
                                    <small><?php echo $book_info["author_info"]["nick_name"] ?>
                                        &nbsp;&nbsp;著，<?php echo ($book_info["updating"] == 1) ? '连载中' : '已完结' ?></small>
                                    <div class="rmd-rate" data-rate-value="<?php echo $book_info["star"] ?>"
                                         data-rate-readonly="true"></div>
                                    <?php echo $book_info["star"] ?>分，<?php
                                    $book_star = (float)$book_info["star"];
                                    if ($book_star <= 1) {
                                        echo "差评如潮";
                                    } else if ($book_star <= 2) {
                                        echo "多数差评";
                                    } else if ($book_star <= 3) {
                                        echo "褒贬不一";
                                    } else if ($book_star <= 4) {
                                        echo "多数好评";
                                    } else if ($book_star <= 5) {
                                        echo "好评如潮";
                                    }
                                    ?>

                                    <div class="actions hidden-xs">
                                        <div class="actions__toggle" title="收藏">
                                            <input type="checkbox">
                                            <i class="zmdi zmdi-star-outline"></i>
                                            <i class="zmdi zmdi-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mortgage__body" style="background-color: rgba(0, 0, 0, 0.4);">
                                <small>（该专题创建于<?php echo date("Y年m月d日 H:i", strtotime($book_info["time"])); ?>）<br/><br/><br/></small>
                                <?php echo $book_info["description"] ?>
                            </div>
                        </div>
                        <div class="container" style="margin-bottom: 30px">
                            <h2>《<?php echo $book_info["name"] ?>》近期更新</h2>
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


                        <nav class="text-center">
                            <ul class="pagination">
                                <li><a>首</a></li>
                                <li><a><i class="zmdi zmdi-chevron-left"></i></a></li>
                                <li class='active'><a href="?cid=31&page=1">1</a></li>
                                <li><a aria-label="Previous"><i class="zmdi zmdi-chevron-right"></i></a></li>
                                <li><a>终</a></li>
                            </ul>
                        </nav>
                    </div>

                    <aside class="col-md-4 col-sm-5 hidden-xs">


                        <div class="card">
                            <div class="card__header">
                                <h2>书籍评论</h2>
                                <small>看看大家对这本书有什么评价</small>
                            </div>
                            <div class="list-group">
                                <?php if (sizeof($review_list) > 0) { ?>
                                    <?php for ($i = 0; $i < sizeof($review_list); $i++) { ?>
                                        <a class="list-group-item media" href="javascript:">
                                            <div class="pull-left">
                                                <img src="<?php echo $review_list[$i]["user_info"]["icon"]; ?>"
                                                     alt="<?php echo $review_list[$i]["user_info"]["nick_name"]; ?>"
                                                     class="list-group__img img-circle" width="65" height="65">
                                            </div>
                                            <div class="media-body list-group__text">
                                                <strong><?php echo $review_list[$i]["user_info"]["nick_name"]; ?></strong>
                                                <div class="rmd-rate"
                                                     data-rate-value="<?php echo $review_list[$i]["star"]; ?>"
                                                     data-rate-readonly="true"></div>
                                                <p class="list-group__text"><?php echo $review_list[$i]["content"]; ?></p>
                                            </div>
                                        </a>
                                    <?php } ?>
                                <?php } else { ?>

                                    <div class="card__body">
                                        <small class="text-muted">该作品暂时没有任何可供显示的评价</small>
                                    </div>

                                <?php } ?>


                                <a href="topic.php?cid=<?php echo $_GET["cid"]; ?>&mode=list"
                                   class="view-more">查看所有评价</a>
                            </div>
                        </div>


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
    } else {

        //评论模式
        //获取所有评论
        $review_list = select_more_data("select * from `review` where `book_id` = '" . $_GET["cid"] . "' order by `time` desc");
        for ($i = 0; $i < sizeof($review_list); $i++) {
            //获取用户信息
            $review_list[$i]["user_info"] = select_data("select * from `user_account` where `ID` = '" . $review_list[$i]["uid"] . "'");
        }


        $page_title = "评价 - " . $book_info["name"] . " - ";
        //引入头部及菜单
        require "theme/model/head.html";
        require "theme/model/menu.html";
        ?>

        <section class="section">
            <div class="container">

                <div class="row">

                    <!-- 发表评价 -->
                    <div class="card card--dark mdc-bg-orange-300" id="review_box" style="overflow: hidden;">
                        <div class="card__header">
                            <h2>发表您的评价</h2>
                            <small>写下您的意见、看法，让所有人知道您目前的想法。</small>
                        </div>

                        <form class="card__body">
                            <div class="row">
                                <div class="rmd-rate"
                                     data-rate-value="3.50"
                                     data-rate-readonly="true">

                                </div>
                                <i class="zmdi zmdi-star-outline"></i>
                                <i class="zmdi zmdi-star"></i>
                            </div>
                            <div class="form-group form-group--light form-group--float">
                                <textarea class="textarea-autoheight form-control"
                                          placeholder="写下评论...(限制500字)" maxlength="500"></textarea>
                                <i class="form-group__bar"></i>
                            </div>

                            <button class="btn btn-default btn-sm m-t-15 mdc-text-orange-700">发表评价</button>
                        </form>
                    </div>
                </div>

                <script>
                    document.getElementById("review_box").style.height = 0;
                </script>

                <!-- Comment Lists -->
                <div class="card list-group blog-comment">
                    <div class="list-group__header clearfix">
                        <span class="pull-left">共<?php echo sizeof($review_list); ?>条评价</span>

                        <a href="javascript:show_review_box__book()"
                           class="pull-right">留下评价</a>
                    </div>


                    <?php for ($i = 0; $i < sizeof($review_list); $i++) { ?>
                        <div class="list-group-item media">
                            <a class="pull-left">
                                <img src="<?php echo $review_list[$i]["user_info"]["icon"] ?>"
                                     class="list-group__img img-circle" width="50"
                                     height="50" alt="">
                                <div class="blog-comment__up"><span style="background-color: #FFB74D">PRO</span></div>
                            </a>
                            <div class="media-body list-group__text">
                                <strong><?php echo $review_list[$i]["user_info"]["nick_name"]; ?></strong>
                                <small><?php echo $review_list[$i]["time"]; ?></small>
                                <p class="m-t-15"><?php echo $review_list[$i]["content"] ?></p>

                                <div class="actions actions--blog-comment dropdown">
                                    <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                                    <ul class="dropdown-menu dropdown-menu--icon pull-right">
                                        <li><a href="javascript:report_review('<?php echo $review_list[$i]["ID"]; ?>')"><i
                                                        class="zmdi zmdi-alert-octagon"></i> 举报</a></li>
                                    </ul>
                                </div>
                            </div>


                        </div>

                    <?php } ?>


                </div>


            </div>


            </div>
        </section>


        <?php

    }

} else {
    $page_title = "页面不存在 - ";
    //引入头部及菜单
    require "theme/model/head.html";
    require "theme/model/menu.html";
    require "theme/model/404_content.html";
}

require "theme/model/footer.html";

?>
