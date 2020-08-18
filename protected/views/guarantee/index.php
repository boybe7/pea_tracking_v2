<?php
$this->breadcrumbs=array(
	'Guarantees',
);

$this->menu=array(
	array('label'=>'Create Guarantee','url'=>array('create')),
	array('label'=>'Manage Guarantee','url'=>array('admin')),
);
?>

<h1>Guarantees</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
