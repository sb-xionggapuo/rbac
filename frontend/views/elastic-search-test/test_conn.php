<?php
/* @var $res array*/
$this->title = "测试elasticsearch";
?>
<style>
    .highlight{
        color:red;
    }
</style>
<table border="1">
    <tr>
        <th>职位</th>
        <th>工作内容</th>
    </tr>
    <?php foreach ($res as $key=>$value){?>
    <tr>
        <td><?=$value->highlight['job'][0]??$value->job?></td>

        <td><?=$value->highlight['title'][0]??$value->title?></td>
    </tr>
    <?php }?>
</table>


