<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>课程列表</title>
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
            <div class="layui-form-mid layui-word-aux">在新页面打开编辑</div>
            <input type="checkbox" id="isNew" name="xxx" lay-skin="switch">
        </div>
    </div>



    <table id="live_table" lay-filter="table_filter"></table>

    <script type="text/html" id="bar1">
        
        <a class="layui-btn layui-btn-xs" lay-event="open">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            
    </script>
    <script type="text/html" id="bar2">

                
        {{#  var a=JSON.parse(d.exam_subject) }}
        {{#  w(a) }}
        {{#  layui.each(a, function(index, item){ }}
            {{ item }},
        {{#  }); }}
    

    </script>

    <script>
        var tableIns;
        layui.use(['table', 'form'], function () {
            var table = layui.table
                , form = layui.form;
            //第一个实例
            tableIns = table.render({
                elem: '#live_table'
                , url: '/finance/index.php/Admin/Exam/getList' //数据接口
                , page: true //开启分页
                , limit: localStorage.limit == null ? 5 : localStorage.limit
                // , limits: [5, 10]
                , cols: [[ //表头
                    { type: 'numbers', width: 50 }
                    , { field: 'exam_id', title: 'ID', width: 80 }
                    , { field: 'exam_name', title: '考试名', edit: 'text', width: 300 }
                    , { field: 'exam_date', title: '考试日期', width: 200 }
                    , { field: 'exam_time', title: '场次时间', width: 200 }
                    , { field: 'exam_money', title: '价格', edit: 'text', width: 100 }
                    , { field: 'exam_num', title: '总人数', edit: 'text', width: 100 }
                    , { field: 'surplus', title: '剩余人数', width: 100 }
                    , { field: 'people_num', title: '报考人数', width: 100 }
                    , { title: '科目', align: 'center', toolbar: '#bar2', width: 300 }
                    , { fixed: 'right', width: 150, align: 'center', toolbar: '#bar1' }
                    // , { field: 'is_up', fixed: 'right', title: '是否推荐', align: 'center', width: 110, templet: '#checkboxTpl', unresize: true }
                    // , { fixed: 'right', width: 180, align: 'center', title: '操作', toolbar: '#bar1' } //这里的toolbar值是模板元素的选择器
                ]]
            });



            //监听工具条
            table.on('tool(table_filter)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的DOM对象
                var exam_id = data.exam_id;
                console.log(layEvent);
                //查看
                var url = '/finance/index.php/Admin/Exam/edit/exam_id/' + exam_id;
                console.log(url);
                if (layEvent === 'open') {


                    if ($('#isNew').is(':checked')) {

                        window.open(url);

                    } else {

                        layer.open({
                            type: 2,
                            title: data.exam_name + " | " + data.exam_date,
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

                        $.post('/finance/index.php/Admin/Exam/del', {
                            "exam_id": obj.data.exam_id,
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
                    "exam_id": obj.data.exam_id,
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
                url: '/finance/index.php/Admin/Exam/getList' //数据接口
            });

        });
        function saveInfo(post, f) {
            $.post('<?php echo U("Exam/saveInfo");?>', post, function (res) {
                console.log(res);
                res = JSON.parse(res);
                if (f != null) {
                    f(res);
                }
            });
        }


    </script>

</body>

</html>