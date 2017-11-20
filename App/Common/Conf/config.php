<?php
return array(

'TMPL_PARSE_STRING' => array(

'__VENDOR__' => __ROOT__ . '/Public/vendor', // 配置自定义资源文件夹
'__DIST__' => __ROOT__ . '/Public/dist', // 配置自定义资源文件夹
'__PUBLIC__' => __ROOT__ . '/Public', // 配置自定义资源文件夹

),

/* 数据库设置 */
'DB_TYPE' => 'mysql', // 数据库类型
'DB_HOST' => '127.0.0.1', // 服务器地址
'DB_NAME' => 'finance', // 数据库名
'DB_USER' => 'root', // 用户名
'DB_PWD' => 'mysqlyh12138..', // /home密码
'DB_PORT' => '3306', // 端口
'DB_PREFIX' => 'fi_', // 数据库表前缀

// 动态加载文件
'LOAD_EXT_FILE' => 'info' ,// 多个文件用英文半角逗号分隔

//================================

//支付宝配置参数
'alipay_config'=>array(
'partner' =>'2088811669460032',   //这里是你在成功申请支付宝接口后获取到的PID；
'key'=>'wmml15pjbk8pd3su7jwwwpx94pfwsorc',//这里是你在成功申请支付宝接口后获取到的Key
'sign_type'=>strtoupper('MD5'),
'input_charset'=> strtolower('utf-8'),
'cacert'=> getcwd().'\\cacert.pem',
'transport'=> 'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
),
//以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；

'alipay'=>array(
//这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
'seller_email'=>'support@finance365.com',

//这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
'notify_url'=>'http://120.78.162.200:12138/finance/home/Pay/notifyurl',

//这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
'return_url'=>'http://120.78.162.200:12138/finance/home/Pay/returnurl',

//支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
'successpage'=>'http://120.78.162.200:12138/finance/home/Zfb/myorder?ordtype=payed',

//支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
'errorpage'=>'http://120.78.162.200:12138/finance/home/Zfb/myorder?ordtype=unpay',
),

);