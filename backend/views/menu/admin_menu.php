<?php
/* @var $menu string */
use \backend\models\Menu;
use \yii\helpers\Url;
$this->title = "后台菜单";
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>
<div class="page-content-wrap">
    <div class="layui-inline tool-btn">
        <button id="menu-add" class="layui-btn layui-btn-small layui-btn-normal addBtn hidden-xs"><i class="layui-icon">&#xe654;</i></button>
        <button id="menu-add" class="layui-btn layui-btn-small layui-btn-danger delBtn hidden-xs"><i class="layui-icon">&#xe640;</i></button>
    </div>
    <div class="layui-form" id="table-list">
        <table class="layui-table" lay-skin="line">
            <colgroup>
                <col width="50">
                <col class="hidden-xs" width="50">
                <col class="hidden-xs" width="100">
                <col class="hidden-xs" width="100">
                <col>
                <col width="80">
                <col width="130">
            </colgroup>
            <thead>
            <tr>
                <th id="allChoose"><input id="choose" type="checkbox" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="hidden-xs">ID</th>
                <th class="hidden-xs">排序</th>
                <th class="hidden-xs">路由</th>
                <th>菜单名称</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($menu as $m){?>
            <tr id='node-<?=$m['id']?>' class="<?php if ($m['parent_id']!=0){
                echo "child-node-".$m['parent_id'];
            }?> parent collapsed" style="<?php if($m['parent_id']!=0)echo 'display:none ;';?>"<?php if($m['parent_id']!=0){
                $id = Menu::getGrandfather($m['parent_id']);
                echo "parentid=".$id;
            }?> >
                <td><input type="checkbox" name="primary_id" lay-skin="primary" data-id="<?=$m['id']?>" value="<?=$m['id']?>"></td>
                <td class="hidden-xs"><?=$m['id']?></td>
                <td class="hidden-xs"><input type="text" name="sort" autocomplete="off" class="layui-input" value="<?=$m['sort']?>" data-id="<?=$m['id']?>"></td>
                <td class="hidden-xs"><?=$m['name']?></td>
                <td><?=$m['tree']?><?=$m['title']?>
                    <?php if (Menu::IsParentMenu($m['id'])){?>
                        <a class="layui-btn layui-btn-mini layui-btn-normal showSubBtn" data-id='<?=$m['id']?>'>+</a>
                    <?}?>
                </td>
                <td data-id="<?=$m['id']?>">
                    <?php if ($m['status']==1){?>
                        <button class="layui-btn layui-btn-mini layui-btn-normal table-list-status" status-flag="<?=$m['status']?>">显示</button>
                    <?php }else{?>
                        <button class="layui-btn layui-btn-mini layui-btn-warm table-list-status" status-flag="<?=$m['status']?>">隐藏</button>
                    <?php }?>
                </td>
                <td>
                    <div class="layui-inline">
                        <a href="<?=Url::to(['menu/admin-menu-add','pid'=>$m['id']])?>" class="layui-btn layui-btn-mini layui-btn-normal  add-btn" data-id="<?=$m['id']?>" data-url="menu-add.html"><i class="layui-icon">&#xe654;</i></a>
                        <a href="<?=Url::to(['menu/admin-menu-add','id'=>$m['id']])?>" class="layui-btn layui-btn-mini layui-btn-normal  edit-btn" data-id="<?=$m['id']?>" data-url="menu-add.html"><i class="layui-icon">&#xe642;</i></a>
                        <a href="<?=Url::to(['menu/admin-menu-del','id'=>$m['id']]);?>" class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="<?=$m['id']?>" data-url="menu-add.html"><i class="layui-icon">&#xe640;</i></a>
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
    $("#menu-add").click(function (){
        window.location.href = "<?=Url::to(['menu/admin-menu-add'])?>";
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
           url:"<?=Url::to(['menu/admin-menu-edit-status'])?>",
           type:"post",
           dataType:"json",
           data:{"Menu[id]":id,"Menu[status]":status,'_csrf-backend':csrf},
            success:function (data){
               if (data.code ==1){
                    if (data.data==1){
                        That.removeClass('layui-btn-warm').addClass('layui-btn-normal').html('显示').attr('status-flag', 1);
                    }else{
                        That.removeClass('layui-btn-normal').addClass('layui-btn-warm').html('隐藏').attr('status-flag', 0);
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
        $("input[name='primary_id']:checked").each(function(){
            var id = $(this).val();
            $.ajax({
               url:"<?=Url::to(['menu/admin-menu-del'])?>",
               data:{"id":id},
               dataType: "json",
               type: "get",
               success:function (data){
                   console.log(data);
               }
            });
        });
        window.location.reload();
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
    $("input[name='sort']").blur(function (){
        var sort = $(this).val();
        var id = $(this).attr("data-id");
        var csrf = $("#csrf").val();
        $.ajax({
            url:"<?=Url::to(['menu/edit-sort'])?>",
            data:{"id":id,"sort":sort,"_csrf-backend":csrf},
            dataType:"json",
            type:"post",
            success:function (data){
                if (data.code==0){
                    layer.msg("修改失败",{
                        icon:5,
                        time:1000,
                        title:"排序修改提示"
                    })
                }
            }
        })
    });
</script>
