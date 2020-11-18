<?php
/* @var $id int */
$this->title = "前台用户添加";
$this->params['tab'] = "前台用户添加";
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
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
<div class="page-content-wrap clearfix">
    <form class="layui-form" action="<?=\yii\helpers\Url::to(['user/frontend-user-add'])?>" method="post">
        <input type="hidden" name="_csrf-backend" value="<?=Yii::$app->request->csrfToken?>">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li><a href="<?=\yii\helpers\Url::to(['user/frontend-index'])?>">用户列表</a></li>
                <li class="layui-this">添加用户</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">用户名：</label>
                        <div class="layui-input-block">
                                <input type="text" name="UserForm[username]" value="<?=$model->username?>"   placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                <span style="color: red"><?=$model->getErrors()['username'][0]??""?></span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮箱：</label>
                        <div class="layui-input-block">
                            <input type="text" name="UserForm[email]" value="<?=$model->email?>"  placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                            <span style="color: red"><?=$model->getErrors()['email'][0]??""?></span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">密码：</label>
                        <div class="layui-input-block">
                            <input type="password" name="UserForm[password]" value="<?=$model->password?>"  placeholder="请输入密码" autocomplete="off" class="layui-input">
                            <span style="color: red"><?=$model->getErrors()['password'][0]??""?></span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">确认密码：</label>
                        <div class="layui-input-block">
                            <input type="password" name="UserForm[Rpassword]" value="<?=$model->Rpassword?>"  placeholder="请确认密码" autocomplete="off" class="layui-input">
                            <span style="color: red"><?=$model->getErrors()['Rpassword'][0]??""?></span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">角色：</label>
                        <div class="layui-input-block">
                            <select name="UserForm[role_id]" lay-verify="">
                                <option value="0">请选择一个角色</option>
                                <?php foreach ($role as $r){?>
                                    <option <?php $rid = $model->role_id??0; if($rid==$r['id'])echo 'selected'?> value="<?=$r['id']?>"><?=$r['tree']?><?=$r['name']?></option>
                                <?php }?>
                            </select>
                            <span style="color: red"><?=$model->getErrors()['role_id'][0]??""?></span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">头像上传：</label>
                        <div class="layui-input-block" >
                            <input id="upload-file" type="file" name="image" class="layui-upload-file">
                            <?php if (!empty($model->head_image)){?>
                                <img id="imgId" src="<?=$model->head_image?>" alt="未找到该图片" class="show">
                            <?php }else{?>
                                <img id="imgId" src="<?=$model->head_image?>" alt="未找到该图片" class="hide">
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <input type="hidden" id="upimage" name="UserForm[head_image]" value="<?=$model->head_image?>">
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 70px;">
            <div class="layui-input-block">
                <?=\yii\helpers\Html::submitButton("立即提交",['class'=>"layui-btn layui-btn-normal"])?>
<!--                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>-->
                <?=\yii\helpers\Html::resetButton('重置',['class'=>"layui-btn layui-btn-primary"])?>
<!--                <button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
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
                $("#head_image").val(res.data);
                $("#imgId").attr("src",res.data);
            },
        });
    });
</script>