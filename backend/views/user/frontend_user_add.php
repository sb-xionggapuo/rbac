<?php
$this->title = "前台用户添加";
$this->params['tab'] = "前台用户添加";
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>
<style>
    .main-layout-tab .layui-tab-content {
        position: relative;
    }
    .show{
        display: block;
        width: 200px;
        height: 200px;
    }
</style>
<div class="page-content-wrap clearfix">
    <form class="layui-form">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li><a href="article-list.html">单页列表</a></li>
                <li class="layui-this">页面管理</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">用户名：</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图像上传：</label>
                        <div class="layui-input-block" >
                            <input id="upload-file" type="file" name="head_image" class="layui-upload-file">
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">

                </div>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 70px;">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
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
        })
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
                $("#upload-file").after("<img src='"+res.data+"' class='show'>");
                console.log(res); //上传成功返回值，必须为json格式
            },
        });
    });
</script>