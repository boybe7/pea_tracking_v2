<?php
$this->breadcrumbs=array(
	'รายการรับเงินงวด'=>array('index'),
	'Create',
);


?>

<h3>เพิ่มรายการรับเงินงวดสัญญาโครงการ</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'T_percent'=>$t,'A_percent'=>$a)); ?>