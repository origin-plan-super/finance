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
* @param string subject_id 想要查询的科目id
* @return int 返回查询的科目id支付过后的人数
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

/**
* 优惠减
* Discount
* =================================
* 创建日期：2017年11月24日07:23:59
* 作者：代码狮
* github：https://github.com/ALNY-AC
* 微信:AJS0314
* QQ:1173197065
* 留言：不知道这种算法行不行，后来者想了解情况的请联系作者。
* =================================
* @param float sub_money 总价
* @param float sub_num 总科目
* @return array [sub_money]=>优惠过后的总价
* @return array [red]=>优惠的价钱，就是减去了多少
*/
function discount($sub_money,$sub_num){
    //最新修改日期：2017年11月24日07:24:06
    
    
    // ========================
    // ====  开始计算价格 ====
    // ========================
    
    $red=0;//这个是要用总价减去的数
    
    //============================1.满减，满多少钱减多少钱============================
    // ==== 获得满减模型 ====
    $model              =   M('discount');
    //取满减数据
    $discount           =   $model->order('full desc')->select();
    //遍历，当找到第一个匹配的时候就跳出循环
    foreach ($discount as $key => $value) {
        if($sub_money >= $value['full']){
            //这里就是满足满减条件
            $red+=$value['red'];
            break
            ;
        }
    }
    //============================1.满减，end============================
    
    
    //============================2.满科减，报了多少科目，就优惠============================
    //满科减的模型
    $model              =   M('DiscountSubject');
    //取得模型数据
    $DiscountSubject           =   $model->order('full desc')->select();
    foreach ($DiscountSubject as $key => $value) {
        //这里计算科目数量是否达到标准
        if($sub_num >= $value['full']){
            $red+=$value['red'];
            break
            ;
        }
    }
    //============================2.满科减，end============================
    
    //优惠就没了，当然还有优惠码，但是不在这里计算
    
    $sub_money-=$red;//减去优惠的钱
    $sub_money = $sub_money<=0 ?0 :$sub_money;//如果负数就等于0
    $arr=[];
    $arr['sub_money']=$sub_money;
    $arr['red']=$red;
    return $arr;
    
}


/**
* 优惠码验证是否可以使用
* Discount
* =================================
* 创建日期：2017年11月24日07:56:58
* 作者：代码狮
* github：https://github.com/ALNY-AC
* 微信:AJS0314
* QQ:1173197065
* 留言：后来者想了解详细情况的请联系作者。
* =================================
* @param float code 想要使用的优惠码
* @return int 返回此优惠码的状态，如果是-1，就代表优惠码已经被使用
* @return int 返回此优惠码的状态，如果是-2，就代表优惠码已经过期
* @return int 返回此优惠码的状态，如果是-3，就代表找不到这个优惠码
* @return float 返回此优惠码的状态，如果是>=0.00，就是优惠码可以优惠的金额，返回的可能不是两位小数，注意
*/
function isCode($code){
    //最新修改时间2017年11月24日07:57:06
    
    //再算优惠码 a75970e82b9722853e8fc36c39461f09
    //创建优惠码模型
    $model=M('DiscountCode');
    //设置条件：id
    $where['discount_code_id']=$code;
    $result=$model->where($where)->find();
    
    if($result){
        //这里是找到了优惠码
        
        if($result['is_use']==0){
            //还没用过
            //检测过期没
            $time=time();//当前的时间
            if($time<$result['end_time']){
                //没过期
                //这里就代表优惠码可以使用
                $ret=$result['money'];
                
            }else{
                //过期了
                $ret=-2;
            }
            
        }else{
            //被用过了
            $ret=-1;
        }
    }else{
        //这里是找不到优惠码
        $ret=-3;
    }
    
    return $ret;
}


/**
* 使用优惠码，调用此函数会将优惠码弃用，所以如果想要验证优惠码而不是使用优惠码，请使用isCode()函数
* Discount
* =================================
* 创建日期：2017年11月24日07:56:52
* 作者：代码狮
* github：https://github.com/ALNY-AC
* 微信:AJS0314
* QQ:1173197065
* 留言：后来者想了解详细情况的请联系作者。
* =================================
*
* @param float code 想要使用的优惠码
* @return int 返回此优惠码的状态，如果是-1，就代表优惠码已经被使用
* @return int 返回此优惠码的状态，如果是-2，就代表优惠码已经过期
* @return int 返回此优惠码的状态，如果是-3，就代表找不到这个优惠码
* @return float 返回此优惠码的状态，如果是>=0，就是优惠码可以优惠的金额
*/
function useCode($code){
    //最新修改时间2017年11月24日07:57:06
    
    //再算优惠码 a75970e82b9722853e8fc36c39461f09
    //创建优惠码模型
    $model=M('DiscountCode');
    //设置条件：id
    $where['discount_code_id']=$code;
    $result=$model->where($where)->find();
    
    if($result){
        //这里是找到了优惠码
        
        if($result['is_use']==0){
            //还没用过
            //检测过期没
            $time=time();//当前的时间
            if($time<$result['end_time']){
                //没过期
                //这里就代表优惠码可以使用
                $ret=$result['money'];
                //把优惠码弃用
                $save['is_use']=1;
                $model->where($where)->save($save);
            }else{
                //过期了
                $ret=-2;
            }
            
        }else{
            //被用过了
            $ret=-1;
        }
    }else{
        //这里是找不到优惠码
        $ret=-3;
    }
    
    return $ret;
    
    
    
}