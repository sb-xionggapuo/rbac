<?php


namespace frontend\controllers;


use common\models\SearchGoods;
use yii\web\Controller;

class ElasticSearchTestController extends Controller
{
    public function actionTestConn(){
        $hightlight=[

            #左标签，配合前端.highlight这个类来实现高亮
            "pre_tags"=>['<span class="highlight">'],
            "post_tags"=>['</span>'],

            #在原生api中写的是{}表示空对象，因此使用php的stdClass来表示空对象
            "fields"=>[
                "job"=>new \stdClass(),
                'title'=>new \stdClass()
            ]
        ];
       $result = SearchGoods::find()->query([
           'multi_match'=>[
               'query'=>"员",
               "fields"=>['job',"title"]
           ]
       ])->highlight($hightlight)->all();
        return $this->render("test_conn",[
            "res" => $result
            ]);
    }

}