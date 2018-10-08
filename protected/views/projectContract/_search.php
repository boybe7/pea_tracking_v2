<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'pc_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_code',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'pc_proj_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_vendor_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_sign_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_end_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_cost',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_T_percent',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_A_percent',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_guarantee',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'pc_user_create',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pc_user_update',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
