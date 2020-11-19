<?php


namespace frontend\component;


use yii\base\Component;

class Msg extends Component
{
    public $msg;
    const EVENT_HANDLE = "handle";
//    public function behaviors()
//    {
//        return [
//            \frontend\behavior\Msg::class,
//        ];
//    }
    /**
     * 注释时间:2020/11/19 9:45
     * author:何文杰
     * 时间 处理器
     */
    public function handle($event){
        $this->bmsg = "kk";
        $this->bmsg;
        var_dump($this->bmsg);
        var_dump($event);
    }
}