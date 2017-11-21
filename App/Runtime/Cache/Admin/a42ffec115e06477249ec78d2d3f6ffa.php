<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查看订单</title>
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

    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">





</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">订单信息</h2>
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <th style='width:150px'>订单号：</th>
                            <td><?php echo ($order["order_id"]); ?></td>
                        </tr>
                        <tr>
                            <th style='width:150px'>用户：</th>
                            <td><?php echo ($order["user_pid"]); ?></td>
                        </tr>
                        <tr>
                            <th style='width:150px'>交易金额：</th>
                            <td><?php echo ($order["money"]); ?></td>
                        </tr>
                        <tr>
                            <th style='width:150px'>支付方式：</th>
                            <td>
                                <!-- <?php echo ($order["method"]); ?> -->
                                <?php if($order["method"] == 0): ?><span class="badge badge-secondary bg-primary">支付宝</span><?php endif; ?>
                                <?php if($order["method"] == 1): ?><span class="badge badge-secondary bg-success">微信</span><?php endif; ?>

                            </td>
                        </tr>
                        <tr>
                            <th style='width:150px'>状态：</th>
                            <td>
                                <?php if($order["state"] == 0): ?><span class="badge badge-secondary">未支付</span><?php endif; ?>
                                <?php if($order["state"] == 1): ?><span class="badge badge-secondary bg-success">已支付</span><?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <hr/>
                <table class="table table-bordered table-hover table-sm">
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
                    <tbody>
                        <?php if(is_array($order_info)): $i = 0; $__LIST__ = $order_info;if( count($__LIST__)==0 ) : echo "没有信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
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
            </div>
        </div>

    </div>


    <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>

    <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</body>

</html>