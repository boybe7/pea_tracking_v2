<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'v_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'v_name',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textAreaRow($model,'v_address',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'v_tax_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'v_tel',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'v_contractor',array('class'=>'span5','maxlength'=>100)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
