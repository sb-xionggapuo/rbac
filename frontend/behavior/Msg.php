<?php


namespace frontend\behavior;


use yii\base\Behavior;

class Msg extends Behavior
{
    public $bmsg;
    public function fujia(){
        echo "附加消息";
    }
    public function events()
    {
        return [
            \frontend\component\Msg::EVENT_HANDLE => "chuli"
        ];
    }
    public function chuli($event){
       var_dump($event->msg);
    }
}