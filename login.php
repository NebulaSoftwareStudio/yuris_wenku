<?php
/**
 * 登录界面
 */

$page_title = '登录或注册Yuris文库通行证 - ';
require "theme/model/head.html";
require "theme/model/menu.html";


?>


    <div class="container" style="padding: 25px;">
        <header class="section__title">
            <h2>Yuris文库编辑部通行证</h2>
            <small>欢迎加入或回到Yuris文库编辑部</small>
        </header>

        <div class="submit-property">
            <ul class="submit-property__steps">
                <li class="active"><a href="#submit-property-1" data-toggle="tab" aria-expanded="true"><i
                                class="zmdi zmdi-sign-in"></i></a></li>
                <li class=""><a href="#submit-property-2" data-toggle="tab" aria-expanded="false"><i
                                class="zmdi zmdi-plus"></i></a></li>

                <li class="submit-property__caret"></li>
            </ul>

            <div class="tab-content submit-property__content">
                <div class="tab-pane fade active in" id="submit-property-1">
                    <div class="card">
                        <div class="card__header">
                            <h2>登入以继续</h2>
                            <small>请登录您的Yuris文库编辑部账户以继续您的操作</small>
                        </div>

                        <form class="card__body text-left">


                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;">
                                <input type="text" class="form-control" id="login_user_name">
                                <i class="form-group__bar"></i>
                                <label>用户名</label>
                            </div>

                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;">
                                <input type="password" class="form-control" id="login_password">
                                <i class="form-group__bar"></i>
                                <label>密码</label>
                            </div>

                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;min-height:50px">
                                <img id="captcha_image" src="common/captcha.php?time=<?php echo time(); ?>"
                                     onclick="change_captcha()" style="float: right;width: 25%;display: block;"/>
                                <input type="text" class="form-control" id="login_captcha" style="width: 60%;float: left;">
                                <i class="form-group__bar" style="width: 60%;float: left;"></i>
                                <label style="width: 60%;float: left;">验证码</label>

                            </div>


                            <a href="#submit-property-3" onclick="login_in_pages()" data-toggle="tab"
                               class="btn btn--circle btn-primary submit-property__button" aria-expanded="true">
                                <i class="zmdi zmdi-long-arrow-right"></i>
                            </a>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="submit-property-2">
                    <div class="card">
                        <div class="card__header">
                            <h2>加入Yuris文库编辑部</h2>
                            <small>填写并提交下方的表单可加入Yuris文库编辑部进行创作</small>
                        </div>

                        <form class="card__body">
                            <div class="form-group form-group--float form-group--float-center">
                                <input type="text" class="form-control text-center">
                                <i class="form-group__bar"></i>
                                <label>Full Name</label>
                            </div>

                            <div class="form-group form-group--float form-group--float-center">
                                <input type="text" class="form-control text-center">
                                <i class="form-group__bar"></i>
                                <label>Organization Name (Opt.)</label>
                            </div>

                            <div class="form-group form-group--float form-group--float-center m-b-5">
                                <input type="text" class="form-control text-center">
                                <i class="form-group__bar"></i>
                                <label>Email Address</label>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox">
                                        <i class="input-helper"></i>
                                        Hide Email Address on listing
                                    </label>
                                </div>
                            </div>

                            <div class="form-group form-group--float form-group--float-center">
                                <input type="text" class="form-control text-center">
                                <i class="form-group__bar"></i>
                                <label>Contact Number</label>
                            </div>

                            <a href="#submit-property-3" data-toggle="tab"
                               class="btn btn--circle btn-primary submit-property__button" aria-expanded="false">
                                <i class="zmdi zmdi-long-arrow-right"></i>
                            </a>
                        </form>
                    </div>
                </div>


                <div class="tab-pane fade" id="submit-property-3">
                    <div class="card" id="status_card">
                        <div class="submit-property__info">
                            <div>
                                <i class="zmdi zmdi-refresh zmdi-hc-spin"></i>
                            </div>

                            <h2>请稍候</h2>
                            <p>正在与服务器通信，请耐心等待···</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>


<?php

require "theme/model/footer.html";
?>