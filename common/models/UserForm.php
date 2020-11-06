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

    public function add($id=0){
        if (empty($id)){
            $model = new User();
        }else{
            $model = User::findOne(['id'=>$id]);
        }
        $model->username = $this->username;
        $model->email = $this->email;
        $model->role_id    = $this->role_id;
        $model->setPassword($this->password);
        $model->identity    = 1;
        $model->status      = 10;
        if (!empty($this->head_image)){
            $model->head_image = $this->head_image;
        }
        if (!empty($this->email)){
            $model->email = $this->email;
        }
        $model->generateAuthKey();
        $model->generateEmailVerificationToken();
        return $model->save();
    }

    public function notZero($attribute, $params){
        if ($this->$attribute ==0){
            $this->addError($attribute,"角色不能为空");
        }
    }
}