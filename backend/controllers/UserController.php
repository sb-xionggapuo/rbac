<?php


namespace backend\controllers;


use common\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * 前台用户首页
     */
    public function actionFrontendIndex(){
        $model = User::find()->where(['<>','status',User::STATUS_DELETED])->andWhere(['identity'=>User::IDENTITY_FRONTEND]);
        $pagination = new Pagination(['totalCount'=>$model->count(),'pageSize'=>1]);
        $user = $model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render("frontend_index",[
            'pagination'    =>  $pagination,
            'user'          =>  $user
        ]);
    }

    /**
     * 前台用户添加
     */
    public function actionFrontendUserAdd(){
        return $this->render("frontend_user_add");
    }

    /**
     * 后台用户首页
     */
    public function actionAdminIndex(){
        return "后台用户首页";
    }
}