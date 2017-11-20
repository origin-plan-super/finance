<?php
/**
* +----------------------------------------------------------------------
* 创建日期：2017年11月20日
* +----------------------------------------------------------------------
* https：//github.com/ALNY-AC
* +----------------------------------------------------------------------
* 微信：AJS0314
* +----------------------------------------------------------------------
* QQ:1173197065
* +----------------------------------------------------------------------
* #####支付宝支付控制器#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class ZfbController extends Controller {
    
    
    public function get(){
        
        vendor("Payment.alipay.alipay","",".class.php");//引入支付宝
        $alipay_config = C("payment.alipay");//获取支付宝配置信息，主要是partnerid和key
        $alipay = new \alipay('2088811669460032','wmml15pjbk8pd3su7jwwwpx94pfwsorc',U("alipay_notify"));//new对象
        
        if(isMobile()){//判断是不是手机端，自动识别并提交至相应的地址
            $alipay->set_alipay_config("service", "alipay.wap.create.direct.pay.by.user");
        }
        //开始支付
        // $notify=U('Zfb/notify');
        // $returnI=U('Zfb/returnI');
        $notify='http://120.78.162.200:12138/finance/Home/zfb/notify';
        $returnI='http://120.78.162.200:12138/finance/Home/zfb/returnI';
        $order_id=rand(1,9999);
        
        $rst = $alipay->pay(0.01, $order_id, '【'.'财金通'.'】购物订单，订单编号：'.$order_id,$notify,$returnI);
        $this->show($rst);//这一步会跳转
        
    }
    
    /**
    * 异步跳转
    */
    public function notify(){
        echo '异步跳转';
        
        dump(I('post.'));
        dump(I('get.'));
        
        F('testpost',I('post.'));
        F('testget',I('get.'));
        
        
    }
    /**同步跳转 */
    public function returnI(){
        echo '同步跳转';
        dump(I('post.'));
        dump(I('get.'));
        
        dump(  F('testpost'));
        dump(  F('testget'));
    }
    
    
}