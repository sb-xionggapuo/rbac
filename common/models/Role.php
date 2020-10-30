<?php


namespace common\models;


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

    public static function IsParentMenu($id){
        if (!is_numeric($id)){
            throw new Exception('$id 不是整型');
        }
        $model = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->one();
        return empty($model)?false:true;
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
            if (!$this->save()){
                throw new \Exception("添加失败");
            }
            foreach ($jurisdiction as $j){
                array_push($arr,[$this->id,$j]);
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