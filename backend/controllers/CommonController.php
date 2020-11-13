<?php
/**
 * 公共调用的控制器方法
 */

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

    /**
     * @return array
     * 注释时间:2020/11/13 14:56
     * author:何文杰
     * 公用的图片上传接口
     */
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

    /**
     * @return array
     * 注释时间:2020/11/13 14:57
     * author:何文杰
     * 文件上传文件夹路径
     */
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