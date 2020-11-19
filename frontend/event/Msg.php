<?php


namespace frontend\event;


use yii\base\Event;

class Msg extends Event
{
    private $msg;
    public function getMsg(){
        return $this->msg;
    }
    public function setMsg($value){
        $this->msg = $value;
    }
}