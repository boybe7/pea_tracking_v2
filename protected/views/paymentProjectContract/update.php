<?php
$this->breadcrumbs=array(
	'รายการรับเงินงวด'=>array('index'),
	'Update',
);

?>

<h3>แก้ไขรายการรับเงินงวดสัญญาโครงการ</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'T_percent'=>$t,'A_percent'=>$a)); ?>