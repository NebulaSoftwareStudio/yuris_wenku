<?php
/**
 * 书籍管理
 */

//计算page
$page = isset($_GET["page"])?$_GET["page"]:0;
$start = $page*10;
//获取该用户书籍
$book_list = select_more_data("select * from `book_list` where `author` = '".$user_info["ID"]."' order by `time` desc limit $start,10");


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
                                <li class="breadcrumb-item active">书籍管理</li>
                            </ol>
                        </div>
                        <h4 class="page-title">书籍管理</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="text-left" id="nestable_list_menu">
                        <button type="button" class="btn btn-purple btn-sm waves-effect mb-3 waves-light" data-action="expand-all"><i class="mdi mdi-plus mr-1"></i>新建书籍</button>
<!--                        <button type="button" class="btn btn-pink btn-sm waves-effect mb-3 waves-light" data-action="collapse-all"><i class="mdi mdi-arrow-collapse-all mr-1"></i> Collapse All</button>-->
                    </div>
                </div> <!-- end col -->
            </div>


            <div class="row">
                <?php for($i=0;$i<sizeof($book_list);$i++){ ?>
                <div class="col-md-12 col-xl-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="../<?php echo $book_list[$i]["cover"]?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $book_list[$i]["name"]?></h5>
                            <div class="card-text" style="overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;" ><?php echo strip_tags($book_list[$i]["description"]); ?></div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">于 <?php echo $book_list[$i]["time"]; ?> 创建</li>
                            <li class="list-group-item">
                                <span class="float-left">是否连载：</span>
                                <div class="custom-control custom-switch float-left">
                                    <input type="checkbox" class="custom-control-input"
                                           onchange="update_article_info('<?php echo $book_list[$i]["ID"]; ?>','updating',this.checked)"
                                        <?php echo $book_list[$i]["updating"]=='1'?'checked':''; ?> id="tabswitch<?php echo $i; ?>">
                                    <label class="custom-control-label" for="tabswitch<?php echo $i; ?>"></label>
                                </div></li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">编辑</a>
                            <a href="#" class="card-link text-danger">删除</a>
                            <a href="../topic.php?cid=<?php echo $book_list[$i]["ID"];?>" target="_blank" class="card-link">在 Yuris 文库中查看 <i class="mdi mdi-open-in-new"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->


</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
