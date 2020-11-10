<?php


namespace common\models;


use common\enum\STATUS;
use common\HelpFunction\Tree;
use yii\db\ActiveRecord;
use yii\db\Exception;

class Role extends ActiveRecord
{
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

    public static function getTree($notPid=null){
        $model = self::find()->where(['<>','status',-1])->andWhere(['<>','id',0])->andFilterWhere(['<>','id',$notPid])->asArray()->all();
        return Tree::tidyTree($model);
    }

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
//是否是父角色
    public static function IsParentRole($id){
        if (!is_numeric($id)){
            throw new Exception('$id 不是整型');
        }
        $model = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->one();
        return empty($model)?false:true;
    }

    /**
     * @param $id
     *
     */
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
    public function add($jurisdiction){
        if ($this->parent_id == 0){
            $this->tree = "|_ _ ";
        }else{
            $parent = self::findOne($this->parent_id);
            $this->tree = $parent->tree."_ _ ";
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $arr = [];
            if (!$this->save())throw new \Exception("添加失败");
            $son = self::find()->where(['parent_id'=>$this->primaryKey])->all();//递归修改
            if (!empty($son)){
                foreach ($son as $s){
                    $sjurisdiction = Jurisdiction::find()->select(['menu_id'])->where(['role_id'=>$s->primaryKey])->column();
                    $s->add($sjurisdiction);
                }
            }
            $pmenus = Jurisdiction::find()->select(['menu_id'])->where(['role_id'=>$this->parent_id])->column();//增加菜单必须在父类拥有的菜单下
            foreach ($jurisdiction as $j){
                if (in_array($j,$pmenus)){
                    array_push($arr,[$this->id,$j]);
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

    public static function recursionDel($id){
        $son = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->all();
        if (!empty($son)){
            foreach ($son as $s){
                self::recursionDel($s->id);
            }
        }
        $model = self::findOne($id);
        $model->status = -1;
        Jurisdiction::deleteAll(['role_id'=>$id]);
        return $model->save();
    }
}