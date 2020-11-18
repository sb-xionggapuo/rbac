<?php


namespace common\models;


use yii\db\ActiveRecord;

class WebSystem extends ActiveRecord
{
    public function rules()
    {
        return [
          [['web_title','web_logo','web_icp','web_count_code','seo_title','seo_keyword','seo_desc'],'safe']
        ];
    }
}