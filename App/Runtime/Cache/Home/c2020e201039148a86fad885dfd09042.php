<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>个人中心</title>
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/all/all.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/user/user.css" />
    <style>
        .pagination>li>a,
        .pagination>li>span {
            margin-left: 17px;
        }

        .cur-icon {
            cursor: pointer;
        }

        .table-test {
            /* position: relative;
            margin: 0 auto;
            min-width: 1000px;
            white-space: 1000px */
        }
    </style>
</head>

<body>
    <div class="user">
        <!-- 表头的导航栏 表头样式统一在allcss里边 -->
        <!-- 页眉-图片部分 -->
<div class="index-package1">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 index-left-one text-left">
				<img src="/finance/Public/img/top-left.png" />
				<img class="secondImg" src="/finance/Public/img/top-left2.png" />
			</div>
			<div class="col-xs-6 index-right text-right">
				<img src="/finance/Public/img/top-right.png" />
			</div>
		</div>
	</div>
</div>

        <!-- 个人中心大字 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 user-sign text-center">
                    <h2 class="inde-sign-font">个人中心</h2>
                </div>
            </div>
        </div>
        <!-- 我的订单字 -->
        <div class="container">
            <div class="row">

                <div class="col-xs-8 user-sign text-left">
                    <h3 class="">我的报名信息</h3>
                </div>

            </div>
        </div>
        <!-- 表格 -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 table-responsive table-test" style="padding:0 120px ">
                    <!-- 表格部分 -->
                    <!-- style="white-space:nowrap" -->
                    <table class="table table-bordered table-hover text-center" style="text-overflow: ellipsis;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>考试名称</th>
                                <th>报考日期</th>
                                <th>场次</th>
                                <th>考试科目</th>
                                <th>价格</th>
                                <!-- 用户信息 -->
                                <th>姓名</th>
                                <th>手机</th>
                                <th>邮箱</th>
                                <th>注册ID</th>
                                <th>身份证</th>
                                <th>出生年月</th>
                                <th>备注</th>
                            </tr>
                        </thead>
                        <tbody class="cell-color">
                            <!-- 
                                [0] => array(16) {
                                    ["exam_id"] => string(32) "3a126424ee15140a5b6e0236e2b324e1"
                                    ["exam_date"] => string(17) "2017年11月19日"
                                    ["exam_time"] => string(13) "00:00 - 00:00"
                                    ["exam_money"] => string(5) "20.99"
                                    ["exam_name"] => string(6) "高考"
                                    ["sign_id"] => string(32) "46e3347b338cfbe676a5ba6efbdb04ce"
                                    ["exam_subject"] => string(6) "语文"
                                    ["user_name"] => string(9) "李传浩"
                                    ["user_phone"] => string(3) "110"
                                    ["user_email"] => string(10) "110@qq.com"
                                    ["user_pid"] => string(3) "123"
                                    ["user_uid"] => string(3) "321"
                                    ["user_day"] => string(17) "2017年11月19日"
                                    ["user_info"] => string(6) "啥？"
                                    ["add_time"] => string(10) "1511050718"
                                    ["edit_time"] => string(10) "1511050718"
                                  } -->
                            <?php if(is_array($user_exam_info)): $i = 0; $__LIST__ = $user_exam_info;if( count($__LIST__)==0 ) : echo "没有信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($vol["exam_name"]); ?></td>
                                    <td><?php echo ($vol["exam_date"]); ?></td>
                                    <td><?php echo ($vol["exam_time"]); ?></td>
                                    <td><?php echo ($vol["exam_subject"]); ?></td>
                                    <td><?php echo ($vol["exam_money"]); ?></td>
                                    <!-- 用户信息 -->
                                    <td><?php echo ($vol["user_name"]); ?></td>
                                    <td><?php echo ($vol["user_phone"]); ?></td>
                                    <td><?php echo ($vol["user_email"]); ?></td>
                                    <td><?php echo ($vol["user_pid"]); ?></td>
                                    <td><?php echo ($vol["user_uid"]); ?></td>
                                    <td><?php echo ($vol["user_day"]); ?></td>
                                    <td><?php echo ($vol["user_info"]); ?></td>
                                </tr><?php endforeach; endif; else: echo "没有信息" ;endif; ?>


                        </tbody>
                    </table>
                    <!-- 表格部分 -->
                </div>
            </div>
        </div>
        <!-- 我的报名信息 -->
        <!-- <div class="container">
            <div class="row">
                <div class="col-xs-8 text-left">
                    <h3 class="">我的报名信息</h3>
                </div>
            </div>
        </div> -->
        <!-- 信息部分 -->
        <!-- <div class="container">
            <div class="row">
                <div class="col-xs-2"></div>
                <div class="col-xs-8 text-left infor-color">
                    <span class="information">考试科目：</span>
                    <span>F1</span>
                    <span class="information">姓名：</span>
                    <span>张三</span>
                    <span class="information">手机：</span>
                    <span>12312313131</span>
                    <span class="information">邮箱：</span>
                    <span>98871@qq.com</span>
                    <br>
                    <span class="information">注册ID：</span>
                    <span>2414</span>
                    <span class="information">身份证：</span>
                    <span>1314141241541515</span>
                    <span class="information">出生年月</span>
                    <span>19871122</span>
                    <br>
                    <span class="information">备注：</span>
                    <span>2325252525</span>
                </div>
                <div class="col-xs-2"></div>
            </div>
        </div> -->
        <!-- 右侧悬浮的图标  -->
        <style type="text/css">
	.glyphicon {
		position: relative;
		top: 1px;
		line-height: 50px;
		display: inline-block;
		font-family: 'Glyphicons Halflings';
		font-style: normal;
		font-weight: 400;
		/* line-height: 1; */
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}
</style>
<!-- 右侧悬浮的图标   -->
<!-- 右侧悬浮的图标   -->
<div id="fudong">
	<a href="<?php echo U('Index/index');?>">
		<div class="fk fudong0">
			<span class="glyphicon glyphicon glyphicon-home userCenter cur-icon"></span>
		</div>
	</a>
	<a href="<?php echo U('User/User');?>">

		<div class="fk fudong1">
			<span class="glyphicon glyphicon-user userCenter cur-icon"></span>
		</div>
	</a>
	<a href="<?php echo U('ShopBag/ShopBag');?>">
		<div class="fk fudong2">
			<span class="glyphicon glyphicon-shopping-cart shopBag cur-icon"></span>
		</div>
	</a>
</div>


    </div>

    <script src="/finance/Public/vendor/jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/dist/user/user.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/dist/all/all.js" type="text/javascript" charset="utf-8"></script>
    <script>

    </script>
</body>

</html>