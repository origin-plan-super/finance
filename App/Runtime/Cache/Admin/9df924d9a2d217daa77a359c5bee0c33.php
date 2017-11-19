<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理后台</title>
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
        #iframeBox {
            position: absolute;
            /* height: calc(100%); */
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;
        }

        #fream {
            position: absolute;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .layui-layout-admin .layui-body {
            top: 60px;
            bottom: 0;
        }

        .hr-black {
            background-color: #777777;
        }
    </style>
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">finance</div>
            <!-- 头部区域（可配合layui已有的水平导航） -->

            <ul class="layui-nav layui-layout-right">

                <li class="layui-nav-item">
                    <a href="<?php echo U('Login/sinOut');?>">退了</a>
                </li>
            </ul>
        </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item">
                        <!-- <a href="javascript:;" data-src='Index/home'>首页</a> -->
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-src='Exam/add'>添加课程</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-src='Exam/showList'>课程管理</a>
                    </li>
                    <hr class="hr-black">
                    <li class="layui-nav-item">
                        <!-- <a href="javascript:;" data-src='Order/index'>订单管理</a> -->
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-src='Discount/showList'>优惠管理</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-src='DiscountCode/showList'>优惠码管理</a>
                    </li>
                    <hr class="hr-black">
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-src='Notice/edit'>公告管理</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <div id="iframeBox">
                <!-- <iframe src="/finance/index.php/Admin/Index/home" id="fream" frameborder="0"></iframe> -->
                <!-- <iframe src="Exam/showList" id="fream" frameborder="0"></iframe> -->
                <iframe src="" id="fream" frameborder="0"></iframe>
            </div>
        </div>


    </div>


    <script>

        layui.use('element', function () {
            var element = layui.element;
        });
        $(function () {



            if ('<?php echo ($admin_url); ?>' != null && '<?php echo ($admin_url); ?>' != '') {
                $('#fream').attr('src', '<?php echo ($admin_url); ?>');
            }

            $('.layui-nav-item').each(function (index) {
                $(this).attr('id', 'item' + index);
            })

            w(localStorage.item_id);
            $(localStorage.item_id).addClass('layui-this');


            $(document).on('click', 'a[href="javascript:;" ]', function () {


                localStorage.item_id = '#' + $(this).parents('.layui-nav-item').attr('id');

                if (!($(this).attr('data-src') == null)) {

                    $.post('', {
                        url: $(this).attr('data-src')
                    }, function (date) {
                        $('#fream').attr('src', date);

                    })
                }

            })

        })




    </script>
</body>

</html>