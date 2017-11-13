// 悬浮的窗口
$(function () {
    var timer, scrollTop, sideDiv = $('#fudong').appendTo('body');
    $(window).scroll(function () {
        timer && clearTimeout(timer);
        scrollTop = $(this).scrollTop();
        timer = setTimeout(function () {
            sideDiv.animate({
                top: scrollTop + 112 + 'px'
            }, 600);
        }, 200);
    });
});