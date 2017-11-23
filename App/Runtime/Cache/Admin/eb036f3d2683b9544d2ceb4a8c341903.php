<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>科目列表</title>
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
        <legend>【<?php echo ($exam_info["exam_name"]); ?>】的科目列表</legend>
    </fieldset>

    <div class="layui-row" style="padding-top:10px">

        <div class="layui-btn-group">
            <button class="layui-btn layui-btn-sm" id="add">
                <i class="layui-icon">&#xe654;</i>新增科目
            </button>
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
            {{ '【'+item.title+'】:'+item.money }}￥,
        {{#  }); }}
    
    </script>
    <script type="text/html" id="barSurplus">
        
        {{#  if(d.surplus > 0){ }}
        {{ d.surplus }}
        {{#  }else{ }}
        <span class="layui-badge">已满员</span>
        {{#  }}}
        
    </script>
    <script>
        var tableIns;
        layui.use(['table', 'form'], function () {
            var table = layui.table
                , form = layui.form;
            //第一个实例
            tableIns = table.render({
                elem: '#live_table'
                , url: '/finance/index.php/Admin/ExamSubject/getList/exam_id/<?php echo ($exam_info["exam_id"]); ?>' //数据接口
                // , limits: [5, 10]
                , cols: [[ //表头
                    { type: 'numbers', width: 50 }
                    , { field: 'subject_id', title: 'ID', width: 80 }
                    , { field: 'title', title: '科目名', edit: 'text', width: 300 }
                    , { field: 'money', title: '科目价格', width: 200, edit: 'text' }
                    , { field: 'date', title: '报考日期', width: 200 }
                    , { field: 'time', title: '报考时间', width: 200 }
                    , { field: 'max_num', title: '考位数量', edit: 'text', width: 100 }
                    , { field: 'exam_name', title: '已报人数', width: 100 }
                    , { field: 'surplus', title: '剩余人数', width: 100 }
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
                var subject_id = data.subject_id;
                console.log(layEvent);
                //编辑地址
                var url = '/finance/index.php/Admin/examSubject/edit/subject_id/' + subject_id;
                console.log(url);
                if (layEvent === 'open') {
                    // window.open(url);

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

                        $.post('/finance/index.php/Admin/ExamSubject/del', {
                            "subject_id": obj.data.subject_id,
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
                    "subject_id": obj.data.subject_id,
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


        function saveInfo(post, f) {
            $.post('/finance/index.php/Admin/ExamSubject/saveInfo', post, function (res) {
                console.log(res);
                res = JSON.parse(res);
                if (f != null) {
                    f(res);
                }
            });
        }

        //新增科目
        $('#add').on('click', function () {
            layer.open({
                type: 2,
                title: '新增优惠码',
                shadeClose: true,
                shade: 0.3,
                maxmin: true, //开启最大化最小化按钮
                area: ['893px', '600px'],
                content: '/finance/index.php/Admin/ExamSubject/add/exam_id/<?php echo ($exam_info["exam_id"]); ?>'
                , cancel: function (index, layero) {
                    tableIns.reload();
                }

            });

        });


    </script>

</body>

</html>