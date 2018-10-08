<?php
$this->breadcrumbs=array(
	'Project Contracts'=>array('index'),
	$model->pc_id,
);

$this->menu=array(
	array('label'=>'List ProjectContract','url'=>array('index')),
	array('label'=>'Create ProjectContract','url'=>array('create')),
	array('label'=>'Update ProjectContract','url'=>array('update','id'=>$model->pc_id)),
	array('label'=>'Delete ProjectContract','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectContract','url'=>array('admin')),
);
?>

<h1>View ProjectContract #<?php echo $model->pc_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pc_id',
		'pc_code',
		'pc_proj_id',
		'pc_vendor_id',
		'pc_sign_date',
		'pc_end_date',
		'pc_cost',
		'pc_T_percent',
		'pc_A_percent',
		'pc_guarantee',
		'pc_user_create',
		'pc_user_update',
	),
)); ?>
