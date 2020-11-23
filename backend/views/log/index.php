<?php
/* @var $log string */
/* @var $pagination string */
$this->title = "网站日志";
$this->params['tab'] = "网站日志";
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
<div class="layui-form" id="table-list">
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col>
            <col>
            <col>
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>操作详情</th>
            <th>操作时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($log as $u){?>
            <tr>
                <td><?=$u->id?></td>
                <td><?=$u->username?></td>
                <td><?=$u->desc?></td>
                <td><?=date("Y-m-d H:i:s",$u->time)?></td>
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
