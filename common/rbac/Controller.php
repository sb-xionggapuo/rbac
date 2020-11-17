<?php
namespace common\rbac;

use yii\helpers\Url;

class Controller extends \yii\web\Controller
{
    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     * 注释时间:2020/11/13 15:01
     * author:何文杰
     * 受rbac控制的控制器 都继承这里 在运行方法前先判断是否有权限
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)){
            return false;
        }
        if(\Yii::$app->user->isGuest){
            $this->goHome();
            return false;
        }
        if (\Yii::$app->user->identity->role_id != 0){
            $permission = $action->controller->module->requestedRoute;//记录我们访问的规则名称
            if(\Yii::$app->user->can($permission))return true;//如该用户能访问该请求，则进行返回
            throw new \Exception("你还没有权限访问");
        }
        return true;
    }
}