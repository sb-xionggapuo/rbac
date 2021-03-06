<?php
namespace backend\models;

use common\HelpFunction\Tree;
use common\models\Jurisdiction;
use yii\db\Exception;

class Menu extends \yii\db\ActiveRecord
{
    const FRONTEND_MENU = 1;
    const BACKEND_MENU = 10;
    static $grandFather;
    public function rules()
    {
        return [
          [['name','title','parent_id','status','sort'],'required',"message"=>"{attribute}不能为空"],
            [['parent_id','status','sort'],'number',"message"=>"{attribute}必须是数字"],
            ['icon','safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            "name"      =>  "路由",
            "title"     =>  "名称",
            'parent_id' =>  "上级",
            "status"    =>  "状态",
            'sort'      =>  "排序"
        ];
    }

    /**
     * specification:
     * author:何文杰
     * date:2020/10/28 11:19
     * @param $notPid 菜单查询出来 不包含的菜单 及子菜单
     * @return array|mixed
     */
    public static function getTree($flag,$notPid=null){
        $model = static::find()->where("status!=-1")->andWhere(['flag'=>$flag])->andFilterWhere(['<>','id',$notPid])->orderBy("sort DESC")->asArray()->all();
        return Tree::tidyTree($model);
    }
    /**
     * 使用前请先$model->load()
     * specification:添加菜单
     * author:何文杰
     * date:2020/10/27 16:48
     * @return bool
     */
    public function add($flag=self::BACKEND_MENU){
        if ($this->parent_id ==0){
            $this->level    =   1;
            $this->tree     =   "|_ _ ";
        }else{
            $parent = self::find()->where(['id'=>$this->parent_id])->one();
            $this->level    =   $parent->level+1;
            $this->tree     =   $parent->tree."_ _ ";
        }
        $this->flag = $flag;
        $result = $this->save();
        $j = Jurisdiction::find()->where(['role_id'=>0,"menu_id"=>$this->primaryKey])->all();
        if (empty($j)){
            $jurisdiction = new Jurisdiction();
            $jurisdiction->role_id = 0;
            $jurisdiction->menu_id = $this->primaryKey;
            $jurisdiction->save();
        }
        $son = self::find()->where(['parent_id'=>$this->primaryKey])->all();//递归修改
        if (!empty($son)){
            foreach ($son as $s){
                $s->add($flag);
            }
        }
        return $result;
    }

    /**
     * specification:检查是不是父栏目
     * author:何文杰
     * date:2020/10/27 16:49
     * @param $id
     * @return bool
     * @throws Exception
     */
    public static function IsParentMenu($id){
        if (!is_numeric($id)){
            throw new Exception('$id 不是整型');
        }
        $model = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->one();
        return empty($model)?false:true;
    }

    /**
     * specification:得到id的 顶级id （祖宗）
     * author:何文杰
     * date:2020/10/28 15:54
     * @param $id
     * @return mixed
     * @throws Exception
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
     * specification: 递归删除 id为$id的菜单及子菜单
     * author:何文杰
     * date:2020/10/28 16:07
     * @param $id
     * @return bool
     */
    public static function recursionDel($id){
        $son = self::find()->where(['parent_id'=>$id])->andWhere('status!=-1')->all();
        if (!empty($son)){
            foreach ($son as $s){
                self::recursionDel($s->id);
            }
        }
        $auth = \Yii::$app->authManager;
        $model = self::findOne($id);
        if (!empty($permission = $auth->getPermission($model->name)))$auth->remove($permission);
        $model->status= -1;
        return $model->save();
    }
}