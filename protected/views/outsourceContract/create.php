<?php
$this->breadcrumbs=array(
	'Outsource Contracts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OutsourceContract','url'=>array('index')),
	array('label'=>'Manage OutsourceContract','url'=>array('admin')),
);
?>

<h1>Create OutsourceContract</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>