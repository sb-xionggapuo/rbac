<?php


namespace backend\controllers;


use common\models\WebSystem;
use common\rbac\Controller;

class SySetController extends Controller
{
    public function actionWebSet(){
        $model = WebSystem::find()->one();
        if ($model->load(\Yii::$app->request->getBodyParams())&&$model->save()){
            \Yii::$app->session->setFlash("success","保存成功");
        }
        return $this->render("web-set",[
            "model"=>$model
        ]);
    }
    public function actionSeoSet(){
        $model = WebSystem::find()->one();
        if ($model->load(\Yii::$app->request->getBodyParams())&&$model->save())
            \Yii::$app->session->setFlash("success","保存成功");
        return $this->render("seo-set",[
            "model"=>$model
        ]);
    }
}