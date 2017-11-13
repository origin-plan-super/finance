// 悬浮图标页面跳转
$(document).on("click",".index",function(){
    window.location.href = "../index/index.html";
})
$(document).on("click",".userCenter",function(){
    window.location.href = "../user/user.html";
})
$(document).on("click",".shopBag",function(){
    window.location.href = "../shopBag/shopBag.html";
})

$(document).on("click",".zfb",function(){
    $('#zhifubao').attr('checked',true)
})
$(document).on("click",".wx",function(){
    $('#weixin').attr('checked',true)
})