<?php


namespace common\controllers;


use yii\captcha\CaptchaAction;
use yii\web\Response;

class CaptchaController extends CaptchaAction
{
    public function run()
    {
        $this->setHttpHeaders();
        \Yii::$app->response->format = Response::FORMAT_RAW;

        return $this->renderImage($this->getVerifyCode(true));
    }
}