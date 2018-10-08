<?php
$this->breadcrumbs=array(
	'Work Categories',
);

$this->menu=array(
	array('label'=>'Create WorkCategory','url'=>array('create')),
	array('label'=>'Manage WorkCategory','url'=>array('admin')),
);
?>

<h1>Work Categories</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
