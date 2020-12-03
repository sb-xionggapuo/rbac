<?php


namespace common\models;


use yii\elasticsearch\ActiveRecord;

class SearchGoods extends ActiveRecord
{

    public function attributes()
    {
       return [
            'job',
            'title'
       ];
    }
    public static function index()
    {
        return "yii2";
    }
    public static function type()
    {
        return "_doc";
    }
}