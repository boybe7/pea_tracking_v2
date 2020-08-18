<?php
$this->breadcrumbs=array(
	'Guarantees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Guarantee','url'=>array('index')),
	array('label'=>'Create Guarantee','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('guarantee-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Guarantees</h1>

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
	'id'=>'guarantee-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'guarantee_no',
		'contract_id',
		'letter_confirm',
		'cost',
		'guarantee_date',
		/*
		'letter_return',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
