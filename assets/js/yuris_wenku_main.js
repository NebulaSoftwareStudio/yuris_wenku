







//返回上一页
function return_previous_page() {
    window.history.go(-1);
}


//设置新版阅读器
function use_new_viewer(version) {
    addCookie("display_mode",version,Infinity);
    if(window.confirm("切换版本要求您刷新页面才能生效。您可点击[确定]选择立即刷新，或选择[取消]稍后手动刷新。")){
        window.location.reload();
    }
}


//展示留言窗口
function show_review_box__book() {
    document.getElementById("review_box").style.height = 'auto';
}


//使用单独页面登录
function login_in_pages() {
    let user_name = document.getElementById("login_user_name").value;
    let password = document.getElementById("login_password").value;
    let captcha = document.getElementById("login_captcha").value;

    if(user_name === ''|| password === '' || captcha === ''){
        document.getElementById("status_card").innerHTML ='\n'+
            '                        <div class="submit-property__error">\n' +
            '                            <div>\n' +
            '                                <i class="zmdi zmdi-close"></i>\n' +
            '                            </div>\n' +
            '\n' +
            '                            <h2>表单不完整</h2>\n' +
            '                            <p>某些项目好像没有填写，请填写完整再提交表单</p>\n' +
            '                        </div>\n'
    }
    else{
        // post xhr request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'common/api/auth/login.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function (e) {
            if (xhr.readyState===4 && xhr.status===200){
                console.log(xhr.responseText);
                let data = JSON.parse(xhr.responseText);
                console.log(data);
                if(data["status"] === true){
                    document.getElementById("status_card").innerHTML ='\n'+
                        '                        <div class="submit-property__success">\n' +
                        '                            <div>\n' +
                        '                                <i class="zmdi zmdi-check-all"></i>\n' +
                        '                            </div>\n' +
                        '\n' +
                        '                            <h2>登录成功</h2>\n' +
                        '                            <p>'+data["info"]+'</p>\n' +
                        '                        </div>\n';
                    setTimeout(function () {
                        window.location.assign("author/");
                    },1000);
                }
                else{
                    document.getElementById("status_card").innerHTML ='\n'+
                        '                        <div class="submit-property__error">\n' +
                        '                            <div>\n' +
                        '                                <i class="zmdi zmdi-close"></i>\n' +
                        '                            </div>\n' +
                        '\n' +
                        '                            <h2>登录失败</h2>\n' +
                        '                            <p>'+data["info"]+'</p>\n' +
                        '                        </div>\n';
                    change_captcha();
                }


            }
            else{
                document.getElementById("status_card").innerHTML ='\n'+
                    '                        <div class="submit-property__error">\n' +
                    '                            <div>\n' +
                    '                                <i class="zmdi zmdi-close"></i>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <h2>与服务器失联</h2>\n' +
                    '                            <p>暂时无法与服务器通讯，请稍后再试</p>\n' +
                    '                        </div>\n'
            }
        };
        xhr.send("user_name="+user_name+"&password="+password+"&captcha="+captcha);
    }



}


function regist_in_pages() {
    let user_name = document.getElementById("regist_user_name").value;
    let password = document.getElementById("regist_password").value;
    let re_password = document.getElementById("regist_re_password").value;
    let email = document.getElementById("regist_email").value;
    let captcha = document.getElementById("regist_captcha").value;

    if(user_name === ''|| password === '' || re_password === '' || email === '' || captcha === ''){
        document.getElementById("status_card").innerHTML ='\n'+
            '                        <div class="submit-property__error">\n' +
            '                            <div>\n' +
            '                                <i class="zmdi zmdi-close"></i>\n' +
            '                            </div>\n' +
            '\n' +
            '                            <h2>表单不完整</h2>\n' +
            '                            <p>某些项目好像没有填写，请填写完整再提交表单</p>\n' +
            '                        </div>\n'
    }
    else if(password !== re_password){
        document.getElementById("status_card").innerHTML ='\n'+
            '                        <div class="submit-property__error">\n' +
            '                            <div>\n' +
            '                                <i class="zmdi zmdi-close"></i>\n' +
            '                            </div>\n' +
            '\n' +
            '                            <h2>密码不一致</h2>\n' +
            '                            <p>两次输入的密码不一致，请检查输入</p>\n' +
            '                        </div>\n'
    }
    else{
        // post xhr request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'common/api/auth/register.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function (e) {
            if (xhr.readyState===4 && xhr.status===200){
                console.log(xhr.responseText);
                let data = JSON.parse(xhr.responseText);
                console.log(data);
                if(data["status"] === true){
                    document.getElementById("status_card").innerHTML ='\n'+
                        '                        <div class="submit-property__success">\n' +
                        '                            <div>\n' +
                        '                                <i class="zmdi zmdi-check-all"></i>\n' +
                        '                            </div>\n' +
                        '\n' +
                        '                            <h2>注册成功</h2>\n' +
                        '                            <p>'+data["info"]+'</p>\n' +
                        '                        </div>\n';
                    setTimeout(function () {
                        window.location.assign("author/");
                    },1000);
                }
                else{
                    document.getElementById("status_card").innerHTML ='\n'+
                        '                        <div class="submit-property__error">\n' +
                        '                            <div>\n' +
                        '                                <i class="zmdi zmdi-close"></i>\n' +
                        '                            </div>\n' +
                        '\n' +
                        '                            <h2>登录失败</h2>\n' +
                        '                            <p>'+data["info"]+'</p>\n' +
                        '                        </div>\n';
                    change_captcha();
                }


            }
            else{
                document.getElementById("status_card").innerHTML ='\n'+
                    '                        <div class="submit-property__error">\n' +
                    '                            <div>\n' +
                    '                                <i class="zmdi zmdi-close"></i>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <h2>与服务器失联</h2>\n' +
                    '                            <p>暂时无法与服务器通讯，请稍后再试</p>\n' +
                    '                        </div>\n'
            }
        };
        xhr.send("user_name="+user_name+"&password="+password+"&email="+email+"&captcha="+captcha);
    }
}

/**
 * 更换验证码
 */
function change_captcha(){
    document.getElementById("login_captcha_image").src = 'common/captcha.php?time='+new Date().getTime();
    document.getElementById("regist_captcha_image").src = 'common/captcha.php?time='+new Date().getTime();
}







/** function - 设置 Cookie
 *  addCookie('surface','cookieMaxAge',Infinity);
 *  addCookie('hunred-day','cookieMaxAge',100);
 *  addCookie('Session','cookieMaxAge');
 */
function addCookie(objName,objValue,objDays){
    var str = objName + "=" + escape(objValue);
    console.log(Infinity);   //Infinity
    console.log(typeof Infinity);   //number
    console.log(Infinity.constructor); //function Number() { [native code] }
    if(objDays > 0){
        var date = new Date();
        var ms = objDays*24*3600*1000;
        date.setTime(date.getTime() + ms);
        str += "; expires=" + date.toGMTString();
    }
    if(objDays===Infinity){
        str += "; expires=Fri, 31 Dec 9999 23:59:59 GMT";
    }

    str += ";";
    document.cookie = str;
}