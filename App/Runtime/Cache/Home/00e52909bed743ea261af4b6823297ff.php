<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>报名页面</title>
	<link rel="stylesheet" type="text/css" href="/finance/Public/dist/all/all.css" />
	<link rel="stylesheet" type="text/css" href="/finance/Public/vendor/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/finance/Public/dist/index/index.css" />


	<style>
		.pagination>li>a,
		.pagination>li>span {
			margin-left: 17px;
		}


		.active {
			background: red;
		}

		.pagination>li>a,
		.pagination>li>span {
			color: #919191;
			background-color: #f5f5f5;
		}

		.selected {
			background: red;
		}

		/* 分页 */

		.pagination>.active>a,
		.pagination>.active>a:focus,
		.pagination>.active>a:hover,
		.pagination>.active>span,
		.pagination>.active>span:focus,
		.pagination>.active>span:hover {
			z-index: -1;
			color: #fff;
			cursor: default;
			background-color: #9c0903;
			border-color: #9c0903;
		}

		.pagination>li>a:focus,
		.pagination>li>a:hover,
		.pagination>li>span:focus,
		.pagination>li>span:hover {
			z-index: 2;
			color: gray;
			background-color: #eee;
			border-color: #ddd;
		}

		.cur-pointer {
			cursor: pointer;
		}

		.cur-pointer:hover {
			color: red;
		}

		.cur-icon {
			cursor: pointer;
		}

		#info * {
			max-width: 100%;
		}
	</style>
</head>

<body>
	<div class="index">
		<!-- 页眉-图片部分 -->

		<style>
	.col-xs-6 {
		/* background-color: #ff0000; */
		/* outline: 1px #00f solid; */
	}

	#topTool {
		position: absolute;
		right: 180px;
		bottom: 0;
		line-height: 0;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	#topTool a {
		display: inline-block;
		background-color: #ca231c;
		border: none;
		width: auto;
	}

	#topTool .fk {
		background-color: #ca231c;
		border: none;
		width: auto;
		height: auto;
		line-height: 1;
		padding: 5px 10px;
		font-size: 16px;

	}

	a:hover {
		text-decoration: none;
	}
</style>

<!-- 页眉-图片部分 -->
<div class="index-package1">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 index-left-one text-left">
				<img src="/finance/Public/img/top-left.png" />
				<img class="secondImg" src="/finance/Public/img/top-left2.png" />
			</div>
			<div class="col-xs-6 index-right text-right">
				<img src="/finance/Public/img/top-right.png" />
				<div id="topTool">
					<a href="<?php echo U('Index/index');?>">
						<div class="fk fudong0">
							首页
						</div>
					</a>
					<a href="<?php echo U('User/User');?>">

						<div class="fk fudong1">
							个人中心
						</div>
					</a>
					<a href="<?php echo U('ShopBag/ShopBag');?>">
						<div class="fk fudong2">
							购物车
						</div>
					</a>
				</div>

			</div>

		</div>
	</div>
</div>


		<!-- 报名系统 红色字体 -->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 index-sign text-center">
					<h2 class="inde-sign-font">报名系统</h2>
				</div>
			</div>
		</div>
		<!-- 表格部分 -->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 table-responsive">
					<table class="table table-bordered table-hover text-center" style="text-overflow: ellipsis;white-space: nowrap;">
						<thead>
							<tr>
								<th class="text-center">考试名称</th>
								<th class="text-center">报考日期</th>
								<th class="text-center">场次</th>
								<th class="text-center">剩余考位</th>
								<th class="text-center">考试科目</th>
								<th class="text-center">价格</th>
								<th class="text-center">报名</th>
							</tr>
						</thead>
						<tbody class="cell-color" id="content">

							<?php if(is_array($exam_info)): $i = 0; $__LIST__ = $exam_info;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo ($vol["exam_name"]); ?></td>
									<td class="date">
										<?php echo ($vol['subject_info'][0]["date"]); ?>
									</td>
									<td class="time">
										<?php echo ($vol['subject_info'][0]["time"]); ?>
									</td>
									<td class="surplus">

										<?php if($vol['subject_info'][0]['surplus'] > 0 ): echo ($vol['subject_info'][0]["surplus"]); ?>
											<?php else: ?>
											<span class="text-danger">已报满</span><?php endif; ?>

									</td>

									<td class="text-center">

										<select class="form-control text-center input-sm subject_select" id="select<?php echo ($vol["subject_id"]); ?>">
											<?php if(is_array($vol["subject_info"])): $i = 0; $__LIST__ = $vol["subject_info"];if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$vol2): $mod = ($i % 2 );++$i;?><option class="text-center" value="<?php echo ($vol2["subject_id"]); ?>"><?php echo ($vol2["title"]); ?></option><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
										</select>

									</td>
									<td class="money"><?php echo ($vol['subject_info'][0]["money"]); ?>元</td>

									<?php if($vol['subject_info'][0]['surplus'] > 0 ): ?><td class="index-red-color toSignUp cur-pointer" data-subject-title="<?php echo ($vol['subject_info'][0]['title']); ?>" data-subject-id="<?php echo ($vol['subject_info'][0]['subject_id']); ?>"
										 data-exam-id='<?php echo ($vol["exam_id"]); ?>'>
											<span class="text-danger">我要报名</span>
										</td>
										<?php else: ?>
										<td class="index-red-color">
											<span class="" style="color:#777">我要报名</span>
										</td><?php endif; ?>

								</tr><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>


						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- 分页按钮部分 -->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<?php echo ($pages); ?>
				</div>
			</div>
		</div>
		<!-- last巨幕部分 -->
		<div class="container">
			<div class="row">
				<div class="col-xs-12" style="display:inline-block">
					<div class="jumbotron gonggao" style="padding-top: 5px;padding-bottom:150px;width:96%;margin-left:2%;">
						<h3 class="text-center" style="padding-bottom:20px;">报名公告</h3>
						<div id="info"><?php echo ($notice_content); ?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- 隐藏的填写个人信息部分 -->
		<div class="container hidden con" style="z-index:999999999999999999;">
			<div class="row">
				<div class="col-xs-12">
					<div class="index-frame text-center layui-form">
						<h3 class="index-red-color">报名信息填写</h3>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">考试科目</label>
							</div>
							<div class="col-xs-8 text-left">
								<span id="subject_title">F1</span>
								<input type="hidden" id="subject_id" name="subject_id">
								<input type="hidden" id="exam_id" name="exam_id">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">姓名</label>
							</div>
							<div class="col-xs-8 text-left">
								<input lay-verify-abcd='required' name="user_name" type="text" class="form-control" style="width:70%;">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">手机</label>
							</div>
							<div class="col-xs-8 text-left">
								<input lay-verify-abcd='required|phone' name="user_phone" type="text" class="form-control" style="width:70%;">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">邮箱</label>
							</div>
							<div class="col-xs-8 text-left">
								<input lay-verify-abcd='required|email' name='user_email' type="text" class="form-control" style="width:70%;">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">身份证</label>
							</div>
							<div class="col-xs-8 text-left">
								<input lay-verify-abcd='required|identity' name="user_uid" type="text" class="form-control" style="width:70%;">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">注册ID</label>
							</div>
							<div class="col-xs-8 text-left">
								<input lay-verify-abcd='required' name="user_pid" type="text" class="form-control" style="width:70%;">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">出生年月</label>
							</div>
							<div class="col-xs-8 text-left">
								<input lay-verify-abcd='required' name="user_day" type="text" class="form-control" style="width:70%;">
							</div>
							<br>
						</div>
						<div class="index-frame-margin">
							<div class="col-xs-4 text-right">
								<label for="">备注</label>
							</div>
							<div class="col-xs-8 text-left">
								<textarea class="form-control" name="user_info" cols="23" rows="3" style="width:70%;" id="userOther"></textarea>
							</div>
							<br>
						</div>
						<div class="index-frame-margin" style="line-height:38px;margin-top:5px;">
							<div class="col-xs-8 text-right">
								<button type="button" class="btn shopcar" lay-submit lay-filter="*">加入购物车</button>
							</div>
							<div class="col-xs-4 text-left">
								<span class="settlement">
									<a href="javascript:;" id="closeForm" style="color:#000">关闭</a>
								</span>
							</div>
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- 右侧悬浮的图标   -->
		<style type="text/css">
	.glyphicon {
		position: relative;
		top: 1px;
		line-height: 50px;
		display: inline-block;
		font-family: 'Glyphicons Halflings';
		font-style: normal;
		font-weight: 400;
		/* line-height: 1; */
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}
</style>
<!-- 右侧悬浮的图标   -->
<!-- 右侧悬浮的图标   -->
<div id="fudong">
	<a href="<?php echo U('Index/index');?>">
		<div class="fk fudong">
			<span class="glyphicon glyphicon glyphicon-home userCenter cur-icon"></span>
		</div>
	</a>
	<a href="<?php echo U('User/User');?>">

		<div class="fk fudong">
			<span class="glyphicon glyphicon-user userCenter cur-icon"></span>
		</div>
	</a>
	<a href="<?php echo U('ShopBag/ShopBag');?>">
		<div class="fk fudong">
			<span class="glyphicon glyphicon-shopping-cart shopBag cur-icon"></span>
		</div>
	</a>

	<a href="<?php echo U('Login/sinOut');?>">
		<div class="fk fudong">
			<span class="glyphicon glyphicon-shopping-cart shopBag cur-icon"></span>
		</div>
	</a>
</div>

	</div>

	<script src="/finance/Public/vendor/jquery/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="/finance/Public/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/finance/Public/dist/all/all.js" type="text/javascript" charset="utf-8"></script>
	<script src="/finance/Public/vendor/layer/layer.js"></script>
	<script src="/finance/Public/vendor/layui/layui.js"></script>
	<script src="/finance/Public/dist/tool/tool.js" type="text/javascript" charset="utf-8"></script>

	<script>

		var exam_info_json = JSON.parse('<?php echo ($exam_info_json); ?>');


		layui.use(['table', 'form'], function () {
			var table = layui.table
				, form = layui.form;

			form.on('submit(*)', function (data) {
				// console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
				// console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
				// console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}

				$.post('', data.field, function (res) {


					// $('#info').html(res);
					res = JSON.parse(res);
					// w(res);

					if (res.res == 0) {
						layer.msg('添加成功~', {
							offset: '80%'
						});
						$(".con").addClass("hidden");
					}

					if (res.res == -2) {
						layer.msg('已经满员~', {
							offset: '80%'
						});
					}

				});


				return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
			});



		});

		function showClick(e) {

			var $this = $(this);


			/**
			先判断登录没
			*/
			$.get('<?php echo U("Login/isLogin");?>', function (res) {


				res = JSON.parse(res);
				if (res.res == -999) {
					//未登录
					window.location.href = '<?php echo U("Login/login");?>';

				} else {
					//登录了

					// <span id="subject_title">F1</span>
					// <input type="hidden" id="subject_id" name="subject_id">
					// <input type="hidden" id="exam_id" name="exam_id">


					var subject_id = $this.attr('data-subject-id');
					var exam_id = $this.attr('data-exam-id');
					var subject_title = $this.attr('data-subject-title');
					// ==
					$('#subject_title').text(subject_title);//科目title
					$('#subject_id').val(subject_id);//科目id
					$('#exam_id').val(exam_id);//课程id

					$(".con").removeClass("hidden");
				}

			});


		}





		// 报名信息页面的显示与隐藏
		$(document).ready(function () {

			$(".toSignUp").click(showClick);

			$("#closeForm").click(function (e) {
				$(".con").addClass("hidden");
			});

			//下拉列表选择
			$(document).on('change', '.subject_select', function (e) {
				var tr = $(this).parents('tr');
				var id = $(this).val();

				$.get('/finance/index.php/Home/ExamSubject/get', {
					id: id
				}, function (res) {

					res = JSON.parse(res);
					tr.find('.money').text(res.msg.money + '元');
					//人数处理
					// toSignUp
					if (res.msg.surplus > 0) {
						tr.find('.surplus').text(res.msg.surplus);

						tr.find('.index-red-color span').addClass('text-danger');
						tr.find('.index-red-color span').css('color', '#a94442');
						tr.find('.index-red-color').addClass('toSignUp cur-pointer');
						tr.find('.index-red-color').click(showClick);

						// w(res.msg);
						//设置我要报名的属性
						tr.find('.index-red-color').attr('data-subject-id', res.msg.subject_id);
						tr.find('.index-red-color').attr('data-exam-id', res.msg.exam_id);
						tr.find('.index-red-color').attr('data-subject-title', res.msg.title);


					} else {

						tr.find('.surplus').html('<span class="text-danger">已报满</span');
						tr.find('.index-red-color span').removeClass('text-danger');
						tr.find('.index-red-color span').css('color', '#777');
						tr.find('.index-red-color').removeClass('toSignUp cur-pointer');
						tr.find('.index-red-color').unbind();

					}


					tr.find('.time').text(res.msg.time);
					tr.find('.date').text(res.msg.date);

				});
				// w($(this).val());

			});

		});



	</script>
</body>

</html>