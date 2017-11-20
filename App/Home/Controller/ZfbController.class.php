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
        
        /**************************支付宝配置**************************/
        $alipay_config['partner']        = '2088****284';
        $alipay_config['seller_email']    = 'support@finance365.com';
        $alipay_config['key']            = 'wvajc*************bixumm';
        $alipay_config['sign_type']    = strtoupper('MD5');
        $alipay_config['input_charset']= strtolower('utf-8');
        //cacert.pem文件放根目录 log.txt也放根目录
        //cacert.pem 是签名用的 log.txt是调试用写日志的
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        $alipay_config['transport']    = 'http';
        //异步地址 就是支付完支付宝服务器会向这个地址发送数据,防止订单丢失
        $notify_url="http://你的域名".U("Alipay/notify_url");
        //同步跳转地址 就是支付完后跳转到这里
        $return_url="http://你的域名".U("Alipay/return_url");
        //注意伪静态隐藏index.php 否则无效 因回调地址带 xxx.php?a=b GET参数
        //伪静态后地址 http://abc.com/Alipay/return_url.html 不可有GET哈
        
        /**************************支付宝配置**************************/
        $price=$_POST['price'];//支付金额
        $out_trade_no="M".Date("YmdHis",time()).time();//商户订单号
        vendor('AliPay.alipay_submit#class');//引入支付宝类库
        
        /**************************存入充值记录**************************/
        $data['uid']=session('id');
        $data['rmb']=$price;
        $data['type']="支付宝";
        $data['code']=$out_trade_no;
        $data['time']=time();
        $data['yes']=0;
        $ispay=M('Pay')->add($data);
        if(!$ispay){
            $this->error("订单写入失败");//提交过来入库,如果入库失败,则不往下执行支付宝
        }
        
        /**************************请求参数**************************/
        //支付类型
        $payment_type = "1";
        //商户订单号
        $out_trade_no = $out_trade_no;
        //订单名称
        $subject = "梦币充值";
        //必填
        //付款金额
        $price = $price;
        //必填
        //商品数量
        $quantity = "1";
        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
        $logistics_fee = "0.00";
        //必填，即运费
        //物流类型
        $logistics_type = "EXPRESS";
        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
        //物流支付方式
        $logistics_payment = "SELLER_PAY";
        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        //订单描述
        $body = "梦雪psd下载网 - 梦币充值";
        //商品展示地址
        $show_url = "http://www.qq839.com/index.php";
        //需以http://开头的完整路径，如：http://www.商户网站.com/myorder.html
        //收货人姓名
        $receive_name = $_POST['WIDreceive_name'];
        //如：张三
        //收货人地址
        $receive_address = $_POST['WIDreceive_address'];
        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
        //收货人邮编
        $receive_zip = $_POST['WIDreceive_zip'];
        //如：123456
        //收货人电话号码
        $receive_phone = $_POST['WIDreceive_phone'];
        //如：0571-88158090
        //收货人手机号码
        $receive_mobile = $_POST['WIDreceive_mobile'];
        //如：13312341234
        /************************************************************/
        //构造要请求的参数数组，无需改动
        $parameter = array(
        "service" => "trade_create_by_buyer",
        "partner" => trim($alipay_config['partner']),
        "seller_email" => trim($alipay_config['seller_email']),
        "payment_type"    => $payment_type,
        "notify_url"    => $notify_url,
        "return_url"    => $return_url,
        "out_trade_no"    => $out_trade_no,
        "subject"    => $subject,
        "price"    => $price,
        "quantity"    => $quantity,
        "logistics_fee"    => $logistics_fee,
        "logistics_type"    => $logistics_type,
        "logistics_payment"    => $logistics_payment,
        "body"    => $body,
        "show_url"    => $show_url,
        "receive_name"    => $receive_name,
        "receive_address"    => $receive_address,
        "receive_zip"    => $receive_zip,
        "receive_phone"    => $receive_phone,
        "receive_mobile"    => $receive_mobile,
        "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );
        
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
        
        
    }
    
    
}