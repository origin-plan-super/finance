<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>后台登录</title>
    <link href="/finance/Public/vendor/layui/css/layui.css" rel="stylesheet" type="text/css">
    <!-- <link href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f8fa;
        }

        .box {
            display: table;
            width: 100%;
            height: 100vh;
        }

        .box-body {
            display: table-cell;
            vertical-align: middle;
        }

        .form {
            max-width: 280px;
            margin-top: -100px;
            margin-right: auto !important;
            margin-left: auto !important;
        }

        #admin_code_img {
            margin: 0;
            height: 100%;
            max-width: 100%;
            width: 100%;
        }

        #basic-addon2 {
            padding: 0;
        }
    </style>

</head>

<body>

    <div class="box">

        <div class="box-body">
            <div class="form text-center layui-form">
                <div class="form-group">
                    <h2>后台管理</h2>
                </div>
                <div class="form-group">
                    <input type="text" lay-verify='required' placeholder="用户名" class="form-control" name="admin_id" id="admin_user">
                </div>
                <div class="form-group">
                    <input type="password" lay-verify='required' placeholder="密码" class="form-control" name="admin_pwd" id="admin_pwd">
                </div>
                <div class="form-group">

                    <div class="input-group">
                        <input type="text" id="admin_code" name="admin_code" lay-verify='required' class="form-control" placeholder="验证码" aria-describedby="basic-addon2">

                        <span class="input-group-addon" id="basic-addon2">
                            <img src="" id="admin_code_img">
                        </span>
                    </div>


                </div>
                <div class="form-group">
                    <!-- lay-submit -->
                    <button lay-submit type="button" class="btn btn-primary" lay-filter="login">登录</button>
                    <!-- <input type="password" lay-verify='required' placeholder="密码" class="form-control" id="admin_pwd"> -->
                </div>
            </div>


        </div>



    </div>


    <script src="/finance/Public/vendor/Jquery/jquery.js"></script>
    <!-- <script src="/finance/Public/vendor/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="/finance/Public/vendor/layer/layer.js"></script>
    <script src="/finance/Public/vendor/layui/layui.js"></script>
    <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
    <script src="https://cdn.bootcss.com/popper.js/1.12.5/umd/popper.min.js"></script>
    <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script>



        layui.use('form', function () {
            var form = layui.form;

            //各种基于事件的操作，下面会有进一步介绍
            form.on('submit(login)', function (data) {
                // console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
                // console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
                // console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}

                $.post('/finance/index.php/Admin/Login/login', data.field, function (res) {
                    console.log(res);
                    obj.upCode();
                    res = JSON.parse(res);
                    layer.msg('code:' + res.res + ' | msg:' + res.msg);

                    if (res.res == 0) {
                        setTimeout(() => {
                            window.location.href = '<?php echo U("Index/index");?>';
                        }, 300);
                    }

                })


                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });




        });

        var code = function () {
            obj = {
                config: {
                    el: ''
                },
                init: function () {
                    $(obj.config.el).css('cursor', 'pointer');
                    $(document).on('click', obj.config.el, function () {
                        obj.upCode();
                    });
                    obj.upCode();
                },
                upCode: function () {
                    $(obj.config.el).attr('src', '/finance/index.php/Admin/Login/getCode');
                }
            }
            return obj;
        }();


        code.config.el = '#admin_code_img';
        code.init();



    </script>
</body>

</html>