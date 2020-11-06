<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("用户名") ?>

                <?= $form->field($model, 'password')->passwordInput()->label("密码") ?>


            <?=$form->field($model,"verifyCode")->widget(\yii\captcha\Captcha::class,[
                'imageOptions'=>[
                    'style'=>'cursor:pointer;',
                    // 添加点击事件
                    'onclick' => 'this.src=this.src+"&c="+Math.random();'
                ],
                'template' => '<div class="row"><div class="layui-inline">{input}</div><div class="layui-inline" onclick="">{image}</div></div>',
            ])->label("验证码");?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
