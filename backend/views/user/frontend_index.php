<?php

/* @var $pagination String */
/* @var $user String */
$this->title = "前台用户管理";
$this->params['tab'] = "前台用户管理";
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>
<style>
    .pagination li.active {
        background-color: #1e9FFF;
    }
    .pagination li.active a{
        color: #ffffff;
    }
</style>
<div class="page-content-wrap">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline tool-btn">
                <a href="<?=\yii\helpers\Url::to(['user/frontend-user-add'])?>" class="layui-btn layui-btn-small layui-btn-normal addBtn hidden-xs"><i class="layui-icon">&#xe654;</i></a>
                <a class="layui-btn layui-btn-small layui-btn-warm listOrderBtn hidden-xs"><i class="iconfont">&#xe656;</i></a>
            </div>
            <div class="layui-inline">
                <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline">
                <select name="category" lay-filter="status">
                    <option value="0">主导航</option>
                    <option value="010">关于我们</option>
                    <option value="021">产品中心</option>
                    <option value="021">新闻中心</option>
                    <option value="021">业务范围</option>
                    <option value="021">联系我们</option>
                    <option value="021">在线留言</option>
                </select>
            </div>
            <button class="layui-btn layui-btn-normal" lay-submit="search">搜索</button>
        </div>
    </form>
    <div class="layui-form" id="table-list">
        <table class="layui-table" lay-even lay-skin="nob">
            <colgroup>
                <col width="50">
                <col class="hidden-xs" width="50">
                <col>
                <col>
                <col>
                <col width="80">
                <col width="150">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="hidden-xs">ID</th>
                <th>用户名</th>
                <th>最后登录时间</th>
                <th>最后登录IP</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($user as $u){?>
            <tr>
                <td>
<!--                    <input type="checkbox" name="" lay-skin="primary" data-id="--><?//=$u->id?><!--">-->
                <?=\yii\helpers\Html::checkbox("check[]",false,['lay-skin'=>'primary','data-id'=>$u->id])?>
                </td>
                <td class="hidden-xs"><?=$u->id?></td>
                <td class="hidden-xs"><?=$u->username?></td>
                <td><?=$u->lastLoginTime?></td>
                <td><?=$u->last_login_ip?></td>
                <td>
                    <?php if ($u->status == \common\models\User::STATUS_ACTIVE){?>
                        <button class="layui-btn layui-btn-mini layui-btn-normal table-list-status" data-status='1'>正常</button>
                    <?php }else{?>
                        <button class="layui-btn layui-btn-mini table-list-status layui-btn-warm" data-status="2">已拉黑</button>
                    <?php }?>
                </td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-mini layui-btn-normal  add-btn" data-id="1" data-url="menu-add2.html"><i class="layui-icon">&#xe654;</i></button>
                        <button class="layui-btn layui-btn-mini layui-btn-normal  edit-btn" data-id="1" data-url="menu-add2.html"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="1" data-url="del.html"><i class="layui-icon">&#xe640;</i></button>
                    </div>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <div class="page-wrap">
            <?=\yii\widgets\LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => ['class' => 'pagination'],
            ])?>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'jquery', 'layer', 'dialog'], function() {
        var $ = layui.jquery;

        //修改状态
        $('#table-list').on('click', '.table-list-status', function() {
            var That = $(this);
            var status = That.attr('data-status');
            var id = That.parent().attr('data-id');
            if(status == 1) {
                That.removeClass('layui-btn-normal').addClass('layui-btn-warm').html('已拉黑').attr('data-status', 2);
            } else if(status == 2) {
                That.removeClass('layui-btn-warm').addClass('layui-btn-normal').html('正常').attr('data-status', 1);

            }
        })

    });
</script>