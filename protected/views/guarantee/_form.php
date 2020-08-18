<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'guarantee-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'guarantee_no',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'cost',array('class'=>'span5','maxlength'=>15)); ?>

	
	<div class="row-fluid">		
					<div class="span5">
      					<?php echo $form->labelEx($model,'guarantee_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					<?php       			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'guarantee_date',
		                        'attribute'=>'guarantee_date',
		                        'model'=>$model,
		                        'defaultOptions' => array(
		                                          'mode'=>'focus',
		                                          'showOn' => 'both',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12 d-picker', 'value'=>$model->guarantee_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      		</div>
		    </div>

	<?php echo $form->textFieldRow($model,'letter_confirm',array('class'=>'span5','maxlength'=>200)); ?>


	<?php echo $form->textFieldRow($model,'letter_return',array('class'=>'span5','maxlength'=>255)); ?>

	

<?php $this->endWidget(); ?>
