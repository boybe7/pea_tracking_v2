<?php
$this->breadcrumbs=array(
	'Work Code Outsources'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WorkCodeOutsource','url'=>array('index')),
	array('label'=>'Create WorkCodeOutsource','url'=>array('create')),
	array('label'=>'View WorkCodeOutsource','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage WorkCodeOutsource','url'=>array('admin')),
);
?>

<h1>Update WorkCodeOutsource <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>