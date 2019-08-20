<?php
/**
 * 发布文章/编辑文章
 */


$book_list = select_more_data("select * from `book_list` where `author` = '".$user_info["ID"]."' order by `time` desc");

if(isset($_GET["mode"])&&isset($_GET["article_id"])){
    $article_id = $_GET["article_id"];
    $article_content = select_data("select * from `article` where `ID` = '$article_id' ");
}
else{
    $article_id = '';
}



?>




<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="./">仪表盘</a></li>
                                <li class="breadcrumb-item"><a href="javascript:">内容管理</a></li>
                                <li class="breadcrumb-item active">文章编辑器（Beta）</li>
                            </ol>
                        </div>
                        <h4 class="page-title">文章编辑器（Beta）</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->






            <!-- Right Sidebar -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <!-- Left sidebar -->
                        <div class="inbox-leftbar">

                            <div class="card card-body">
                                <h5 class="card-title">关于编辑器</h5>

                                <p class="card-text">Yuris文库目前正在使用第三方的开源可视化编辑器，采用可视化编辑的HTML代码形式存储，可能会存在bug。如果在使用过程中有任何意见或建议，欢迎使用本站工单系统提交反馈。</p>
                                <p class="card-text">
                                    <small class="text-muted">此为全部33条中的第2条</small>
                                </p>
                            </div>

                        </div>
                        <!-- End Left sidebar -->

                        <div class="inbox-rightbar">


                            <div>
                                    <div class="btn-group" style="margin: 0 0 20px 0;">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-folder font-18"></i> <span id="article_book_name">所属书籍</span>
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                                            <span class="dropdown-header">请选择文集：</span>
                                            <?php for($i=0;$i<sizeof($book_list);$i++){?>
                                            <a class="dropdown-item" href="javascript:"
                                               onclick="change_article_book_id('<?php echo $book_list[$i]["ID"]; ?>','<?php echo $book_list[$i]["name"];?>')"><?php echo $book_list[$i]["name"];?></a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="btn-group" style="margin: 0 0 20px 20px;">
                                        <button type="button" class="btn btn-sm btn-light " onclick="select_article_image()">
                                            <i class="mdi mdi-image font-18"></i> 封面图片
                                            <i class="mdi mdi-upload"></i>
                                        </button>
                                    </div>

                                    <input type="file" id="select_file"
                                           style="position: fixed;z-index: -9999;left: -99999px;top: -99999px;"
                                           accept="image/jpeg"
                                           onchange="upload_article_image()"/>


                                    <div class="form-group" id="article_image_box"></div>


                                    <div class="form-group">
                                        <input type="text" id="article_title" class="form-control" placeholder="标题"
                                               value="<?php echo isset($article_content)?$article_content["title"]:'' ?>">
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control" id="article_description" placeholder="概要"><?php echo isset($article_content)?$article_content["description"]:'' ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="summernote"><?php echo isset($article_content)?$article_content["content"]:''; ?></div>
                                    </div>

                                    <div class="form-group m-b-0">
                                        <div class="text-right">
                                            <button class="btn btn-primary waves-effect waves-light"
                                                    onclick="save_article('<?php echo $article_id; ?>')">
                                                <span>保存</span> <i class="mdi mdi-send ml-2"></i>
                                            </button>
                                        </div>
                                    </div>
                            </div> <!-- end card-->

                            <?php if(isset($article_content)){ ?>
                                <script>

                                    setTimeout(function () {
                                        let name_dom = document.getElementById("article_book_name");
                                        let article_image_box = document.getElementById("article_image_box");
                                        article_book_id = '<?php echo $article_content["book"]; ?>';
                                        name_dom.innerText = '<?php echo select_data("select * from `book_list` where `ID` = '".$article_content["book"]."'")["name"]; ?>';
                                        article_image = '<?php echo $article_content["image"]; ?>';
                                        article_image_box.innerHTML = '<img src="../<?php echo $article_content["image"]; ?>" alt="文章图片" style="max-width:200px;" />'
                                    },1000)
                                </script>
                            <?php } ?>

                        </div>
                        <!-- end inbox-rightbar-->

                        <div class="clearfix"></div>
                    </div>

                </div> <!-- end Col -->

            </div><!-- End row -->







        </div> <!-- container -->

    </div> <!-- content -->


</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->



