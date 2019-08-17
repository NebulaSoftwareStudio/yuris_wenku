<?php
/**
 * 仪表盘首页
 */

// Notice: A session had already been started

//获取该用户发表的新文章（前4篇）
$previous_articles = @select_more_data("select * from `article` where `author` = '".$user_info["ID"]."' order by `time` desc limit 0,4");

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
                                <li class="breadcrumb-item"><a href="../" target="_blank">Yuris文库</a></li>
                                <li class="breadcrumb-item active">仪表盘</li>
                            </ol>
                        </div>
                        <h4 class="page-title">欢迎回来！<?php echo ($user_info["nick_name"]); ?></h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->



            <div class="row">
                <div class="col-xl-4">
                    <div class="card text-white">
                        <img class="card-img img-fluid" src="assets/images/img-7.jpg" alt="Card image">
                        <div class="card-img-overlay">
                            <h3 class="text-white">欢迎回到 Yuris 文库 </h3>
                            <h6 style="color: #D9D9D9">文库版本：V1.0.5（内部代号：kitoko）</h6>
                            <p class="text-white">文库运作系统正在稳步升级当中，届时可能会出现界面上的些许变化，请多多留意我们的公示板。在使用过程中出现任何问题，欢迎通过客服或工单系统提交问题。</p>
                            <p class="text-white">感谢您使用 Yuris 文库进行创作！</p>

                            <a href="#" class="btn btn-purple">了解 Kitoko 版本 <i class="mdi mdi-open-in-new"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card-box">
                        <h4 class="header-title mb-3">您近期在 Yuris 文库发表的文章</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-centered m-0">

                                <thead class="thead-light">
                                <tr>
                                    <th>标题</th>
                                    <th>发表日期</th>
                                    <th>阅读数</th>
                                    <th>Payouts</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php for($i=0;$i<sizeof($previous_articles);$i++){ ?>
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
                                        $815.89
                                    </td>

                                    <td>
                                        <?php if($previous_articles[$i]["publish"]==1){ ?>
                                        <span class="badge badge-light-success">已发布</span>
                                        <?php }else{ ?>
                                            <span class="badge badge-light-warning">私有</span>
                                        <?php }?>
                                    </td>

                                    <td>
                                        <a href="?pid=3&mode=edit&article_id=<?php echo $previous_articles[$i]["ID"]; ?>" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
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
