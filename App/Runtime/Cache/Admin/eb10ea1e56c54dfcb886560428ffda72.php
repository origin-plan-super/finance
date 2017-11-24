<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>优惠码管理</title>
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
        <legend>优惠码管理</legend>
    </fieldset>
    <div class="layui-row layui-form">
        <div class="layui-col-md4">
            <div class="layui-inline">
                <input class="layui-input" id="key" placeholder="搜索" autocomplete="off">
            </div>
            <button class="layui-btn" id="reload" data-type="reload">搜索</button>

        </div>

    </div>
    <div class="layui-row" style="padding-top:10px">

        <div class="layui-btn-group">
            <button class="layui-btn layui-btn-sm" id="add">
                <i class="layui-icon">&#xe654;</i>新增优惠码
            </button>
            <button class="layui-btn layui-btn-sm" id="removeAll">
                <i class="layui-icon">&#xe640;</i>批量删除
            </button>
        </div>


    </div>

    <table id="table" lay-filter="table_filter"></table>

    <script type="text/html" id="bar1">

        {{#  if(d.is_use > 0){ }}

        <span class="layui-badge">已使用</span>
        
        {{#  } else { }}

        <span class="layui-badge layui-bg-gray">未使用</span>

        {{#  } }}
            
    </script>
    <script type="text/html" id="bar2">

                
        {{# var a = getLocalTime(d.add_time) }}
        {{ a }}
        
    </script>

    <script type="text/html" id="barEndTim">
        
                        
                {{# var a = getLocalTime(d.end_time) }}
                {{ a }}
                
    </script>

    <script type="text/html" id="bar3">

        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>

    </script>
    <script type="text/html" id="isEnd">
        
                {{#  if(d.isEnd == true){ }}
        
                <span class="layui-badge">已过期</span>
                
                {{#  } else { }}
        
                <span class="layui-badge layui-bg-gray">未过期</span>
        
                {{#  } }}
                    
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
                , elem: '#table'
                , url: '/finance/index.php/Admin/DiscountCode/getList' //数据接口
                , page: true //开启分页
                , limit: localStorage.limit == null ? 10 : localStorage.limit
                // , limits: [5, 10]
                , cols: [[ //表头
                    { type: 'checkbox', width: 50, fixed: 'lfet' }
                    , { type: 'numbers', width: 50 }
                    , { field: 'discount_code_id', title: '优惠码', width: 150 }
                    , { field: 'money', title: '优惠', edit: 'text', width: 150 }
                    , { field: 'is_use', title: '是否使用', width: 100, toolbar: '#bar1', align: 'center' }
                    , { title: '是否过期', width: 100, toolbar: '#isEnd', align: 'center' }
                    , { field: 'end_time', title: '过期时间', width: 200, toolbar: '#barEndTim' }
                    , { field: 'add_time', title: '添加时间', width: 200, toolbar: '#bar2' }
                    , { fixed: 'right', width: 100, align: 'center', title: '操作', toolbar: '#bar3' } //这里的toolbar值是模板元素的选择器
                ]]
            });



            //监听工具条
            table.on('tool(table_filter)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的DOM对象

                if (layEvent === 'del') { //删除

                    layer.confirm('真的删除此条数据吗？', function (index) {
                        //删除对应行（tr）的DOM结构，并更新缓存
                        layer.close(index);
                        //向服务端发送删除指令

                        $.post('/finance/index.php/Admin/DiscountCode/del', {
                            "discount_code_id": obj.data.discount_code_id,
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
                    "id": obj.data.discount_code_id,
                    "save": save
                }, function (res) {
                    w(res);
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
                    console.log(res);

                    //得到当前页码
                    console.log(curr);

                    //得到数据总量
                    console.log(count);
                }
            });
        });

        /**
        表格刷新
        */

        $(document).on('click', '#refresh', function () {
            tableIns.reload({
                url: '/finance/index.php/Admin/DiscountCode/getList' //数据接口
            });

        });
        function saveInfo(post, f) {
            $.post('/finance/index.php/Admin/DiscountCode/saveInfo', post, function (res) {
                console.log(res);
                res = JSON.parse(res);
                if (f != null) {
                    f(res);
                }
            });
        }

        $('#add').on('click', function () {
            layer.open({
                type: 2,
                title: '新增优惠码',
                shadeClose: true,
                shade: 0.3,
                maxmin: true, //开启最大化最小化按钮
                area: ['893px', '600px'],
                content: '/finance/index.php/Admin/DiscountCode/add'
                , cancel: function (index, layero) {
                    tableIns.reload();
                }

            });

        });

        /**
         * 批量删除
         */
        $(document).on('click', '#removeAll', function () {
            w('开始批量删除');
            var o = table.checkStatus('table');
            if (o.data.length <= 0) {
                return;
            }

            layer.confirm('确定删除这些商品？', function (index) {
                var id = '';
                for (var i = 0; i < o.data.length; i++) {
                    id += "'" + o.data[i].discount_code_id + "',";
                }
                id = id.substring(0, id.length - 1);

                $.post('/finance/index.php/Admin/DiscountCode/removes', {
                    'discount_code_id': id
                }, function (res) {

                    var res = JSON.parse(res);

                    if (res.res > 0) {

                        layer.msg('成功删除' + res.res + '数据~');
                        w(res.msg);

                        tableIns.reload();
                    } else {
                        layer.msg('删除失败！' + res.msg);

                    }

                });

            });

        });
    </script>
</body>

</html>