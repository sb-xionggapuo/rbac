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
                <a href="javascript:;"><i class="layui-icon">&#xe62a;</i> 菜单管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?=\yii\helpers\Url::to(['/menu/admin-menu'])?>"><span class="l-line"></span>后台菜单</a></dd>
                    <dd><a href="<?=\yii\helpers\Url::to(['/menu/frontend-menu'])?>"><span class="l-line"></span>前台菜单</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="layui-icon">&#xe613;</i>&nbsp;&nbsp;用户管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?=Url::to(['/user/frontend-index'])?>"><span class="l-line"></span>前台用户</a></dd>
                    <dd><a href="<?=Url::to(['/user/backend-index'])?>"><span class="l-line"></span>管理员用户</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">

            </li>
            <li class="layui-nav-item">

            </li>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="layui-icon">&#xe631;</i>&nbsp;&nbsp;设置</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?=Url::to(['/sy-set/web-set'])?>"><span class="l-line"></span>网站信息</a></dd>
                    <dd><a href="<?=Url::to(['/sy-set/seo-set'])?>"><span class="l-line"></span>SEO设置</a></dd>
                    <dd><a href="<?=Url::to(['/role/index'])?>"><span class="l-line"></span>角色管理</a></dd>
                    <dd><a href="<?=Url::to(['/backup'])?>"><span class="l-line"></span>数据备份</a></dd>
                </dl>
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
<script>

    layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog', 'element', 'upload', 'layedit'], function() {
        var form = layui.form(),
            layer = layui.layer,
            $ = layui.jquery,
            laypage = layui.laypage,
            laydate = layui.laydate,
            layedit = layui.layedit,
            element = layui.element(),
            dialog = layui.dialog;

        //获取当前iframe的name值
        var iframeObj = $(window.frameElement).attr('name');
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor', {
            tool: ['strong' //加粗
                , 'italic' //斜体
                , 'underline' //下划线
                , 'del' //删除线
                , '|' //分割线
                , 'left' //左对齐
                , 'center' //居中对齐
                , 'right' //右对齐
                , 'link' //超链接
                , 'unlink' //清除链接
                , 'image' //插入图片
            ],
            height: 100
        });
        //全选
        form.on('checkbox(allChoose)', function(data) {
            var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
            child.each(function(index, item) {
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
        form.render();

        layui.upload({
            url: '<?=\yii\helpers\Url::to(["common/upload-image"])?>',
            success: function(res) {
                $("#imgId").removeClass("hide").addClass("show");
                $("#upimage").val(res.data);
                $("#imgId").attr("src",res.data);
                console.log(res); //上传成功返回值，必须为json格式
            },
        });
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
