<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Update',
);


?>

<h3>แก้ไขข้อมูลโครงการ</h3>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model,'clearSession'=>$clearSession,'modelOC'=>$modelOC,'contracts'=>$contracts,'outsource'=>$outsource,'tab'=>$tab,'numContracts'=>$numContracts)); ?>