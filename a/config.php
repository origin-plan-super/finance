<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => " 2016041901315502",

		//商户私钥
		'merchant_private_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlrpjeZpTiYB9NAXgcHDvXY582iYYxhoaKzsADy1JaBchd1FYDgkPwFReOF5uCdcSLzr5hp1qC5nP2XvR2IKk7rW8rvAtUza12JDRmOMfGpVfr+Xr5uHAavt6LMl6CoZI2fHZ6XYLHaAm9j1nXRsQvrLTrd45/6IQLBjZHtAPx1GpLVIxl8jZNihoRgQk75XkrSw55AuUSopyxmRWRVJFkfkaEcwmGbe5RS+4qQlQ1d+iW/2lynwqdNUXTJ3BYXGG+9BZMLWlBqVazelAVwH4JYfE6Db9Zttwnd2DQ22VT5Zw1vGBpp4Y301dk5jE2HwKpUpix+U3G63ivXxw7tYUWwIDAQAB",
		
		//异步通知地址
		'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "wmml15pjbk8pd3su7jwwwpx94pfwsorc",
);