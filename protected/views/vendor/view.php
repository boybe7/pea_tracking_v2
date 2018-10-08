<style type="text/css">
	table.detail-view th
	{
        background-color: #f5f5f5;
        color: #08C;
        font-weight: bold;
	}

</style>

<?php
$this->breadcrumbs=array(
	'Vendors'=>array('admin'),
	
);

?>

<h1>ข้อมูลคู่สัญญา</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'type'=>'bordered condensed',
	'attributes'=>array(
		
		'v_name',
		'v_address',
		'v_tax_id',
		'v_tel',
		'v_contractor',
	),
)); ?>
