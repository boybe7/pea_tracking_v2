<?php
$this->breadcrumbs=array(
	'Payment Outsource Contracts',
);

$this->menu=array(
	array('label'=>'Create PaymentOutsourceContract','url'=>array('create')),
	array('label'=>'Manage PaymentOutsourceContract','url'=>array('admin')),
);
?>

<h1>Payment Outsource Contracts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
