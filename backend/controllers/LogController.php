<?php


namespace backend\controllers;


use common\models\AdminLog;
use common\rbac\Controller;
use yii\data\Pagination;

class LogController extends  Controller
{
    public function actionIndex(){
        $model = AdminLog::find()->orderBy("time desc");
        $pagination = new Pagination([
            'totalCount'=>$model->count(),
            'pageSize'  =>  10
        ]);
        $log = $model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render("index",[
            'log'           =>  $log,
            'pagination'    =>  $pagination
        ]);
    }
}