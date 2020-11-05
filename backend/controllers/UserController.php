<?php


namespace backend\controllers;


use common\models\User;
use common\models\UserForm;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * 用户管理 前台用户 展示页
     * 默认按 修改时间 倒序排列
     */
    public function actionFrontendIndex(){
        $model = User::find()->where(['<>','status',User::STATUS_DELETED])->andWhere(['identity'=>User::IDENTITY_FRONTEND])->orderBy("updated_at DESC");
        $pagination = new Pagination(['totalCount'=>$model->count(),'pageSize'=>10]);
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
        $model = new UserForm();
        $id = \Yii::$app->request->getQueryParam("id",0);
        $postid = \Yii::$app->request->getBodyParam("id",0);
        $model->setScenario(UserForm::USERFORM_ADD);
        if (!empty($id)){
            $model->setScenario(UserForm::SCENARIO_DEFAULT);
            $user =  User::findOne(['id'=>$id]);
            $model->username = $user->username;
            $model->email = $user->email;
            $model->head_image = $user->head_image;
        }
        if (!empty($postid)){
            $id = $postid;
            $model->setScenario(UserForm::SCENARIO_DEFAULT);
        }
        if ($model->load(\Yii::$app->request->getBodyParams())&&$model->validate()&&$model->add($postid)){
            return $this->redirect(Url::to(['user/frontend-index']));
        }
        return $this->render("frontend_user_add",[
            'model' =>  $model,
            "id"    =>  $id
        ]);
    }

    /**
     * 通用的删除单个用户
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUserDel(){
        $id = \Yii::$app->request->getQueryParam("id",0);
        if (empty($id)){
            throw new \Exception("id 不能为空");
        }
        User::findOne(['id'=>$id])->delete();
        return $this->redirect(Url::to(['user/frontend-index']));

    }

    /**
     * 通用的修改状态
     * @return array
     */

    public function actionUpdateStatus(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $id = \Yii::$app->request->getBodyParam('id');
        $status = \Yii::$app->request->getBodyParam('status');
        $model = User::findOne(['id'=>$id]);
        $model->status = $status;
        if ($model->save()){
            return ['code'=>1,'status'=>$status,"msg"=>"修改成功"];
        }else{
            return ['code'=>0,'status'=>$status,"msg"=>"修改失败"];
        }
    }


    public function actionUserDelAll(){
        $ids = \Yii::$app->request->getQueryParam('id');
        $flag = true;
        $transaction = User::getDb()->beginTransaction();
        foreach ($ids as $id){
            try{
                if(!User::find()->where(['id'=>$id])->one()->delete()){
                    $flag = false;
                }
            }catch (\Exception $exception){
                $transaction->rollBack();
                throw  $exception;
            }
        }
        $transaction->commit();
        return $flag?$this->success():$this->error();
    }
    /**
     * 后台用户首页
     */
    public function actionAdminIndex(){
        return "后台用户首页";
    }
}