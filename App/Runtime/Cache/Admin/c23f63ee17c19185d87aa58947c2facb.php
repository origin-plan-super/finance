<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加优惠码</title>
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
            padding: 15px
        }
    </style>

</head>

<body>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>添加优惠码</legend>
    </fieldset>

    <form class="layui-form">
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label">优惠价格</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" name="money" placeholder="￥" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label">生成数量</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" name="num" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label">过期时间</label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input lay-verify='required' type="text" name="end_time" class="layui-input" id="end_time" placeholder="请选择过期时间">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="*">生成</button>
            </div>
        </div>

    </form>

    <script>
        layui.use(['form', 'laydate'], function () {
            var form = layui.form;
            var laydate = layui.laydate;

            //日期选择器
            laydate.render({
                elem: '#end_time' //指定元素
                , format: 'yyyy-MM-dd' //可任意组合
            });



            form.on('submit(*)', function (data) {
                // console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
                // console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
                // console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}


                var index = layer.load(2, { time: 1000 });
                $.post('', data.field, function (res) {
                    res = JSON.parse(res);

                    w(res);
                    layer.close(index);

                    if (res.res > 0) {
                        layer.msg('生成成功~');
                    } else {
                        layer.msg('生成失败！' + res.msg);
                    }

                });

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });

        });
    </script>
</body>

</html>