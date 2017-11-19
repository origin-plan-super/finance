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
'DB_PWD' => 'mysqlyh12138..', // 密码
'DB_PORT' => '3306', // 端口
'DB_PREFIX' => 'fi_', // 数据库表前缀

// 动态加载文件
'LOAD_EXT_FILE' => 'info' // 多个文件用英文半角逗号分隔

);