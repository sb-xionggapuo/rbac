<?php
namespace common\HelpFunction;

class Tree
{
    public static function tidyTree(array $arr,$parent_id=0,&$arrBox=[]){
        foreach ($arr as $a){
            if ($a['parent_id']==$parent_id){
                array_push($arrBox,$a);
                static::tidyTree($arr,$a['id'],$arrBox);
            }
        }
        return $arrBox;
    }
}