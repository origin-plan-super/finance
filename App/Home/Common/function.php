<?php
//判断是否是手机
function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
    return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
        'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
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