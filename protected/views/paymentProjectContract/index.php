<?php
$this->breadcrumbs=array(
	'รายการรับเงินงวด',
);

$this->menu=array(
	array('label'=>'Create PaymentProjectContract','url'=>array('create')),
	array('label'=>'Manage PaymentProjectContract','url'=>array('admin')),
);
?>

<h1>Payment Project Contracts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
