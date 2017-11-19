<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 定义应用目录
define('APP_PATH','./App/');
// +----------------------------------------------------------------------
// 全局key
define('__KEY__', 'finance12138..');
//定义工作路径
define('WORKING_PATH', str_replace('\\', '/', __DIR__));
//定义上传的跟目录——用户
define('UPLOAD_ROOT_PATH_USER', '/Public/Upload/user/');
//定义上传的跟目录——管理
define('UPLOAD_ROOT_PATH_ADMIN', '/Public/Upload/admin/');
// +----------------------------------------------------------------------

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单