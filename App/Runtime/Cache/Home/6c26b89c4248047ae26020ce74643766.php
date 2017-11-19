<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- ng-app="ionicApp" -->
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>我的购物车</title>
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/all/all.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/shopBag/shopBag.css" />
    <link href="/finance/Public/vendor/layui/css/layui.css" rel="stylesheet" type="text/css">

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

        .btn.focus,
        .btn:focus,
        .btn:hover {
            color: white;
            text-decoration: none;
        }

        .cur-pointer {
            cursor: pointer;
        }

        .cur-pointer:hover {
            color: red;
        }

        s .cur-icon {
            cursor: pointer;
        }

        .layui-form-checked[lay-skin=primary] i {
            border-color: #9c0903;
            background-color: #9c0903;
            color: #fff;
        }


        .layui-form-checkbox[lay-skin=primary]:hover i {
            border-color: #9c0903;
            color: #fff;
        }
    </style>
</head>

<body>
    <form class="shopBag layui-form" action='<?php echo U("Order/order");?>' method="post">
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
                <div class="col-xs-12 shopBag-sign text-left">
                    <h2 class="inde-sign-font">我的购物车</h2>
                </div>
            </div>
        </div>
        <!-- 表格 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-2">

                </div>
                <div class="col-xs-8">
                    <!-- 表格部分 -->
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th></th>
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
                                    <td>
                                        <input type="checkbox" name="sign_id[]" lay-skin="primary" value='<?php echo ($vol["sign_id"]); ?>'>
                                    </td>
                                    <td><?php echo ($vol["exam_name"]); ?></td>
                                    <td><?php echo ($vol["exam_date"]); ?></td>
                                    <td><?php echo ($vol["exam_time"]); ?></td>
                                    <td><?php echo ($vol["exam_subject"]); ?></td>
                                    <td><?php echo ($vol["exam_money"]); ?></td>
                                    <td class="cur-pointer del" data-id='<?php echo ($vol["sign_id"]); ?>'>删除</td>
                                </tr><?php endforeach; endif; else: echo "没有信息" ;endif; ?>
                        </tbody>
                    </table>
                    <!-- 表格部分 -->
                </div>
                <div class="col-xs-2"></div>
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
                        <!-- 满1000元减100元，满10科减100元。 -->

                        <?php if(is_array($discount)): $i = 0; $__LIST__ = $discount;if( count($__LIST__)==0 ) : echo "没有优惠信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?>满<?php echo ($vol["full"]); ?>元减<?php echo ($vol["red"]); ?>元
                            <?php if($i < count($discount)): ?>，<?php endif; endforeach; endif; else: echo "没有优惠信息" ;endif; ?>

                    </span>
                </div>
                <div class="col-xs-2">

                </div>
            </div>
        </div>
        <!-- 去结算 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-2 text-right">
                </div>
                <div class="col-xs-8">
                    <div class="col-xs-10  text-right">
                        <span>已减<?php echo ($red); ?>元</span>
                        <br>
                        <span>合计：
                            <span style="color:red"><?php echo ($sub_money); ?></span>元</span>
                    </div>
                    <div class="col-xs-2  text-right">
                        <button type="submit" class="btn btn-red goPay">去结算</button>
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


    </form>

    <script src="/finance/Public/vendor/jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/dist/all/all.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/vendor/layer/layer.js"></script>
    <script src="/finance/Public/vendor/layui/layui.js"></script>
    <script src="/finance/Public/dist/tool/tool.js" type="text/javascript" charset="utf-8"></script>


    <script>


        layui.use('form', function () {
            var form = layui.form;

        });


        $(document).on('click', '.del', function () {

            var id = $(this).attr('data-id');
            var _this = $(this);

            $.post('/finance/index.php/Home/ShopBag/del', {
                sign_id: id
            }, function (res) {

                res = JSON.parse(res);
                if (res.res == 0) {

                    _this.parents('tr').remove();

                } else {
                    w(res);
                    layer.msg('删除失败~' + res.msg, {
                        offset: '80%'
                    });
                }

            });

        });




    </script>
</body>

</html>