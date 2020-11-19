<?php


namespace common\rbac;


use common\models\AdminLog;
use common\models\LoginForm;
use common\models\Role;
use yii\db\ActiveRecord;

class log
{
    public static function write($event){
        $user = \Yii::$app->user->identity;
        if ($event->sender instanceof AdminLog||$user->role_id==0)return ;
        $role = Role::findOne($user->role_id);
        $username = $role->name."($user->username)";
        $table = $event->name != LoginForm::EVENT_AFTER_LOGIN?$event->sender->tableSchema->name:"user";
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT){
            $desc = "在$table 中增加了一条数据";
        }else if ($event->name == ActiveRecord::EVENT_AFTER_UPDATE){
            $key = array_keys($event->changedAttributes);
            $field = implode(",",$key);
            $desc = "在$table 中修改 $field 数据";
        }else if ($event->name == ActiveRecord::EVENT_AFTER_DELETE){
            $desc = "在$table 中删除了一条数据";
        }else if ($event->name == LoginForm::EVENT_AFTER_LOGIN){
            $desc = "$username 登录了";
        }
        $adminlog = new AdminLog();
        $adminlog->username = $username;
        $adminlog->desc = $desc;
        $adminlog->time = time();
        $adminlog->save();
    }
}