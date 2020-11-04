<?php


namespace backend\controllers;


use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class CommonController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->actionMethod == "actionUploadImage"){
            $action->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionUploadImage(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $file = UploadedFile::getInstanceByName("head_image");
        $path = $this->getTimePath();
        $uniqid = md5(uniqid(microtime(true),true));
        if ($file->saveAs($path['absolute'].$uniqid.".".$file->extension)){
            $rpath = $path['relative'].$uniqid.".".$file->extension;
            return ['code'=>1,"msg"=>"上传成功","data"=>$rpath];
        }else{
            return ['code'=>0,"msg"=>"上传失败","data"=>null];
        }
    }
    public function getTimePath(){
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $absolute = \Yii::getAlias("@rootWeb/uploads")."/$year/$month/$day/";
        $relative = "/uploads/$year/$month/$day/";
        if (!is_dir($absolute)){
            mkdir($absolute,0777,true);
        }
        return ['absolute'=>$absolute,'relative'=>$relative];
    }
}