<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'contract-change-history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'ref_no',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'detail',array('rows'=>4, 'cols'=>30, 'class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cost',array('class'=>'span5')); ?>

	

	
<?php $this->endWidget(); ?>
