<?php
/* @var $menu string */
/* @var $model string */
/* @var $parent_id int */
use \yii\widgets\ActiveForm;
use \yii\helpers\Html;
$this->title = "前台菜单添加";
?>

<div class="wrap-container">


        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'layui-form','id'=>'form1','enctype'=>"multipart/form-data",'style'=>"width: 90%;padding-top: 20px;"]
        ])?>

        <div class="layui-form-item">
            <label class="layui-form-label">上级：</label>
            <div class="layui-input-block">
                <select name="Menu[parent_id]" lay-verify="required">
                    <option value="0">作为一级菜单</option>
                    <?php foreach ($menu as $m){?>
                        <option <?=$m['id'] == $parent_id?'selected':'';?> value="<?=$m['id']?>"><?=$m['tree']?>&nbsp;<?=$m['title']?></option>
                    <?php }?>
                </select>
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称：</label>
            <div class="layui-input-block">
                <?=$form->field($model,"title")->textInput(['class'=>"layui-input",'placeholder'=>"请输入名称"])->label(false)?>
<!--                <input type="text" name="title" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">-->
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">路由：</label>
            <div class="layui-input-block">
                <?=$form->field($model,"name")->textInput(['class'=>"layui-input",'placeholder'=>"请输入路由 如:main/index"])->label(false)?>
<!--                <input type="text" name="title" required lay-verify="required" placeholder="请输入路由" autocomplete="off" class="layui-input">-->
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标：</label>
            <div class="layui-input-block">
                <?=$form->field($model,"icon")->textInput(['class'=>"layui-input",'placeholder'=>"填写 如:&#xe627;"])->label(false)?>
<!--                <input type="text" name="title" required lay-verify="required" placeholder="请输入图标" autocomplete="off" class="layui-input">-->
                <a style="color: #0000cc" target="_blank" href="https://www.layui.com/v1/doc/element/icon.html#table">图标库</a>
            </div>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-block">
                <?=$form->field($model,"sort")->textInput(['class'=>"layui-input",'placeholder'=>"请输入排序 如:999"])->label(false)?>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="Menu[status]" value="1" title="显示" checked>
                <input type="radio" name="Menu[status]" value="0" title="隐藏" <?= $model->status==0&&is_numeric($model->status)?"checked":"";?> >
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
    <?php ActiveForm::end();?>
</div>

<script>
    //Demo
    layui.use(['form'], function() {
        var form = layui.form();
        form.render();
        //监听提交
        form.on('submit(formDemo)', function(data) {
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });
</script>
<?php $this->beginBlock('js');?>
<script>
</script>
<?php $this->endBlock();?>
