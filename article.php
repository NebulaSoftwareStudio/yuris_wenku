<?php
/**
 * 文章页面
 * User: Hanawa Hinata
 * Date: 2019/3/28
 * Time: 21:05
 */

require "common/function.php";

//获取热门文章
$hot_article = select_more_data("select * from `article` order by `view` desc limit 0,5");

//检查链接是否携带参数
if (isset($_GET["id"])) {
    $id = $_GET["id"];
//检查参数是否命中文章
    if (select_data("select count(*) as `count` from `article` where `ID` = '$id'")["count"] > 0) {
        $article_info = select_data("select * from `article` where `ID` = '$id'");
        $author_info = select_data("select * from `user_account` where `ID` = '" . $article_info["author"] . "'");
        $book_info = select_data("select * from `book_list` where `ID` = '" . $article_info["book"] . "'");
        $page_title = $article_info["title"] . ' - ';
        //检测用户选择的是那种展示方式。如果cookie存储的新版展示方式，就按新版展示
        if (isset($_COOKIE["display_mode"]) && $_COOKIE["display_mode"] == 'kitoko') {
            //展示预览版模板
        } else {
            //展示默认模板

            //引入头部及菜单
            require "theme/model/head.html";
            require "theme/model/menu.html";

            ?>
            <section class="section">
                <div class="container">


                    <div class="row">
                        <div class="col-md-8 col-sm-7">


                            <article class="card blog">

                                <?php if ($article_info["image"] != '') { ?>
                                    <div class="card__img">
                                        <img src="<?php echo $article_info["image"]; ?>" alt="<?php echo $article_info["title"]; ?>"/>
                                    </div>
                                <?php } ?>
                                <div class="card__body">

                                    <h1><?php echo $article_info["title"] ?></h1>
                                    <small><?php echo $author_info["nick_name"] ?>
                                        于<?php echo date("Y年m月d日 H:i:s", strtotime($article_info["time"])) ?>发表在<a
                                                href="topic.php?cid=<?php echo $book_info["ID"]; ?>"><?php echo $book_info["name"]; ?></a>
                                    </small>
                                    <hr/>

                                    <?php echo $article_info["content"]; ?>

                                </div>


                                <div class="blog__tags">
                                    <a href="topic.php?cid=<?php echo $book_info["ID"]; ?>"
                                       class="tags-list__item">#<?php echo $book_info["name"]; ?></a>
                                </div>


                                <div class="blog__arthur">
                                    <div class="blog__arthur-img">
                                        <img src="<?php echo $author_info["icon"]; ?>"
                                             alt="<?php echo $author_info["nick_name"]; ?>"/>
                                    </div>
                                    <div class="blog__arthur-contents">
                                        <h2>本文作者：<?php echo $author_info["nick_name"]; ?></h2>
                                        <p>「<?php echo $author_info["sign"]; ?>」</p>
                                        <div class="blog__arthur-social">
                                            <a href="author.php?id=<?php echo $author_info["ID"]; ?>" title="作者在Yuris文库的主页" class="mdc-bg-indigo-500"><i class="zmdi zmdi-home"></i></a>
                                            <a href="https://twitter.com/<?php echo $author_info["twitter"]?>" target="_blank" title="关注twitter（您所在的地区可能无法访问此链接）" class="mdc-bg-cyan-500"><i class="zmdi zmdi-twitter"></i></a>
                                        </div>
                                    </div>
                                </div>


                            </article>

                        </div>


                        <aside class="col-md-4 col-sm-5 hidden-xs">


                            <div class="card subscribe mdc-bg-blue-900">
                                <div class="subscribe__icon">
                                    <i class="zmdi zmdi-alert-polygon"></i>
                                </div>

                                <h2>试用新版文章阅读工具</h2>
                                <small>点击下面的按钮，您即可从当前版本的阅读器切换到新版的阅读器。新版的阅读器使用竖向排版及横向滚动，并且添加使用了许多新玩意。</small>
                                <small>
                                    切换过程要求您刷新页面，您可能会失去当前的阅读进度。在切换进行前，请注意您的阅读进度。使用新版阅读工具，即表示您同意我们的用户隐私权政策及Cookie使用策略。
                                </small>
                                <small>另外地，您不用担心切换后的问题。如果您使用这个新版阅读工具有任何不习惯，您随时可以切换回当前版本的阅读器。如果您对阅读器有任何意见或建议，欢迎发送反馈给我们。
                                </small>
                                <button class="btn btn--circle" onclick="use_new_viewer('kitoko')">
                                    <i class="zmdi zmdi-check mdc-text-blue-900"></i>
                                </button>

                            </div>


                            <div class="card tags-list">
                                <div class="card__header">
                                    <h2>目录</h2>
                                    <small>页内章节目录</small>
                                </div>
                                <div class="card__body" id="cag_index">

                                    <a href="list.php?cid=29" class="tags-list__item" title="一">一</a>
                                    <a href="list.php?cid=30" class="tags-list__item" title="二">二</a>
                                    <a href="list.php?cid=31" class="tags-list__item" title="三">三</a>

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

                            <script>
                                let headers = document.getElementsByTagName("h3");
                                let html_string = '';
                                //console.log(headers);
                                if(headers.length>0){
                                    for(let i=0;i<headers.length;i++){
                                        //对象id重置
                                        headers[i]["id"] = "header_"+i;
                                        //拼接html字符串
                                        html_string += '<a href="#header_'+i+'" class="tags-list__item" title="'+headers[i]["innerText"]+'">'+headers[i]["innerText"]+'</a>'
                                    }
                                    document.getElementById("cag_index").innerHTML = html_string;
                                }
                            </script>


                            <?php if (!isset($_COOKIE["use_cookies"])) {
                                require "theme/model/cookie.html";
                            } ?>

                        </aside>


                    </div>

                </div>

            </section>

            <?php

            require "theme/model/footer.html";

        }
    } else {
        //404
        $page_title = '文章不存在 - ';
        //引入头部及菜单
        require "theme/model/head.html";
        require "theme/model/menu.html";

        ?>
        <section id="main" style="background-color: #FFD54F;padding-bottom: 100px;">
            <div class="four-zero__content" style="position: relative;">
                <h1>404</h1>
                <p>你似乎来到了一个神秘的地方。这个神秘的地方没有别人，只有你自己。你我都是人类，人类的本性就是孤独。</p>

                <div class="four-zero__links">
                    <a href="./">文库首页</a>
                    <a href="javascript:return_previous_page()">返回上一页</a>
                </div>
            </div>
        </section>
        <?php
        require "theme/model/footer.html";
    }
} else {
    //404
    $page_title = '文章不存在 - ';
    //引入头部及菜单
    require "theme/model/head.html";
    require "theme/model/menu.html";

    ?>
    <section id="main" style="background-color: #FFD54F;padding-bottom: 100px;">
        <div class="four-zero__content" style="position: relative;">
            <h1>404</h1>
            <p>你似乎来到了一个神秘的地方。这个神秘的地方没有别人，只有你自己。你我都是人类，人类的本性就是孤独。</p>

            <div class="four-zero__links">
                <a href="./">文库首页</a>
                <a href="javascript:return_previous_page()">返回上一页</a>
            </div>
        </div>
    </section>
    <?php
    require "theme/model/footer.html";
}

?>

