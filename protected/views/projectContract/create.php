<?php
$this->breadcrumbs=array(
	'Project Contracts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectContract','url'=>array('index')),
	array('label'=>'Manage ProjectContract','url'=>array('admin')),
);
?>

<h1>Create ProjectContract</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>