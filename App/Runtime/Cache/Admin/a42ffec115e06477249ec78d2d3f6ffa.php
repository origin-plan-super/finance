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
                        <tr>
                            <th style='width:150px'>课程：</th>
                            <td>

                                <?php if(is_array($order["exam_info"])): $i = 0; $__LIST__ = $order["exam_info"];if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><span><?php echo ($vol["exam_name"]); ?>
                                        <?php if($i < count($order['exam_info'])): ?>，<?php endif; ?>
                                    </span><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th style='width:150px'>课程ID：</th>
                            <td>

                                <?php if(is_array($order["exam_info"])): $i = 0; $__LIST__ = $order["exam_info"];if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><span><?php echo ($vol["exam_id"]); ?>
                                        <?php if($i < count($order['exam_info'])): ?>，<?php endif; ?>
                                    </span><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                            </td>
                        </tr>
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