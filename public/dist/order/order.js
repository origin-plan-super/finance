
//点击图标可以选中前边的单选框
$(document).on("click",".zfb",function(){
    $('#zhifubao').attr('checked',true)
})
$(document).on("click",".wx",function(){
    $('#weixin').attr('checked',true)
})

// 点击去结算
$(document).on("click",".settlement",function(){
    window.location.href = "../order/order.html";
})