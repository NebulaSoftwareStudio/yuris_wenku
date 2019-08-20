<?php
/**
 * 用户页面
 */

require "common/function.php";


if (isset($_GET["id"])) {
//获取作者信息
$id = $_GET["id"];
$author_info = select_data("select * from `user_account` where `id` = '$id'");

//获取作者热门书籍前三位
$hot_book = @select_more_data("select * from `book_list` where `author` = '$id' order by `time` desc limit 0,3");

//获取作者最新更新的文章
$recent_update_article = @select_more_data("select * from `article` where `author` = '$id' order by `time` desc limit 0,3");

$page_title = '用户:' . $author_info["nick_name"] . ' - ';


//引入头部及菜单
require "theme/model/head.html";
require "theme/model/menu.html";


?>

<section class="section" style="padding: 0">
    <section class="section">
        <div class="container container--sm">
            <header class="section__title text-left">
                <h2><?php echo $author_info["nick_name"]; ?><?php if ($author_info["identification"] == 1) { ?>
                        <i class="zmdi zmdi-check-circle text-success"></i>
                    <?php } ?></h2>
                <small><?php echo $author_info["sign"]; ?></small>
            </header>

            <div class="clearfix"></div>

            <div class="card profile">
                <div class="profile__img">
                    <img src="<?php echo $author_info["icon"]; ?>" alt="">
                </div>

                <div class="profile__info">
                    <?php if ($author_info["pro"] == 1) { ?>
                        <span class="label label-warning" title="文库编辑部签约作者">签约作者</span>
                    <?php } ?>

                    <?php if ($author_info["identification"] == 1) { ?>
                        <span class="label label-success" title="文库编辑部认证用户">认证用户</span>
                    <?php } ?>


                    <div class="profile__review">
                        <?php if ($author_info["identification"] == 1) { ?>
                            <span><?php echo $author_info["identification_info"]; ?></span>
                        <?php } ?>
                    </div>

                    <ul class="rmd-contact-list">
                        <li><i class="zmdi zmdi-calendar"></i>于 <?php echo $author_info["time"]; ?> 加入</li>
                        <?php if ($author_info["twitter"] !== '') { ?>
                            <li><i class="zmdi zmdi-twitter"></i>@<?php echo $author_info["twitter"]; ?></li>
                        <?php } ?>
                        <?php if ($author_info["email"] !== '') { ?>
                            <li><i class="zmdi zmdi-email"></i><?php echo $author_info["email"]; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="tab-nav tab-nav--justified" data-rmd-breakpoint="650">
                    <div class="tab-nav__inner">
                        <ul>
                            <li class="active"><a href="#description">用户简介</a></li>
                            <li><a href="#recent">近期更新</a></li>
                            <li><a href="#represent">近期作品</a></li>
                            <li><a href="#award">奖项</a></li>
                        </ul>
                    </div>
                </div>

                <div class="card__body">
                    <div class="card__sub" id="description">
                        <h4>关于 <?php echo $author_info["nick_name"]; ?></h4>

                        <?php echo $author_info["description"]; ?>
                    </div>

                    <div class="card__sub" id="recent">
                        <h4>近期更新</h4>
                        <?php if (sizeof($recent_update_article) > 0) { ?>
                            <div class="list-group">
                                <?php for ($i = 0; $i < sizeof($recent_update_article); $i++) { ?>
                                    <a href="article.php?id=1" class="list-group-item media">
                                        <div class="pull-left" style="max-height: 45px;overflow: hidden;">
                                            <img src="<?php echo $recent_update_article[$i]["image"]; ?>"
                                                 alt="<?php echo $recent_update_article[$i]["title"]; ?>"
                                                 class="list-group__img" width="65">
                                        </div>
                                        <div class="media-body list-group__text">
                                            <strong><?php echo $recent_update_article[$i]["title"]; ?></strong>
                                            <small><?php echo $recent_update_article[$i]["description"]; ?></small>
                                        </div>
                                    </a>
                                <?php } ?>
                                <div class="p-10"></div>
                            </div>
                        <?php } else { ?>
                            <p>暂时无法获取</p>
                        <?php } ?>

                    </div>

                    <div class="card__sub" id="represent">
                        <h4>近期作品</h4>

                        <div class="card__sub row rmd-stats">
                            <?php for ($i = 0; $i < sizeof($hot_book); $i++) { ?>
                                <a href="topic.php?cid=<?php echo $hot_book[$i]["ID"]; ?>">
                                    <div class="col-xs-4">
                                        <img src="<?php echo $hot_book[$i]["cover"]; ?>" style="max-width:100%;"/>
                                        <div class="rmd-stats__item <?php echo($i == 0 ? 'mdc-bg-teal-400' : ($i == 1 ? 'mdc-bg-purple-400' : 'mdc-bg-red-400')); ?>">
                                            <h2><?php echo($i + 1); ?></h2>
                                            <small><?php echo $hot_book[$i]["name"]; ?></small>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="card__sub" id="award">
                        <h4>奖项</h4>
                        <p>文库目前没有记录该作者的获奖情况</p>
                    </div>


                </div>
            </div>
        </div>
    </section>


    <?php


    } else {
        $page_title = '页面不存在 - ';
        //引入头部及菜单
        require "theme/model/head.html";
        require "theme/model/menu.html";
        require "theme/model/404_content.html";
    }

    require "theme/model/footer.html";

    ?>
