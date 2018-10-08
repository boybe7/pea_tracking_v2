<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'po-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'PO',array('class'=>'span5','maxlength'=>200)); ?>

	
	<?php echo $form->textFieldRow($model,'letter',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'money',array('class'=>'span5')); ?>

	

<?php $this->endWidget(); ?>
