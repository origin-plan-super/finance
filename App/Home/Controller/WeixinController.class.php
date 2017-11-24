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
        $order_id = $_GET ['order_id'];
        
        $model=M('order');
        $where['order_id']=$order_id ;
        $order_info=$model -> where($where)->find();
        
        
        
        // $premission_name = $_POST ['premission_name'];
        //钱
        $price = $order_info['money'];
        //商品id
        //把id放在商品名上
        $premission_name = $order_id;
        //开始处理
        $input = new \WxPayUnifiedOrder ();
        //商品的名称，商品描述
        $input->SetBody ( "财金通---" . $premission_name );
        
        $input->SetAttach ( "财金通-Attach" );
        
        // $out_trade_no=\WxPayConfig::MCHID . date ( "YmdHis" );
        $out_trade_no=$order_id;
        // session('out_trade_no',$out_trade_no);
        $input->SetOut_trade_no ( $out_trade_no );
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
        // 获取微信回调的数据
        $notifiedData = $GLOBALS ['HTTP_RAW_POST_DATA'];
        // 加载相关的类
        import ( "@.Controller.WxPay.WxPayNativePay" );
        import ( "@.Controller.WxPay.WxPayData" );
        import ( "@.Controller.WxPay.WxPayNotify" );
        import ( "@.Controller.WxPay.PayNotifyCallBack" );
        
        $wx_notified_data=\WxPayDataBase::FromXml_4_babbage ( $notifiedData ) ;
        
        // 转成数组 并写入缓存
        F ( "wx_notified_data", $wx_notified_data);
        // 吧xml原型也写入xml
        F ( "wx_notified_data_xml", $notifiedData );
        /**
        * 这里要对订单数据库进行操作
        */
        
        if($wx_notified_data['result_code']==='SUCCESS'){
            //支付成功
            $where['order_id']=$wx_notified_data['out_trade_no'];
            $model=M('Order');
            $save['w_openid']=$wx_notified_data['w_openid'];
            $save['state']=1;
            $order->where($where)->save($save);
            F(session('user_id').'wx_info','SUCCESS');
        }else{
            F(session('user_id').'wx_info','ERROR');
        }
        
        
        // 给微信返回支付状态值
        $notify = new \PayNotifyCallBack ();
        // 返回状态
        $notify->Handle ( false );
    }
    public function getNotify() {
        
        
        
        echo F(session('user_id').'wx_info');
        F(session('user_id').'wx_info',null);
        // echo 'SUCCESS';
        
        // dump(F("wx_notified_data"));
        
        // dump(F("wx_notified_data_xml"));
        // dump(F("wxpay_HTTP_RAW_POST_DATA"));
        
        
        // C:\App\finance\ThinkPHP\Common\functions.php:842:
        // array (size=17)
        //   'appid' => string 'wx27f56521bd47f6fd' (length=18)
        //   'attach' => string '财金通-Attach' (length=16)
        //   'bank_type' => string 'CFT' (length=3)
        //   'cash_fee' => string '1' (length=1)
        //   'fee_type' => string 'CNY' (length=3)
        //   'is_subscribe' => string 'N' (length=1)
        //   'mch_id' => string '1346662401' (length=10)
        //   'nonce_str' => string 'oumgtlf88drpnvzsshp7wym7jpu6tdod' (length=32)
        //   'openid' => string 'oAq7fvhPtNSCCsIUwV4xI81mANRI' (length=28)
        //   'out_trade_no' => string '134666240120171124085249' (length=24)//订单号
        //   'result_code' => string 'SUCCESS' (length=7)//交易标识
        //   'return_code' => string 'SUCCESS' (length=7)
        //   'sign' => string '6B98DCDB9B1802AFD581869042BACA39' (length=32)
        //   'time_end' => string '20171124085309' (length=14)
        //   'total_fee' => string '1' (length=1)
        //   'trade_type' => string 'NATIVE' (length=6)
        //   'transaction_id' => string '4200000025201711246659351181' (length=28)
        
        
        
        // C:\App\finance\ThinkPHP\Common\functions.php:842:string '<xml><appid><![CDATA[wx27f56521bd47f6fd]]></appid>
        // <attach><![CDATA[财金通-Attach]]></attach>
        // <bank_type><![CDATA[CFT]]></bank_type>
        // <cash_fee><![CDATA[1]]></cash_fee>
        // <fee_type><![CDATA[CNY]]></fee_type>
        // <is_subscribe><![CDATA[N]]></is_subscribe>
        // <mch_id><![CDATA[1346662401]]></mch_id>
        // <nonce_str><![CDATA[oumgtlf88drpnvzsshp7wym7jpu6tdod]]></nonce_str>
        // <openid><![CDATA[oAq7fvhPtNSCCsIUwV4xI81mANRI]]></openid>
        // <out_trade_no><![CDATA[134666240120171124085249]]></out_trade_no>
        // <result_code><![CDATA[SUCCESS'... (length=832)
        
        // C:\App\finance\ThinkPHP\Common\functions.php:842:boolean false
        
    }
    
}