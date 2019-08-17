document.getElementById("login_button").onclick = function () {
    // alert("test");
    let notification_bar = $("#notification_bar");
    let notification_bar_dom = document.getElementById("notification_bar");
    let user_name = document.getElementById("user_name").value;
    let password = document.getElementById("password").value;
    let captcha = document.getElementById("captcha").value;

    if(user_name === '' || password === '' || captcha === ''){
        notification_bar_dom.classList = 'alert bg-danger text-white text-center border-0';
        notification_bar_dom.innerText = "请务必补充填写以下字段："+(user_name === ''?' 用户名 ':'')+(password === ''?' 密码 ':'')+(captcha === ''?' 验证码 ':'');

        notification_bar.animate({top: "0px"}, 200);
        setTimeout(function () {
            $("#notification_bar").animate({top: "-50px"}, 200);
        }, 1000);
    }
    else{
        $.ajax({
            url: "common/api/user_account_login.php",
            method: "POST",
            data: {
                user_name:user_name,
                password:password,
                captcha:captcha
            },
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data.response.status === 'success') {
                    notification_bar_dom.classList = 'alert bg-success text-white text-center border-0';
                    notification_bar_dom.innerText = data.response.status_info + '，欢迎回来！';
                } else {
                    notification_bar_dom.classList = 'alert bg-danger text-white text-center border-0';
                    notification_bar_dom.innerText = data.response.status_info;
                }

                notification_bar.animate({top: "0px"}, 200);
                setTimeout(function () {
                    $("#notification_bar").animate({top: "-50px"}, 200);
                }, 1000);
                setTimeout(function () {
                    window.location.assign("./");
                }, 1200);

            },
            fail: function () {
                notification_bar_dom.classList = 'alert bg-danger text-white text-center border-0';
                notification_bar_dom.innerText = "网络错误或超时，请重试。";

                notification_bar.animate({top: "0px"}, 200);
                setTimeout(function () {
                    $("#notification_bar").animate({top: "-50px"}, 200);
                }, 1000);
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
            }
        });
    }

};