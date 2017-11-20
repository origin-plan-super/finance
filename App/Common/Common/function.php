<?php

function checkorderstatus($ordid){
    $Ord=M('Order');
    $ordstatus=$Ord->where('order_id='.$ordid)->getField('state');
    if($ordstatus==1){
        return true;
    }else{
        return false;
    }
}

//处理订单函数
//更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter){
    $ordid=$parameter['out_trade_no'];
    $data['z_payment_trade_no']      =  $parameter['trade_no'];
    $data['z_payment_trade_status']  =  $parameter['trade_status'];
    $data['z_payment_notify_id']     =  $parameter['notify_id'];
    $data['z_payment_notify_time']   =  $parameter['notify_time'];
    $data['z_payment_buyer_email']   =  $parameter['buyer_email'];
    $data['state']                   =  1;
    $Ord=M('Order');
    $Ord->where('order_id='.$ordid)->save($data);
}



/*-----------------------------------
2013.8.13更正
下面这个函数，其实不需要，大家可以把他删掉，
具体看我下面的修正补充部分的说明
------------------------------------*/

// //获取一个随机且唯一的订单号；
// function getordcode(){
//     $Ord=M('Order');
//     $numbers = range (10,99);
//     shuffle ($numbers);
//     $code=array_slice($numbers,0,4);
//     $ordcode=$code[0].$code[1].$code[2].$code[3];
//     $oldcode=$Ord->where("ordcode='".$ordcode."'")->getField('ordcode');
//     if($oldcode){
//         getordcode();
//     }else{
//         return $ordcode;
//     }
// }