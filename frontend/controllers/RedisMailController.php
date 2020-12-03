<?php


namespace frontend\controllers;


use yii\web\Controller;

class RedisMailController extends Controller
{
    public function actionIndex(){
        $verification = rand(100000, 999999);
        $body = "您本次的验证码是:$verification";
        $result  = $this->sendEmail("2943536159@qq.com","rbac权限管理系统","$body");
        if($result)
            echo "success";
        else
            echo "failse";
    }
    private function sendEmail($toMember, $subject, $body)
    {
        //1构造对象
        $emailObj = \Yii::$app->mailer->compose();
        //设置发件人的邮件地址
        return $emailObj->setTo($toMember)//设置收件人的地址
            ->setSubject($subject)//设置邮件主题
            ->setHtmlBody($body)//设置邮件的内容的html
            ->send();//发送方法
    }
}