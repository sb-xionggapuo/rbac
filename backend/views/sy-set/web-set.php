<?php
/* @var $model string */
$this->title = "网站设置";
$this->params['tab'] = "网站设置";
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

    <form class="layui-form" action="<?=\yii\helpers\Url::to(['/sy-set/web-set'])?>" method="post">
        <input type="hidden" name="_csrf-backend" value="<?=Yii::$app->request->csrfToken?>">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">网站标题：</label>
                        <div class="layui-input-block">
                            <input type="text" name="WebSystem[web_title]" required lay-verify="required" placeholder="请输入网站标题" autocomplete="off" class="layui-input" value="<?=$model->web_title;?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">网站logo：</label>
                        <div class="layui-input-block">
                            <input id="upload-file" type="file" name="image" class="layui-upload-file">
                            <?php if (empty($model->web_logo)){?>
                                <img id="imgId" src="<?=$model->web_logo?>" alt="未找到该图片" class="hide">
                            <?php }else{?>
                                <img id="imgId" src="<?=$model->web_logo?>" alt="未找到该图片" class="show">
                            <?php }?>
                        </div>
                    </div>
                    <input type="hidden" id="upimage" name="WebSystem[web_logo]" value="<?=$model->web_logo??''?>">
                    <div class="layui-form-item">
                        <label class="layui-form-label">ICP备案号：</label>
                        <div class="layui-input-block">
                            <input type="text" name="WebSystem[web_icp]" placeholder="请输入备案号" autocomplete="off" class="layui-input" value="<?=$model->web_icp;?>">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">统计代码：</label>
                        <div class="layui-input-block">
                            <textarea name="WebSystem[web_count_code]" placeholder="请输入统计代码" class="layui-textarea"><?=$model->web_count_code;?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 70px;">
            <div class="layui-input-block">
                <?=\yii\helpers\Html::submitButton("立即提交",['class'=>"layui-btn layui-btn-normal"])?>
<!--                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>-->
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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

