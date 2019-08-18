<?php
/**
 * 文章管理
 */


//计算page
$page = isset($_GET["page"]) ? $_GET["page"] : 0;
$start = $page * 20;

//按照发表顺序获取文章列表
$previous_articles = @select_more_data("select * from `article` where `author` = '" . $user_info["ID"] . "' order by `time` desc limit $start,20");

for ($i = 0; $i < sizeof($previous_articles); $i++) {
    //获取所属书籍信息
    $previous_articles[$i]["book_info"] = select_data("select * from `book_list` where `ID` = '" . $previous_articles[$i]["book"] . "'");
}

?>


<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

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
                                <li class="breadcrumb-item active">文章管理</li>
                            </ol>
                        </div>
                        <h4 class="page-title">文章管理</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="text-left" id="nestable_list_menu">
                        <a href="?pid=3">
                            <button type="button" class="btn btn-purple btn-sm waves-effect mb-3 waves-light"
                                    data-action="expand-all"><i class="mdi mdi-plus mr-1"></i>新建文章
                            </button>
                        </a>
                    </div>
                </div> <!-- end col -->
            </div>


            <div class="row">

                <div class="col-xl-12">
                    <div class="card-box">

                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-centered m-0">

                                <thead class="thead-light">
                                <tr>
                                    <th>标题</th>
                                    <th>发表日期</th>
                                    <th>阅读数</th>
                                    <th>所属书籍</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php for ($i = 0; $i < sizeof($previous_articles); $i++) { ?>
                                    <tr>
                                        <td>
                                            <h5 class="m-0 font-weight-normal"><?php echo $previous_articles[$i]["title"]; ?></h5>
                                        </td>

                                        <td>
                                            <?php echo $previous_articles[$i]["time"]; ?>
                                        </td>

                                        <td>
                                            <?php echo $previous_articles[$i]["view"]; ?>
                                        </td>

                                        <td>
                                            <a href="javascript:"> <?php echo $previous_articles[$i]["book_info"]["name"]; ?></a>
                                        </td>

                                        <td>
                                            <?php if ($previous_articles[$i]["publish"] == 1) { ?>
                                                <span class="badge badge-light-success">已发布</span>
                                            <?php } else { ?>
                                                <span class="badge badge-light-warning">私有</span>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <a href="?pid=3&mode=edit&article_id=<?php echo $previous_articles[$i]["ID"]; ?>"
                                               class="btn btn-xs btn-secondary" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="编辑文章">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="../article.php?id=<?php echo $previous_articles[$i]["ID"]; ?>"
                                               target="_blank"
                                               class="btn btn-xs btn-secondary" data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="预览文章">
                                                <i class="mdi mdi-open-in-new"></i>
                                            </a>
                                            <span data-toggle="tooltip" data-original-title="删除文章">
                                                <a href="JavaScript:"
                                                   onclick="current_article_id = '<?php echo $previous_articles[$i]["ID"]; ?>'"
                                                   class="btn btn-xs btn-danger" data-toggle="modal"
                                                   data-target="#delete_article_modal"
                                                   data-placement="top">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>

                                <?php } ?>


                                </tbody>
                            </table>
                        </div> <!-- end .table-responsive-->
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->


</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


<div id="delete_article_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger" id="myModalLabel">删除文章</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>删除文章是一项无法回退的操作。您确定要删除这篇文章吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-danger waves-effect waves-light"
                        onclick="delete_article()">删除</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>