<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'เพิ่มสัญญาจ้างช่วง/ซื้อ',
);


?>

<h3>เพิ่มข้อมูลโครงการ</h3>

<?php echo $this->renderPartial('_form2', array('model'=>$model,'outsource'=>$outsource,'numContracts'=>$numContracts,'modelValidate'=>$modelValidate,'managementCost'=>$managementCost)); ?>