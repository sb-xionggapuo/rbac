<?php


namespace common\models;


use backend\models\Menu;
use Codeception\Module\Yii2;
use common\enum\STATUS;
use common\HelpFunction\Tree;
use yii\db\ActiveRecord;
use yii\db\Exception;

class Role extends ActiveRecord
{
    static $oldName;
    static $grandFather;
    public function rules()
    {
        return [
            [['parent_id','name','describe','status'],'required','message'=>'{attribute}不能为空'],
            [['parent_id','status'],'number','message'=>'{attribute}必须是数字'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'name'        =>  '角色名称',
          'describe'    =>  '描述',
          'parent_id'   =>  '上级角色',
            'status'    =>  '状态',
        ];
    }

    /**
     * @param null $notPid
     * @return array
     * 注释时间:2020/11/13 15:05
     * author:何文杰
     * 得到树形角色树
     */
    public static function getTree($notPid=null){
        $model = self::find()->where(['<>','status',-1])->andWhere(['<>','id',0])->andFilterWhere(['<>','id',$notPid])->asArray()->all();
        return Tree::tidyTree($model);
    }

    /**
     * @param $id 要得到祖父角色的角色id
     * @return mixed
     * @throws Exception
     * 注释时间:2020/11/13 15:05
     * author:何文杰
     * 得到id的一级父角色
     */
    public static function getGrandfather($id){
        if (!is_numeric($id)){
            throw new Exception('$id 不是整型');
        }
        $model = self::find()->where(['id'=>$id])->one();
        if ($model['parent_id'] != 0){
            self::$grandFather = self::getGrandfather($model['parent_id']);
        }else{
            self::$grandFather = $model['id'];
        }
        return self::$grandFather;
    }

    /**
     * @param $id 要判断的角色id
     * @return bool
     * @throws Exception
     * 注释时间:2020/11/13 15:04
     * author:何文杰
     *  是否是父角色
     */
    public static function IsParentRole($id){
        if (!is_numeric($id)){
            throw new Exception('$id 不是整型');
        }
        $model = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->one();
        return empty($model)?false:true;
    }

    /**
     * @param null $role_id 当前登录后台的管理员的 角色id
     * @return array  树形角色菜单 得到id角色下的所有子角色
     */
    public static function getSon($role_id=null){
        $arr1 = self::getTree();
        if (!empty($role_id)){
            $arr2 = self::getTree($role_id);
            foreach($arr1 as $key=>$value){
                if (in_array($arr1[$key],$arr2)){
                    unset($arr1[$key]);
                }
            }
        }
        return $arr1;
    }

    public static function getSonIds($role){
        $in = [];
        foreach ($role as $r){
            array_push($in,$r['id']);
        }
        return $in;
    }

    /**
     * @param $jurisdiction
     * @return bool
     * @throws \Exception
     * 注释时间:2020/11/13 15:03
     * author:何文杰
     *  递归 增加或者修改一个菜单
     */
    public function add($jurisdiction){
        if ($this->parent_id == 0){ //父级角色是一级角色的时候
            $this->tree = "|_ _ ";
        }else{
            $parent = self::findOne($this->parent_id);
            $this->tree = $parent->tree."_ _ ";
        }
        $transaction = \Yii::$app->db->beginTransaction();//开启事务
        try {
            $arr = [];
            if (!$this->save())throw new \Exception("添加失败");
            $son = self::find()->where(['parent_id'=>$this->primaryKey])->all();//递归修改
            if (!empty($son)){ //有子类
                foreach ($son as $s){
                    $sjurisdiction = Jurisdiction::find()->select(['menu_id'])->where(['role_id'=>$s->primaryKey])->column();
                    $s->add($sjurisdiction);
                }
            }
            $auth = \Yii::$app->authManager;
            if (self::$oldName != $this->name&&!empty($oldRole = $auth->getRole(self::$oldName))){
                $auth->remove($oldRole);
            }
            if (empty($role = $auth->getRole($this->name))){

                $role = $auth->createRole($this->name);
                $role->description = $this->describe;
                $auth->add($role);
            }
            $pmenus = Jurisdiction::find()->select(['menu_id'])->where(['role_id'=>$this->parent_id])->column();//增加菜单必须在父类拥有的菜单下
            $auth->removeChildren($role);
            foreach ($jurisdiction as $j){
                $per = Menu::findOne($j);
                if (empty($permission = $auth->getPermission($per->name))){
                    $permission = $auth->createPermission($per->name);
                    $permission->description = $per->title;
                    $auth->add($permission);
                }
                if (in_array($j,$pmenus)){
                    if (!$auth->hasChild($role,$permission))$auth->addChild($role,$permission);
                    array_push($arr,[$this->id,$j]);
                }else{
                    if ($auth->hasChild($role,$permission))$auth->removeChild($role,$permission);
                }
            }
            Jurisdiction::deleteAll(['role_id'=>$this->id]);
            \Yii::$app->db->createCommand()->batchInsert('jurisdiction',['role_id','menu_id'],$arr)->execute();
            $transaction->commit();
        }catch (\Exception $exception){
            $transaction->rollBack();
            throw $exception;
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     * 注释时间:2020/11/13 15:03
     * author:何文杰
     * 递归删除 包括删除子角色
     */
    public static function recursionDel($id){
        $son = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->all();
        if (!empty($son)){
            foreach ($son as $s){
                self::recursionDel($s->id);
            }
        }
        $model = self::findOne($id);
        $auth = \Yii::$app->authManager;
        if (!empty( $role = $auth->getRole($model->name)))$auth->remove($role);
        $model->status = -1;
        Jurisdiction::deleteAll(['role_id'=>$id]);
        return $model->save();
    }
}