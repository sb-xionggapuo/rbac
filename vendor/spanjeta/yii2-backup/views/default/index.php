
<div class="wrapper main-content-spacing">
	<div class="backup-default-index">

<?php
$this->title = "数据备份";
$this->params['tab'] = "数据备份";
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Manage',
		'url' => array (
				'index' 
		) 
];
?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
<div class="alert alert-success">
	<?php echo Yii::$app->session->getFlash('success'); ?>
</div>
<?php endif; ?>

		<div class="panel">

					<header class="panel-heading form-spacing clearfix">
					<h4 style="margin:0;" class="clearfix">
						<span class="pull-right">
						<a href="<?= \yii\helpers\Url::toRoute(['create']) ?>" class="layui-btn layui-btn-small layui-btn-warm"> <i class="fa fa-plus"></i> 创建备份 </a>
						</span></h4>
						</header>
					<div class="panel-body">
				
						<?php
						
						echo $this->render ( '_list', array (
								'dataProvider' => $dataProvider 
						) );
						?>
								
			
					</div>

		</div>
		
		
	</div>
</div>