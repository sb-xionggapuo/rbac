<?php
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>后台登录</title>
		<link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/layui/css/layui.css" />
		<link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/login.css" />
	</head>

	<body>
		<div class="m-login-bg">
			<div class="m-login">
				<h3>后台系统登录</h3>
				<div class="m-login-warp">
                    <?php $form = \yii\widgets\ActiveForm::begin([
                            'id'    =>  "loginForm"
                    ]);?>
					<form class="layui-form">
						<div class="layui-form-item">
                            <?=$form->field($model,'username')->textInput(['placeholder'=> '请输入用户名', 'class'=> 'layui-input', 'maxlength' => true, 'value' => $model->username])->label(false) ?>
<!--							<input type="text" name="title" required lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">-->
						</div>
						<div class="layui-form-item">
                            <?=$form->field($model,'password')->passwordInput(['placeholder'=> '请输入密码','class'  =>  'layui-input'])->label(false);?>
<!--							<input type="text" name="password" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">-->
						</div>
						<div class="layui-form-item">
							<div class="layui-inline">
                                <?=$form->field($model,"verifyCode")->widget(\yii\captcha\Captcha::class,[
                                        'options'   => ["class" =>  'layui-input','placeholder'=>'请输入验证码','autocomplete'=>'off'],
                                    'imageOptions'=>[
                                        'id'=>'captchaimg',
                                        'title'=>'换一个',
                                        'alt'=>'换一个',
                                        'style'=>'cursor:pointer;',
                                        // 添加点击事件
                                        'onclick' => 'this.src=this.src+"&c="+Math.random();'
                                    ],
                                    'template' => '<div class="row"><div class="layui-inline">{input}</div><div class="layui-inline" onclick="">{image}</div></div>',
                                ])->label(false);?>
<!--								<input type="text" name="verity_code" required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">-->
							</div>
                            <?= $form->field($model, 'rememberMe')->checkbox() ?>
<!--							<div class="layui-inline">-->
<!--                                --><?//=\yii\captcha\Captcha::widget([
//                                        'name'          =>  'captcha',
//                                        'captchaAction' =>  'site/captcha',
//                                        'imageOptions'  =>  ['id'=>'verify_image', 'title'=>'换一个', 'alt'=>'换一个'],
//                                        'template'      =>  '{image}'
//                                ])?>
<!--							</div>-->
						</div>
						<div class="layui-form-item m-login-btn">
							<div class="layui-inline">
<!--								<button class="layui-btn layui-btn-normal" lay-submit lay-filter="login">登录</button>-->
                                <?=\yii\helpers\Html::submitButton("登录",['class'=>'layui-btn layui-btn-normal'])?>
							</div>
							<div class="layui-inline">
<!--								<button type="reset" class="layui-btn layui-btn-primary">取消</button>-->
                                <?=\yii\helpers\Html::resetButton("取消",['class'=>'layui-btn layui-btn-primary'])?>
							</div>
						</div>
					</form>
                    <?\yii\widgets\ActiveForm::end();?>
				</div>
				<p class="copyright">Copyright 2015-2016 by XIAODU</p>
			</div>
		</div>
		<script src="<?=$baseUrl?>/layui/layui.js" type="text/javascript" charset="utf-8"></script>
		<script>
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form(),
					layer = layui.layer;


				//自定义验证规则
				form.verify({
					title: function(value) {
						if(value.length < 5) {
							return '标题至少得5个字符啊';
						}
					},
					password: [/(.+){6,12}$/, '密码必须6到12位'],
					verity: [/(.+){6}$/, '验证码必须是6位'],
					
				});

				
				//监听提交
				form.on('submit(login)', function(data) {
					layer.alert(JSON.stringify(data.field), {
						title: '最终的提交信息'
					})
					return false;
				});

			});
		</script>
	</body>

</html>