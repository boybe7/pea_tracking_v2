<?php
$this->breadcrumbs=array(
	'Management Cost Saps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ManagementCostSap','url'=>array('index')),
	array('label'=>'Create ManagementCostSap','url'=>array('create')),
	array('label'=>'View ManagementCostSap','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ManagementCostSap','url'=>array('admin')),
);
?>

<h1>Update ManagementCostSap <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>