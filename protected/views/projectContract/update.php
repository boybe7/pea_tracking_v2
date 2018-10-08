<?php
$this->breadcrumbs=array(
	'Project Contracts'=>array('index'),
	$model->pc_id=>array('view','id'=>$model->pc_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectContract','url'=>array('index')),
	array('label'=>'Create ProjectContract','url'=>array('create')),
	array('label'=>'View ProjectContract','url'=>array('view','id'=>$model->pc_id)),
	array('label'=>'Manage ProjectContract','url'=>array('admin')),
);
?>

<h1>Update ProjectContract <?php echo $model->pc_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>