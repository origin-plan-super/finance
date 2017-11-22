<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>导出</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>

<body>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success" id="down">下载表格</button>
                <hr>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12 ">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm" id="table">
                        <thead>
                            <tr>
                                <th>订单号</th>
                                <th>用户账户</th>
                                <th>订单金额</th>
                                <th>支付方式</th>
                                <th>支付状态</th>
                                <th>添加时间</th>
                                <th>最后修改时间</th>
                                <th>支付方账户</th>
                                <!-- 课程 -->
                                <th>课程id</th>
                                <th>科目</th>
                                <!-- 用户信息 -->
                                <th>姓名</th>
                                <th>手机号</th>
                                <th>邮箱</th>
                                <th>身份证号</th>
                                <th>生日</th>
                                <th>备注</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($table)): $i = 0; $__LIST__ = $table;if( count($__LIST__)==0 ) : echo "没有信息" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($vol["order_id"]); ?></td>
                                    <td><?php echo ($vol["user_pid"]); ?></td>
                                    <td><?php echo ($vol["money"]); ?></td>
                                    <td>
                                        <?php if($vol["method"] == 0 ): ?><span class="label label-info">支付宝</span><?php endif; ?>
                                        <?php if($vol["method"] == 1 ): ?><span class="label label-success">微信</span><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($vol["state"] == 0 ): ?><span class="label label-warning">未支付</span><?php endif; ?>
                                        <?php if($vol["state"] == 1 ): ?><span class="">已支付</span><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo (date('Y-m-d H:i:s',$vol["add_time"])); ?>
                                    </td>
                                    <td>
                                        <?php echo (date('Y-m-d H:i:s',$vol["edit_time"])); ?>
                                    </td>
                                    <td><?php echo ($vol["z_payment_buyer_email"]); ?></td>
                                    <!-- 课程信息 -->
                                    <td><?php echo ($vol["exam_id"]); ?></td>
                                    <td><?php echo ($vol["exam_subject"]); ?></td>
                                    <!-- 用户信息 -->
                                    <td><?php echo ($vol["user_name"]); ?></td>
                                    <td><?php echo ($vol["user_phone"]); ?></td>
                                    <td><?php echo ($vol["user_email"]); ?></td>
                                    <td><?php echo ($vol['user_uid']); ?>&nbsp</td>
                                    <td><?php echo ($vol["user_day"]); ?></td>
                                    <td><?php echo ($vol["user_info"]); ?></td>
                                </tr><?php endforeach; endif; else: echo "没有信息" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>







    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

    <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>

    <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

    <!-- <script src="/finance/Public/vendor/jquery/jquery.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="/finance/Public/vendor/tableExport/tableExport.min.js" type="text/javascript" charset="utf-8"></script>

    <script>


        $('#down').on('click', function () {
            $('#table').tableExport({
                filename: "<?php echo ($fileName); ?>",
                format: 'xls'
            });
        });


    </script>
</body>

</html>