<?php
$this->breadcrumbs=array(
	'Vendors'=>array('admin'),
	'Update',
);

?>

<h1>แก้ไขข้อมูลคู่สัญญา</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>