



//设置 Cookie
//  addCookie('surface','cookieMaxAge',Infinity);
//  addCookie('hunred-day','cookieMaxAge',100);
//  addCookie('Session','cookieMaxAge');
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
    $("#review_box").animate({height:'none'},2000);
    // $("#review_box").animate({height:"300px"});
}