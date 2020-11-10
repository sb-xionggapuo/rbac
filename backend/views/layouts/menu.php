<?php
use \yii\helpers\Html;
use \yii\helpers\Url;
/* @var $content string */
    $baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php Yii::$app->language?>">
<head>
    <meta charset="<?php Yii::$app->charset?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/layui/css/layui.css"/>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/admin.css"/>
    <script src="<?=$baseUrl?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?=$baseUrl?>/layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=$baseUrl?>/js/common.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=$baseUrl?>/js/module/dialog.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=$baseUrl?>/js/main.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<?php $this->beginBody() ?>
<div class="main-layout" id='main-layout'>
    <!--侧边栏-->
    <div class="main-layout-side">
        <div class="m-logo">
        </div>
        <ul class="layui-nav layui-nav-tree" lay-filter="leftNav">
            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;"><i class="iconfont">&#xe607;</i>菜单管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?=\yii\helpers\Url::to(['/menu/admin-menu'])?>" data-id='1' data-text="后台菜单"><span class="l-line"></span>后台菜单</a></dd>
                    <dd><a href="<?=\yii\helpers\Url::to(['/menu/frontend-menu'])?>" data-id='2' data-text="前台菜单"><span class="l-line"></span>前台菜单</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe608;</i>内容管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;"  data-id='3' data-text="文章管理"><span class="l-line"></span>文章管理</a></dd>
                    <dd><a href="javascript:;"  data-id='9' data-text="单页管理"><span class="l-line"></span>单页管理</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe608;</i>用户管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?=Url::to(['user/frontend-index'])?>"  data-id='3' data-text="前台用户"><span class="l-line"></span>前台用户</a></dd>
                    <dd><a href="<?=Url::to(['user/backend-index'])?>"  data-id='9' data-text="管理员用户"><span class="l-line"></span>管理员用户</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe604;</i>推荐位管理</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe60c;</i>友情链接</a>
            </li>
            <li class="layui-nav-item">
                <a href="<?=Url::to(['role/index'])?>"><i class="iconfont">&#xe60a;</i>RBAC</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;" data-url="email.html" data-id='4' data-text="邮件系统"><i class="iconfont">&#xe603;</i>邮件系统</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe60d;</i>生成静态</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe600;</i>备份管理</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe600;</i>备份管理2</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;"  data-id='3' data-text="文章管理"><span class="l-line"></span>文章管理</a></dd>
                    <dd><a href="javascript:;"  data-id='9' data-text="单页管理"><span class="l-line"></span>单页管理</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont">&#xe600;</i>备份管理2</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;"  data-id='3' data-text="文章管理"><span class="l-line"></span>文章管理</a></dd>
                    <dd><a href="javascript:;"  data-id='9' data-text="单页管理"><span class="l-line"></span>单页管理</a></dd>
                </dl>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:;" data-url="admin-info.html" data-id='5' data-text="个人信息"><i class="iconfont">&#xe606;</i>个人信息</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;" data-url="system.html" data-id='6' data-text="系统设置"><i class="iconfont">&#xe60b;</i>系统设置</a>
            </li>
        </ul>
    </div>
    <!--右侧内容-->
    <div class="main-layout-container">
        <!--头部-->
        <div class="main-layout-header">
            <div class="menu-btn" id="hideBtn">
                <a href="javascript:;">
                    <span class="iconfont">&#xe60e;</span>
                </a>
            </div>
            <ul class="layui-nav" lay-filter="rightNav">
                <li class="layui-nav-item"><a href="javascript:;" data-url="email.html" data-id='4' data-text="邮件系统"><i class="iconfont">&#xe603;</i></a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;" data-url="admin-info.html" data-id='5' data-text="个人信息">超级管理员</a>
                </li>
                <li class="layui-nav-item"><a href="<?=\yii\helpers\Url::to(['site/logout'])?>">退出</a></li>
            </ul>
        </div>
        <!--主体内容-->
        <div class="main-layout-body">
            <!--tab 切换-->
            <div class="layui-tab layui-tab-brief main-layout-tab" lay-filter="tab" lay-allowClose="true">
                <ul class="layui-tab-title">
                    <li class="layui-this welcome"><?=empty($this->params['tab'])?"":$this->params['tab']?></li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show" style="background: #f5f5f5;">
                        <!--1-->
                        <?= $content ?>

                        <!--1end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--遮罩-->
    <div class="main-mask">

    </div>
</div>
<?=$this->blocks['js'];?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
