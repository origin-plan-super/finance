<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>订单管理</title>
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
        <legend>课程列表</legend>
    </fieldset>
    <div class="layui-row layui-form">
        <div class="layui-col-md4">
            <div class="layui-inline">
                <input class="layui-input" id="key" placeholder="搜索" autocomplete="off">
            </div>
            <button class="layui-btn" id="reload" data-type="reload">搜索</button>
            <button class="layui-btn" id="refresh" data-type="reload">刷新表格</button>
        </div>
        <div class="layui-col-md4 layui-col-md-offset4">
            <div class="layui-form-mid layui-word-aux">在新页面打开查看</div>
            <input type="checkbox" id="isNew" name="xxx" lay-skin="switch">
        </div>
    </div>
    <div class="layui-row" style="padding-top:10px">

        <div class="layui-btn-group">
            <button class="layui-btn layui-btn-sm" id="printAll">
                <i class="layui-icon">&#xe640;</i>批量导出
            </button>
        </div>


    </div>


    <table id="live_table" lay-filter="table_filter"></table>

    <script type="text/html" id="bar1">
        
        <a class="layui-btn layui-btn-xs" lay-event="open">查看</a>
        {{#  if(d.state == 0){ }}
        <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
        {{#  } }}

    </script>

    <script type="text/html" id="bar2">
        <!-- 状态 -->

        {{#  if(d.state == 0){ }}
        <span class="layui-badge layui-bg-gray">未支付</span>
        {{#  } }}

        {{#  if(d.state == 1){ }}
        <span class="layui-badge layui-bg-green">已支付</span>
        {{#  } }}
    </script>

    <script type="text/html" id="bar3">
        <!-- 支付方式 -->
        {{#  if(d.method == 0){ }}
        <span class="layui-badge layui-bg-blue">支付宝</span>
        {{#  } }}

        {{#  if(d.method == 1){ }}
        <span class="layui-badge layui-bg-green">微信</span>
        {{#  } }}
    </script>

    <script type="text/html" id="barTime">
        {{# var a = getLocalTime(d.add_time) }}
        {{ a }}
    </script>

    <script>
        var tableIns;
        var table;
        layui.use(['table', 'form'], function () {
            table = layui.table
                , form = layui.form;
            //第一个实例
            tableIns = table.render({
                id: 'table'
                , elem: '#live_table'
                , url: '/finance/index.php/Admin/Order/getList' //数据接口
                , page: true //开启分页
                , limit: localStorage.limit == null ? 5 : localStorage.limit
                // , limits: [5, 10]
                , cols: [[ //表头
                    { type: 'checkbox', width: 50, fixed: 'lfet' }
                    , { type: 'numbers', width: 50 }
                    , { field: 'order_id', title: '订单号', width: 200 }
                    , { field: 'user_id', title: '用户', width: 200 }
                    , { field: 'money', title: '交易金额', width: 150, edit: 'text' }
                    , { field: 'method', title: '支付方式', width: 100, toolbar: '#bar3', align: 'center' }
                    , { field: 'state', title: '状态', width: 80, toolbar: '#bar2' }
                    , { field: 'add_time', title: '添加时间', width: 200, toolbar: '#barTime' }
                    // , { field: 'edit_time', title: '最后修改时间', width: 200 }
                    , { fixed: 'right', title: '', width: 150, align: 'center', toolbar: '#bar1' }
                    // , { field: 'is_up', fixed: 'right', title: '是否推荐', align: 'center', width: 110, templet: '#checkboxTpl', unresize: true }
                    // , { fixed: 'right', width: 180, align: 'center', title: '操作', toolbar: '#bar1' } //这里的toolbar值是模板元素的选择器
                ]],
                done: function (res, curr, count) {
                    //如果是异步请求数据方式，res即为你接口返回的信息。
                    //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                    // console.log(res);

                    //得到当前页码
                    // console.log(curr);

                    //得到数据总量
                    // console.log(count);
                }
            });



            //监听工具条
            table.on('tool(table_filter)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的DOM对象
                var order_id = data.order_id;
                console.log(layEvent);
                //查看
                var url = '/finance/index.php/Admin/Order/show/order_id/' + order_id;
                console.log(url);
                if (layEvent === 'open') {


                    if ($('#isNew').is(':checked')) {

                        window.open(url);

                    } else {

                        layer.open({
                            type: 2,
                            title: data.order_id + " | " + data.user_id,
                            shadeClose: true,
                            maxmin: true, //开启最大化最小化按钮
                            area: ['80%', '80%'],
                            content: url

                        });
                    }

                }
                if (layEvent === 'del') { //删除

                    layer.confirm('真的删除此条数据吗？', function (index) {
                        //删除对应行（tr）的DOM结构，并更新缓存
                        layer.close(index);
                        //向服务端发送删除指令

                        $.post('/finance/index.php/Admin/Order/del', {
                            "order_id": obj.data.order_id,
                        }, function (res) {
                            res = JSON.parse(res);
                            if (res.res == 0) {
                                layer.msg('删除成功~', {
                                    offset: '80%'
                                });
                                obj.del();

                            } else {
                                layer.msg(res.msg, {
                                    offset: '80%'
                                });
                            }
                        });
                    });
                }
            });

            /**
           监听单元格编辑
           */
            table.on('edit(table_filter)', function (obj) { //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
                console.log(obj.value); //得到修改后的值
                console.log(obj.field); //当前编辑的字段名
                console.log(obj.data); //所在行的所有相关数据  

                var save = {};
                save[obj.field] = obj.value;

                saveInfo({
                    "order_id": obj.data.order_id,
                    "save": save
                }, function (res) {
                    if (res.res == 0) {
                        layer.msg('修改成功~', {
                            offset: '80%'
                        });
                    } else {
                        layer.msg(res.msg, {
                            offset: '80%'
                        });
                    }
                });
            });
        });

        /**
        数据搜索
        */
        $(document).on('click', '#reload', function () {
            var key = $('#key').val();
            //执行重载
            tableIns.reload({
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    key: key
                }
                , done: function (res, curr, count) {
                    //如果是异步请求数据方式，res即为你接口返回的信息。
                    //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                    // console.log(res);

                    //得到当前页码
                    // console.log(curr);

                    //得到数据总量
                    // console.log(count);
                    layer.msg('找到了' + count + '条数据~');
                }
            });

        });

        /**
        表格刷新
        */
        $(document).on('click', '#refresh', function () {
            tableIns.reload({
                url: '/finance/index.php/Admin/Order/getList' //数据接口
            });

        });
        function saveInfo(post, f) {
            $.post('<?php echo U("Order/saveInfo");?>', post, function (res) {
                console.log(res);
                res = JSON.parse(res);
                if (f != null) {
                    f(res);
                }
            });
        }
        /**
                * 批量打印
                */
        $(document).on('click', '#printAll', function () {
            // w('开始批量打印');
            var o = table.checkStatus('table');
            if (o.data.length <= 0) {
                return;
            }
            var id = '';
            for (var i = 0; i < o.data.length; i++) {
                id += "'" + o.data[i].order_id + "',";
            }
            id = id.substring(0, id.length - 1);


            window.location.href = '/finance/index.php/Admin/Order/printXls/order_id/' + id;

        });

    </script>

</body>

</html>