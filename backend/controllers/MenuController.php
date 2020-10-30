<?php


namespace backend\controllers;


use backend\models\Menu;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Controller;

class MenuController extends Controller
{
    public $layout = "menu";

    /**
     * specification:后台菜单首页
     * author:何文杰
     * date:2020/10/27 16:46
     * @return string
     */
    public function actionAdminMenu(){
        $menu = Menu::getTree(10);
        return $this->render("admin_menu",[
            'menu'  =>  $menu
        ]);
    }
    /**
     * specification:后台菜单管理添加
     * author:何文杰
     * date:2020/10/27 9:49
     *
     */
    public function actionAdminMenuAdd(){
        $menu = Menu::getTree(10);
        $model = new Menu();
        $parent_id = \Yii::$app->request->getQueryParam('pid',0);//这个是用于 指定父菜单添加的 parent_id
        $id = \Yii::$app->request->getQueryParam('id',0);//这个是用于修改的 id
        if ($id!=0){
            $menu = Menu::getTree(10,$id);
            $model = Menu::findOne($id);
            $parent_id  = $model->parent_id;
        }
        if ($model->load(\Yii::$app->request->post())&&$model->add()){
            return $this->redirect(Url::to(['menu/admin-menu']));
        }
        return $this->render("admin_menu_add",[
            "model" =>   $model,
            "menu"  =>  $menu,
            'parent_id' =>  $parent_id
        ]);
    }

    /**
     * specification:后台菜单修改状态
     * author:何文杰
     * date:2020/10/28 14:52
     */
    public function actionAdminMenuEditStatus(){
        $params = \Yii::$app->request->getBodyParams();
        $model = Menu::findOne($params['Menu']['id']);
        $data = $params['Menu']['status'];
        if ($model->load($params)&&$model->save()){
           return $this->success(1,"修改成功",$data);
        }else{
            return $this->error(0);
        }
    }

    /**
     * specification:删除菜单
     * author:何文杰
     * date:2020/10/28 16:34
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionAdminMenuDel(){
        $id = \Yii::$app->request->getQueryParam("id");
        if (!Menu::recursionDel($id)){
            throw new \Exception("删除失败");
        }
        if (\Yii::$app->request->isAjax){
            return $this->success(1,"删除成功");
        }
        return $this->redirect(['menu/admin-menu']);
    }
    public function actionEditSort(){
        $params = \Yii::$app->request->getBodyParams();
        $model = Menu::findOne($params['id']);
        $model->sort = $params['sort'];
        if (!$model->save()){
            return $this->error();
        }
        return $this->success();
    }

    public function actionFrontendMenu(){
        $menu = Menu::getTree(1);
        return $this->render("frontend_menu",[
           'menu'  =>  $menu
       ]);
    }

    public function actionFrontendMenuAdd(){
        $menu = Menu::getTree(1);
        $model = new Menu();
        $parent_id = \Yii::$app->request->getQueryParam('pid',0);//这个是用于 指定父菜单添加的 parent_id
        $id = \Yii::$app->request->getQueryParam('id',0);//这个是用于修改的 id
        if ($id!=0){
            $menu = Menu::getTree(1,$id);
            $model = Menu::findOne($id);
            $parent_id  = $model->parent_id;
        }
        if ($model->load(\Yii::$app->request->post())&&$model->add(1)){
            return $this->redirect(Url::to(['menu/frontend-menu']));
        }
        return $this->render("frontend_menu_add",[
            "model" =>   $model,
            "menu"  =>  $menu,
            'parent_id' =>  $parent_id
        ]);
    }
    public function actionFrontendMenuDel(){
        $id = \Yii::$app->request->getQueryParam("id");
        if (!Menu::recursionDel($id)){
            throw new \Exception("删除失败");
        }
        if (\Yii::$app->request->isAjax){
            return $this->success(1,"删除成功");
        }
        return $this->redirect(['menu/frontend-menu']);
    }

    public function actionDelAll(){
        $ids = \Yii::$app->request->getQueryParam('id');
        $flag = true;
        foreach ($ids as $id){
            if(!Menu::recursionDel($id)){
                $flag = false;
            }
        }
        return $flag?$this->success():$this->error();
    }
}