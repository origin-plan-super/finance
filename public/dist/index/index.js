// 报名信息页面的显示与隐藏
$(document).ready(function () {
    $(".toSignUp").click(function (e) {
        e.stopPropagation();
        $("div.con").removeClass("hide");
    });
    $(".shopcar").click(function (e) {
        e.stopPropagation();
        // if (!$("div.con").hasClass("hide")) {
        //     $("div.con").addClass("hide");
        // }
        $("div.con").addClass("hide");
    });
});
// 点击分页进行效果的切换
$(function () {
    $(".index-pages li").click(function (event) {
        event.stopPropagation();
        event.preventDefault();
        $(this).addClass('selected'); // 添加当前元素的样式
        $(this).siblings('li').removeClass('selected'); // 删除其他兄弟元素的样式
    });
});



// 分页效果
$('#pageLimit').bootstrapPaginator({
    currentPage: 1, //当前的请求页面。
    totalPages: 20, //一共多少页。
    size: "normal", //应该是页眉的大小。
    bootstrapMajorVersion: 3, //bootstrap的版本要求。
    alignment: "right",
    numberOfPages: 5, //一页列出多少数据。
    itemTexts: function (type, page, current) { //如下的代码是将页眉显示的中文显示我们自定义的中文。
        switch (type) {
            case "first":
                return "首页";
            case "prev":
                return "<";
            case "next":
                return ">";
            case "last":
                return "尾页";
            case "page":
                return page;
        }
    }
});
