<?php


namespace backend\controllers;


use backend\models\Menu;
use common\HelpFunction\Tree;
use common\models\Jurisdiction;
use common\models\Role;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class RoleController extends Controller
{
    /**
     * specification:rbac首页
     * author:何文杰
     * date:2020/10/30 10:48
     * @return string
     */
    public function actionIndex(){
        $role = Role::getTree();//得到 整理好的树形结构
        return $this->render("index",[
            "model" =>  $role
        ]);
    }

    /**
     * specification:修改状态
     * author:何文杰
     * date:2020/10/30 10:49
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEditStatus(){
        $params = \Yii::$app->request->getBodyParams();
        $model = Role::findOne($params['id']);
        $model->status = $params['status'];
        if ($model->save()){
            return $this->success(1,"成功",$params['status']);
        }else{
            return $this->error();
        }

    }

    /**
     * specification:增加角色
     * author:何文杰
     * date:2020/10/30 10:49
     * @return string
     */
    public function actionAdd(){
        $menu = Role::getTree();
        $model = new Role();
        $parent_id = \Yii::$app->request->getQueryParam('pid',0);//这个是用于 指定父菜单添加的 parent_id
        $id = \Yii::$app->request->getQueryParam('id',0);//这个是用于 编辑
        if ($id!=0){
            $menu   = Role::getTree($id);
            $model = Role::findOne($id);
            $parent_id  = $model->parent_id;
        }
        $params = \Yii::$app->request->getBodyParams();
        if ($model->load($params)&&!empty($params['Role']['jurisdiction'])&&$model->add($params['Role']['jurisdiction'])){
                return $this->redirect(Url::to(['role/index']));
        }
        return $this->render("add",[
            'menu'      =>  $menu,
            'parent_id' =>  $parent_id,
            'model'     =>  $model,
            'id'        =>  $id,
        ]);
    }
    public function actionDel($id=0){
        $id = \Yii::$app->request->getQueryParam('id',0);
        if ($id==0){
            throw new \Exception("删除失败");
        }
        if (!Role::recursionDel($id)){
            throw new \Exception("删除失败");
        }
        if (\Yii::$app->request->isAjax){
            return $this->success(1,"删除成功");
        }
        return $this->redirect(['role/index']);
    }
    public function actionDelAll(){
        $ids = \Yii::$app->request->getQueryParam('id');
        $flag = true;
        foreach ($ids as $id){
           if(!Role::recursionDel($id)){
               $flag = false;
           }
        }
        return $flag?$this->success():$this->error();
    }

    /**
     * specification:得到菜单tree 整理返回json格式
     * author:何文杰
     * date:2020/10/30 14:16
     * @return array
     */
    public function actionGetMenu(){
        $id = \Yii::$app->request->getBodyParam("id");
        $checkId = Jurisdiction::find()->select(['menu_id'])->filterWhere(['role_id'=>$id])->column();
        $menu = Menu::find()->where(['<>','status',-1])->asArray()->all();
        $data = ['list'=>$menu,'checkedId'=>$checkId,'disabledId'=>[4]];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['code'=>1,'msg'=>"成功",'data'=>$data];
    }
}