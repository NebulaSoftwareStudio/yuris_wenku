<?php
/**
 * 书籍管理
 */

//计算page
$page = isset($_GET["page"]) ? $_GET["page"] : 0;
$start = $page * 10;
//获取该用户书籍
$book_list = @select_more_data("select * from `book_list` where `author` = '" . $user_info["ID"] . "' order by `time` desc limit $start,10");

//获取所有可投稿类目
$book_classify = select_more_data("select * from `book_classify` where `special` != 1 order by `ID`");


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
                        <button type="button" class="btn btn-primary waves-effect waves-effect mb-3 waves-light"
                                data-toggle="modal" data-target="#edit_book_model">新建书籍
                        </button>
                    </div>
                </div> <!-- end col -->
            </div>


            <div class="row">
                <?php for ($i = 0; $i < sizeof($book_list); $i++) { ?>
                    <div class="col-md-12 col-xl-3">
                        <div class="card">
                            <img class="card-img-top img-fluid" src="../<?php echo $book_list[$i]["cover"] ?>"
                                 alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $book_list[$i]["name"] ?></h5>
                                <div class="card-text"
                                     style="overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;"><?php echo strip_tags($book_list[$i]["description"]); ?></div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">于 <?php echo $book_list[$i]["time"]; ?> 创建</li>
                                <li class="list-group-item">
                                    <span class="float-left">是否连载：</span>
                                    <div class="custom-control custom-switch float-left">
                                        <input type="checkbox" class="custom-control-input"
                                               onchange="update_article_info('<?php echo $book_list[$i]["ID"]; ?>','updating',this.checked)"
                                            <?php echo $book_list[$i]["updating"] == '1' ? 'checked' : ''; ?>
                                               id="tabswitch<?php echo $i; ?>">
                                        <label class="custom-control-label" for="tabswitch<?php echo $i; ?>"></label>
                                    </div>
                                </li>
                            </ul>
                            <div class="card-body">
                                <a href="javascript:" class="card-link"
                                   onclick="edit_book('<?php echo $book_list[$i]["ID"] ?>')">编辑</a>
                                <a href="javascript:" onclick="delete_book('<?php echo $book_list[$i]["ID"] ?>')" class="card-link text-danger">删除</a>
                                <a href="../topic.php?cid=<?php echo $book_list[$i]["ID"]; ?>" target="_blank"
                                   class="card-link">在 Yuris 文库中查看 <i class="mdi mdi-open-in-new"></i></a>
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


<div id="edit_book_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">新建或编辑书籍</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">


                <div class="dropzone dz-clickable" style="padding: 20px;margin: 0 0 20px 0;cursor: pointer;"
                     title="点击此区域可上传书籍封面" onclick="select_book_image()" id="upload_image_box">
                    <div class="dz-message needsclick">
                        <p class="h1 text-muted"><i class="mdi mdi-cloud-upload"></i></p>
                        <h3>点击此区域可上传书籍封面</h3>
                        <span class="text-muted font-13">请上传 2409px × 3311px 大小的封面，不符合条件的图片将拒绝上传。封面制作模板（<a
                                    href="../assets/image/cover/book/book_cover.psd"><i class="mdi mdi-download"></i> PSD</a>）</span>
                    </div>
                </div>
                <input type="file" id="select_book_image"
                       style="position: fixed;z-index: -9999;left: -99999px;top: -99999px;"
                       accept="image/jpeg"
                       onchange="get_book_image_sel()"/>


                <div class="btn-group" style="margin: 0 0 20px 0;">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect"
                            data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-folder font-18"></i> <span id="book_classify_name">书籍投稿类目</span>
                        <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start"
                         style="position: absolute; will-change: transform; top: 0; left: 0; transform: translate3d(0px, 38px, 0px);">
                        <span class="dropdown-header">请选择类目：</span>
                        <?php for ($i = 0; $i < sizeof($book_classify); $i++) { ?>
                            <a class="dropdown-item" href="javascript:"
                               onclick="change_book_classify('<?php echo $book_classify[$i]["ID"] ?>','<?php echo $book_classify[$i]["name"] ?>')">
                                <?php echo $book_classify[$i]["name"] ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">书籍名称</label>
                            <input type="text" maxlength="20" class="form-control" id="book_name" placeholder="书籍名称，不得超过20字">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label">书籍概要</label>
                            <textarea class="form-control" id="book_description"
                                      placeholder="请简要概述书籍内容，支持HTML"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="save_book_info()">保存书籍</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->



<div id="delete_article_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger" id="myModalLabel">删除书籍</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>请再次确认您的操作，您确定要删除这本书籍以及所有下属文章吗？这一操作不可回退！</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-danger waves-effect waves-light"
                        onclick="confirm_delete_book()">删除</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

