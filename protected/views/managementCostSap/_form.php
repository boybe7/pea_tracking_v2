<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'management-cost-sap-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php
     	$workcat = Yii::app()->db->createCommand()
                    ->select('id,name')
                    ->from('department')
                    ->queryAll();
     
             		$typelist = CHtml::listData($workcat,'id','name');
             		echo $form->dropDownListRow($model, 'department_id', $typelist,array('class'=>'span5'), array('options' => array('department_id'=>array('selected'=>true)))); 
              ?>

	<?php echo $form->textFieldRow($model,'cost',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'year',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'บันทึก' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
