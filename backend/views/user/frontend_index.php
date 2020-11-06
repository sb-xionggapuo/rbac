<?php

/* @var $pagination String */
/* @var $user String */
/* @var $role String */
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
                <button class="layui-btn layui-btn-small layui-btn-danger delBtn hidden-xs"><i class="layui-icon">&#xe640;</i></button>
            </div>
            <div class="layui-inline">
                <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline">
                <select name="role_id">
                    <option value="">选择角色</option>
                    <?php foreach ($role as $r){?>
                    <option value="<?=$r['id']?>"><?=$r['tree']?><?=$r['name']?></option>
                    <?php }?>
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
                <col>
                <col width="80">
                <col width="150">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="hidden-xs">ID</th>
                <th>用户名</th>
                <th>角色名称</th>
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
                    <input type="checkbox" name="primary_id" lay-skin="primary" data-id="<?=$u['id']?>" value="<?=$u['id']?>">
<!--                --><?//=\yii\helpers\Html::checkbox("check[]",false,['lay-skin'=>'primary','data-id'=>$u->id])?>
                </td>
                <td class="hidden-xs"><?=$u['id']?></td>
                <td class="hidden-xs"><?=$u['username']?></td>
                <td class="hidden-xs"><?=$u['role_name']?></td>
                <td><?=date("Y-m-d H:i:s",$u['last_login_time'])?></td>
                <td><?=$u['last_login_ip']?></td>
                <td data-id="<?=$u['id']?>">
                    <?php if ($u['status'] == \common\models\User::STATUS_ACTIVE){?>
                        <button class="layui-btn layui-btn-mini layui-btn-normal table-list-status" data-status='10'>正常</button>
                    <?php }else{?>
                        <button class="layui-btn layui-btn-mini table-list-status layui-btn-warm" data-status="9">已拉黑</button>
                    <?php }?>
                </td>
                <td>
                    <div class="layui-inline">
                        <a href="<?=\yii\helpers\Url::to(['user/frontend-user-add','id'=>$u['id']])?>" class="layui-btn layui-btn-mini layui-btn-normal  edit-btn" data-id="1" data-url="menu-add2.html"><i class="layui-icon">&#xe642;</i></a>
                        <a href="<?=\yii\helpers\Url::to(['user/user-del','id'=>$u['id']])?>" class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="1" data-url="del.html"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <input type="hidden" id="csrf" value="<?=Yii::$app->request->csrfToken?>">
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
            if (status ==10){
                status=9;
            }else{
                status=10;
            }
            var csrf = $("#csrf").val();
            var id = That.parent().attr('data-id');
            $.ajax({
                url:"<?=\yii\helpers\Url::to(['user/update-status'])?>",
                type:"post",
                dataType:"json",
                data:{"status":status,"id":id,"_csrf-backend":csrf},
                success:function(data){
                    if(data.status == 9) {
                        That.removeClass('layui-btn-normal').addClass('layui-btn-warm').html('已拉黑').attr('data-status',9);
                    } else if(data.status == 10) {
                        That.removeClass('layui-btn-warm').addClass('layui-btn-normal').html('正常').attr('data-status', 10);
                    }
                    console.log(data);
                }
            });

        });

        $(".delBtn").click(function (){
            var ids = new Array();
            $("input[name='primary_id']:checked").each(function(){
                ids.push($(this).val());
            });
            $.ajax({
                url:"<?=\yii\helpers\Url::to(['user/user-del-all'])?>",
                data:{"id":ids},
                dataType: "json",
                type: "get",
                success:function (data){
                    if (data.code ==1){
                        layer.msg("删除成功",{
                            icon:6,time:2000,title:"删除提示"
                        },function (){
                            window.location.reload();
                        });
                    }else{
                        layer.alert("删除失败",{
                            icon:5,
                            title:"删除提示"
                        },function (){
                            window.location.reload();
                        })
                    }
                }
            });
        });

    });
</script>