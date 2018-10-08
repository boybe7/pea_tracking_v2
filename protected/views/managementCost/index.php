<?php
$this->breadcrumbs=array(
	'Management Costs',
);

$this->menu=array(
	array('label'=>'Create ManagementCost','url'=>array('create')),
	array('label'=>'Manage ManagementCost','url'=>array('admin')),
);
?>

<h1>Management Costs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
