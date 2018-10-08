<?php
$this->breadcrumbs=array(
	'Work Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WorkCategory','url'=>array('index')),
	array('label'=>'Manage WorkCategory','url'=>array('admin')),
);
?>

<h1>Create WorkCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>