
// 页面跳转 点击悬浮的首页跳转页面
$(document).on("click", ".index", function () {
    window.location.href = "../index/index.html";
})
// 点击悬浮的购物车跳转购物车页面
$(document).on("click", ".userCenter", function () {
    window.location.href = "../user/user.html";
})


// 点击去结算 跳转支付页面

$(document).on("click",".goPay",function(){
    window.location.href = "../order/order.html";
})