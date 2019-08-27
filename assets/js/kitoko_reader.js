const main_content = document.getElementById("main_content");
const pre_loader = document.getElementById("pre_loader");
const bottom_menu = document.getElementById("bottom_menu");
const top_menu = document.getElementById("top_menu");
const main_box_width = main_content.scrollLeft;

let show_menu = false;

document.addEventListener('DOMMouseScroll', scroll_handler, false);
document.addEventListener('mousewheel', scroll_handler, false);

/**
 * onload function
 * @param event
 */
window.onload = function () {
    pre_loader.classList = "hide_content";
    setTimeout(function () {
        pre_loader.remove()
    }, 1000);
};

function scroll_handler(event) {
    let detail = event.wheelDelta || event.detail;
    let moveForwardStep = 1;
    let moveBackStep = -1;

    let step = 0;
    if (detail > 0) {
        step = moveForwardStep * 200;
    } else {
        step = moveBackStep * 200;
    }

    let scrollOptions = {
        left: main_content.scrollLeft - step,
        top: 0,
        behavior: 'smooth'
    };

    main_content.scrollTo(scrollOptions);

    if (main_content.scrollLeft < main_box_width - 300) {
        document.getElementById('scroll_to_start').classList = "show_content";
    } else {
        document.getElementById('scroll_to_start').classList = "hide_content";
    }

    //计算百分比
    let percent = ((main_box_width - main_content.scrollLeft) / main_box_width)  * 100;
    //设置百分比
    document.getElementById("control_dot").style = 'right:'+percent+'%';
    document.getElementById("progressed_bar").style = 'width:'+percent+'%';
}

function scroll_to_start() {
    let scrollOptions = {
        left: main_box_width,
        top: 0,
        behavior: 'smooth'
    };

    main_content.scrollTo(scrollOptions);
    document.getElementById('scroll_to_start').classList = "hide_content";
    document.getElementById("control_dot").style = 'right:0';
    document.getElementById("progressed_bar").style = 'width:0';
}


main_content.onclick = function () {
    if (show_menu) {
        bottom_menu.classList = 'bottom_menu_hide';
        setTimeout(function () {
            bottom_menu.style = 'display:none';
        }, 200);

        top_menu.classList = 'top_menu_hide';
        setTimeout(function () {
            top_menu.style = 'display:none';
        }, 200);

        show_menu = false;
    } else {
        bottom_menu.style = 'display:block';
        setTimeout(function () {
            bottom_menu.classList = 'bottom_menu_show';
        }, 100);

        top_menu.style = 'display:block';
        setTimeout(function () {
            top_menu.classList = 'top_menu_show';
        }, 100);

        show_menu = true;
    }
};


function change_reading_progress() {
    //获取鼠标点击的窗口位置
    let e = window.event||arguments[0];
    //获取进度条在整个窗口的位置
    let play_div = $('#play-progress');
    let progressWrap = play_div.offset();
    let progressWidth = play_div.width();
    let dom_width = document.body.offsetWidth;
    console.log(e);
    console.log(dom_width);
    console.log(progressWrap);
    //点击位置X坐标减去进度条最左侧的X坐标即点击位置在进度条上的X坐标
    //能获取到的数据：鼠标点击的坐标（左 上），进度条的坐标（左，上）
    //要反向计算
    //寻找元素左边的边距+元素宽度-鼠标点击点与浏览器的左侧宽度
    let length = (progressWidth + progressWrap.left) - (e.pageX);
    // console.log(progressWidth,progressWrap.left,e.pageX);
    // console.log(length);
    let percent = (length/progressWidth)*100;
    console.log("percent",percent);
    //设置进度
    document.getElementById("control_dot").style = 'right:'+percent+'%';
    document.getElementById("progressed_bar").style = 'width:'+percent+'%';

    let scrollOptions = {
        left: main_box_width - main_box_width * (percent/100) ,
        top: 0,
        behavior: 'smooth'
    };

    main_content.scrollTo(scrollOptions);

}




//进入全屏
function requestFullScreen(element) {
    let de = document.querySelector(element) || document.documentElement;
    if (de.requestFullscreen) {
        de.requestFullscreen();
    } else if (de.mozRequestFullScreen) {
        de.mozRequestFullScreen();
    } else if (de.webkitRequestFullScreen) {
        de.webkitRequestFullScreen();
    }

    $("#fullscreen_controller").attr("onclick","exitFullscreen()");
}
//退出全屏
function exitFullscreen(element) {
    let de = document.querySelector(element) || document.documentElement;
    if (de.exitFullscreen) {
        de.exitFullscreen();
    } else if (de.mozCancelFullScreen) {
        de.mozCancelFullScreen();
    } else if (de.webkitCancelFullScreen) {
        de.webkitCancelFullScreen();
    }

    $("#fullscreen_controller").attr("onclick","requestFullScreen()");
}




function delete_cookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = get_cookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}


function get_cookie(name) {
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}