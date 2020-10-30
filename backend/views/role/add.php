<?php
/* @var $menu string */
/* @var $model string */
/* @var $parent_id int */
use \yii\widgets\ActiveForm;
use \yii\helpers\Html;
$this->title = "角色添加";
$baseUrl = \backend\assets\MenuAsset::register($this)->baseUrl;
?>

<div class="wrap-container">


        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'layui-form','id'=>'form1','enctype'=>"multipart/form-data",'style'=>"width: 90%;padding-top: 20px;"]
        ])?>

        <div class="layui-form-item">
            <label class="layui-form-label">上级：</label>
            <div class="layui-input-block">
                <select name="Role[parent_id]" lay-verify="required">
                    <option value="0">作为一级角色</option>
                    <?php foreach ($menu as $m){?>
                        <option <?=$m['id'] == $parent_id?'selected':'';?> value="<?=$m['id']?>"><?=$m['tree']?>&nbsp;<?=$m['name']?></option>
                    <?php }?>
                </select>
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色名称：</label>
            <div class="layui-input-block">
                <?=$form->field($model,"name")->textInput(['class'=>"layui-input",'placeholder'=>"请输入角色名称"])->label(false)?>
<!--                <input type="text" name="title" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">-->
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述：</label>
            <div class="layui-input-block">
                <?=$form->field($model,"describe")->textInput(['class'=>"layui-input",'placeholder'=>"请输入描述角色的内容"])->label(false)?>
<!--                <input type="text" name="title" required lay-verify="required" placeholder="请输入路由" autocomplete="off" class="layui-input">-->
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限：</label>
            <div class="layui-input-block">
                <div id="LAY-auth-tree-index"></div>
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="Role[status]" value="1" title="启用" checked>
                <input type="radio" name="Role[status]" value="0" title="禁用" <?= $model->status==0&&is_numeric($model->status)?"checked":"";?> >
            </div>

        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <?=Html::submitButton("立即提交",[
                        'class'=> "layui-btn layui-btn-normal"
                ])?>
                <?=Html::resetButton("重置",[
                        'class'=>   "layui-btn layui-btn-primary"
                ])?>
            </div>
        </div>
    <input type="hidden" id="hideId" value="<?=$id;?>">
    <input type="hidden" id="csrf" value="<?=Yii::$app->request->csrfToken?>">
    <?php ActiveForm::end();?>
</div>

<script>
    layui.config({
        base: '<?=$baseUrl?>/layui/lay/modules/',
    }).extend({
        authtree: 'authtree',
    });
    //Demo
    layui.use(['jquery', 'form', 'authtree', 'layer'], function(){
        var $ = layui.jquery;
        var authtree = layui.authtree;
        var form = layui.form();
        var layer = layui.layer;
        var csrf = $("#csrf").val();
        var id = $("#hideId").val();
        // 一般来说，权限数据是异步传递过来的
        $.ajax({
            url: "<?=\yii\helpers\Url::to(['role/get-menu'])?>",
            data:{"_csrf-backend":csrf,"id":id},
            type:"post",
            dataType: 'json',
            success: function(res){
                // 如果后台返回的不是树结构，请使用 authtree.listConvert 转换
                var trees = authtree.listConvert(res.data.list,{
                    primaryKey: 'id' //标志，名字根据json可改
                    ,startPid: "0"  //起始id（根节点），根据json填写
                    ,parentKey: 'parent_id' //父节点id，名字根据json可改
                    ,nameKey: 'title' //名称，名字根据json可改
                    ,valueKey: 'id' //value值，名字根据json可改
                    ,checkedKey: res.data.checkedId//控制是否选中，checkedId是json中的数据
                    ,disabledKey: res.data.disabledId//控制是否可以获得，disabledId是json中的数据
                });
                authtree.render('#LAY-auth-tree-index', trees,{
                    inputname: 'Role[jurisdiction][]',
                    layfilter: 'lay-check-auth',
                    autowidth: true,
                });
            }
        });
    });
</script>
<?php $this->beginBlock('js');?>
<script>
</script>
<?php $this->endBlock();?>
