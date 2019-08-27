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

                        <div class="card__body text-left">


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
                                <img id="login_captcha_image" src="common/captcha.php?time=<?php echo time(); ?>"
                                     onclick="change_captcha()" style="float: right;width: 25%;display: block;"/>
                                <input type="text" class="form-control" id="login_captcha"
                                       style="width: 60%;float: left;">
                                <i class="form-group__bar" style="width: 60%;float: left;"></i>
                                <label style="width: 60%;float: left;">验证码</label>

                            </div>


                            <a href="#submit-property-3" onclick="login_in_pages()" data-toggle="tab"
                               class="btn btn--circle btn-primary submit-property__button" aria-expanded="true">
                                <i class="zmdi zmdi-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="submit-property-2">
                    <div class="card">
                        <div class="card__header">
                            <h2>加入Yuris文库编辑部</h2>
                            <small>填写并提交下方的表单可加入Yuris文库编辑部进行创作</small>
                        </div>

                        <div class="card__body text-left">


                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;">
                                <input type="text" class="form-control" id="regist_user_name">
                                <i class="form-group__bar"></i>
                                <label>用户名</label>
                            </div>

                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;">
                                <input type="password" class="form-control" id="regist_password">
                                <i class="form-group__bar"></i>
                                <label>密码</label>
                            </div>

                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;">
                                <input type="password" class="form-control" id="regist_re_password">
                                <i class="form-group__bar"></i>
                                <label>重复密码</label>
                            </div>


                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;">
                                <input type="email" class="form-control" id="regist_email">
                                <i class="form-group__bar"></i>
                                <label>电子邮件地址</label>
                            </div>

                            <div class="form-group form-group--float m-b-5" style="margin-bottom: 30px;min-height:50px">
                                <img id="regist_captcha_image" class="captcha_image" src="common/captcha.php?time=<?php echo time(); ?>"
                                     onclick="change_captcha()" style="float: right;width: 25%;display: block;"/>
                                <input type="text" class="form-control" id="regist_captcha"
                                       style="width: 60%;float: left;">
                                <i class="form-group__bar" style="width: 60%;float: left;"></i>
                                <label style="width: 60%;float: left;">验证码</label>

                            </div>

                            <p>
                                <small><span style="vertical-align: inherit;">通过注册Yuris文库，即表示您同意我们的</span>
                                    <a href="about.php?mode=policy&name=%E9%9A%90%E7%A7%81%E6%9D%83%E6%94%BF%E7%AD%96"><span style="vertical-align: inherit;">条款和条件</span></a>
                                    <span
                                            style="vertical-align: inherit;">。电子邮件地址是 Yuris 文库联系您（包括您找回密码等操作）的唯一凭据。根据我们的上述条款，我们不会将电邮地址用于推送广告或提供给合作伙伴。请仔细确认谨防填写错误。</span></small>
                            </p>


                            <a href="#submit-property-3" onclick="regist_in_pages()" data-toggle="tab"
                               class="btn btn--circle btn-primary submit-property__button" aria-expanded="true">
                                <i class="zmdi zmdi-long-arrow-right"></i>
                            </a>
                        </div>
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