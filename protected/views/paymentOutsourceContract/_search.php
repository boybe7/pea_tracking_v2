<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'contract_id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'money',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'invoice_no',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'invoice_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'approve_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_create',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_update',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
