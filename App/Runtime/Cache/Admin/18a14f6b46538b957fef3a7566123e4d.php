<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加科目</title>
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
        body {
            padding: 15px;
        }
    </style>

</head>

<body>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>为【<?php echo ($exam_info["exam_name"]); ?>】添加科目</legend>
        <div class="layui-field-box">
        </div>
    </fieldset>
    <form class="layui-form" style="width: 600px;" action="" method="post">

        <!--  -->
        <input type="hidden" name="exam_id" value="<?php echo ($exam_info["exam_id"]); ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">科目名称：</label>
            <div class="layui-input-block">
                <input lay-verify='required' type="text" name="title" placeholder="请输入科目名称" autocomplete="off" class="layui-input">
            </div>
        </div>

        <!--  -->

        <div class="layui-form-item">
            <label class="layui-form-label">报考日期：</label>
            <div class="layui-input-block">
                <!-- 注意：这一层元素并不是必须的 -->
                <input lay-verify='required' type="text" name="date" class="layui-input" id="date" placeholder="请选择日期">
            </div>

        </div>

        <!--  -->

        <div class="layui-form-item">
            <label class="layui-form-label">场次时间：</label>
            <div class="layui-input-block">
                <input lay-verify='required' type="text" name="time" class="layui-input" id="time_start" placeholder="开始时间">
            </div>

        </div>

        <!--  -->

        <div class="layui-form-item">
            <label class="layui-form-label">考位数量：</label>
            <div class="layui-input-block">
                <input lay-verify='required' type="number" name="max_num" placeholder="考位数量" autocomplete="off" class="layui-input">
            </div>
        </div>
        <!--  -->

        <div class="layui-form-item">
            <label class="layui-form-label">考试价格：</label>
            <div class="layui-input-block">
                <input lay-verify='required' type="number" name="money" placeholder="考试价格" autocomplete="off" class="layui-input">
            </div>
        </div>
        <!--  -->

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>

        <!--  -->

    </form>
    <div id="test">

    </div>
    <script>
        layui.use(['form', 'laydate'], function () {
            var form = layui.form;
            var laydate = layui.laydate;

            //日期选择器
            laydate.render({
                elem: '#date' //指定元素
                , format: 'yyyy年MM月dd日' //可任意组合
            });

            //开始时间
            laydate.render({
                elem: '#time_start'
                , type: 'time'
                , format: 'HH:mm' //可任意组合
                , range: true
            });

            form.on('submit(*)', function (data) {
                // console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
                // console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
                // console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}

                $.post('', data.field, function (res) {

                    res = JSON.parse(res);
                    if (res.res == 0) {
                        layer.msg('添加成功~', {
                            offset: '80%'
                        });

                    } else {
                        layer.msg(res.msg, {
                            offset: '80%'
                        });
                    }

                });


                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });


        });
    </script>
</body>

</html>