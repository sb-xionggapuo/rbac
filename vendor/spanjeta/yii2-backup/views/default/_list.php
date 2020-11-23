<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

echo GridView::widget ( [
		'id' => 'install-grid',
		'dataProvider' => $dataProvider,
        'summary'=>false,
		'tableOptions'=>['class'=>"layui-table"],
		'columns' => array (
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'name',
                    'label' => '备份名称',
                ],
                [
                    'attribute'=>'size',
                    'label' => '备份大小',
                    'format'=>'shortSize',
                ],
                [
                    'attribute'=>'create_time',
                    'label' => '创建时间',
                    'format'=>'datetime',
                ],
				array (
						'header' => '操作',
						'class' => 'yii\grid\ActionColumn',
						'template' => '{restore}{delete}',
						'buttons' => [
								'delete' => function ($url, $model) {
									return Html::a ( '<span class="layui-btn layui-btn-small layui-btn-danger">删除备份</span>', $url, [
											'title' => Yii::t ( 'app', 'Delete this backup' ) ,'data-method'=>'post'
									] );
								},
								'restore' => function ($url, $model) {
									return Html::a ( '<span class="layui-btn layui-btn-small layui-btn-normal">恢复备份</span>', $url, [
											'title' => Yii::t ( 'app', 'Restore this backup' ) ,'data-method'=>'post'
									] );
								}
						],
						'urlCreator' => function ($action, $model, $key, $index) {

								$url = Url::toRoute ( [
										'default/' .$action,
										'file' => $model ['name']
								] );
								return $url;

						}
				)

		)
] );
?>