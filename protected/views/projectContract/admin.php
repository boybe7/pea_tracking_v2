<?php
$this->breadcrumbs=array(
	'Project Contracts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProjectContract','url'=>array('index')),
	array('label'=>'Create ProjectContract','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('project-contract-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Project Contracts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'project-contract-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'pc_id',
		'pc_code',
		'pc_proj_id',
		'pc_vendor_id',
		'pc_sign_date',
		'pc_end_date',
		/*
		'pc_cost',
		'pc_T_percent',
		'pc_A_percent',
		'pc_guarantee',
		'pc_user_create',
		'pc_user_update',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
