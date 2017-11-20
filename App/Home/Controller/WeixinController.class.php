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
* #####微信支付控制器#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class WeixinController extends Controller {
    
    /**
    * 获得二维码
    */
    /**
    * @功能描述： 入口模块
    * @作者 希尔瓦柯
    * @时间 2016-9-2下午2:28:25
    */
    public function get(){
        
        ini_set ( 'date.timezone', 'Asia/Shanghai' );
        error_reporting ( E_ERROR );
        import ( "@.Controller.WxPay.WxPayNativePay" );
        $notify = new \WxPayNativePay ();
        $url1 = $notify->GetPrePayUrl ( "123456789" );
        // 模式二
        /**
        * 流程：
        * 1、调用统一下单，取得code_url，生成二维码
        * 2、用户扫描二维码，进行支付
        * 3、支付完成之后，微信服务器会通知支付成功
        * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
        */
        // $price = $_POST ['price'];
        $prodect_id = $_GET ['order_id'];
        
        $model=M('order');
        $where['order_id']=$prodect_id ;
        $order_info=$model -> where($where)->find();
        
        
        
        // $premission_name = $_POST ['premission_name'];
        //钱
        $price = $order_info['money'];
        //商品id
        // $prodect_id = rand ( 2, 8 );
        //把id放在商品名上
        $premission_name = $prodect_id;
        //开始处理
        $input = new \WxPayUnifiedOrder ();
        //商品的名称，商品描述
        $input->SetBody ( "财金通---" . $premission_name );
        
        
        $input->SetAttach ( "财金通-Attach" );
        $input->SetOut_trade_no ( \WxPayConfig::MCHID . date ( "YmdHis" ) );
        $input->SetTotal_fee ( $price * 100 );
        $input->SetTime_start ( date ( "YmdHis" ) );
        $input->SetTime_expire ( date ( "YmdHis", time () + 600 ) );
        $input->SetGoods_tag ( "财金通-tag" );
        //回调
        $input->SetNotify_url ( "http://120.78.162.200:12138/finance/index.php/home/Weixin/notify" );
        $input->SetTrade_type ( "NATIVE" );
        $input->SetProduct_id ( rand ( 4, 8 ) );
        $result = $notify->GetPayUrl ( $input );
        $url2 = $result ["code_url"];
        // 生成二维码
        error_reporting ( E_ERROR );
        import ( "@.Controller.WxPay.PHPQRCODE" );
        $url = urldecode ( $url2 );
        \QRcode::png ( $url );
        
        
    }
    /**
    * @功能描述：微信支付回调处理
    * @作者 希尔瓦柯
    * @时间 2016-9-22下午3:41:59
    */
    public function notify() {
        echo 1;
        // 获取微信回调的数据
        $notifiedData = $GLOBALS ['HTTP_RAW_POST_DATA'];
        // 加载相关的类
        import ( "@.Controller.WxPay.WxPayNativePay" );
        import ( "@.Controller.WxPay.WxPayData" );
        import ( "@.Controller.WxPay.WxPayNotify" );
        import ( "@.Controller.WxPay.PayNotifyCallBack" );
        
        // 转成数组 并写入缓存
        F ( "wx_notified_data", \WxPayDataBase::FromXml_4_babbage ( $notifiedData ) );
        // 吧xml原型也写入xml
        F ( "wx_notified_data_xml", $notifiedData );
        
        // 给微信返回支付状态值
        $notify = new \PayNotifyCallBack ();
        // 返回状态
        $notify->Handle ( false );
    }
    public function getNotify() {
        dump(F("wx_notified_data"));
        dump(F("wx_notified_data_xml"));
        dump(F("wxpay_HTTP_RAW_POST_DATA"));
    }
}