<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付</title>
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/all/all.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/order/order.css" />
    <!-- css -->
<link href="/finance/Public/vendor/layui/css/layui.css" rel="stylesheet" type="text/css">


<!-- js -->
<script src="/finance/Public/vendor/jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="/finance/Public/vendor/layer/layer.js"></script>
<script src="/finance/Public/vendor/layui/layui.js"></script>
<script src="/finance/Public/dist/tool/tool.js"></script>

<script>

    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
    }
</script>
</head>

<body>

    <!-- 表头的导航栏 表头样式统一在allcss里边 -->
    <style>
	.col-xs-6 {
		/* background-color: #ff0000; */
		/* outline: 1px #00f solid; */
	}

	#topTool {
		position: absolute;
		right: 180px;
		bottom: 0;
		line-height: 0;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	#topTool a {
		display: inline-block;
		background-color: #ca231c;
		border: none;
		width: auto;
	}

	#topTool .fk {
		background-color: #ca231c;
		border: none;
		width: auto;
		height: auto;
		line-height: 1;
		padding: 5px 10px;

	}

	a:hover {
		text-decoration: none;
	}
</style>

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
				<div id="topTool">
					<a href="<?php echo U('Index/index');?>">
						<div class="fk fudong0">
							首页
						</div>
					</a>
					<a href="<?php echo U('User/User');?>">

						<div class="fk fudong1">
							个人中心
						</div>
					</a>
					<a href="<?php echo U('ShopBag/ShopBag');?>">
						<div class="fk fudong2">
							购物车
						</div>
					</a>
				</div>

			</div>

		</div>
	</div>
</div>
    <p><?php echo ($order["order_id"]); ?></p>
    <p><?php echo ($order["money"]); ?></p>
    <p><?php echo ($order["user_pid"]); ?></p>
    <p><?php echo ($order["method"]); ?></p>
    <p><?php echo ($order["exam_id"]); ?></p>

    <img src='<?php echo ($url); ?>' alt="">

    <script>


        //验证是否支付
        setInterval(function () {

            $.get('/finance/index.php/Home/Weixin/getNotify', function (res) {
                if (res == 'SUCCESS') {

                    layer.msg('支付成功！正在为您跳转');

                    setTimeout(function () {
                        window.location.href = '/finance/index.php/Home/User/user';

                    }, 500);

                }

            });


        }, 1000)


// getNotify




    </script>



</body>

</html>