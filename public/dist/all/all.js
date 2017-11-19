// 悬浮的窗口
$(function () {
    var timer, scrollTop, sideDiv = $('#fudong').appendTo('body');
    $(window).scroll(function () {

        clearTimeout(timer);

        scrollTop = $(this).scrollTop();

        timer = setTimeout(function () {
            sideDiv.animate({
                top: scrollTop + 480 + 'px'
            }, 300);

        }, 20);

    });
});