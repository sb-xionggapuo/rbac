<?php


namespace common\models;


use yii\base\Model;

class UserForm extends Model
{
    const USERFORM_ADD = "add";
    const USERFORM_EDIT = "edit";

    public $username;
    public $email;
    public $password;
    public $Rpassword;
    public $head_image;
    public $role_id;
    public function rules()
    {
        return [
            ['username','required',"message"=>"{attribute}不能为空"],
            [['password','Rpassword'],"required","message"=>"{attribute}不能为空","on"=>"add"],
            [['username','email'],"unique","targetClass"=>User::class,"message"=>"{attribute}已经被注册了,换一个试试吧","on"=>['add']],
            [['username','password'],'string',"min"=>2,"max"=>15],
            ['email',"email","message"=>"邮箱格式不正确"],
            ['Rpassword',"compare",'compareAttribute'=>"password","message"=>"重复密码不一致"],
            ['head_image',"safe"],
            ['role_id','notZero']
        ];
    }
    public function attributeLabels()
    {
        return [
            "username"  =>  "用户名",
            "email"     =>  "邮箱",
            "password"  =>  "密码",
            "Rpassword" =>  "确认密码",
            "role_id"   =>  "角色",
        ];
    }

    /**
     * @param int $id
     * @param int $identity
     * @return bool
     * 注释时间:2020/11/13 15:08
     * author:何文杰
     * 用户添加  同步authmanager
     */
    public function add($id=0,$identity=User::IDENTITY_FRONTEND){
        $auth = \Yii::$app->authManager;
        if (empty($id)){
            $model = new User();
        }else{
            $model = User::findOne(['id'=>$id]);
            $model->role_id;
            $rname = Role::findOne($model->role_id);
            $role = $auth->getRole($rname->name);
            $auth->revoke($role,$model->id);
        }
        $rname = Role::findOne($this->role_id);
        $role = $auth->getRole($rname->name);
        $model->username = $this->username;
        $model->email = $this->email;
        $model->role_id    = $this->role_id;
        $model->setPassword($this->password);
        $model->identity    = $identity;
        $model->status      = 10;
        if (!empty($this->head_image))$model->head_image = $this->head_image;
        if (!empty($this->email))$model->email = $this->email;
        $model->generateAuthKey();
        $model->generateEmailVerificationToken();
        $flag = true;
        $flag2 = $model->save();
        try{
            $auth->revokeAll($model->primaryKey);
            $auth->assign($role,$model->primaryKey);
        }catch (\Exception $exception){
            $flag = false;
        }
        return $flag2&&$flag;
    }

    /**
     * @param $attribute
     * @param $params
     * 注释时间:2020/11/13 15:08
     * author:何文杰
     * 不为0
     */
    public function notZero($attribute, $params){
        if ($this->$attribute ==0){
            $this->addError($attribute,"角色不能为空");
        }
    }
}