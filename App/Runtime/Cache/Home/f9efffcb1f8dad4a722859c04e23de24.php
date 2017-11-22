<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/all/all.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/finance/Public/dist/index/index.css" />


    <style>
        .pagination>li>a,
        .pagination>li>span {
            margin-left: 17px;
        }


        .active {
            background: red;
        }

        .pagination>li>a,
        .pagination>li>span {
            color: #919191;
            background-color: #f5f5f5;
        }

        .selected {
            background: red;
        }

        /* 分页 */

        .pagination>.active>a,
        .pagination>.active>a:focus,
        .pagination>.active>a:hover,
        .pagination>.active>span,
        .pagination>.active>span:focus,
        .pagination>.active>span:hover {
            z-index: -1;
            color: #fff;
            cursor: default;
            background-color: #9c0903;
            border-color: #9c0903;
        }

        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            z-index: 2;
            color: gray;
            background-color: #eee;
            border-color: #ddd;
        }

        .cur-pointer {
            cursor: pointer;
        }

        .cur-pointer:hover {
            color: red;
        }

        .cur-icon {
            cursor: pointer;
        }

        #info * {
            max-width: 100%;
        }

        .form-login {
            position: relative;
            width: 300px;
            margin: 0 auto;
        }

        .btn-red {
            background-color: #9c0903;
            color: white;
        }

        .btn-red:hover {
            background-color: #9c0903;
            color: white;
        }
    </style>
</head>

<body>
    <div class="index">
        <!-- 页眉-图片部分 -->

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


        <!-- 报名系统 红色字体 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 index-sign text-center">
                    <h2 class="inde-sign-font">请登录</h2>
                </div>
            </div>
        </div>
        <!-- 登录页 -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 ">

                    <form class="form-login" method="post">
                        <label for="user_pid">手机号</label>

                        <div class="input-group form-group">
                            <input type="text" class="form-control" id="user_pid" name="user_pid" placeholder="手机号" value="13914896237">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="getCode">获取验证码</button>
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="user_code">短信验证码</label>
                            <input type="text" name="user_code" class="form-control" id="user_code" placeholder="短信验证码">
                        </div>
                        <button type="submit" class="btn btn-default btn-red">登录</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- 右侧悬浮的图标   -->
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
    <script src="/finance/Public/dist/all/all.js" type="text/javascript" charset="utf-8"></script>
    <script src="/finance/Public/vendor/layer/layer.js"></script>
    <script src="/finance/Public/vendor/layui/layui.js"></script>
    <script src="/finance/Public/dist/tool/tool.js" type="text/javascript" charset="utf-8"></script>

    <script>


        var num = 2;
        var count = num;
        $('#getCode').on('click', function () {
            $this = $(this).attr('disabled', 'disabled');


            var url = '/finance/Public/SUBMAIL_PHP_SDK/demo/message_xsend_demo.php?user_pid=' + $('#user_pid').val();
            $.get(url, function (res) {
                // $('#info').html(res);
                res = JSON.parse(res);

                if (res.status == 'success') {
                    //发送成功

                    $this.text(count)
                    var Interval = setInterval(function () {
                        count--;
                        $this.text(count)
                        if (count <= 0) {
                            //计时器完
                            $this.removeAttr('disabled');
                            $this.text('发送验证码');
                            count = num;
                            clearInterval(Interval);
                        }
                    }, 1000);


                } else {
                    //发送失败
                    layer.msg('发送失败，请重试');
                    $this.removeAttr('disabled');
                    $this.text('发送验证码');
                    count = num;
                }


            });


        });;


    </script>

</body>

</html>