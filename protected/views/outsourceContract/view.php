<?php
$this->breadcrumbs=array(
	'Outsource Contracts'=>array('index'),
	$model->oc_id,
);

$this->menu=array(
	array('label'=>'List OutsourceContract','url'=>array('index')),
	array('label'=>'Create OutsourceContract','url'=>array('create')),
	array('label'=>'Update OutsourceContract','url'=>array('update','id'=>$model->oc_id)),
	array('label'=>'Delete OutsourceContract','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->oc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OutsourceContract','url'=>array('admin')),
);
?>

<h1>View OutsourceContract #<?php echo $model->oc_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'oc_id',
		'oc_code',
		'oc_proj_id',
		'oc_vendor_id',
		'oc_sign_date',
		'oc_end_date',
		'oc_approve_date',
		'oc_cost',
		'oc_T_percent',
		'oc_A_percent',
		'oc_guarantee',
		'oc_adv_guarantee',
		'oc_insurance',
		'oc_letter',
		'oc_user_create',
		'oc_user_update',
	),
)); ?>
