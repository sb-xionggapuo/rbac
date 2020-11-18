<?php
$this->title = "SEO设置";
$this->params['tab'] = "SEO设置";
?>
<style>
    .main-layout-tab .layui-tab-content {
        position: relative;
    }
    .hide{
        display: none;
    }
    .show{
        display: block;
        width: 200px;
        height: 200px;
    }
</style>
<?=Yii::$app->session->getFlash("success")?>
<div class="page-content-wrap clearfix">
    <form class="layui-form" action="<?=\yii\helpers\Url::to(['/sy-set/seo-set'])?>" method="post">
        <input type="hidden" name="_csrf-backend" value="<?=Yii::$app->request->csrfToken?>">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">标题：</label>
                        <div class="layui-input-block">
                            <input type="text" name="WebSystem[seo_title]" required lay-verify="required" placeholder="请输入seo标题" autocomplete="off" class="layui-input" value="<?=$model->seo_title?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">关键词：</label>
                        <div class="layui-input-block">
                            <input type="text" name="WebSystem[seo_keyword]" placeholder="请输入关键词" autocomplete="off" class="layui-input" value="<?=$model->seo_keyword?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">详情：</label>
                        <div class="layui-input-block">
                            <input type="text" name="WebSystem[seo_desc]" placeholder="请输入seo详情" autocomplete="off" class="layui-input" value="<?=$model->seo_desc?>">
                        </div>
                    </div>
<!--                    <div class="layui-form-item layui-form-text">-->
<!--                        <label class="layui-form-label">站点状态：</label>-->
<!--                        <div class="layui-input-block">-->
<!--                            <input type="radio" title="开启" name="radio" checked>-->
<!--                            <input type="radio" title="关闭" name="radio" >-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 70px;">
            <div class="layui-input-block">
                <?=\yii\helpers\Html::submitButton("立即提交",['class'=>'layui-btn layui-btn-normal'])?>
                <?=\yii\helpers\Html::resetButton("重置",['class'=>'layui-btn layui-btn-primary'])?>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    var SCOPE = {
        static: '/static',
        index: '/admin/category/index.html',
        add: 'add.html',
        save: '/admin/category/save.html',
        edit: 'add.html',
        updateEdit: '/admin/category/updateedit.html',
        status: '/admin/category/updatestatus.html',
        del: '/admin/category/del.html',
        delAll: '/admin/category/deleteall.html',
        listOrderAll: '/admin/category/listorderall.html'
    }
</script>

