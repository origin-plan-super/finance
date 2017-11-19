<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>编辑公告</title>

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
    <link href="/finance/Public/vendor/summernote/summernote.css" rel="stylesheet" type="text/css">
    <link href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <style>
        body {
            padding: 15px;
        }
    </style>

</head>

<body>


    <form class="layui-form">

        <input type="hidden" name="notice_id" id="notice_id" value="<?php echo ($notice["notice_id"]); ?>">
        <textarea id="summernote" name='content'><?php echo ($notice["content"]); ?></textarea>
        <button class="btn btn-primary btn-lg btn-block" type="button" lay-submit lay-filter="*">保存</button>

    </form>
    <div id="test">

    </div>
    <script src="/finance/Public/vendor/summernote/summernote.min.js"></script>
    <script src="/finance/Public/vendor/summernote/lang/summernote-zh-CN.js"></script>

    <script src="/finance/Public/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- 中文-->
    <script>

        $(function () {
            $('#summernote').summernote({
                height: '80vh',
                tabsize: 2,
                lang: 'zh-CN',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });
        })



        layui.use('form', function () {
            var form = layui.form;
            form.on('submit(*)', function (data) {
                // console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
                // console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
                console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}

                save(data.field.notice_id, data.field.content, '保存成功~');


                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });


        });

        setInterval(function () {

            var id = $('#notice_id').val();
            var content = $('#summernote').summernote('code');
            save(id, content, function () {
                layer.msg('自动保存完成', {
                    offset: '80%'
                });
            });

        }, 10000);


        function save(id, content, successInfo) {
            $.post('', {
                "notice_id": id,
                "content": content
            }, function (res) {

                res = JSON.parse(res);
                w(res);

                if (res.res == 0) {

                    if (successInfo != null) {

                        if (typeof (successInfo) == 'function') {
                            successInfo();

                        } else {

                            layer.msg(successInfo, {
                                offset: '80%'
                            });
                        }


                    }

                } else {
                    layer.msg('保存失败：' + res.msg, {
                    });
                }
            });
        }
    </script>
</body>

</html>