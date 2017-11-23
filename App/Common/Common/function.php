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



/**
* 创建日期 2017年11月24日06:48:37
* 计算当前科目有多少人，
* 根据支付人数来计算
* @param subject_id 想要查询的科目id
* @return 返回查询的科目id支付过后的人数
*/
function countSubject($subject_id){
    //先从订单信息中取出所有的相关科目的订单
    $model=M('OrderInfo');
    //设置条件
    $where['subject_id']=$subject_id;
    //取出所有
    $subject_arr=  $model->where($where)->select();
    //=====到订单中去比对
    //创建订单模型
    $model=M('Order');
    //循环每个
    foreach ($subject_arr as $key => $value) {
        //清空条件
        $where=[];
        //设置条件为订单信息中的id
        $where['order_id']=$value['order_id'];
        //查一个订单
        $result= $model->where($where)->find();
        //如果未支付，就从数组中移除
        if($result['state']<1){
            //未支付，移除
            unset($subject_arr[$key]);
        }
    }
    
    //返回当前要查询的科目id已经支付过的人数
    return count($subject_arr);
    
}