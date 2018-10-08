<?php
$this->breadcrumbs=array(
	'Outsource Contracts'=>array('index'),
	$model->oc_id=>array('view','id'=>$model->oc_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OutsourceContract','url'=>array('index')),
	array('label'=>'Create OutsourceContract','url'=>array('create')),
	array('label'=>'View OutsourceContract','url'=>array('view','id'=>$model->oc_id)),
	array('label'=>'Manage OutsourceContract','url'=>array('admin')),
);
?>

<h1>Update OutsourceContract <?php echo $model->oc_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>