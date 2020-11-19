<?php
/* @var $model string */
use \common\models\Role;
use \yii\helpers\Url;
$this->title = "rbac-角色管理";
$this->params['tab'] = "角色管理";
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>
<div class="page-content-wrap">
    <div class="layui-inline tool-btn">
        <a href="<?=Url::to(['role/add'])?>" class="layui-btn layui-btn-small layui-btn-normal addBtn hidden-xs"><i class="layui-icon">&#xe654;</i></a>
        <button class="layui-btn layui-btn-small layui-btn-danger delBtn hidden-xs"><i class="layui-icon">&#xe640;</i></button>
    </div>
    <div class="layui-form" id="table-list" style="overflow-y:scroll;width:100%;height: 800px;">
        <table class="layui-table" lay-skin="line">
            <colgroup>
                <col width="50">
                <col class="hidden-xs" width="50">
                <col>
                <col>
                <col width="80">
                <col width="130">
            </colgroup>
            <thead>
            <tr>
                <th id="allChoose"><input id="choose" type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="hidden-xs">ID</th>
                <th>名称</th>
                <th>描述</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model as $m){?>
            <tr id='node-<?=$m['id']?>' class="<?php if ($m['parent_id']!=0){
                echo "child-node-".$m['parent_id'];
            }?> parent collapsed" style="<?php if($m['parent_id']!=0)echo 'display:none ;';?>"<?php if($m['parent_id']!=0){
                $id = Role::getGrandfather($m['parent_id']);
                echo "parentid=".$id;
            }?> >
                <td><input type="checkbox" name="primary_id" lay-skin="primary" data-id="<?=$m['id']?>" value="<?=$m['id']?>"></td>
                <td class="hidden-xs"><?=$m['id']?></td>
                <td><?=$m['tree']?><?=$m['name']?>
                    <?php if (Role::IsParentRole($m['id'])){?>
                        <a class="layui-btn layui-btn-mini layui-btn-normal showSubBtn" data-id='<?=$m['id']?>'>+</a>
                    <?}?></td>
                <td><?=$m['describe']?></td>
                <td data-id="<?=$m['id']?>">
                    <?php if ($m['status']==1){?>
                        <button class="layui-btn layui-btn-mini layui-btn-normal table-list-status" status-flag="<?=$m['status']?>">启用</button>
                    <?php }else{?>
                        <button class="layui-btn layui-btn-mini layui-btn-warm table-list-status" status-flag="<?=$m['status']?>">禁用</button>
                    <?php }?>
                </td>
                <td>
                    <div class="layui-inline">
                        <a href="<?=Url::to(['role/add','pid'=>$m['id']])?>" class="layui-btn layui-btn-mini layui-btn-normal  add-btn" data-id="<?=$m['id']?>" data-url="menu-add.html"><i class="layui-icon">&#xe654;</i></a>
                        <?php if (Yii::$app->user->identity->role_id != $m['id']){?>
                        <a href="<?=Url::to(['role/add','id'=>$m['id']])?>" class="layui-btn layui-btn-mini layui-btn-normal  edit-btn" data-id="<?=$m['id']?>" data-url="menu-add.html"><i class="layui-icon">&#xe642;</i></a>
                        <?php }?>
                        <a href="<?=Url::to(['role/del','id'=>$m['id']]);?>" class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="<?=$m['id']?>" data-url="menu-add.html"><i class="layui-icon">&#xe640;</i></a>
                    </div>
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <input type="hidden" id="csrf" value="<?=Yii::$app->request->csrfToken?>">
    </div>
</div>
<script>
    layui.use(['jquery'], function() {
        var $=layui.jquery;
        //修改状态
        //栏目展示隐藏
        $('.showSubBtn').on('click', function() {
            var _this = $(this);
            var id = _this.attr('data-id');
            var parent = _this.parents('.parent');
            var child = $('.child-node-' + id);
            var childAll = $('tr[parentid=' + id + ']');
            if(parent.hasClass('collapsed')) {
                _this.html('-');
                parent.addClass('expanded').removeClass('collapsed');
                child.css('display', '');
            } else {
                _this.html('+');
                parent.addClass('collapsed').removeClass('expanded');
                child.css('display', 'none');
                childAll.addClass('collapsed').removeClass('expanded').css('display', 'none');
                childAll.find('.showSubBtn').html('+');
            }

        })
    });
    $(".table-list-status").click(function (){
        var That = $(this);
        var flag = That.attr("status-flag");
        if (flag == 1){
            var status = 0;
        }else{
            var status = 1;
        }
        var id = That.parent().attr('data-id');
        var csrf = $("#csrf").val();
        $.ajax({
           url:"<?=Url::to(['role/edit-status'])?>",
           type:"post",
           dataType:"json",
           data:{"id":id,"status":status,'_csrf-backend':csrf},
            success:function (data){
               if (data.code ==1){
                    if (data.data==1){
                        That.removeClass('layui-btn-warm').addClass('layui-btn-normal').html('启用').attr('status-flag', 1);
                    }else{
                        That.removeClass('layui-btn-normal').addClass('layui-btn-warm').html('禁用').attr('status-flag', 0);
                    }
               }else{
                   layui.alert("修改失败",{
                       icon:5,
                       title:"修改提示",
                   });
               }
            }
        });
    });
    $(".delBtn").click(function (){
        var ids = new Array();
        $("input[name='primary_id']:checked").each(function(){
            ids.push($(this).val());
        });
        $.ajax({
            url:"<?=Url::to(['role/del-all'])?>",
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
        // setTimeout(window.location.reload(),2000);
    });
    $("#allChoose").click(function (){
        if ($("#choose").prop("checked") == true){
            $("input[name='primary_id']").prop("checked", true);
            $(".layui-form-checkbox").addClass("layui-form-checked");
        }else{
            $("input[name='primary_id']").prop("checked", false);
            $(".layui-form-checkbox").removeClass("layui-form-checked");
        }
    });

</script>
