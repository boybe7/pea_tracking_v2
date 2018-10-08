<?php
$this->breadcrumbs=array(
	'รายการรับเงินงวด'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PaymentProjectContract','url'=>array('index')),
	array('label'=>'Create PaymentProjectContract','url'=>array('create')),
	array('label'=>'Update PaymentProjectContract','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PaymentProjectContract','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaymentProjectContract','url'=>array('admin')),
);
?>

<h1>View PaymentProjectContract #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'proj_id',
		'detail',
		'money',
		'invoice_no',
		'invoice_date',
		'bill_no',
		'bill_date',
		'user_create',
		'user_update',
		'last_update',
	),
)); ?>
