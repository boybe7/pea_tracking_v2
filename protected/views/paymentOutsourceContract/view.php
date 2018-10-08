<?php
$this->breadcrumbs=array(
	'Payment Outsource Contracts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PaymentOutsourceContract','url'=>array('index')),
	array('label'=>'Create PaymentOutsourceContract','url'=>array('create')),
	array('label'=>'Update PaymentOutsourceContract','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PaymentOutsourceContract','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaymentOutsourceContract','url'=>array('admin')),
);
?>

<h1>View PaymentOutsourceContract #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contract_id',
		'detail',
		'money',
		'invoice_no',
		'invoice_date',
		'approve_date',
		'user_create',
		'user_update',
		'last_update',
	),
)); ?>
