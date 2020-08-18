<?php
$this->breadcrumbs=array(
	'Management Costs'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มรายการจ่ายเงินค่ารับรองโครงการ</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'id'=>$id)); ?>