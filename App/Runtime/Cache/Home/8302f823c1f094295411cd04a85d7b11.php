<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- ng-app="ionicApp" -->
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>提交订单</title>
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

    <style>
        .pagination>li>a,
        .pagination>li>span {
            margin-left: 17px;
        }

        .btn-red {
            background-color: #9c0903;
            color: white;
            font-size: 25px;
            padding: 2px 25px;
        }

        .btn-small {
            padding: 3px 17px;
            background-color: #9c0903;
            color: white;
        }

        .btn-small:hover {
            background-color: #9c0903;
            color: white;
        }

        .cur-pointer {
            cursor: pointer;
        }

        .cur-pointer:hover {
            color: red;
        }

        .btn.focus,
        .btn:focus,
        .btn:hover {
            color: #fff;
            text-decoration: none;
        }

        .cur-icon {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="order">
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

        <!-- 提交订单大字 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 order-sign text-left">
                    <h2 class="inde-sign-font" style="padding-top:20px;color:#cb2016">提交订单</h2>
                </div>
            </div>
        </div>
        <!-- 表格 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <!-- 表格部分 -->
                    <table class="table table-bordered table-hover text-center" style="text-overflow: ellipsis;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th class="text-center">考试名称</th>
                                <th class="text-center">报考日期</th>
                                <th class="text-center">场次</th>
                                <th class="text-center">考试科目</th>
                                <th class="text-center">价格</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="cell-color">

                            <?php if(is_array($user_exam_info)): $i = 0; $__LIST__ = $user_exam_info;if( count($__LIST__)==0 ) : echo "没有信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($vol["exam_name"]); ?></td>
                                    <td><?php echo ($vol["date"]); ?></td>
                                    <td><?php echo ($vol["time"]); ?></td>
                                    <td><?php echo ($vol["title"]); ?></td>
                                    <td><?php echo ($vol["money"]); ?></td>
                                    <td class="cur-pointer">删除</td>
                                </tr><?php endforeach; endif; else: echo "没有信息" ;endif; ?>

                        </tbody>
                    </table>
                    <!-- 表格部分 -->
                </div>
            </div>
        </div>
        <!-- 优惠减免 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-2">


                </div>
                <div class="col-xs-8">
                    <span class="discount">优惠减免</span>
                    <span class="reduction">
                        <?php if(is_array($discount)): $i = 0; $__LIST__ = $discount;if( count($__LIST__)==0 ) : echo "没有优惠信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?>满<?php echo ($vol["full"]); ?>元减<?php echo ($vol["red"]); ?>元
                            <?php if($i < count($discount)): ?>，<?php endif; endforeach; endif; else: echo "没有优惠信息" ;endif; ?>
                    </span>
                </div>
                <div class="col-xs-2">

                </div>
            </div>
            <div class="row">
                <div class="col-xs-2">

                </div>
                <div class="col-xs-8">
                    <span class="discount">科目减免</span>

                    <span class="reduction">

                        <?php if(is_array($DiscountSubject)): $i = 0; $__LIST__ = $DiscountSubject;if( count($__LIST__)==0 ) : echo "没有优惠信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?>满<?php echo ($vol["full"]); ?>科目减<?php echo ($vol["red"]); ?>元
                            <?php if($i < count($DiscountSubject)): ?>，<?php endif; endforeach; endif; else: echo "没有优惠信息" ;endif; ?>

                    </span>
                </div>
                <div class="col-xs-2">

                </div>
            </div>
        </div>
        <!-- 使用优惠码 -->
        <div class="container" style="margin-top:1%;">
            <div class="row">
                <div class="col-xs-2">
                </div>
                <div class="col-xs-8 text-left">
                    <span class="discount">使用优惠码</span>
                    <input type="text" style="margin-left:2%;" id="discountCode">
                    <button type="button" class="btn btn-sm btn-small" id="ok">确定</button>
                    <span id="discountCodeBox"></span>

                </div>
                <div class="col-xs-2">
                </div>
            </div>
        </div>
        <!-- 选择支付方式 -->
        <div class="container" style="margin-top:1%;">
            <div class="row">
                <div class="col-xs-2"></div>
                <div class="col-xs-8">
                    <span class="discount">选择支付方式</span>
                </div>
                <div class="col-xs-2"></div>
            </div>
        </div>
        <!-- 支付方式 -->
        <div class="container" style="margin-top:1%;">
            <div class="row">
                <div class="col-xs-2"></div>
                <div class="col-xs-8">


                    <label for="zhifubao">
                        <input type="radio" name="method" id="zhifubao" value="0">
                        <img class="zfb" src="/finance/Public/img/zhifubao.png" alt="" align="middle">
                    </label>
                    <label for="weixin">
                        <input type="radio" name="method" id="weixin" style="margin-right:9px;" value="1">
                        <img class="wx" src="/finance/Public/img/weixin.png" alt="" align="middle">
                    </label>


                </div>
                <div class="col-xs-2"></div>
            </div>
        </div>
        <!-- 去结算 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-2 text-right">
                </div>
                <div class="col-xs-8 text-right">
                    <div class="col-xs-10 text-right">
                        <span>已减
                            <span><?php echo ($red); ?></span>元</span>
                        <br>
                        <span>合计：
                            <span style="color:red" id="sub_money"><?php echo ($sub_money); ?></span>元</span>
                    </div>
                    <div class="col-xs-2 text-right">
                        <button type="button" class="btn btn-red" id="goAdd">去支付</button>
                    </div>
                </div>
                <div class="col-xs-2">
                </div>
            </div>
        </div>


        <!-- 右侧悬浮的图标 -->
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
    <div id="test">

    </div>

    <script src="/finance/Public/vendor/jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/dist/order/order.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/dist/all/all.js" type="text/javascript" charset="utf-8"></script>

    <script>

        var sub_money = parseInt('<?php echo ($sub_money); ?>');


        $('#ok').on('click', function () {
            var discountCode = $('#discountCode').val();
            $.post('/finance/index.php/Home/Order/code', {
                discountCode: discountCode
            }, function (res) {

                res = JSON.parse(res);
                if (res.res > 0) {
                    var money = sub_money;

                    layer.msg('优惠码正确');
                    money -= res.res;
                    money = money.toFixed(2);
                    $('#discountCodeBox').text('已减' + res.res + '元');

                    money = money <= 0 ? 0 : money;
                    $('#sub_money').text(money);

                } else {
                    layer.msg(res.msg);
                }


            });

        });
        /*
        *去支付订单
        */
        $('#goAdd').on('click', function () {

            var method = $('input[name="method"]:checked').val();

            if (method == null) {
                layer.msg('请选择支付方式！');
                return;
            }

            // a75970e82b9722853e8fc36c39461f09
            $.post('/finance/index.php/Home/Order/add', {
                method: method,
                code: $('#discountCode').val()
            }, function (res) {

                // $('#test').html(res);
                res = JSON.parse(res);

                if (res.res == 1) {
                    //订单金额<=0，直接支付完成

                    layer.msg('支付完成~正在为您跳转');
                    setTimeout(function () {
                        window.location.href = '<?php echo U("User/user");?>';
                    }, 500);

                    // window.open('<?php echo U("User/user");?>');
                    return;
                }

                if (res.res == 0) {

                    layer.msg('订单提交成功');
                    if (method == 0) {
                        //支付宝
                        window.location.href = '/finance/index.php/Home/Pay/doalipay/order_id/' + res.msg;

                    }
                    if (method == 1) {
                        //微信
                        window.location.href = '/finance/index.php/Home/Order/payment/order_id/' + res.msg;

                    }


                } else {
                    layer.msg(res.msg);

                }


            });

        })

    </script>
</body>

</html>